---
title: About IDs in Post Markdown Files
desc: "A paragraph about why using IDs in post markdown files."
slug: ids-in-post-markdown-files
---

[TOC]

# About IDs in Post Markdown Files

The IDs in post markdown (.md) files is just for ordering. The site orders the files by descensing by their filename,
this way if you want to move a post up or down you can easily do so by changing the ID.

## About URLs and IDs

Post URLs come from the `slug` defined above markdown front matter. Changing the ID won't change the post link, but 
it will only change the ordering on the homepage.

## New posts

By default you can increment the biggest post ID by 1 and use it for your new post. This way, latest post will be at 
the top.

## Be careful about string ordering

Be careful that this is not a numeric ordering, 11 will come before 2. Because we are ordering descending, 2 will 
come to top. If you want to use numeric ordering, you can use 02, 11, 12, etc. This way, 02 will come before 11.

When you have posts with IDs 1, 2, 3 and you want to add a new post between 1 and 2, you can use 11 or 15 as the ID 
for that post without changing the other post IDs.

