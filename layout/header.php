<?php

global $ssg;

$processed_meta = $ssg->layout->GetProcessedPageMeta();

?>
<!-- Built with Ata's SSG https://www.github.com/atas/ssg -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="viewport"
          content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no, user-scalable=no"/>
    <meta name="theme-color" content="#000000"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <meta name="description" content="<?= $processed_meta->desc ?>"/>

    <meta property="og:url" content="<?= $ssg->getCurrentFullUrl() ?>"/>
    <meta property="og:type" content="<?= $processed_meta->type ?>"/>
    <meta property="og:title" content="<?= $processed_meta->title ?>"/>
    <meta property="og:description" content="<?= $processed_meta->desc ?>"/>
    <?php
        if (isset($processed_meta->og_image))
            echo "<meta property=\"og:image\" content=\"$processed_meta->og_image\"/>\n";
        if (isset($processed_meta->og_image_width))
            echo "<meta property=\"og:image:width\" content=\"$processed_meta->og_image_width\"/>\n";
        if (isset($processed_meta->og_image_height))
            echo "<meta property=\"og:image:height\" content=\"$processed_meta->og_image_height\"/>\n";
    ?>
    <title><?= $processed_meta->title ?></title>
    <?php
    if ($ssg->isBuildRunning()) {
        ?> <link rel="stylesheet" href="/assets/styles/style.css"> <?php
    }
    else {
        ?>
        <link rel="stylesheet/less" type="text/css" href="/assets/styles/style.less">
        <script src="https://cdn.jsdelivr.net/npm/less" ></script>
        <?php
    }
    ?>
    <link rel="icon" type="image/jpeg" href="/assets/images/favicon-96.jpg">
    <script>
        <?= $ssg->layout->get_email_parts_in_js() ?>
    </script>
    <script src="/assets/site.js"></script>
</head>
<body>

<div id="header">
    <div class="info">
        <a href="/assets/images/site-icon-big.jpg" target="_blank">
            <img src="/assets/images/site-icon.jpg" alt="Ata's photo" width="42" height="42" class="ataImg"/>
        </a>

        <div id="h1Wrapper">
            <span class="bashArrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44">
                    <path fill="none" d="M15 8l14.729 14.382L15 35.367"></path>
                </svg>
            </span>
            <h1>
                <a href="/"><?= $ssg->config->site_top_h1 ?></a>
            </h1>
            <div class="cursor"></div>
        </div>

        <div class="shortAbout">
            <?= $ssg->config->site_top_about_line1 ?>
            <br class="br"/>
            <?= $ssg->config->site_top_about_line2 ?>
        </div>
    </div>

    <div id="tabs">
        <div class="tabsContent">
            <a href="/" class="<?= $ssg->layout->selectedTabCss("home") ?>">
                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <title>216242_home_icon-svg</title>
                    <style>
                        .s0 {
                            fill: #ffffff
                        }
                    </style>
                    <path id="Layer" class="s0"
                          d="m12 3c0 0-6.2 5.3-9.6 8.2-0.2 0.2-0.4 0.5-0.4 0.8 0 0.6 0.4 1 1 1h2v7c0 0.6 0.4 1 1 1h3c0.6 0 1-0.4 1-1v-4h4v4c0 0.6 0.4 1 1 1h3c0.6 0 1-0.4 1-1v-7h2c0.6 0 1-0.4 1-1 0-0.3-0.2-0.6-0.4-0.8-3.4-2.9-9.6-8.2-9.6-8.2z"/>
                </svg>

                <div class="text">
                    Home
                </div>
            </a>

            <a href="/about" class="<?= $ssg->layout->selectedTabCss("about") ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title/>
                    <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm-.5,3A1.5,1.5,0,1,1,10,6.5,1.5,1.5,0,0,1,11.5,5ZM14,18H13a2,2,0,0,1-2-2V12a1,1,0,0,1,0-2h1a1,1,0,0,1,1,1v5h1a1,1,0,0,1,0,2Z"
                          fill="#ffffff"/>
                </svg>
                <div class="text">
                    About
                </div>
            </a>

            <a href="/contact" class="<?= $ssg->layout->selectedTabCss("contact") ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="1792" viewBox="0 0 1792 1792" width="1792">
                    <path d="M1100 775q0-108-53.5-169t-147.5-61q-63 0-124 30.5t-110 84.5-79.5 137-30.5 180q0 112 53.5 173t150.5 61q96 0 176-66.5t122.5-166 42.5-203.5zm564 121q0 111-37 197t-98.5 135-131.5 74.5-145 27.5q-6 0-15.5.5t-16.5.5q-95 0-142-53-28-33-33-83-52 66-131.5 110t-173.5 44q-161 0-249.5-95.5t-88.5-269.5q0-157 66-290t179-210.5 246-77.5q87 0 155 35.5t106 99.5l2-19 11-56q1-6 5.5-12t9.5-6h118q5 0 13 11 5 5 3 16l-120 614q-5 24-5 48 0 39 12.5 52t44.5 13q28-1 57-5.5t73-24 77-50 57-89.5 24-137q0-292-174-466t-466-174q-130 0-248.5 51t-204 136.5-136.5 204-51 248.5 51 248.5 136.5 204 204 136.5 248.5 51q228 0 405-144 11-9 24-8t21 12l41 49q8 12 7 24-2 13-12 22-102 83-227.5 128t-258.5 45q-156 0-298-61t-245-164-164-245-61-298 61-298 164-245 245-164 298-61q344 0 556 212t212 556z"
                          fill="#ffffff"/>
                </svg>
                <div class="text">
                    Contact
                </div>
            </a>
        </div>
    </div>
</div>

<div id="bodyWrapper">

    <div id="content">

        <div class="socialMediaIcons">
            <?php if (isset($ssg->config->linkedin_url) && strlen($ssg->config->linkedin_url) > 0) { ?>
                <a href="<?= $ssg->config->linkedin_url ?>" target="_blank" rel="nofollow noreferrer" title="on LinkedIn">
                    <img src="/assets/images/linkedin-icon.svg" alt="GitHub icon" />
                </a>
            <?php } ?>

            <?php if (isset($ssg->config->twitter_url) && strlen($ssg->config->twitter_url) > 0) { ?>
                <a href="<?= $ssg->config->twitter_url ?>" target="_blank" rel="nofollow noreferrer" title="on X / Twitter">
                    <img src="/assets/images/x-icon.svg"  alt="X / Twitter Icon"/>
                </a>
            <?php } ?>

            <?php if (isset($ssg->config->github_url) && strlen($ssg->config->github_url) > 0) { ?>
                <a href="<?= $ssg->config->github_url ?>" target="_blank" rel="nofollow noreferrer" title="on GitHub">
                    <img src="/assets/images/github-icon.svg" alt="GitHub icon" />
                </a>
            <?php } ?>
        </div>

        <?php if (isset($ssg->config->location) && strlen($ssg->config->location) > 0) { ?>
        <div class="location">
            <img src="/assets/images/location.svg" alt="Location Icon"/>
            <?= $ssg->config->location ?>
        </div>
        <?php } ?>
        
        <div class="clear"></div>