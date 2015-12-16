<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?=
            $this->Form->postLink(
                    __('Delete'), ['action' => 'delete', $occasion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $occasion->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('List Occasions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="occasions form large-9 medium-8 columns content">
    <?= $this->Form->create($occasion) ?>
    <fieldset>
        <legend><?= __('Edit Occasion') ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('date_from');
        echo $this->Form->input('date_to');
        echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
