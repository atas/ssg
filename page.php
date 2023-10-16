<?php
require 'vendor/autoload.php';

use Atas\SsgSystemPhp\AtasSsg;

$ssg = new AtasSsg(__DIR__);

$md_path = "pages/$_GET[page].md";

// If not found, return 404.
if (!file_exists($md_path)) $ssg->exit_with_not_found();

$tpl = $ssg->markdown->convert($md_path);

$ssg->pageMeta->title = $tpl->meta->title ?? null;
$ssg->pageMeta->desc = $tpl->meta->desc ?? null;
$ssg->pageMeta->selectedTab = $tpl->meta->selectedTab ?? "index";

include 'layout/header.php';
?>

    <div class='box singlePage'>
        <?= $tpl->content ?>
    </div>

<?php
include 'layout/footer.php';
