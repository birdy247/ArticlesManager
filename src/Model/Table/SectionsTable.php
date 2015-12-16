<?php

namespace ArticlesManager\Model\Table;

use ArticlesManager\Model\Entity\Section;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;
use ArrayObject;

/**
 * Sections Model
 *
 */
class SectionsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('sections');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Formations', [
            'foreignKey' => 'formation_id',
            'joinType' => 'INNER',
            'className' => 'ArticlesManager.Formations'
        ]);

        $this->hasMany('Articles', [
            'foreignKey' => 'section_id',
            'className' => 'ArticlesManager.Articles'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->requirePresence('subtitle', 'create')
                ->notEmpty('subtitle');

        $validator
                ->add('num', 'valid', ['rule' => 'numeric'])
                ->requirePresence('num', 'create')
                ->notEmpty('num');

        $validator
                ->add('menu', 'valid', ['rule' => 'boolean'])
                ->requirePresence('menu', 'create')
                ->notEmpty('menu');

        return $validator;
    }

    public function beforeDelete(Event $event, Entity $entity, ArrayObject $options) {
        $articles = $this->Articles->find('section', ['section_id' => $entity->id])->count();
        if ($articles) {
            return false;
        }
        return true;
    }

}
