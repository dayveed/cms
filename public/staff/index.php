<?php require_once('../../private/initialize.php'); ?>

<?php require_login(); ?>

<?php $page_title = 'Staff Menu'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li><a href="<?php echo get_url('/staff/content_types/index.php'); ?>">Content types</a></li>
      <li><a href="<?php echo get_url('/staff/pages/index.php'); ?>">Pages</a></li>
      <li><a href="<?php echo get_url('/staff/admins/index.php'); ?>">Admins</a></li>
    </ul>
  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
