<?php
use Migrations\AbstractMigration;

class AddArticleIdToOccasionsNew extends AbstractMigration
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
        $table = $this->table('occasions');
        $table->addColumn('article_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addForeignKey(
            'article_id',
            'articles',
            'id',
            [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ]
        );
        $table->update();
    }
}
