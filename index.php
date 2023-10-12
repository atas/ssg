<?php

require_once "system/bootstrap.php";
global $og;

$og->title = $tpl->meta->title ?? "";
$og->desc = $tpl->meta->desc ?? "";
$selectedTab = "home";
require_once 'layout/header.php';

$posts = get_posts();

echo "<div id='posts'>";
foreach ($posts as $post) {
    echo "<article class='post'><a href='/p/$post->slug'>";
    echo "<div class='left'>";
    echo "<h2>$post->title</h2>";
    echo "<div class='desc'>$post->desc</div>";
    echo "</div>";
    echo '<div class="right"><img src="/assets/images/right-arrow.svg" /></div>';
    echo "</a></article>";
}
echo "</div>";

require_once 'layout/footer.php';

