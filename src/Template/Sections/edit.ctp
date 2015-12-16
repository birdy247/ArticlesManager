
<?= $this->Form->create($section) ?>
<?php

echo $this->Form->input('name');
echo $this->Form->input('subtitle');
echo $this->Form->input('num');
echo $this->Form->input('menu');
echo $this->Form->input('active');
echo $this->Form->input('show_common');
echo $this->Form->input('template_id');
?>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>

