<?php
namespace ArticlesManager\Test\TestCase\View\Helper;

use ArticlesManager\View\Helper\AdditionsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * ArticlesManager\View\Helper\AdditionsHelper Test Case
 */
class AdditionsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ArticlesManager\View\Helper\AdditionsHelper
     */
    public $Additions;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Additions = new AdditionsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Additions);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
