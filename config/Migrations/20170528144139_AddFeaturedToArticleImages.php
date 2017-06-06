<?php
use Migrations\AbstractMigration;

class AddFeaturedToArticleImages extends AbstractMigration
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
        $table = $this->table('article_images');
        $table->addColumn('featured', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
