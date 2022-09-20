<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(get_url('/staff/pages/index.php'));
}
$id = $_GET['id'];

$page = find_page_by_id($id);
 

if(is_post_request()) {

  $result = delete_page($id);
  $_SESSION['message'] = 'The page was deleted successfully.';
  redirect_to(get_url('/staff/content_types/show.php?id=' . h(u($page['content_type_id']))));

}

?>

<?php $page_title = 'Delete Page'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/show.php?id=' . h(u($page['content_type_id']))); ?>">&laquo; Back to Content types Page</a>

  <div class="page delete">
    <h1>Delete Page</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo h($page['title']); ?></p>

    <form action="<?php echo get_url('/staff/pages/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Page" />
      </div>
    </form>
  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
