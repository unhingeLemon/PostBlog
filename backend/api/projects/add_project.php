<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Projects.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Project object
  $project = new Projects($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $project->blog_title = $data->project_title;
  $project->project_desc = $data->project_desc;
  $project->made_by = $data->made_by;
  $project->link = $data->link;

  // Add Project
  if($project->add_project()) {
    echo json_encode(
      array('message' => 'Project added')
    );
  } else {
    echo json_encode(
      array('message' => 'Project NOT added')
    );
  }

