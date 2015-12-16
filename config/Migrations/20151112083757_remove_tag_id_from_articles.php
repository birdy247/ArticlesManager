<?php

use Migrations\AbstractMigration;

class RemoveTagIdFromArticles extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('articles');
        $table->removeColumn('tag_id');
        $table->update();
    }

}
