<?php

  function is_blank($value) {
    return !isset($value) || trim($value) === '';
  }


  function has_presence($value) {
    return !is_blank($value);
  }


  function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
  }

 
  function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
  }


  function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
  }

 
  function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
      return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
      return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

 
  function has_inclusion_of($value, $set) {
  	return in_array($value, $set);
  }

  
  function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
  }


  function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
  }


  function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }


  function has_unique_page_name($title, $current_id="0", $content_type_id) {
    global $db;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE title='" . db_escape($db, $title) . "' ";
    $sql .= "AND content_type_id = '" . db_escape($db, $content_type_id) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    $page_set = mysqli_query($db, $sql);
    $page_count = mysqli_num_rows($page_set);
    mysqli_free_result($page_set);

    return $page_count === 0;
  }

  
  function has_unique_username($username, $current_id="0") {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "AND id != '" . db_escape($db, $current_id) . "'";

    $result = mysqli_query($db, $sql);
    $admin_count = mysqli_num_rows($result);
    mysqli_free_result($result);

    return $admin_count === 0;
  }

?>
