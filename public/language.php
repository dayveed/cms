<?php require_once('../private/initialize.php'); ?>

<?php

if(is_post_request()) {
  
  $language = $_POST['language'] ?? 'Any';
  $expire = time() + 60*60*24*365;
  setcookie('language', $language, $expire);

} else {
  
  $language = $_COOKIE['language'] ?? 'None';
}

?>

<?php include(COMMON_PATH . '/public_header.php'); ?>

<div id="main">

  <?php include(COMMON_PATH . '/public_navigation.php'); ?>

  <div id="page">

    <div id="content">
      <h1>Set Language Preference</h1>

      <p>The currently selected language is: <?php echo $language; ?></p>

      <form action="<?php echo get_url('/language.php'); ?>" method="post">

        <select name="language">
          <?php
            $language_choices = ['Any', 'English', 'Spanish', 'French', 'German'];
            foreach($language_choices as $language_choice) {
              echo "<option value=\"{$language_choice}\"";
              if($language == $language_choice) {
                echo " selected";
              }
              echo ">{$language_choice}</option>";
            }
          ?>
        </select><br />
        <br />
        <input type="submit" value="Set Preference" />
      </form>
    </div>

  </div>

</div>

<?php include(COMMON_PATH . '/public_footer.php'); ?>
