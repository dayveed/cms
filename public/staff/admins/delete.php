<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(get_url('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  $result = delete_admin($id);
  $_SESSION['message'] = 'Admin deleted.';
  redirect_to(get_url('/staff/admins/index.php'));
} else {
  $admin = find_admin_by_id($id);
}

?>

<?php $page_title = 'Delete Admin'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin delete">
    <h1>Delete Admin</h1>
    <p>Are you sure you want to delete this admin?</p>
    <p class="item"><?php echo h($admin['username']); ?></p>

    <form action="<?php echo get_url('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Admin" />
      </div>
    </form>
  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
