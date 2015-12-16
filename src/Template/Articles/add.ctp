
<?= $this->Form->create($article) ?>
<?php

echo $this->Form->input('name');
echo $this->Form->input('tags._ids', [
    'type' => 'select',
    'multiple' => true,
    'options' => $tags,
]);
echo $this->Form->input('active');
echo $this->Form->input('section_id');
echo $this->Form->input('description', ['id' => 'ck_description']);
?>
<?= $this->Form->button('Submit', ['class' => 'btn btn-success btn-primary']) ?>
<?= $this->Form->end() ?>

