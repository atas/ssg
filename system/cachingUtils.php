<?php
function findMostRecentlyUpdatedFile($dir) {
    $latestFile = "";
    $latestTime = 0;

    foreach (scandir($dir) as $file) {
        // Avoid directories and only check files
        if (is_file($dir . '/' . $file)) {
            $fileTime = filemtime($dir . '/' . $file);
            if ($fileTime > $latestTime) {
                $latestTime = $fileTime;
                $latestFile = $file;
            }
        }
    }

    return $latestTime;
}

/*
 * TODO: This function needs refactoring, should be a class, and needs tests.
 * @return Post[]
 */
function updateAndGetCachedPostList(): array
{
    $cachePath = __DIR__ . '/../tmp/posts.json';
    $postsDir = __DIR__ . '/../posts/';

    /* @var Post[] $cachedPosts */
    $cachedPosts = [];
    if (file_exists($cachePath)) {
        $cachedPostsJson = file_get_contents($cachePath);
        $cachedPosts = json_decode($cachedPostsJson);
    }

    $cacheModified = false; // Flag to track modifications

    // Iterate through each post in the directory
    $postFiles = scandir($postsDir);
    foreach ($postFiles as $postFile) {
        if (is_file($postsDir . $postFile)) {
            $lastModified = filemtime($postsDir . $postFile);

            // Check if post is in cache and if its lastModified is outdated
            $shouldUpdateCache = true;
            foreach ($cachedPosts as &$cachedPost) {
                if ($cachedPost->filename === $postFile && $cachedPost->lastModified >= $lastModified) {
                    $shouldUpdateCache = false;
                    break;
                }
            }

            // If post is outdated or not in cache, update its data
            if ($shouldUpdateCache) {
                $tpl = get_markdown($postsDir . $postFile);

                $postObj = new stdClass();
                $postObj->title = $tpl->meta->title;
                $postObj->desc = $tpl->meta->desc;
                $postObj->slug = $tpl->meta->slug;
                $postObj->filename = $postFile;
                $postObj->lastModified = $lastModified;

                // Replace or append the post in the cache array
                $found = false;
                foreach ($cachedPosts as &$cachedPost) {
                    if ($cachedPost->filename === $postFile) {
                        $cachedPost = $postObj;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $cachedPosts[] = $postObj;
                }

                $cacheModified = true; // Mark that the cache has been modified
            }
        }
    }

    // Only save the updated cache if it was modified
    if ($cacheModified) {
        file_put_contents($cachePath, json_encode($cachedPosts, JSON_PRETTY_PRINT));
    }

    return $cachedPosts;
}
