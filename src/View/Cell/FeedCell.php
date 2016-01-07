<?php

namespace ArticlesManager\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Feed cell
 */
class FeedCell extends Cell {

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
    public function display($sectionId = 1, $items = 5) {
        $articlesTable = TableRegistry::get('ArticlesManager.Articles');
        $articles = $articlesTable
                ->find('active')
                ->find('section', ['section_id' => $sectionId])
                ->order(['Articles.created' => 'DESC'])
                ->limit($items);

        $this->set(compact('articles'));
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function popular() {
        $this->loadModel('Tags');
        $tags = $this->Tags
                ->find('all');

        $this->set(compact('tags'));
    }

}
