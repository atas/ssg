<?php

use JetBrains\PhpStorm\NoReturn;
use League\CommonMark\Exception\CommonMarkException;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . '/Types.php');

$config = json_decode(file_get_contents(__DIR__ . "/../config.json"));

$page_meta = new PageMeta();
$page_meta->desc = $config->site_desc;

/**
 * Get a markdown file by its path, by converting that to html
 * @param $path
 * @return ConvertedMarkdown
 * @throws CommonMarkException
 */
function get_markdown($path): ConvertedMarkdown
{
    if (!file_exists($path)) {
        exit_with_not_found();
    }

    require_once 'system/markdown.php';

    return convert_markdown($path);
}

/**
 * Generate and return all posts as an array
 * @return Post[]
 * @throws CommonMarkException
 */
function get_all_posts(): array
{
    $posts = [];
    $files = glob('posts/*.md');
    rsort($files);
    foreach ($files as $key => $post_file_path) {
        $tpl = get_markdown($post_file_path);

        $postObj = new Post();
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
#[NoReturn] function exit_with_not_found(): void
{
    header('HTTP/1.0 404 Not Found');
    include_once '404.php';
    exit;
}