<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>
<style>
    body{
        background-color: #231b18 !important;
        color: white !important;
    }

</style>

<body >
    <?php include '../components/navbar.php'?>
    <?php 
        
        $b_id;
        $domain = "http://localhost/phpfinalproj";
         session_start();
        
        if(isset($_GET['id'])){
            // API URL to GET data
            $url = $domain."/backend/api/blogs/get_single_blog.php?id=".$_GET['id'];
            // curl initiate
            $response = file_get_contents($url);
            $response = json_decode($response);
            $b_id = $_GET['id'];
            
        }
           
    ?>




    <div class="viewBlog container">
        <h2><?php echo $response->blog_title ?></h2>
        <span><?php echo $response->written_by ?></span>
        <span><?php echo $response->created_at ?></span>
        <p><?php echo $response->blog_body ?></p>
    </div>
   

    <div class="comments">

        <?php 
            
            if(isset($_SESSION['userdata'])){
                // API URL to GET data
                $url = $domain.'/backend/api/comments/get_blog_comments.php?blog_id='.$_GET['id'];
                // curl initiate
                $comments = file_get_contents($url);
                $comments = json_decode($comments);
                if(!isset($comments->message)){
                  
                    foreach ($comments as $comment) {
                        echo "<div class=\"comment container\">";
                        echo "<h5><strong>".$comment->commenter."</strong> </h5>";
                        echo "<p>".$comment->comment."</p>";
                        echo " <span>".date("F d,Y h:iA",strtotime($comment->created_at))."</span>";
                        echo "</div>";
                    }

                   

                    
                } else{
                    echo "<h1>No comments so far...</h1>";
                }
            }
        
        ?>
        
    </div>

    <div class="commentForm">
        <form class="container commentForm" method='POST' action=<?php echo 'viewBlog.php?id='.$_GET['id'] ?>   >
            <h4><strong>Write a comment</strong></h4>
            <div class="mb-3">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='comment'></textarea>
            </div>
            <button type="submit" name = 'submit' class="btn btn-primary commentSubmitBut">Submit</button>
        </form>
    </div>
    
    <?php 
         if(isset($_POST['submit'])){
           
            if(isset($_POST['comment']) && $_POST['comment'] != ''){
                 // User data to send using HTTP POST method in curl
                $data = array('comment'=>$_POST['comment'],
                'commenter'=>$_SESSION['userdata']->username,
                'blog_id'=>$_GET['id']
                );


                // Data should be passed as json format
                $data_json = json_encode($data);

                // API URL to send data
                $url = $domain . "/backend/api/comments/add_comment.php";
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
               
                if($response->message != 'Comment added'){
                //ALERT USER HERE ABOUT THE ERRROR
                    $message = "ERROR, COMMENT NOT SUBMITTED";
                    echo "<script type='text/javascript'>alert('$message');</script>";

                }else{
                    // $message = "COMMENT SUBMITTED";
                    // echo "<script type='text/javascript'>alert('$message');</script>";
                  
                    header("Location: ".$domain."/frontend/pages/viewBlog.php?id=".$b_id);

                }
                

            } else{
                $message = "ERROR";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }
         

        }
    
    ?>

        
</body>
</html>



