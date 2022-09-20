<?php
  // Default values to prevent errors
  $page_id = $page_id ?? '';
  $content_type_id = $content_type_id ?? '';
  $visible = $visible ?? true;
?>

<navigation>
  <?php $nav_content_types = find_all_content_types(['visible' => $visible]); ?>
  <ul class="content-types">
    <?php while($nav_content_type = mysqli_fetch_assoc($nav_content_types)) { ?>
      <?php // if(!$nav_content_type['visible']) { continue; } ?>
      <li class="<?php if($nav_content_type['id'] == $content_type_id) { echo 'selected'; } ?>">
        <a href="<?php echo get_url('index.php?content_type_id=' . h(u($nav_content_type['id']))); ?>">
          <?php echo h($nav_content_type['name']); ?>
        </a>

        <?php if($nav_content_type['id'] == $content_type_id) { ?>
          <?php $nav_pages = find_pages_by_content_type_id($nav_content_type['id'], ['visible' => $visible]); ?>
          <ul class="pages">
            <?php while($nav_page = mysqli_fetch_assoc($nav_pages)) { ?>
              <?php // if(!$nav_page['visible']) { continue; } ?>
              <li class="<?php if($nav_page['id'] == $page_id) { echo 'selected'; } ?>">
                <a href="<?php echo get_url('index.php?id=' . h(u($nav_page['id']))); ?>">
                  <?php echo h($nav_page['title']); ?>
                </a>
              </li>
            <?php } // while $nav_pages ?>
          </ul>
          <?php mysqli_free_result($nav_pages); ?>
        <?php } // if($nav_content_type['id'] == $content_type_id) ?>

      </li>
    <?php } // while $nav_content_type ?>
  </ul>
  <?php mysqli_free_result($nav_content_types); ?>
</navigation>
