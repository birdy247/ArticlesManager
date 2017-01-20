<?php if (!empty($articles)) { ?>
    <?php foreach ($articles as $article) { ?>
        <li class="clearfix">
            <!--<a href="#" class="post-thumb"> <img src="assets/images/work-3.jpg" class="img-responsive" alt=""></a>-->
            <div class="recent-post-content">
                <?= $this->Html->link($article->name, ['plugin' => 'ArticlesManager', 'controller' => 'Articles', 'action' => 'view', $article->slug]) ?>
                <span><?= $article->created->format('d M Y') ?></span>
            </div>
        </li>
    <?php } ?>
<?php } ?>