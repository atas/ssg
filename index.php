<?php

require_once "system/bootstrap.php";

global $page_meta;
$page_meta->selectedTab = "home";

require_once 'layout/header.php';

$posts = get_all_posts();

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
