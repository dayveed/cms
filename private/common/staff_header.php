<?php
  if(!isset($page_title)) { $page_title = 'Staff Area'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title><?php echo SITE_NAME.' - '.h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo get_url('/stylesheets/staff.css'); ?>" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  </head>

  <body>
    <header>
      <h1><?php echo SITE_NAME;?> Staff Area</h1>
    </header>

    <navigation>
      <ul>
        <li>User: <?php echo $_SESSION['username'] ?? ''; ?></li>
        <li><a href="<?php echo get_url('/staff/index.php'); ?>">Menu</a></li>
        <li><a href="<?php echo get_url('/staff/logout.php'); ?>">Logout</a></li>
      </ul>
    </navigation>

    <?php echo display_session_message(); ?>
