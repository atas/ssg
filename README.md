# Ata's SSG - A PHP-based Static Site Generator for GitHub Pages

Harness the power of PHP to create static sites seamlessly for GitHub Pages. With Ata's SSG, there's no need to juggle complex frameworks or master new templating languages. Simply fork, configure, and deploy!

## Demo - Examples
This repo's CI deploys to https://ssg-test.atasasmaz.com you can visit there as a demo or visit my webpage for a 
production-environment example at https://www.atasasmaz.com which has a separate private repo forked from this repo.

## Why Ata's SSG?

* **Simplicity with PHP**: PHP stands as a robust templating and server-side language, eliminating the need to learn new templating languages.

* **No Framework Learning Curve**: Forget about the learning curve associated with new frameworks or 
  applications. Familiarity with basic PHP is enough to get started. It's just few files.

* **Markdown & Beyond**: Craft blog posts or pages with Markdown. Need more complexity? Integrate PHP effortlessly.

* **Efficient Deployment**: The process is straightforward. Build process visits each PHP and markdown page during, 
  saves its HTML, and deploy directly to GitHub Pages.

* **Instant Local Preview**: If you setup a local PHP server, Visualize your changes locally in real-time, ensuring 
  your 
  development cycle isn't 
  hindered by lengthy build times.

**Disclaimer**: This project is purposefully kept as simple as possible for those just needing to output some HTML 
from the simplest PHP files.

## How to Use

FYI: GitHub Pages for public repos are free, private repos require paid GitHub subscription.

1. Fork this repository and **name the fork** as `your-github-username.github.io` if you want to use GitHub Pages as 
   `https://your-github-username.github.io` or name it anything else if you want to use a custom domain.

2. Update the `config.json` file to your liking.
3. Update images `favicon-96.jpg` `site-icon.jpg` `site-icon-big.jpg` at `./assets/images`
4. Add your pages to ./pages directory in Markdown format. Page URLs are derived from the file name. `my-post.md`
   will be
   `yoursite.com/my-post` automatically.
5. Add your posts to `./posts` directory in Markdown format. Post URLs are derived from `slug` key in the front matter.
   See
   the existing examples.
6. Open file `./layout/footer.php` to add your tracking code if you want, Google Analytics, Matomo (Piwik), etc.
    * If using advanced analytics, add a GDPR banner, or use analytics with anonymisation. See my blog post about
      more: https://www.atasasmaz.com/p/gdpr-friendly-analytics
7. For changing the layout, see `layout` directory, especially `header.php` and `footer.php`, simple HTML files with 
  minimal PHP in them. For CSS changes, `less` is used to generate `css` files, see `./assets/styles` directory.
8. Follow the below steps to deploy to GitHub Pages.

### Individual PHP file to HTML

You can create any .php page at root directory or project or any subdirectory. `./system` and `./layout` directories, 
`post.php` and `page.php` are excluded from individual PHP to HTML generation.

`./my-custom.php` will be `yoursite.com/my-custom`  
`./my-custom-dir/my-custom.php` will be `yoursite.com/my-custom-dir/my-custom`

Nginx configuration includes extensionless-php directives to remove `.php` extension from URLs in your local dev 
environment. Don't put `.php` extensions in the URLs and links, just put in files.

## Enabling GitHub Pages

1. Go to your repo -> Settings -> Pages (on the left) and select `GitHub Actions` option in the `Source` select box, 
   change it from `Deploy from a branch`.
2. Do not select Jekyll or static site options below, don't click on them.
3. Go to Actions tab of your repo, beside `Code` and `Pull requests`.
4. **Enable the Workflow**.
5. Select Deploy Website from the left column.
6. Click `Run Workflow` button on the right and click `Run Workflow` again.
7. Now Select `All workflows` on the left column and see the progress of the build process.

### Using GitHub Pages as `https://username.github.io`

Nothing else to do, your website should be alive.

### Using GitHub Pages through custom domain

* Go to `your repo -> Settings -> Pages` (on the left) and select GitHub Actions option in the Source select box.
* Add a custom domain below, anything you want, you will need to access to its DNS records.
* Add below A and AAAA records for your domain name or subdomain. Official docs are here: https://docs.github.com/en/pages/configuring-a-custom-domain-for-your-github-pages-site

_FYI: You can have multiple A and AAAA records for the same domain or subdomain name._
```
A 185.199.108.153
A 185.199.109.153
A 185.199.111.153
A 185.199.110.153
AAAA 2606:50c0:8003::153
AAAA 2606:50c0:8002::153
AAAA 2606:50c0:8001::153
AAAA 2606:50c0:8000::153
```
* * If your repo name matches `your-github-username.github.io`, which you can only have one repo in this name, then 
    you can also add `your-github-username.github.io` as a CNAME record to your DNS records instead and still have a 
    custom domain, instead of the IP addresses above.

## Local Development Environment

You can spin up the docker container and let it serve the PHP site locally, without a build process. You need to 
have `docker` installed on your machine.

`cd` into the project directory

run:
```
make dev-server
```

Alternatively, you don't have `make` installed, you can run below, and adjust the port `8001` to your liking:
```
docker run --rm -it --entrypoint /workspace/system/bin/dev-server-entrypoint.sh -p 8001:80 \
    -v $(shell pwd):/workspace ghcr.io/atas/ssg-builder::latest
```

Your local php site will be running at **http://localhost:8001** with instant updates on page refresh, as PHP does.

## Future Plans

### Caching Markdown files for performance in local env

Caching for page and post Markdowns in local environment will be added, so that the local dev env is fast to 
navigate between pages.