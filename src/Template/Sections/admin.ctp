<table cellpadding="0" cellspacing="0" class ="table">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('subtitle') ?></th>
            <th><?= $this->Paginator->sort('num') ?></th>
            <th><?= $this->Paginator->sort('menu') ?></th>
            <th><?= $this->Paginator->sort('active') ?></th>
            <th><?= $this->Paginator->sort('show_common') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><?= $this->Number->format($section->id) ?></td>
                <td><?= h($section->name) ?></td>
                <td><?= h($section->subtitle) ?></td>
                <td><?= $this->Number->format($section->num) ?></td>
                <td><?= h($section->menu) ?></td>
                <td><?= h($section->active) ?></td>
                <td><?= h($section->show_common) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $section->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $section->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id)]) ?>
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
