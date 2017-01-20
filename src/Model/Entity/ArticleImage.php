<?php
namespace ArticlesManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArticleImage Entity
 *
 * @property int $id
 * @property string $image
 * @property string $image_dir
 * @property int $article_id
 *
 * @property \ArticlesManager\Model\Entity\Article $article
 */
class ArticleImage extends Entity
{

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
        'id' => false
    ];
}
