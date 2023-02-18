<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Blogs.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog object
  $blogs = new Blogs($db);
  $blogs->written_by = isset($_GET['written_by']) ? $_GET['written_by']: die();
  // Blog read query
  $result = $blogs->get_user_blogs();
  

  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
        // Cat array
        $cat_arr = array();
        $cat_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $cat_item = array(
            'id' => $id,
            'blog_title' => $blog_title,
            'blog_body' => $blog_body,
            'created_at' => $created_at,
            'written_by' => $written_by
          );

    

          // Push to "data"
          array_push($cat_arr, $cat_item);
        }

        // Turn to JSON & output
        echo json_encode($cat_arr);
      

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No blogs found.')
        );
  }


?>