<?php
include "system/bootstrap.php";
global $page_meta;

$md_path = "pages/$_GET[page].md";

/**
 * Page parameter can only be alphanumeric and hyphen and .md file must exist.
 * If not, return 404.
 */
if (!preg_match('/^[a-zA-Z0-9\-]+$/', $_GET['page']) || !file_exists($md_path)) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit;
}

$tpl = get_markdown($md_path);

$page_meta->title = $tpl->meta->title ?? null;
$page_meta->desc = $tpl->meta->desc ?? null;
$page_meta->selectedTab = $tpl->meta->selectedTab ?? "index";
include 'layout/header.php';
?>

    <div class='box singlePage'>
        <?= $tpl->content ?>
    </div>

<?php
include 'layout/footer.php';
