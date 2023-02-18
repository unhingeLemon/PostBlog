<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Projects.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog object
  $projects = new Projects($db);
  $projects->made_by = isset($_GET['made_by']) ? $_GET['made_by']: die();
  // Blog read query
  $result = $projects->get_user_projects();
  

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
            'project_title' => $project_title,
            'project_desc' => $project_desc,
            'created_at' => $created_at,
            'link' => $link,
            'made_by' => $made_by
          );

    

          // Push to "data"
          array_push($cat_arr, $cat_item);
        }

        // Turn to JSON & output
        echo json_encode($cat_arr);
      

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No projects found.')
        );
  }


?>