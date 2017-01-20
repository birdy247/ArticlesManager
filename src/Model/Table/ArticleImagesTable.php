<?php
namespace ArticlesManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * ArticleImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Articles
 *
 * @method \ArticlesManager\Model\Entity\ArticleImage get($primaryKey, $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage newEntity($data = null, array $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage[] newEntities(array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage[] patchEntities($entities, array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\ArticleImage findOrCreate($search, callable $callback = null, $options = [])
 */
class ArticleImagesTable extends Table
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

        $this->table('article_images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Proffer.Proffer', [
            'image' => [
                'dir' => 'image_dir',
                'thumbnailSizes' => [
                    'portfolio' => ['w' => 1140, 'h' => 450]
                ]
            ]
        ]);

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'joinType' => 'INNER',
            'className' => 'ArticlesManager.Articles'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        //$validator
            //->requirePresence('image', 'create')
            //->allowEmpty('image', 'update');

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
        $rules->add($rules->existsIn(['article_id'], 'Articles'));

        return $rules;
    }
}
