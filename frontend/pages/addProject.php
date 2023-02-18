<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Project</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>

<style>
  body,html{
      background-color:#231b18 !important;
      color: #fefbf6 !important; 
  }
</style>
<body>

<?php 
  $domain = "http://localhost/phpfinalproj";
  if(isset($_GET['message'])){
    $message = $_GET['message'];
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  session_start();
  if(isset($_POST['submit'])){
    if(isset($_SESSION['userdata'])){
       // User data to send using HTTP POST method in curl
       $data = array('project_title'=>$_POST['project_title'],
                     'project_desc'=>nl2br($_POST['project_desc']),
                     'link'=>$_POST['link'],
                     'made_by'=>$_SESSION['userdata']->username
                    );


       // Data should be passed as json format
       $data_json = json_encode($data);
       
       // API URL to send data
       $url = $domain.'/backend/api/projects/add_project.php';
       // curl initiate
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       // SET Method as a POST
       curl_setopt($ch, CURLOPT_POST, 1);
       // Pass user data in POST command
       curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       // Execute curl and assign returned data
       $response  = curl_exec($ch);
       // Close curl
       curl_close($ch);
       
       // See response if data is posted successfully or any error
       //print_r ($response);
       $response = json_decode($response);
       if($response->err_message != 'Project added'){
           //ALERT USER HERE ABOUT THE ERRROR
           $message =  $response->message;
           header("Location: ".$domain."/frontend/pages/addProject.php?message=".$message);
        
       }else{
          $message =  $response->message;
          header("Location: ".$domain."/frontend/pages/addProject.php?message=".$message);
       }


    }
  }
  
?>










<?php include '../components/navbar.php'?>
    
  <form class="form" method='POST' action='addProject.php'>
    <h2>Add Project</h2>
    <a class='link-tag'href="home.php">Back</a>
    <div class="mb-3">
        <label class="form-label">Project Title</label>
        <input type="text"placeholder="Project Title"class="form-control" required name='project_title'>
    </div>
    <div class="mb-3">
        <label class="form-label">Link</label>
        <input type="url"placeholder="https://www.example.com/"class="form-control" required name='link'>
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Project Description</label>
      <textarea class="form-control" id='addForm'  rows="3" placeholder='Blog Body' name='project_desc'></textarea>
  </div>
    <button type="submit" name = 'submit' class="submit btn btn-primary">Submit</button>
</form>
        
</body>
</html>



