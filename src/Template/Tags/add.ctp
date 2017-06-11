
<?= $this->Form->create($tag) ?>
<?php

echo $this->Form->input('name');
echo $this->Form->input('description');
echo $this->Form->input('slug');
?>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>

