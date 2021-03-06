<?php

namespace ArticlesManager\Model\Table;

use ArticlesManager\Model\Entity\Article;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;
use ArrayObject;
use Cake\Utility\Text;

/**
 * Articles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tags
 */
class ArticlesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('articles');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->addBehavior('Tools.Slugged', [
            'field' => 'slug',
            'overwriteField' => 'overwrite_slug',
            'mode' => 'url',
            'separator' => '-',
            'length' => null,
            'overwrite' => false,
            'unique' => true,
            'notices' => true,
            'case' => 'low',
            'scope' => [],
            'tidy' => true,
            'implementedFinders' => ['slugged' => 'findSlugged']
        ]);

        $this->belongsToMany('Tags', [
            'joinTable' => 'articles_tags',
            'className' => 'ArticlesManager.Tags'
        ]);

        $this->belongsToMany('Additions', [
            'foreignKey' => 'article_id',
            'targetForeignKey' => 'addition_id',
            'joinTable' => 'additions_articles',
            'className' => 'ArticlesManager.Additions'
        ]);

        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'className' => 'ArticlesManager.Sections'
        ]);

        $this->belongsTo('Creators', [
            'foreignKey' => 'created_by',
            'className' => 'UsersManager.Users'
        ]);


        $this->belongsTo('Modifiers', [
            'foreignKey' => 'modified_by',
            'className' => 'UsersManager.Users'
        ]);

        $this->hasMany('ArticleImages', [
            'className' => 'ArticlesManager.ArticleImages',
            'foreignKey' => 'article_id'
        ]);

        $this->hasOne('FeaturedImages', [
            'className' => 'ArticlesManager.ArticleImages',
            'foreignKey' => 'article_id',
            'finder' => 'featured'
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        /*        $validator
                    ->add('reference', 'valid', ['rule' => 'uuid'])
                    ->notEmpty('reference');*/

        /*        $validator
                    ->requirePresence('name', 'create')
                    ->add('name', 'unqiueName', [
                        'rule' => [$this, 'isUniqueForReferenceValidation'],
                        'message' => __('You cannot use the same name as another item of content'),
                        'provider' => 'table',
                    ])
                    ->notEmpty('name');*/

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationImage(Validator $validator)
    {

        $validator
            ->requirePresence('upload', 'create')
            ->notEmpty('upload');

        $validator
            // Set the thumbnail resize dimensions
            ->add('upload', 'extnesion_check', [
                'rule' => ['extension'],
                'message' => 'Image must be jpg, png or gif.'
            ])
            ->add('upload', 'file_size', [
                'rule' => ['fileSize', '<', '500Kb'],
                'message' => 'Image is not correct dimensions.'
            ])
            ->add('upload', 'mimeType', [
                'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
                'message' => 'Image must be jpg, png or gif.'
            ]);

        $validator->provider('proffer', 'Proffer\Model\Validation\ProfferRules')
            // Set the thumbnail resize dimensions
            ->add('upload', 'proffer', [
                'rule' => ['dimensions', [
                    'min' => ['w' => 1, 'h' => 1],
                    'max' => ['w' => 1920, 'h' => 1920]
                ]],
                'message' => 'Image is not correct dimensions.',
                'provider' => 'proffer'
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tag_id'], 'Tags'));
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (!empty($data['article_images'])) {
            foreach ($data['article_images'] as $key => $articleImage) {
                if (isset($articleImage['image'])) {
                    if ($articleImage['image']['error'] == 4) {
                        unset($data['article_images'][$key]);
                    }
                }
            }
        }
    }


    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!empty($entity->article_images)) {
            foreach ($entity->article_images as $articleImage) {
                if (isset($articleImage['id']) && isset($articleImage['remove'])) {
                    $articleImageEntity = $this->ArticleImages->get($articleImage['id']);
                    $this->ArticleImages->delete($articleImageEntity);
                }
            }
        }
    }

    //
    //
    // VALIDATION METHODS

    //
    //

    /**
     * Checks if a given name is unique for different references
     *
     * @param type $field
     * @param type $entity
     */
    public function isUniqueForReferenceValidation($value, array $data)
    {
        return $this->isUniqueForReference($value, $data['data']['reference']);
    }

    public function isUniqueForReferenceRule(Entity $entity)
    {
        return $this->isUniqueForReference($entity->name, $entity->reference);
    }

    public function isUniqueForReference($name, $reference)
    {
        if ($this->exists(['Articles.name' => $name, 'Articles.reference !=' => $reference])) {
            return false;
        }
        return true;
    }

    //
    //
    //TABLE OBJECT
    //
    //


    public function afterSaveCommit(Event $event, Entity $entity, ArrayObject $options)
    {
        /*        if ($options['publish']) {
                    $this->updateAll(['active' => 0], ['reference' => $entity->reference, 'id NOT IN' => [$entity->id]]);
                    $this->deleteAll(['reference' => $entity->reference, 'preview' => 1]);
                }*/
    }

    //
    //
    //CUSTOM FINDERS

    //
    //

    /**
     * Find a article for a given section
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findSection(Query $query, array $options)
    {
        $query->where(['Articles.section_id' => $options['section_id']]);
        return $query;
    }

    public function findActive(Query $query, array $options)
    {
        $query->where(['Articles.active' => 1]);
        return $query;
    }

    public function findReference(Query $query, array $options)
    {
        $query->where(['Articles.reference' => $options['reference']]);
        return $query;
    }

    public function findSlug(Query $query, array $options)
    {
        $query->where(['Articles.slug' => $options['slug']]);
        return $query;
    }

    //
    //
    //HELPER FINDING METHODS

    //
    //

    /**
     * Returns a list of articles (grouped by section) for a given organiser
     *
     * @param type $organiserId - The organiser ID for whom we are looking for races
     * @param type $exclude - Items to exclude from the list
     * @return type
     */
    public function getArticlesList($sectionGroup = true)
    {
        //Get a list of Races that can be used in the series
        $articles = $this->find('list', [
            'keyField' => 'reference',
            'valueField' => 'article_name',
            'groupField' => 'section_name'
        ])
            ->contain([
                'Sections' => function ($q) {
                    return $q;
                }
            ])
            ->distinct(['Articles.reference'])
            ->order(['Sections.name' => 'ASC', 'Articles.name' => 'ASC']);


        $articles
            ->select([
                'article_name' => $articles->func()->concat(['Articles.name' => 'literal'])
            ]);
        $articles
            ->select([
                'reference' => $articles->func()->concat(['Articles.reference' => 'literal'])
            ]);
        $articles
            ->select([
                'section_name' => $articles->func()->concat(['Sections.name' => 'literal'])
            ]);

        return $articles;
    }

}
