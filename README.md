# Ata's SSG - A PHP Static Site Generator

Harness the power of PHP to create static sites seamlessly for GitHub Pages. With Ata's SSG, there's no need to juggle complex frameworks or master new templating languages. Simply fork, configure, and deploy!

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

1. Fork this repository.
2. Update the `config.json` file to your liking.
3. Update images `favicon-96.jpg` `site-icon.jpg` `site-icon-big.jpg` at `./assets/images`
4. Add your pages to ./pages directory in Markdown format. Page URLs are derived from the file name. `my-post.md`
   will be
   `yoursite.com/my-post` automatically.
5. Add your posts to `./posts` directory in Markdown format. Post URLs are derived from `slug` key in the front matter.
   See
   the existing examples.
6. Open `layout/footer.php` to add your tracking code if you want, Google Analytics, Matomo (Piwik), etc.
    * If using advanced analytics, add a GDPR banner, or use analytics with anonymisation. See my blog post about
      more: https://www.atasasmaz.com/p/gdpr-friendly-analytics
7. For changing the layout, see `layout` directory, especially `header.php` and `footer.php`, simple HTML files with 
  minimal PHP in them. For CSS changes, `less` is used to generate `css` files, see `assets/styles` directory.
8. Follow the below steps to deploy to GitHub Pages.

## Using GitHub Pages as `https://username.github.io` 

* Your repo name must be `username.github.io` for this to work. Username is github username, lowercase. Rename your 
  repo.
* Public repos are free, private repos require paid GitHub subscription.  
...
TBA

## Using GitHub Pages through custom domain
...
TBA

## Local Development without build process
You can use either apache with php or nginx with php-fpm locally to run your site. When run locally, there is no 
build process, it's just PHP working server side.

For Nginx, use the config file in `system/workflow-image/nginx.conf` and follow the comments.
For local Apache, the .htaccess should be enough.

Ensure local hostname matches the `local_hostname` in `config.json` file. Add it to hosts file at `/etc/hosts` if 
necessary. 
Locally, http works fine, https is used in build process with self-signed cert to generate URLs correctly.