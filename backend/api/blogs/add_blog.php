<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Blogs.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog object
  $blog = new Blogs($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $blog->blog_title = $data->blog_title;
  $blog->blog_body = $data->blog_body;
  $blog->written_by = $data->written_by;

  // Add Blog
  if($blog->add_blog()) {
    echo json_encode(
      array('message' => 'Blog added')
    );
  } else {
    echo json_encode(
      array('message' => 'Blog NOT added')
    );
  }

