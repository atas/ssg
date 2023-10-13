<?php

require_once(__DIR__."/../vendor/league/commonmark/src/GithubFlavoredMarkdownConverter.php");

use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;

/**
 * Get the markdown configuration array
 * @return array
 */
function get_md_config(): array
{
    global $config;
    return [
        'allow_unsafe_links' => false,
        'external_link' => [
            'internal_hosts' => [getCurrentHostname()],
            'open_in_new_window' => true,
            'html_class' => 'external-link',
            'nofollow' => '',
            'noopener' => 'external',
            'noreferrer' => 'external',
        ],
        'table_of_contents' => [
            'html_class' => 'table-of-contents',
            'position' => 'placeholder',
            'style' => 'bullet',
            'min_heading_level' => 2,
            'max_heading_level' => 6,
            'normalize' => 'relative',
            'placeholder' => '[TOC]',
        ],
        'heading_permalink' => [
//        'html_class' => 'heading-permalink',
//        'id_prefix' => 'user-content',
//        'inner_contents' => HeadingPermalinkRenderer::DEFAULT_INNER_CONTENTS,
            'insert' => 'before',
            'title' => 'Permalink',
        ]
    ];
}

/**
 * Converts a given markdown file to HTML with handy flavours and extensions.
 * @param $path
 * @return ConvertedMarkdown
 * @throws CommonMarkException
 */
function convert_markdown($path): ConvertedMarkdown
{
    $converter = new GithubFlavoredMarkdownConverter(get_md_config());

    $converter->getEnvironment()->addExtension(new FrontMatterExtension());
    $converter->getEnvironment()->addExtension(new ExternalLinkExtension());
    $converter->getEnvironment()->addExtension(new HeadingPermalinkExtension());
    $converter->getEnvironment()->addExtension(new TableOfContentsExtension());

    $md = file_get_contents($path);

    $output = $converter->convert($md);

    $tpl = new ConvertedMarkdown();
    $tpl->content = $output->getContent();

    if ($output instanceof RenderedContentWithFrontMatter) {
        $tpl->meta = (object) $output->getFrontMatter();
    }

    return $tpl;
}
