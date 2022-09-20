<?php require_once('../private/initialize.php'); ?>

<?php

$preview = false;
if(isset($_GET['preview'])) {
 
  $preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
}
$visible = !$preview;

if(isset($_GET['id'])) {
  $page_id = $_GET['id'];
  $page = find_page_by_id($page_id, ['visible' => $visible]);
  if(!$page) {
    redirect_to(get_url('/index.php'));
  }
  $content_type_id = $page['content_type_id'];
  $content_type = find_content_type_by_id($content_type_id, ['visible' => $visible]);
  if(!$content_type) {
    redirect_to(get_url('/index.php'));
  }

} elseif(isset($_GET['content_type_id'])) {
  $content_type_id = $_GET['content_type_id'];
  $content_type = find_content_type_by_id($content_type_id, ['visible' => $visible]);
  if(!$content_type) {
    redirect_to(get_url('/index.php'));
  }
  $page_set = find_pages_by_content_type_id($content_type_id, ['visible' => $visible]);
  $page = mysqli_fetch_assoc($page_set); 
  mysqli_free_result($page_set);
  if(!$page) {
    redirect_to(get_url('/index.php'));
  }
  $page_id = $page['id'];
} 
elseif(isset($_GET['slug'])) {
  $page_slug = $_GET['slug'];
  $content_type_slug = $_GET['content_type'];
  $page = find_page_by_slug($page_slug, $content_type_slug, ['visible' => $visible]);
  if(!$page) {
    redirect_to(get_url('/index.php'));
  }
  $content_type_id = $page['content_type_id'];
  $content_type = find_content_type_by_id($content_type_id, ['visible' => $visible]);
  if(!$content_type) {
    redirect_to(get_url('/index.php'));
  }
}
else {
 
}

?>

<?php include(COMMON_PATH . '/public_header.php'); ?>

<div id="main">

  <?php include(COMMON_PATH . '/public_navigation.php'); ?>

  <div id="page">
  <div id="page-info">
    <h1><?php if (isset($page['title'])) {echo $page['title'];}?></h1>
    <p><?php if (isset($page['updated_at'])) {echo format_page_date($page['updated_at']);} ?></p>
    <div id="author">
    <h4><?php  if (isset($page['name'])) {echo 'Written by: '. $page['name'];} ?></h4>
    <p><i><?php echo $page['blurb'] ?? '';?></i></p>
  </div>
  </div> 
  <div id="content">
    <?php
      
      if(isset($page)) {
        
        $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li>';
        
        echo strip_tags($page['content'], $allowed_tags);

      } else {
       
        include(COMMON_PATH . '/static_homepage.php');
      }
    ?>
</div>
  </div>

</div>

<?php include(COMMON_PATH . '/public_footer.php'); ?>
