<?php

use JetBrains\PhpStorm\NoReturn;

require_once(__DIR__ . "/../vendor/autoload.php");

$config = json_decode(file_get_contents(__DIR__ . "/../config.json"));

class OpenGraph
{
    public ?string $title = null;
    public string $type = "website";
    public string $desc = "";
}

$og = new OpenGraph();
$og->desc = $config->site_desc;

/**
 * Get a markdown file by its path, by converting that to html
 * @param $path
 * @return stdClass
 */
function get_md($path): stdClass
{
    if (!file_exists($path)) {
        not_found();
    }

    require_once 'system/markdown.php';

    return convert_md($path);
}

/**
 * Generate and return all posts as an array
 * @return array
 */
function get_posts(): array
{
    $posts = [];
    $files = glob('posts/*.md');
    rsort($files);
    foreach ($files as $key => $post_file_path) {
        $tpl = get_md($post_file_path);

        $postObj = new stdClass();
        $postObj->title = $tpl->meta->title;
        $postObj->desc = $tpl->meta->desc;
        $postObj->slug = $tpl->meta->slug;
        $postObj->filename = $post_file_path;

        $posts[] = $postObj;
    }

    return $posts;
}

/**
 * Show not found page
 * @return void
 */
#[NoReturn] function not_found(): void
{
    header('HTTP/1.0 404 Not Found');
    include_once '404.php';
    exit;
}