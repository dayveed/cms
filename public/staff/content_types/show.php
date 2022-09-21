<?php require_once('../../../private/initialize.php'); ?>

<?php
require_login();

$id = $_GET['id'] ?? '1'; 

$content_type = find_content_type_by_id($id);
$page_set = find_pages_by_content_type_id($id);

?>

<?php $page_title = 'Show Content type'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo get_url('/staff/content_types/index.php'); ?>">&laquo; Back to List</a>

  <div class="content_type show">

    <h1>Content type: <?php echo h($content_type['name']); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Menu Name</dt>
        <dd><?php echo h($content_type['name']); ?></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd><?php echo h($content_type['position']); ?></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd><?php echo $content_type['visible'] == '1' ? 'true' : 'false'; ?></dd>
      </dl>
    </div>

    <hr />

    <div class="pages listing">
      <h2>Pages</h2>

      

      <table class="list">
        <tr>
          <th>ID</th>
          <th>Position</th>
          <th>Visible</th>
          <th>Name</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>

        <?php while($page = mysqli_fetch_assoc($page_set)) { ?>
          <?php $content_type = find_content_type_by_id($page['content_type_id']); ?>
          <tr>
            <td><?php echo h($page['id']); ?></td>
            <td><?php echo h($page['position']); ?></td>
            <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
            <td><?php echo h($page['title']); ?></td>
            <td><a class="action" href="<?php echo get_url('/staff/pages/show.php?id=' . h(u($page['id']))); ?>">View</a></td>
            <td><a class="action" href="<?php echo get_url('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
            <td><a class="action" href="<?php echo get_url('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a></td>
          </tr>
        <?php } ?>
      </table>

      <?php mysqli_free_result($page_set); ?>

    </div>



  </div>

</div>
