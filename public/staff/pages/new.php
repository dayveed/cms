<?php

require_once('../../../private/initialize.php');

require_login();

if(is_post_request()) {
  
  $page = [];
  $page['content_type_id'] = $_POST['content_type_id'] ?? '';
  $page['title'] = $_POST['title'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content'] ?? '';
  $page['author_id'] = $_POST['author_id'] ?? '';

  $page['slug'] = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($page['title']))) ?? 'bob';


  $result = insert_page($page);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The page was created successfully.';
    redirect_to(get_url('/staff/pages/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {

  $page = [];
  $page['content_type_id'] = $_GET['content_type_id'] ?? '1';
  $page['title'] = '';
  $page['position'] = '';
  $page['visible'] = '';
  $page['content'] = '';
  $page['author_id'] = '';

}

$page_count = count_pages_by_content_type_id($page['content_type_id']) + 1;

?>

<?php $page_title = 'Create Page'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/show.php?id=' . h(u($page['content_type_id']))); ?>">&laquo; Back to Content type Page</a>

  <div class="page new">
    <h1>Create Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo get_url('/staff/pages/new.php'); ?>" method="post">
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
      <dl>
        <dt>Author</dt>
        <dd>
          <select name="author_id">
          <?php
            $author_set = find_all_authors();
            while($author = mysqli_fetch_assoc($author_set)) {
              echo "<option value=\"" . h($author['id']) . "\"";
              if($page["author_id"] == $author['id']) {
                echo " selected";
              }
              echo ">" . h($author['name']) . "</option>";
            }
            mysqli_free_result($author_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="title" value="<?php echo h($page['title']); ?>" /></dd>
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
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
