<?php

include "system/bootstrap.php";
global $og;

$md_path = "pages/$_GET[page].md";

if (!preg_match('/^[a-zA-Z0-9\-]+$/', $_GET['page']) || !file_exists($md_path)) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit;
}

$tpl = get_md($md_path);

$og->title = $tpl->meta->title ?? null;
$og->desc = $tpl->meta->desc ?? null;
$selectedTab = $tpl->meta->selectedTab ?? "index";
include 'layout/header.php';

echo "<div class='box singlePage'>";
echo $tpl->content;
echo "</div>";
include 'layout/footer.php';

?>

