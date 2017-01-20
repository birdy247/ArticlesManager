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

        $this->belongsToMany('Additions', [
            'foreignKey' => 'section_id',
            'targetForeignKey' => 'addition_id',
            'joinTable' => 'additions_sections',
            'className' => 'ArticlesManager.Additions'
        ]);

        $this->belongsTo('Formations', [
            'foreignKey' => 'formation_id',
            'joinType' => 'INNER',
            'className' => 'ArticlesManager.Formations'
        ]);

        $this->hasMany('Articles', [
            'foreignKey' => 'section_id',
            'className' => 'ArticlesManager.Articles',
            'dependent' => true
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
        $articles = $this->Articles->find('section', ['section_id' => $entity->id])->find('active')->count();
        if ($articles) {
            return false;
        }
        return true;
    }

    public function findActive(Query $query, array $options) {
        $query->where(['Sections.active' => 1]);
        return $query;
    }

    public function findMenu(Query $query, array $options) {
        $query->where(['Sections.menu' => 1]);
        return $query;
    }

}
