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

class ProcessedPageMeta
{
    public ?string $title = null;
    public string $desc = "";
    public string $type = "website";
    public string $og_image;
    public string $og_image_width;
    public string $og_image_height;
}

class ConvertedMarkdown {
    public string $content;
    public object $meta;
}
