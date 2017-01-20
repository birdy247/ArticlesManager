<?php
use Migrations\AbstractMigration;

class CreateAdditions extends AbstractMigration
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
        $table = $this->table('additions');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('data_type', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('length', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addIndex([
            'name',
        ], [
            'name' => 'UNIQUE_NAME',
            'unique' => true,
        ]);
        $table->create();
    }
}
