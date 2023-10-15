<?php

use function Atas\SsgSystemPhp\exit_with_not_found;
use function Atas\SsgSystemPhp\get_markdown;

include "system/bootstrap.php";
global $page_meta;

$md_path = "pages/$_GET[page].md";

/**
 * Page parameter can only be alphanumeric and hyphen and .md file must exist.
 * If not, return 404.
 */
if (!preg_match('/^[a-zA-Z0-9\-]+$/', $_GET['page']) || !file_exists($md_path)) {
    exit_with_not_found();
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
