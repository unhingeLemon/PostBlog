<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate user object
  $user = new Users($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $user->firstname = $data->firstname;
  $user->lastname = $data->lastname;
  $user->username = $data->username;
  $user->password = sha1($data->password);
  $user->intro = $data->intro;
  $user->email = $data->email;
  $user->contact = $data->contact;

  // Register user
  if($user->register()) {
    echo json_encode(
      array('message' => 'User Registered')
    );
  } else {
    echo json_encode(
      array('message' => 'User not registered')
    );
  }

