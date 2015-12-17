<?php

namespace ArticlesManager\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Occasion Entity.
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $date
 * @property string $description
 */
class Occasion extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
    protected $_virtual = ['article'];

    //Lazy loading of article
    protected function _getArticle() {
        if (!empty($this->article_reference)) {
            $articlesTable = TableRegistry::get('ArticlesManager.Articles');
            return $articlesTable->find('reference', ['reference' => $this->article_reference])->find('active')->first();
        }
    }

}
