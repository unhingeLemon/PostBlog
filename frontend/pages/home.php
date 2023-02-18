<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portblog | Home</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>
<body>
    <?php

        session_start();
        $domain = "http://localhost/phpfinalproj";
        if(isset($_POST['submit']) ){
            
            // User data to send using HTTP POST method in curl
            $data = array('username'=>$_POST['username'],'password'=>$_POST['password']);
            // Data should be passed as json format
            $data_json = json_encode($data);
            
            // API URL to send data
            $url = $domain.'/backend/api/users/login.php';
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
            $_SESSION['userdata'] = json_decode($response);
            if($_SESSION['userdata']->user_err_message != 'success'){
                //ALERT USER HERE ABOUT THE ERRROR
                $message =  $_SESSION['userdata']->user_err_message;
                header("Location: ".$domain."/frontend/pages/login.php?message=".$message);
             
            } 
            
        }
    
     

                
                
    ?>
    <?php include '../components/navbar.php'?>
    <section id='intro'>
        <div class="cont">
            <h1><?php echo 'Hi, I\'m '.($_SESSION['userdata']->firstname)." ".
            ($_SESSION['userdata']->lastname)  ;?> </h1>
            <hr size="5px" width="100%" color="#fefbf6">  
            <p><?php echo ($_SESSION['userdata']->intro)  ;?>

            </p>
        </div>
        <form class="input-group mb-3 form search" method='GET' action='searchBlogs.php'>
            
            <input type="text" class="form-control" name='searchKey'placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Search Blogs</button>
        </form>
    </section>
    
    <section id='projects'>
        <h2>My Projects</h2>
        <!-- Button trigger modal -->
        <a href="addProject.php" class="btn btn-primary">Add</a>
      
        <?php 

    
            if(isset($_SESSION['userdata'])){
                // API URL to GET data
                $url = $domain.'/backend/api/projects/get_user_projects.php?made_by='.$_SESSION['userdata']->username;
                // curl initiate
                $projects = file_get_contents($url);
                $projects = json_decode($projects);
                if(!isset($projects->message)){
                    echo "<div class=\"container\">
                            <div class=\"row row-cols-4\">";
                    foreach ($projects as $project) {
                        echo "

                            <div class=\" col card text-white bg-secondary\">
                                <div class=\"card-header\">".date("F d,Y h:iA",strtotime($project->created_at))."</div>
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">".$project->project_title."</h5>
                                    <p class=\"card-text\">". strip_tags($project->project_desc) ."</p>
                                    <a href=\"".$domain."/frontend/pages/viewProject.php?id=".$project->id."\" class=\"btn btn-primary\">See</a>
                                </div>
                            </div>
  
                        ";

                    }

                    echo "</div>
                    </div>";

                  
                } else{
                    echo "<h1>No Projects</h1>";
                }
            }
        
        ?>

    </section>

    <section id='blogs'>
        <h2>My Blogs</h2>
      
        <!-- Button trigger modal -->
        <a href="addBlog.php" class="btn btn-primary">Add</a>
        <?php 
            
    
            if(isset($_SESSION['userdata'])){
                // API URL to GET data
                $url = $domain.'/backend/api/blogs/get_user_blogs.php?written_by='.$_SESSION['userdata']->username;
                // curl initiate
                $blogs = file_get_contents($url);
                $blogs = json_decode($blogs);
                if(!isset($blogs->message)){
                    echo "<div class=\"container\">
                            <div class=\"row row-cols-4\">";
                    foreach ($blogs as $blog) {
                        echo "

                            <div class=\" col card text-white bg-secondary\">
                                <div class=\"card-header\">".date("F d,Y h:iA",strtotime($blog->created_at))."</div>
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">".$blog->blog_title."</h5>
                                    <p class=\"card-text\">". strip_tags($blog->blog_body) ."</p>
                                    <a href=\"".$domain."/frontend/pages/viewBlog.php?id=".$blog->id."\" class=\"btn btn-primary\">See</a>
                                </div>
                            </div>
  
                        ";

                    }

                    echo "</div>
                    </div>";

                  
                } else{
                    echo "<h1>No blogs</h1>";
                }
            }
        
        ?>

    </section>

    <section id='contact'>
        <h2>Contact me:</h2>
        <p><?php echo ($_SESSION['userdata']->email); ?></p>
        <p><?php echo ($_SESSION['userdata']->contact); ?></p>
        <br>
        <br>
        <br>
       
    </section>

    <p id='credits'>2021 © MUSKETEERS</p>


        
</body>
</html>



