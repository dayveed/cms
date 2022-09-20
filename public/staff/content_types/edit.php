<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(get_url('/staff/content_types/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $content_type = [];
  $content_type['id'] = $id;
  $content_type['name'] = $_POST['name'] ?? '';
  $content_type['position'] = $_POST['position'] ?? '';
  $content_type['visible'] = $_POST['visible'] ?? '';

  $result = update_content_type($content_type);
  if($result === true) {
    $_SESSION['message'] = 'The content_type was updated successfully.';
    redirect_to(get_url('/staff/content_types/show.php?id=' . $id));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  $content_type = find_content_type_by_id($id);

}

$content_type_set = find_all_content_types();
$content_type_count = mysqli_num_rows($content_type_set);
mysqli_free_result($content_type_set);

?>

<?php $page_title = 'Edit Content type'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/index.php'); ?>">&laquo; Back to List</a>

  <div class="content_type edit">
    <h1>Edit Content type</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo get_url('/staff/content_types/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="name" value="<?php echo h($content_type['name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
          <?php
            for($i=1; $i <= $content_type_count; $i++) {
              echo "<option value=\"{$i}\"";
              if($content_type["position"] == $i) {
                echo " selected";
              }
              echo ">{$i}</option>";
            }
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1"<?php if($content_type['visible'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Content type" />
      </div>
    </form>

  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
