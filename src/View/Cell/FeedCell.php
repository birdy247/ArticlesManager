<?php

namespace ArticlesManager\View\Cell;

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
        $articles = $articlesTable
            ->find('active')
            ->find('section', ['section_id' => $sectionId]);

        if (!empty($excludeIds)) {
            $articles->where(['Articles.id NOT IN' => $excludeIds]);
        }

        $articles->contain(['ArticleImages'])
            ->order(['Articles.created' => 'DESC'])
            ->limit($items);



        $this->set(compact('articles', 'items'));
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

    public function images()
    {
        $this->loadModel('ArticleImages');
        $articleImages = $this->ArticleImages->find('all');

        $this->set(compact('articleImages'));
    }

}
