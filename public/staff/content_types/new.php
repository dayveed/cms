<?php

require_once('../../../private/initialize.php');

require_login();

$content_type_set = find_all_content_types();
$content_type_count = mysqli_num_rows($content_type_set) + 1;
mysqli_free_result($content_type_set);

if(is_post_request()) {

  $content_type = [];
  $content_type['name'] = $_POST['name'] ?? '';
  $content_type['position'] = $_POST['position'] ?? '';
  $content_type['visible'] = $_POST['visible'] ?? '';

  $result = insert_content_type($content_type);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The content_type was created successfully.';
    redirect_to(get_url('/staff/content_types/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  
  $content_type = [];
  $content_type["name"] = '';
  $content_type["position"] = $content_type_count;
  $content_type["visible"] = '';
}

?>

<?php $page_title = 'Create Content type'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/index.php'); ?>">&laquo; Back to List</a>

  <div class="content_type new">
    <h1>Create Content type</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo get_url('/staff/content_types/new.php'); ?>" method="post">
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
          <input type="checkbox" name="visible" value="1"<?php if($content_type['visible'] == 1) { echo " checked"; } ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Content type" />
      </div>
    </form>

  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
