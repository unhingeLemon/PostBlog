<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>
<style>
    body{
        background-color: #215875 !important;
        color: white !important;
    }

</style>

<body >
    <?php include '../components/navbar.php'?>
    <?php 
         session_start();
         $domain = "http://localhost/phpfinalproj";
        if(isset($_GET['id'])){
            // API URL to GET data
            $url = $domain.'/backend/api/projects/get_single_project.php?id='.$_GET['id'];
            // curl initiate
            $response = file_get_contents($url);
            $response = json_decode($response);
     
       
        }
           
    ?>



        
    <div class="viewBlog container">
        <h2><?php echo $response->project_title ?></h2>
        <span><?php echo $response->made_by ?></span>
        <span><?php echo $response->created_at ?></span>
        <p><?php echo $response->project_desc ?></p>
        <span class="badge bg-info text-dark"><a href="<?php echo $response->link ?>">Link</a></span>
    </div>
   
        
</body>
</html>



