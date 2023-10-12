<?php

/**
 * Returns the 'selected' css class if the selectedTab variable matches the given tab name. Or returns empty string.
 * @param $tab
 * @return string
 */
function selectedTab($tab): string
{
    global $selectedTab;
    if ($selectedTab == $tab) {
        return "selected";
    }
    return "";
}

/**
 * Update config.json's local_hostname, in local host we use less.js in-browser compilation.
 * @return bool
 */
function isLocalHost(): bool
{
    global $config;
    return $_SERVER['HTTP_HOST'] == $config->local_hostname;
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

/**
 * Gets the current full hostname with protocol
 * @return string
 */
function getCurrentHostnameWithProtocol(): string
{
    // Check if HTTPS or HTTP is being used
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";

    // Construct the full URL
    $currentUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];
    return $currentUrl;
}