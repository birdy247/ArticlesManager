<?php
namespace ArticlesManager\Test\TestCase\Model\Behavior;

use ArticlesManager\Model\Behavior\SluggedBehavior;
use Cake\TestSuite\TestCase;

/**
 * ArticlesManager\Model\Behavior\SluggedBehavior Test Case
 */
class SluggedBehaviorTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Slugged = new SluggedBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Slugged);

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
