<?php
namespace ArticlesManager\View\Helper;

use ArticlesManager\Model\Entity\Addition;
use Cake\I18n\Time;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Additions helper
 */
class AdditionsHelper extends Helper
{

    public $helpers = ['Number'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function display(Addition $addition)
    {
        switch ($addition->data_type) {
            case "datetime":
                $date = Time::parseDateTime($addition->_joinData->value);
                return $date->i18nFormat('d-M-y');

            case "date":
                $date = Time::parseDate($addition->_joinData->value);
                return $date->i18nFormat('MMM y');

            case "string":
                return $addition->_joinData->value;

            case "integer":
                return $this->Number->format($addition->_joinData->value);

            default:
                return $addition->_joinData->value;
        }
    }

}
