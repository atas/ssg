<?php
require 'vendor/autoload.php';

use Atas\SsgSystemPhp\AtasSsg;

$ssg = new AtasSsg(__DIR__);
$ssg->pageMeta->selectedTab = $tpl->meta->selectedTab ?? "home";

$ssg->pageMeta->title = "404 Not Found";
$ssg->pageMeta->desc = "This page has not been found.";

require_once 'layout/header.php';
?>

    <div class="box">
        <h1>404 Not Found</h1>
        <a href='/' class='btn white'>HOME</a>
    </div>

<?php
require_once 'layout/footer.php';
