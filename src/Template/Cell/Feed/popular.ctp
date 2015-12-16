<?= $this->Html->link('ALL', ['plugin' => 'ArticlesManager', 'controller' => 'Articles', 'action' => 'index'], ['style' => 'font-size: 20px;']) ?>
<?php foreach ($tags as $tag) { ?>
    <?= $this->Html->link($tag->name, ['plugin' => 'ArticlesManager', 'controller' => 'Articles', 'action' => 'index', 0, $tag->id]) ?>
<?php } ?>
            
