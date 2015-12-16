<?php

use Migrations\AbstractMigration;

class ChangeDatesForOccasions extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('occasions');
        $table->removeColumn('date');
        $table->addColumn('date_from', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('date_to', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }

}
