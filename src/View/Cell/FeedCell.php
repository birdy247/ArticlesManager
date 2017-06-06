<?php

namespace ArticlesManager\View\Cell;

use Cake\Collection\Collection;
use Cake\Datasource\ResultSetInterface;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Feed cell
 */
class FeedCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function articles($sectionId = 1, $items = 5, $excludeIds = [])
    {

        $articlesTable = TableRegistry::get('ArticlesManager.Articles');
        $sectionTable = TableRegistry::get('ArticlesManager.Sections');

        $section = $sectionTable->get($sectionId);

        $articles = $articlesTable->find('active')
            ->find('section', ['section_id' => $sectionId]);

        if (!empty($excludeIds)) {
            $articles->where(['Articles.id NOT IN' => $excludeIds]);
        }

        $articles->contain(['ArticleImages', 'Additions', 'Creators'])
            ->order(['Articles.created' => 'DESC'])
            ->limit($items)
            ->formatResults(function (ResultSetInterface $results) {
                return $results->map(function ($row) {

                    $additions = (new Collection($row['additions']))->combine(
                        'name',
                        function ($entity) {
                            return $entity;
                        }
                    )->toArray();

                    $row['additions'] = $additions;

                    return $row;
                });
            });


        $this->set(compact('articles', 'items', 'section'));
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function tags()
    {
        $this->loadModel('Tags');
        $tags = $this->Tags
            ->find('all');

        $this->set(compact('tags'));
    }

    public function images($limit = 4)
    {
        $ArticlesImagesTable = TableRegistry::get('ArticlesManager.ArticleImages');
        $articleImages = $ArticlesImagesTable->find('all')->contain(['Articles.Sections'])->limit($limit);

        $this->set(compact('articleImages'));
    }

}
