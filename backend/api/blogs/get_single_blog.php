<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Blogs.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $blog = new Blogs($db);

  // Get user by id credentials

  $blog->id = isset($_GET['id']) ? $_GET['id']: die();

  // get blog
  $blog->get_single_blog();

  // Create array
  $blog_arr = array(
    'id' => $blog->id,
    'blog_title' => $blog->blog_title,
    'blog_body' => $blog->blog_body,
    'created_at' => $blog->created_at,
    'written_by' => $blog->written_by
  );
    // Make JSON
  if($blog->err_message == 'success'){
    echo json_encode($blog_arr);
  } else{
    echo json_encode(array('message'=>$blog->err_message));
  }

 