<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(get_url('/staff/pages/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $page = [];
  $page['id'] = $id;
  $page['content_type_id'] = $_POST['content_type_id'] ?? '';
  $page['title'] = $_POST['title'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content'] ?? '';

  $result = update_page($page);
  if($result === true) {
    $_SESSION['message'] = 'The page was updated successfully.';
    redirect_to(get_url('/staff/pages/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $page = find_page_by_id($id);

}

$page_count = count_pages_by_content_type_id($page['content_type_id']);

?>

<?php $page_title = 'Edit Page'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/show.php?id=' . h(u($page['content_type_id']))); ?>">&laquo; Back to Content type Page</a>

  <div class="page edit">
    <h1>Edit Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo get_url('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Content type</dt>
        <dd>
          <select name="content_type_id">
          <?php
            $content_type_set = find_all_content_types();
            while($content_type = mysqli_fetch_assoc($content_type_set)) {
              echo "<option value=\"" . h($content_type['id']) . "\"";
              if($page["content_type_id"] == $content_type['id']) {
                echo " selected";
              }
              echo ">" . h($content_type['name']) . "</option>";
            }
            mysqli_free_result($content_type_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="name" value="<?php echo h($page['title']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php
              for($i=1; $i <= $page_count; $i++) {
                echo "<option value=\"{$i}\"";
                if($page["position"] == $i) {
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
          <input type="checkbox" name="visible" value="1"<?php if($page['visible'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
