<?php
use Migrations\AbstractMigration;

class AddSubtitleToSections extends AbstractMigration
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
        $table = $this->table('sections');
        $table->addColumn('subtitle', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('show_common', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
