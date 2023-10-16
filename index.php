<?php
require 'vendor/autoload.php';

use Atas\SsgSystemPhp\AtasSsg;

$ssg = new AtasSsg(__DIR__);
$ssg->pageMeta->selectedTab = $tpl->meta->selectedTab ?? "home";

require_once 'layout/header.php';

$posts = $ssg->postCache->updateAndGetCachedPostList();

echo "<div id='posts'>";
foreach ($posts as $post) {
    ?>
    <article class='post'>
        <a href='/p/<?= $post->slug ?>'>
            <div class='left'>
                <h2><?= $post->title ?></h2>
                <div class='desc'><?= $post->desc ?></div>
            </div>
            <div class="right"><img src="/assets/images/right-arrow.svg" alt="Right arrow"/></div>
        </a>
    </article>
    <?php
}
echo "</div>";

require_once 'layout/footer.php';
