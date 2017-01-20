<?php
use Migrations\AbstractMigration;

class CreateAdditionsSections extends AbstractMigration
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
        $table = $this->table('additions_sections');
        $table->addColumn('addition_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('section_id', 'integer', [
            'default' => null,
            'limit' => 11,
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
            'section_id',
            'sections',
            'id',
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $table->create();
    }
}
