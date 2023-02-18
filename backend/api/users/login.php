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

  // Get posted user credentials
  $data = json_decode(file_get_contents("php://input"));

  $user->username = isset($data->username ) ? $data->username : die();
  $user->password = isset($data->password ) ? sha1($data->password) : die();

  // login user
  $user->login();

  // Create array
  
  $user_arr = array(
    'id' => $user->id,
    'firstname' => $user->firstname,
    'lastname' => $user->lastname,
    'username' => $user->username,
    'intro' => $user->intro,
    'email' => $user->email,
    'contact' => $user->contact,
    'user_err_message' => $user->user_err_message,
  );

  // Make JSON
  if($user->user_err_message == 'success'){
    echo json_encode($user_arr);
  } else{
    echo json_encode(array('user_err_message'=>$user->user_err_message));
  }
    