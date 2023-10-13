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
 * Are we running like a PHP site or if the build pipeline running this?
 * @return bool
 */
function isBuildRunning(): bool
{
    return file_exists(__DIR__ . "/../build.lock");
}

/**
 * Gets the current full URL
 * @return string
 */
function getCurrentFullUrl(): string
{
    // Check if HTTPS or HTTP is being used
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";

    // Construct the full URL
    $currentUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $currentUrl;
}
