<?php

namespace ArticlesManager\View\Cell;

use Cake\View\Cell;
use Cake\ORM\TableRegistry;

/**
 * Occasion cell
 */
class OccasionCell extends Cell {

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
    public function display($items = 5) {
        $this->loadModel('Occasions');
        $occasionsTable = TableRegistry::get('ArticlesManager.Occasions');
        $occasions = $occasionsTable
                ->find('active')
                ->order(['Occasions.date_from' => 'DESC'])
                ->limit($items);

        $this->set(compact('occasions'));
    }

}
