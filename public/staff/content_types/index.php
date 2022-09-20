<?php require_once('../../../private/initialize.php'); ?>

<?php

  require_login();

  $content_type_set = find_all_content_types();

?>

<?php $page_title = 'Content types'; ?>
<?php include(COMMON_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="content_types listing">
    <h1>Content types</h1>

    <div class="actions">
      <a class="action" href="<?php echo get_url('/staff/content_types/new.php'); ?>">Create New Content type</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
  	    <th>Name</th>
        <th>Pages</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($content_type = mysqli_fetch_assoc($content_type_set)) { ?>
        <?php $page_count = count_pages_by_content_type_id($content_type['id']); ?>
        <tr>
          <td><?php echo h($content_type['id']); ?></td>
          <td><?php echo h($content_type['position']); ?></td>
          <td><?php echo $content_type['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo h($content_type['name']); ?></td>
          <td><?php echo $page_count; ?></td>
          <td><a class="action" href="<?php echo get_url('/staff/content_types/show.php?id=' . h(u($content_type['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo get_url('/staff/content_types/edit.php?id=' . h(u($content_type['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo get_url('/staff/content_types/delete.php?id=' . h(u($content_type['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($content_type_set);
    ?>
  </div>

</div>

<?php include(COMMON_PATH . '/staff_footer.php'); ?>
