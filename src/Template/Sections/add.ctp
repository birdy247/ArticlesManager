<?= $this->Form->create($section) ?>
<?php

echo $this->Form->input('name');
echo $this->Form->input('subtitle');
echo $this->Form->input('num', ['label' => 'Priority']);
echo $this->Form->input('formation_id', ['label' => 'Page Layout']);
echo $this->Form->input('additions._ids', ['multiple' => 'checkbox', 'label' => 'Additional Input fields']);
echo $this->Form->input('menu', ['label' => 'Make this section accesible from the menu']);
echo $this->Form->input('active', ['label' => 'Enable this section']);
?>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>