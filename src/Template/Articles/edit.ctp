<?= $this->Form->create($article) ?>
<?php


if (!empty($article->article_images)):
    foreach ($article->article_images as $key => $articleImage): ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?= $this->Html->image('../files/articleimages/image/' . $articleImage->get('image_dir') . '/' . $articleImage->get('image')); ?>
                <div class="caption">
                    <?= $this->Form->input('article_images.' . $key . '.id') ?>
                    <?= $this->Form->input('article_images.' . $key . '.remove', ['type' => 'checkbox', 'hiddenField' => false, 'label' => 'Remove my cover photo']) ?>
                </div>
            </div>
        </div>
    <?php endforeach;
endif;

echo $this->Form->input('name');
echo $this->Form->input('excerpt', ['type' => 'textarea']);
echo $this->Form->input('tags._ids', [
    'type' => 'select',
    'multiple' => true,
    'options' => $tags,
]);
echo $this->Form->input('active');
echo $this->Form->input('description', ['id' => 'ck_description']);
if (!empty($article->section->additions)):
    foreach ($article->section->additions as $key => $addition):
        echo $this->Form->input('additions.' . $key . '.id', ['value' => $addition->id]);
        echo $this->Form->input('additions.' . $key . '._joinData.value', ['label' => $addition->name]);
    endforeach;
endif;
?>
<?= $this->Form->button('Submit', ['class' => 'btn btn-success btn-primary']) ?>
<?= $this->Form->end() ?>