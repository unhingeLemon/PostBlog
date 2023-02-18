<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Projects.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $project = new Projects($db);

  // Get user by id credentials

  $project->id = isset($_GET['id']) ? $_GET['id']: die();

  // get project
  $project->get_single_project();

  // Create array
  $project_arr = array(
    'id' => $project->id,
    'project_title' => $project->project_title,
    'project_desc' => $project->project_desc,
    'created_at' => $project->created_at,
    'link' => $project->link,
    'made_by' => $project->made_by
  );
    // Make JSON
  if($project->err_message == 'success'){
    echo json_encode($project_arr);
  } else{
    echo json_encode(array('message'=>$project->err_message));
  }

 