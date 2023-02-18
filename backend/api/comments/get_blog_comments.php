<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Comments.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog object
  $comment = new Comments($db);
  $comment->blog_id = isset($_GET['blog_id']) ? $_GET['blog_id']: die();
  // Blog read query
  $result = $comment->get_blog_comments();
  

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
            'comment' => $comment,
            'commenter' => $commenter,
            'created_at' => $created_at,
            'blog_id' => $blog_id
          );

    

          // Push to "data"
          array_push($cat_arr, $cat_item);
        }

        // Turn to JSON & output
        echo json_encode($cat_arr);
      

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No comments found.')
        );
  }


?>