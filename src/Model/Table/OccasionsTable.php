<?php

namespace ArticlesManager\Model\Table;

use ArticlesManager\Model\Entity\Occasion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Occasions Model
 *
 */
class OccasionsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('occasions');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'className' => 'ArticlesManager.Articles'
        ]);

        $this->addBehavior('Proffer.Proffer', [
            'photo' => [    // The name of your upload field
                'root' => WWW_ROOT . 'files', // Customise the root upload folder here, or omit to use the default
                'dir' => 'photo_dir', // The name of the field to store the folder
                'thumbnailSizes' => [ // Declare your thumbnails
                    'portrait' => [     // Define a second thumbnail
                        'w' => 90,
                        'h' => 90
                    ],
                ],
                'thumbnailMethod' => 'imagick'  // Options are Imagick, Gd or Gmagick
            ]
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
                ->add('date_from', 'valid', ['rule' => 'datetime'])
                ->requirePresence('date_from', 'create')
                ->notEmpty('date_from');

        $validator
                ->add('date_to', 'valid', ['rule' => 'datetime'])
                ->requirePresence('date_to', 'create')
                ->notEmpty('date_to');

        $validator
                ->requirePresence('description', 'create')
                ->notEmpty('description');

        $validator
                ->requirePresence('photo', false)
                ->allowEmpty('photo', true);

        $validator
                ->add('active', 'valid', ['rule' => 'boolean'])
                ->requirePresence('active', 'create')
                ->notEmpty('active');

        return $validator;
    }

    public function findActive(Query $query, array $options) {
        $query->where(['Occasions.active' => 1]);
        return $query;
    }

    public function findArticles(Query $query, array $options) {
        $query->contain(['Articles']);
        return $query;
    }

}
