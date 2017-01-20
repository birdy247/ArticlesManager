<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Addition'), ['action' => 'edit', $addition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Addition'), ['action' => 'delete', $addition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $addition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Additions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Addition'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="additions view large-9 medium-8 columns content">
    <h3><?= h($addition->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($addition->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Type') ?></th>
            <td><?= h($addition->data_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($addition->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Length') ?></th>
            <td><?= $this->Number->format($addition->length) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Articles') ?></h4>
        <?php if (!empty($addition->articles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Section Id') ?></th>
                <th scope="col"><?= __('Slug') ?></th>
                <th scope="col"><?= __('Reference') ?></th>
                <th scope="col"><?= __('Preview') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Modified By') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($addition->articles as $articles): ?>
            <tr>
                <td><?= h($articles->id) ?></td>
                <td><?= h($articles->name) ?></td>
                <td><?= h($articles->description) ?></td>
                <td><?= h($articles->active) ?></td>
                <td><?= h($articles->created) ?></td>
                <td><?= h($articles->modified) ?></td>
                <td><?= h($articles->section_id) ?></td>
                <td><?= h($articles->slug) ?></td>
                <td><?= h($articles->reference) ?></td>
                <td><?= h($articles->preview) ?></td>
                <td><?= h($articles->created_by) ?></td>
                <td><?= h($articles->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Articles', 'action' => 'view', $articles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Articles', 'action' => 'edit', $articles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sections') ?></h4>
        <?php if (!empty($addition->sections)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Num') ?></th>
                <th scope="col"><?= __('Menu') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Subtitle') ?></th>
                <th scope="col"><?= __('Show Common') ?></th>
                <th scope="col"><?= __('Formation Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($addition->sections as $sections): ?>
            <tr>
                <td><?= h($sections->id) ?></td>
                <td><?= h($sections->name) ?></td>
                <td><?= h($sections->num) ?></td>
                <td><?= h($sections->menu) ?></td>
                <td><?= h($sections->active) ?></td>
                <td><?= h($sections->subtitle) ?></td>
                <td><?= h($sections->show_common) ?></td>
                <td><?= h($sections->formation_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sections', 'action' => 'view', $sections->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sections', 'action' => 'edit', $sections->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sections', 'action' => 'delete', $sections->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sections->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
