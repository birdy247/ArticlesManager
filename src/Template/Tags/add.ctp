
<?= $this->Form->create($tag) ?>
<?php

echo $this->Form->input('name');
echo $this->Form->input('description');
?>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>

