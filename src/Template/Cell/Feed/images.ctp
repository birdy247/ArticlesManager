<?php if (!$articles->isEmpty()): ?>
    <?php if (!empty($article->article_images)): ?>
        <?php foreach ($articleImages as $articleImage) : ?>
            <div class="col-xs-4 col-md-6">
                <div class="overlay-container mb-10">
                    <?= $this->Html->image('../files/articleimages/image/' . $articleImage->image_dir . '/' . $articleImage->image); ?>
                    <?= $this->html->link('<i class="fa fa-link"></i>', ['plugin' => 'ArticlesManager', 'controller' => 'Articles', 'action' => 'view', $article->slug], ['class' => 'overlay-link', 'escape' => false]) ?>
                    </a>
                </div>
            </div>
            <?php
            break;
        endforeach; ?>
    <?php endif; ?>
<?php endif;