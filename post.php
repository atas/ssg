<?php

require_once "system/bootstrap.php";
global $og;

if (!preg_match('/^[a-zA-Z0-9\-]+$/', $_GET['slug'])) {
    echo "<!--POST PATTERN IS WRONG, 404, SLUG: $_GET[slug]-->";
    not_found();
}

$post = current(array_filter(get_posts(), function ($post) {
    return $post->slug == $_GET['slug'];
}));

if (!$post) {
    echo "<!--POST NOT FOUND, 404, SLUG: $_GET[slug]-->";
    not_found();
}

$tpl = get_md($post->filename);

$og->title = $tpl->meta->title ?? null;
$og->type = "article";
$og->desc = $tpl->meta->desc ?? null;

require_once 'layout/header.php';

echo "<div class='box singlePost'>";
echo $tpl->content;
echo "</div>";

?>

<?php require_once 'layout/footer.php'; ?>
