<?php

namespace Atas\SsgSystemPhp\Tests;

require 'system/bootstrap.php';

use Atas\SsgSystemPhp\PostsCache;
use PHPUnit\Framework\TestCase;

class PostsCacheTest extends TestCase
{
    protected string $postsDir;
    protected string $postsCacheFilePath;

    protected function setUp(): void
    {
        $this->postsDir = __DIR__ . "/../tmp/test_posts/";
        $this->postsCacheFilePath = __DIR__ . "/../tmp/test_cache.json";

        if (!is_dir($this->postsDir)) {
            mkdir($this->postsDir);
        }
    }

    protected function tearDown(): void
    {
        if (file_exists($this->postsCacheFilePath)) {
            unlink($this->postsCacheFilePath);
        }

        shell_exec("rm -rf " . escapeshellarg($this->postsDir) . " $this->postsCacheFilePath");
    }

    public function testUpdateAndGetCachedPostList()
    {
        // Create a dummy post file
        file_put_contents($this->postsDir . 'test.md',
            "---\ntitle: Mocked Title\ndesc: Mocked Description\nslug: mocked-slug\n---\n# Mocked Title\nThis is a mocked post content.");

        // Instantiate TestablePostsCache with the test environment
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);

        // Run the method
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that the cached list is as expected
        $this->assertCount(1, $posts);
        $this->assertEquals("Mocked Title", $posts[0]->title);
        $this->assertEquals("Mocked Description", $posts[0]->desc);
        $this->assertEquals("mocked-slug", $posts[0]->slug);
    }

    public function testAddingNewPostUpdatesCache()
    {
        // Create an initial dummy post
        file_put_contents($this->postsDir . 'a.md', "# Mocked Title\nThis is a mocked post content.");

        // Instantiate TestablePostsCache with the test environment
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);

        // Run the method
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that the cached list is as expected
        $this->assertCount(1, $posts);

        // Now, add another post
        file_put_contents($this->postsDir . 'b.md', "# Another Mocked Title\nThis is another mocked post content.");

        // Run the method again
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that the cached list is updated
        $this->assertCount(2, $posts);
    }

    public function testSortingOfPosts()
    {
        // Create multiple dummy posts
        file_put_contents($this->postsDir . 'c.md', "# C Title\nThis is a mocked post content.");
        file_put_contents($this->postsDir . 'a.md', "# A Title\nThis is a mocked post content.");
        file_put_contents($this->postsDir . 'b.md', "# B Title\nThis is another mocked post content.");

        // Instantiate TestablePostsCache with the test environment
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);

        // Run the method
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that posts are sorted
        $this->assertEquals('c.md', $posts[0]->filename);
        $this->assertEquals('b.md', $posts[1]->filename);
        $this->assertEquals('a.md', $posts[2]->filename);
    }

    public function testNonPostFilesAreIgnored()
    {
        // Create a dummy file that's not a post and a directory
        file_put_contents($this->postsDir . 'not_a_post.txt', "This is not a post content.");
        mkdir($this->postsDir . 'directory');

        // Instantiate TestablePostsCache with the test environment
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);

        // Run the method
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that the cached list is empty
        $this->assertCount(0, $posts);
    }

    public function testModifyingPostUpdatesCache()
    {
        // Create an initial dummy post
        $filePath = $this->postsDir . 'test.md';
        file_put_contents($filePath, "---\ntitle: Mocked Title\n---\n# test");

        // Instantiate TestablePostsCache with the test environment
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);
        $postsCache->updateAndGetCachedPostList();

        // Modify the post
        sleep(2);  // Ensuring the modified time changes
        unlink($filePath);
        file_put_contents($filePath, "---\ntitle: Modified Title\n---\n# test");

        // Run the method again
        $postsCache = new PostsCache($this->postsCacheFilePath, $this->postsDir);
        $posts = $postsCache->updateAndGetCachedPostList();

        // Assert that the post in the cached list is updated
        $this->assertEquals("Modified Title", $posts[0]->title);
    }
}
