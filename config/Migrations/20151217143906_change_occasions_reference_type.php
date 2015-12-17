<?php

use Migrations\AbstractMigration;

class ChangeOccasionsReferenceType extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('occasions');
        $table->changeColumn('article_reference', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
    }

}
