<?php
namespace ArticlesManager\Test\TestCase\Model\Table;

use ArticlesManager\Model\Table\AdditionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * ArticlesManager\Model\Table\AdditionsTable Test Case
 */
class AdditionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ArticlesManager\Model\Table\AdditionsTable
     */
    public $Additions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.articles_manager.additions',
        'plugin.articles_manager.articles',
        'plugin.articles_manager.tags',
        'plugin.articles_manager.articles_tags',
        'plugin.articles_manager.sections',
        'plugin.articles_manager.formations',
        'plugin.articles_manager.creators',
        'plugin.articles_manager.roles',
        'plugin.articles_manager.users',
        'plugin.articles_manager.modifiers',
        'plugin.articles_manager.article_images',
        'plugin.articles_manager.additions_articles',
        'plugin.articles_manager.additions_sections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Additions') ? [] : ['className' => 'ArticlesManager\Model\Table\AdditionsTable'];
        $this->Additions = TableRegistry::get('Additions', $config);
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
