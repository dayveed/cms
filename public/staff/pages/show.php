<?php require_once('../../../private/initialize.php'); ?>

<?php

require_login();


$id = $_GET['id'] ?? '1'; 

$page = find_page_by_id($id);
$content_type = find_content_type_by_id($page['content_type_id']);

?>

<?php $page_title = 'Show Page'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/show.php?id=' . h(u($content_type['id']))); ?>">&laquo; Back to Content types Page</a>

  <div class="page show">

    <h1>Page: <?php echo h($page['title']); ?></h1>

    <div class="actions">
      <a class="action" href="<?php echo get_url('/index.php?id=' . h(u($page['id'])) . '&preview=true'); ?>" target="_blank">Preview</a>
    </div>

    <div class="attributes">
      <dl>
        <dt>Content type</dt>
        <dd><?php echo h($content_type['name']); ?></dd>
      </dl>
      <dl>
        <dt>Title</dt>
        <dd><?php echo h($page['title']); ?></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd><?php echo h($page['position']); ?></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd><?php echo $page['visible'] == '1' ? 'true' : 'false'; ?></dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd><?php echo h($page['content']); ?></dd>
      </dl>
    </div>


  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
