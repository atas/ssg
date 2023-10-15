<?php

/**
 * Returns the 'selected' css class if the selectedTab variable matches the given tab name. Or returns empty string.
 * @param $tab string
 * @return string
 */
function selectedTabCss(string $tab): string
{
    global $page_meta;
    if ($page_meta->selectedTab == $tab) {
        return "selected";
    }
    return "";
}

/**
 * Secure email by splitting it into two parts so that it's not easily scrapable by bots
 * @return string
 */
function get_email_parts_in_js(): string
{
    global $config;
    $email_parts = explode('@', $config->email);
    if (count($email_parts) === 2) {
        return "const email_local = '$email_parts[0]'; const email_domain = '$email_parts[1]';";
    }

    return "";
}

/**
 * Some of the meta tags need processing before being outputted
 * @return ProcessedPageMeta
 */
function GetProcessedPageMeta(): ProcessedPageMeta
{
    global $page_meta, $config;

    $processed = new ProcessedPageMeta();

    $processed->title = !isset($page_meta->title) || strlen($page_meta->title) == 0 ? $config->full_title : "$page_meta->title$config->appended_title";
    $processed->desc = !isset($page_meta->desc) || strlen($page_meta->desc) == 0 ? $config->site_desc : $page_meta->desc;

    if (!preg_match('/^(https?:\/\/|\/)/', $page_meta->og_image)) {
        list($processed->og_image_width, $processed->og_image_height) = getimagesize($page_meta->og_image);
        $processed->og_image = getCurrentHostnameWithProtocol() . "/" . $page_meta->og_image;
    } else if (preg_match('/^https?:\/\//', $page_meta->og_image)) {
        $processed->og_image = $page_meta->og_image;
    }

    $processed->type = $page_meta->type;

    return $processed;
}