<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Occasion'), ['action' => 'edit', $occasion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Occasion'), ['action' => 'delete', $occasion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $occasion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Occasions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Occasion'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="occasions view large-9 medium-8 columns content">
    <h3><?= h($occasion->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($occasion->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($occasion->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($occasion->date) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($occasion->description)); ?>
    </div>
</div>
