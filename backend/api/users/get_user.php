<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $user = new Users($db);

  // Get user by id credentials

  $user->id = isset($_GET['id']) ? $_GET['id']: die();

  // get user
  $user->get_user();

  // Create array
  
  $user_arr = array(
    'id' => $user->id,
    'firstname' => $user->firstname,
    'lastname' => $user->lastname,
    'username' => $user->username,
    'intro' => $user->intro,
    'email' => $user->email,
    'contact' => $user->contact
  );
    // Make JSON
  if($user->user_err_message == 'success'){
    echo json_encode($user_arr);
  } else{
    echo json_encode(array('message'=>$user->user_err_message));
  }

 