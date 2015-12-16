<?php if (!empty($occasions)) { ?>
    <?php foreach ($occasions as $occasion) { ?>
        <li class="clearfix">
            <!--<a href="#" class="post-thumb"> <img src="assets/images/work-3.jpg" class="img-responsive" alt=""></a>-->
            <div class="recent-post-content">
                <a href="#">
                    <?= $occasion->name ?>
                </a>
                <span><?= $occasion->date_from->format('d M Y') ?></span>
            </div>
        </li>
    <?php } ?>
<?php } ?>