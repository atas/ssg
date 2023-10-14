<?php

use JetBrains\PhpStorm\NoReturn;
use League\CommonMark\Exception\CommonMarkException;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . '/Types.php');

$config = json_decode(file_get_contents(__DIR__ . "/../config.json"));

if ($config == null) {
    die("Config file is invalid");
}

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

/**
 * Gets the current full hostname with protocol
 * @return string
 */
function getCurrentHostname(): string
{
    // Check if HTTPS or HTTP is being used
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";

    // Get the server port
    $port = $_SERVER['SERVER_PORT'];

    // Depending on whether the port is standard for the protocol, include it in the URL
    if (($protocol === 'http' && $port == 80) || ($protocol === 'https' && $port == 443)) {
        // Standard ports for HTTP and HTTPS, respectively. No need to include the port in the URL.
        $currentUrl = "{$_SERVER['HTTP_HOST']}";
    } else {
        // Non-standard port, include it in the URL.
        $currentUrl = "{$_SERVER['HTTP_HOST']}:{$port}";
    }

    return $currentUrl;
}

/**
 * Gets the current full hostname with protocol
 * @return string
 */
function getCurrentHostnameWithProtocol(): string
{
    // Check if HTTPS or HTTP is being used
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";

    return "{$protocol}://" . getCurrentHostname();
}
