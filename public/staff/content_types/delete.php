<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(get_url('/staff/content_types/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $result = delete_content_type($id);
  $_SESSION['message'] = 'The content_type was deleted successfully.';
  redirect_to(get_url('/staff/content_types/index.php'));

} else {
  $content_type = find_content_type_by_id($id);
}

?>

<?php $page_title = 'Delete Content type'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/index.php'); ?>">&laquo; Back to List</a>

  <div class="content_type delete">
    <h1>Delete Content type</h1>
    <p>Are you sure you want to delete this content type?</p>
    <p class="item"><?php echo h($content_type['name']); ?></p>

    <form action="<?php echo get_url('/staff/content_types/delete.php?id=' . h(u($content_type['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Content type" />
      </div>
    </form>
  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
