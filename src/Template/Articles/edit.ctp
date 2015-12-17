
<?= $this->Form->create($article) ?>
<?php
echo $this->Form->input('name');
echo $this->Form->input('tags._ids', [
    'type' => 'select',
    'multiple' => true,
    'options' => $tags,
]);
echo $this->Form->input('active');
echo $this->Form->input('description', ['id' => 'ck_description']);
echo $this->Form->input('reference', ['type' => 'hidden']);
?>


<?= $this->Form->button('Submit', ['class' => 'btn btn-success btn-primary']) ?>
<?= $this->Form->end() ?>
<?php if ($articles) { ?>
    <table cellpadding = "0" cellspacing = "0" class ="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('active') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $a): ?>
                <tr>
                    <td><?= $this->Number->format($a->id) ?></td>
                    <td><?= h($a->name) ?></td>
                    <td><?= h($a->active) ?></td>
                    <td><?= h($a->created) ?></td>
                    <td><?= h($a->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $a->slug, $a->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $a->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $a->id], ['confirm' => __('Are you sure you want to delete # {0}?', $a->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}