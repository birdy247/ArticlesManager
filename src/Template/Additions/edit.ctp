<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $addition->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $addition->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Additions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="additions form large-9 medium-8 columns content">
    <?= $this->Form->create($addition) ?>
    <fieldset>
        <legend><?= __('Edit Addition') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('data_type');
            echo $this->Form->input('length');
            echo $this->Form->input('articles._ids', ['options' => $articles]);
            echo $this->Form->input('sections._ids', ['options' => $sections]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
