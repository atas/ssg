<?php

class Post {
    public string $title;
    public string $desc;
    public string $slug;
    public string $filename;
}

class PageMeta
{
    public ?string $title = null;
    public string $type = "website";
    public string $desc = "";
    public string $selectedTab = "";
    public string $og_image;
}

class ConvertedMarkdown {
    public string $content;
    public object $meta;
}
