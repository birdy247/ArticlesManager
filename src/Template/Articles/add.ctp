<?= $this->Form->create($article) ?>
<?php

echo $this->Form->input('article_images.0.image', ['type' => 'file']);
echo $this->Form->input('article_images.1.image', ['type' => 'file']);
echo $this->Form->input('article_images.2.image', ['type' => 'file']);
echo $this->Form->input('name');
echo $this->Form->input('excerpt', ['type' => 'textarea']);
echo $this->Form->input('tags._ids', [
    'type' => 'select',
    'multiple' => true,
    'options' => $tags,
]);
echo $this->Form->input('active');
echo $this->Form->input('section_id');
echo $this->Form->input('description', ['id' => 'ck_description']);
if (!empty($article->section->additions)):
    foreach ($article->section->additions as $key => $addition):
        echo $this->Form->input('additions.' . $key . '.id');
        echo $this->Form->input('additions.' . $key . '._joinData.value');
    endforeach;
endif;
?>
<?= $this->Form->button('Submit', ['class' => 'btn btn-success btn-primary']) ?>
<?= $this->Form->end() ?>

