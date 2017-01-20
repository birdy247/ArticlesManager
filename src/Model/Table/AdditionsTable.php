<?php
namespace ArticlesManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Additions Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Articles
 * @property \Cake\ORM\Association\BelongsToMany $Sections
 *
 * @method \ArticlesManager\Model\Entity\Addition get($primaryKey, $options = [])
 * @method \ArticlesManager\Model\Entity\Addition newEntity($data = null, array $options = [])
 * @method \ArticlesManager\Model\Entity\Addition[] newEntities(array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\Addition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ArticlesManager\Model\Entity\Addition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\Addition[] patchEntities($entities, array $data, array $options = [])
 * @method \ArticlesManager\Model\Entity\Addition findOrCreate($search, callable $callback = null, $options = [])
 */
class AdditionsTable extends Table
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

        $this->table('additions');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsToMany('Articles', [
            'foreignKey' => 'addition_id',
            'targetForeignKey' => 'article_id',
            'joinTable' => 'additions_articles',
            'className' => 'ArticlesManager.Articles'
        ]);
        $this->belongsToMany('Sections', [
            'foreignKey' => 'addition_id',
            'targetForeignKey' => 'section_id',
            'joinTable' => 'additions_sections',
            'className' => 'ArticlesManager.Sections'
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('data_type', 'create')
            ->notEmpty('data_type');

        $validator
            ->integer('length')
            ->allowEmpty('length');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
