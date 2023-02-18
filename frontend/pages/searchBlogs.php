<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Blog</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>
<body >
    <?php include '../components/navbar.php'?>
    <?php 
        
        
        $domain = "http://localhost/phpfinalproj";
         session_start();
        
       
           
    ?>
    <form class="input-group mb-3 form search" method='GET' action='searchBlogs.php'>
        
        <input type="text" class="form-control" name='searchKey'placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Search Blogs</button>
    </form>


    <?php 
    
    if(isset($_GET['searchKey'])){

           
        if(isset($_SESSION['userdata'])){
            // API URL to GET data
            $string = str_replace(" ", "+", $_GET['searchKey']);
            $url = $domain.'/backend/api/blogs/search_blog.php?searchKey='.$string;
            // curl initiate
            $blogs = file_get_contents($url);
            $blogs = json_decode($blogs);
  
            if(!isset($blogs->message)){
                echo "<div class=\"container\">
                        <div class=\"row row-cols-4\">";
                foreach ($blogs as $blog) {
                    echo "

                        <div class=\" col card text-white bg-secondary\">
                            <div class=\"card-header\">".$blog->written_by."</div>
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
                echo "<h1>No blogs found</h1>";
            }
        }
    }
    ?>
</body>
</html>



