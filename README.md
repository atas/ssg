# Ata's SSG - Simple PHP Static Site Generator for GitHub Pages

- No frameworks.
- No templating.
- No plugins.
- Just very basic PHP and HTML.

Simply clone, configure, and deploy!

## Demo - Examples

- This repo's CI deploys to: https://ssg-test.atasasmaz.com
- Production example: https://www.atasasmaz.com

## Quick Start

1. Clone the repo
2. `cd` into project dir, run `$ composer update`  
   If you don't have composer installed: [Composer](https://getcomposer.org/)
3. Run `$ make dev-server` (needs docker)  
   Your local php site will be running at **http://localhost:8002**
4. Add your markdown pages and posts to `./pages` and `./posts`, or .php files anywhere and commit & push to a new
   repo.
   - _Ensure `.github` dir from here is included in your new repo._

- Your site will be alive on GitHub Pages!

🔴 **IMPORTANT: Your repo name** should be `github-username.github.io` if you want to use GitHub Pages subdomain. To
use a **Custom Domain**, check my docs for [GITHUB PAGES](GITHUB-PAGES.md).

## Configuring GitHub Pages

See [GITHUB PAGES](GITHUB-PAGES.md).

## Related projects

- Custom GitHub Action: https://github.com/atas/ssg-html-builder-action
- Docker image: https://github.com/atas/ssg-builder-image
- PHP Lib: https://github.com/atas/ssg-system-php

## Why Ata's SSG?

- **Basic PHP**: PHP stands as a robust templating and server-side language, eliminating the need to learn new
  templating languages.

- **No Framework**: No learning new frameworks or applications. Familiarity with basic PHP is enough to get started. Just create your own HTML and PHP files.

- **Markdown & Beyond**: Write blog posts or create pages with Markdown. Need more complexity? Create HTML or PHP files.

- **Efficient Deployment**: Build process visits each PHP and markdown page, saves their HTML, and deploys to GitHub
  Pages.

- **Instant Local Preview**: There is an integrated docker-based local Nginx & PHP server, just run `make dev-server`
  to Visualize your changes locally by just refreshing the page without a build process.

## Customisation of your site

- Update the `config.json` at root, and `favicon-96.jpg` `site-icon.jpg` `site-icon-big.jpg` at `./assets/images`

- Pages: see examples in `./pages`. Page URLs are derived from the file name. `my-post.md` will be `yoursite.
com/my-post`.

- Blog Posts: see examples in `./posts`. Post URLs are derived from `slug` key in the front matter. Blog post files
  start with an id e.g. 2_some_title.md and IDs are used to sort them in descending order. It's a string comparison
  sort, not numeric.

- Layout changes: see `./layout` directory.

- Open file `./layout/footer.php` to add your tracking code like Google Analytics, Matomo (Piwik), etc.

  - If using advanced analytics, add a GDPR banner, or use analytics with anonymisation. See my blog post about
    more: https://www.atasasmaz.com/p/gdpr-friendly-analytics

- CSS changes: `less` is used to generate `css` files, see `./assets/styles` directory.
  - Check `.github/workflows/build-and-deploy.yml` and remove line pointing to the `.less` file if you don't want to
    LESS and use good old CSS.

## Having custom PHP files to HTML

You can create any .php at root or any sub-dir. `./layout`, `post.php` and `page.php` are excluded from individual
PHP to HTML generation.

`./my-custom.php` will be `yoursite.com/my-custom`  
`./my-custom-dir/my-custom.php` will be `yoursite.com/my-custom-dir/my-custom`

Omit `.php` extensions in the URLs and links, but keep them in the actual files.

## Local Development Environment

You can spin up the docker container and let it serve the PHP site locally, without a build process. You need to
have `docker` installed on your machine.

`cd` into the project directory

run:

```
composer update
make dev-server
```

Alternatively, if you don't have `make` installed, you can run below, and adjust the port `8002` to your liking:

```
docker run --rm -it --entrypoint /dev-server-entrypoint.sh -p 8002:80 \
    -v $(pwd):/workspace ghcr.io/atas/ssg-builder:latest
```

Your local php site will be running at **http://localhost:8002** with instant updates on page refresh, as PHP does.

## Keep in touch with this repo's future updates

- Create your empty repo on GitHub with nothing in it, nothing.
- Clone this repo to your local.
- `cd` into this repo and run

```
git remote add upstream git@github.com:atas/ssg.git
git checkout -b updates-from-upstream
git fetch upstream
git checkout main
git merge upstream/main
git push
```

Then create a pull request from `updates-from-upstream` branch to `main` branch and go through it.

## Future Plans

### Pagination for posts

I am a fan of continuous scrolling and not numbered pages. We can implement continuous scrolling on the homepage but
I can't imagine if it can be helpful for sites with less than 100 posts. Even after 100 posts, it should not
be a big problem for the page to be rendered. I am open for suggestions though.
