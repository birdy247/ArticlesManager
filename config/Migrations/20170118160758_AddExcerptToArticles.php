<?php
use Migrations\AbstractMigration;

class AddExcerptToArticles extends AbstractMigration
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
        $table = $this->table('articles');
        $table->changeColumn('created_by', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);
        $table->changeColumn('modified_by', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);
        $table->addColumn('excerpt', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->removeColumn('reference');
        $table->removeColumn('preview');
        $table->addForeignKey(
            'section_id',
            'sections',
            'id',
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $table->addForeignKey(
            'created_by',
            'users',
            'id',
            [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ]
        );
        $table->addForeignKey(
            'modified_by',
            'users',
            'id',
            [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ]
        );
        $table->update();
    }
}
