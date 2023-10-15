
# This page explains how to setup Github Pages

You can always consult to Official Docs as well, same things are explained here in a different way.  
https://docs.github.com/en/pages/configuring-a-custom-domain-for-your-github-pages-site

_FYI: GitHub Pages for public repos are free, private repos require paid GitHub subscription._

🔴 **IMPORTANT: Repo name** should be `github-username.github.io` if you want to use GitHub Pages subdomain. Change it
from `ssg` while forking the repo or later in the repo settings. To use a **Custom Domain**, scroll below for its steps.

1. Fork this repository and **name the fork** as `your-github-username.github.io` if you want to use GitHub Pages as
   `https://your-github-username.github.io` unless you use a custom domain with DNS records.


2. Go to your repo -> Settings -> Pages (on the left) and select `GitHub Actions` option in the `Source` select box,
    * Do not select Jekyll or static site options below, don't click on them.

3. Go to `Actions` tab of your repo at top, beside `Code` and `Pull requests`.

    * **Enable the Workflow**.
    * Select Deploy Website from the left column.
    * Click `Run Workflow` button on the right and click `Run Workflow` again.
    * Now Select `All workflows` on the left column and see the progress of the build process.

## Using a Custom Domain

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