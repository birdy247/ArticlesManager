<?php
use Migrations\AbstractMigration;

class CreateAdditionsArticles extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('additions_articles');
        $table->addColumn('addition_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('article_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('value', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addForeignKey(
            'addition_id',
            'additions',
            'id',
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $table->addForeignKey(
            'article_id',
            'articles',
            'id',
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $table->create();
    }
}
