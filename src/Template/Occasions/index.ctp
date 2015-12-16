<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Occasion'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="occasions index large-9 medium-8 columns content">
    <h3><?= __('Occasions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('date_from') ?></th>
                <th><?= $this->Paginator->sort('date_to') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($occasions as $occasion): ?>
            <tr>
                <td><?= $this->Number->format($occasion->id) ?></td>
                <td><?= h($occasion->name) ?></td>
                <td><?= h($occasion->date_from) ?></td>
                <td><?= h($occasion->date_to) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $occasion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $occasion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $occasion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $occasion->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
