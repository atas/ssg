<?php
require 'vendor/autoload.php';

use Atas\SsgSystemPhp\AtasSsg;

$ssg = new AtasSsg(__DIR__);

// Iterate through all posts and find the one with the same slug
$post = current(array_filter($ssg->postCache->updateAndGetCachedPostList(), function ($post) {
    return $post->slug == $_GET['slug'];
}));

if (!$post) {
    echo "<!--POST NOT FOUND, 404, SLUG: $_GET[slug]-->";
    $ssg->exit_with_not_found();
}

$tpl = $ssg->markdown->convert('posts/' . $post->filename);

$ssg->pageMeta->title = $tpl->meta->title ?? null;
$ssg->pageMeta->type = "article";
$ssg->pageMeta->desc = $tpl->meta->desc ?? null;

require_once 'layout/header.php';

?>

<div class='box singlePost'>
<?=$tpl->content?>
</div>

<?php
require_once 'layout/footer.php';
