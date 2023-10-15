<?php

use Atas\SsgSystemPhp\PostsCache;
use function Atas\SsgSystemPhp\exit_with_not_found;
use function Atas\SsgSystemPhp\get_markdown;

require_once "system/bootstrap.php";
global $page_meta;

/**
 * Slug querystring can only be alphanumeric and hyphen
 * If not, return 404.
 */
if (!preg_match('/^[a-zA-Z0-9\-]+$/', $_GET['slug'])) {
    echo "<!--POST PATTERN IS WRONG, 404, SLUG: $_GET[slug]-->";
    exit_with_not_found();
}

// Iterate through all posts and find the one with the same slug
$post = current(array_filter((new PostsCache())->updateAndGetCachedPostList(), function ($post) {
    return $post->slug == $_GET['slug'];
}));

if (!$post) {
    echo "<!--POST NOT FOUND, 404, SLUG: $_GET[slug]-->";
    exit_with_not_found();
}

$tpl = get_markdown('posts/' . $post->filename);

$page_meta->title = $tpl->meta->title ?? null;
$page_meta->type = "article";
$page_meta->desc = $tpl->meta->desc ?? null;

require_once 'layout/header.php';

?>

<div class='box singlePost'>
<?=$tpl->content?>
</div>

<?php
require_once 'layout/footer.php';
