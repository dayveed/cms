<?php require_once('../../../private/initialize.php'); ?>

<?php

  require_login();

  $page_set = find_all_pages();

?>

<?php $page_title = 'Pages'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="pages listing">
    <h1>Pages</h1>

    <div class="actions">
      <a class="action" href="<?php echo get_url('/staff/pages/new.php'); ?>">Create New Page</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>content_type</th>
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
          <td><?php echo h($content_type['name']); ?></td>
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

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
