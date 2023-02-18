<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Comments.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog object
  $comment = new Comments($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $comment->commenter = $data->commenter;
  $comment->comment = $data->comment;
  $comment->blog_id = $data->blog_id;

  // Add Blog
  if($comment->add_comment()) {
    echo json_encode(
      array('message' => 'Comment added')
    );
  } else {
    echo json_encode(
      array('message' => 'Comment NOT added')
    );
  }

