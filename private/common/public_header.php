<!doctype html>

<html lang="en">
  <head>
    <title><?php echo SITE_NAME; if(isset($page_title)) { echo '- ' . h($page_title); } ?><?php if(isset($preview) && $preview) { echo ' [PREVIEW]'; } ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo get_url('/stylesheets/public.css'); ?>" />
  </head>

  <body>

    <header>
      <h1>
        <a href="<?php echo get_url('/index.php'); ?>">
          <img src="<?php echo get_url('/images/cms_logo.jpg'); ?>" width="194" height="100" alt="" />
        </a>
      </h1>
    </header>
