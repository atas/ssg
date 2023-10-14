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


