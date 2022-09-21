<?php

  // Content types

  function find_all_content_types($options=[]) {
    global $db;

    $sql = "SELECT * FROM content_types ";
    
    $sql .= "ORDER BY position ASC";
    
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_content_type_by_id($id, $options=[]) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM content_types ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    if($visible) {
      $sql .= "AND visible = true";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $content_type = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $content_type; 
  }

  function validate_content_type($content_type) {
    $errors = [];
    if(is_blank($content_type['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif(!has_length($content_type['name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    return $errors;
  }

  function insert_content_type($content_type) {
    global $db;

    $errors = validate_content_type($content_type);
    if(!empty($errors)) {
      return $errors;
    }

    shift_content_type_positions(0, $content_type['position']);

    $sql = "INSERT INTO content_types ";
    $sql .= "(name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $content_type['name']) . "',";
    $sql .= "'" . db_escape($db, $content_type['position']) . "',";
    $sql .= "'" . db_escape($db, $content_type['visible']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
  
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_content_type($content_type) {
    global $db;

    $errors = validate_content_type($content_type);
    if(!empty($errors)) {
      return $errors;
    }

    $old_content_type = find_content_type_by_id($content_type['id']);
    $old_position = $old_content_type['position'];
    shift_content_type_positions($old_position, $content_type['position'], $content_type['id']);

    $sql = "UPDATE content_types SET ";
    $sql .= "name='" . db_escape($db, $content_type['name']) . "', ";
    $sql .= "position='" . db_escape($db, $content_type['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $content_type['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $content_type['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function delete_content_type($id) {
    global $db;

    $old_content_type = find_content_type_by_id($id);
    $old_position = $old_content_type['position'];
    shift_content_type_positions($old_position, 0, $id);

    $sql = "DELETE FROM content_types ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if($result) {
      return true;
    } else {
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function shift_content_type_positions($start_pos, $end_pos, $current_id=0) {
    global $db;

    if($start_pos == $end_pos) { return; }

    $sql = "UPDATE content_types ";
    if($start_pos == 0) {
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif($end_pos == 0) {
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif($start_pos < $end_pos) {
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
      $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif($start_pos > $end_pos) {
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
      $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";

    $result = mysqli_query($db, $sql);
    
    if($result) {
      return true;
    } else {
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }


  

  function find_all_pages() {
    global $db;

    $sql = "SELECT * FROM pages ";
    $sql .= "ORDER BY content_type_id ASC, position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_page_by_id($id, $options=[]) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "LEFT JOIN authors ON pages.author_id = authors.id ";
    $sql .= "WHERE pages.id='" . db_escape($db, $id) . "' ";
    if($visible) {
      $sql .= "AND visible = true";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page; 
  }

  function find_page_by_slug($slug, $content_type, $options=[]) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "LEFT JOIN authors ON pages.author_id = authors.id ";
    $sql .= "LEFT JOIN content_types ON pages.content_type_id = content_types.id ";
    $sql .= "WHERE pages.slug='" . db_escape($db, $slug) . "' ";
    if($content_type) {
      $sql .= "AND content_types.slug='" . db_escape($db, $content_type) . "' ";
    }
    if($visible) {
      $sql .= "AND pages.visible = true";
    }
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page; 
  }

  function get_blog_post($id) {
    $sql = "SELECT * FROM pages ";
    $sql .= "LEFT JOIN page_meta on pages.id = page_meta.page_id ";
    $sql .= "LEFT JOIN services on page_meta.meta_value = services.id ";
    $sql .= "WHERE pages.id='" . db_escape($db, $id) . "' ";
    $sql .= "AND WHERE page_meta.meta_key = 'service_id' ";
    
  }
  function validate_page($page) {
    $errors = [];

    
    if(is_blank($page['content_type_id'])) {
      $errors[] = "Content type cannot be blank.";
    }

    
    if(is_blank($page['title'])) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($page['title'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Title must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    $content_type_id  = $page['content_type_id'];
    if(!has_unique_page_name($page['title'], $current_id, $content_type_id)) {
      $errors[] = "Title must be unique for each content type.";
    }


   
    $postion_int = (int) $page['position'];
    if($postion_int <= 0) {
      $errors[] = "Position must be greater than zero.";
    }
    if($postion_int > 999) {
      $errors[] = "Position must be less than 999.";
    }

    $visible_str = (string) $page['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }

    
    if(is_blank($page['content'])) {
      $errors[] = "Content cannot be blank.";
    }

    return $errors;
  }

  function insert_page($page, $page_meta) {
    global $db;

    $errors = validate_page($page);
    if(!empty($errors)) {
      return $errors;
    }

    shift_page_positions(0, $page['position'], $page['content_type_id']);

    $sql = "INSERT INTO pages ";
    $sql .= "(content_type_id, title, position, visible, content, author_id, slug) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $page['content_type_id']) . "',";
    $sql .= "'" . db_escape($db, $page['title']) . "',";
    $sql .= "'" . db_escape($db, $page['position']) . "',";
    $sql .= "'" . db_escape($db, $page['visible']) . "',";
    $sql .= "'" . db_escape($db, $page['content']) . "',";
    $sql .= "'" . db_escape($db, $page['author_id']) . "',";
    $sql .= "'" . db_escape($db, $page['slug']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    $new_id = mysqli_insert_id($db);
    
    if (count($page_meta) > 0) {
      
      foreach ($page_meta as $key => $value) {
        $sql_meta = "INSERT INTO page_meta ";
        $sql_meta .= "(page_id, meta_key, meta_value) ";
        $sql_meta .= "VALUES (";
        $sql_meta .= "'" . db_escape($db, $new_id) . "',";
        $sql_meta .= "'" . db_escape($db, $key) . "',";
        $sql_meta .= "'" . db_escape($db, $value) . "'";
        $sql_meta .= ")";
        $result_meta = mysqli_query($db, $sql_meta);
      }
    }
    
    if($result) {
      $return_obj = new stdClass();
      $return_obj->success = true;
      $return_obj->new_id = $new_id;

      return $return_obj;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_page($page) {
    global $db;

    $errors = validate_page($page);
    if(!empty($errors)) {
      return $errors;
    }

    $old_page = find_page_by_id($page['id']);
    $old_position = $old_page['position'];
    shift_page_positions($old_position, $page['position'], $page['content_type_id'], $page['id']);

    $sql = "UPDATE pages SET ";
    $sql .= "content_type_id='" . db_escape($db, $page['content_type_id']) . "', ";
    $sql .= "title='" . db_escape($db, $page['title']) . "', ";
    $sql .= "position='" . db_escape($db, $page['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function delete_page($id) {
    global $db;

    $old_page = find_page_by_id($id);
    $old_position = $old_page['position'];
    shift_page_positions($old_position, 0, $old_page['content_type_id'], $id);

    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    $sql = "DELETE FROM page_meta ";
    $sql .= "WHERE page_id='" . db_escape($db, $id) . "' ";
    
    $result = mysqli_query($db, $sql);

   
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function find_pages_by_content_type_id($content_type_id, $options=[]) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
   
    $sql .= "WHERE content_type_id='" . db_escape($db, $content_type_id) . "' ";
    if($visible) {
      $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function count_pages_by_content_type_id($content_type_id, $options=[]) {
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT COUNT(id) FROM pages ";
    $sql .= "WHERE content_type_id='" . db_escape($db, $content_type_id) . "' ";
    if($visible) {
      $sql .= "AND visible = true ";
    }
    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $count = $row[0];
    return $count;
  }

  function shift_page_positions($start_pos, $end_pos, $content_type_id, $current_id=0) {
    global $db;

    if($start_pos == $end_pos) { return; }

    $sql = "UPDATE pages ";
    if($start_pos == 0) {
      
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif($end_pos == 0) {
      
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif($start_pos < $end_pos) {
     
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
      $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif($start_pos > $end_pos) {
     
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
      $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }
   
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
    $sql .= "AND content_type_id = '" . db_escape($db, $content_type_id) . "'";

    $result = mysqli_query($db, $sql);
    
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }


  function find_all_admins() {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); 
    mysqli_free_result($result);
    return $admin;
  }

  function find_admin_by_username($username) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); 
    mysqli_free_result($result);
    return $admin; 
  }

  function validate_admin($admin, $options=[]) {

    $password_required = $options['password_required'] ?? true;

    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }

  function insert_admin($admin) {
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    
    if($result) {
      return true;
    } else {
    
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_admin($admin) {
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if($password_sent) {
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

   
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_admin($admin) {
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    
    if($result) {
      return true;
    } else {
      
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function find_all_authors($options=[]) {
    global $db;

    $sql = "SELECT * FROM authors ";
    
    $sql .= "ORDER BY name ASC";
   
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_all_services($options=[]) {
    global $db;

    $sql = "SELECT * FROM services ";
    
    $sql .= "ORDER BY name ASC";
 
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_all_contractors($options=[]) {
    global $db;

    $sql = "SELECT * FROM contractors ";
    
    $sql .= "ORDER BY name ASC";
   
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

?>
