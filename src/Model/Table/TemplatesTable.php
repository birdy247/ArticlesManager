<?php
namespace ArticlesManager\Model\Table;

use ArticlesManager\Model\Entity\Template;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Templates Model
 *
 * @property \Cake\ORM\Association\HasMany $Sections
 */
class TemplatesTable extends Table
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

        $this->table('templates');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Sections', [
            'foreignKey' => 'template_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('directory', 'create')
            ->notEmpty('directory');

        return $validator;
    }
}
