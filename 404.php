<?php
require_once 'system/bootstrap.php';

global $page_meta;

$page_meta->title = "404 Not Found";
$page_meta->desc = "This page has not been found.";

require_once 'layout/header.php';
?>

    <div class="box">
        <h1>404 Not Found</h1>
        <a href='/' class='btn white'>HOME</a>
    </div>

<?php
require_once 'layout/footer.php';
