

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/main.css">
</head>

<style>
    body{
        background:#231b18;
        color: #fefbf6;
    }
    form{
        width: 45% !important;
        margin: 40px auto !important;
        border: 4px solid white;
        border-radius: 20px;
        padding:40px;
      

    }
</style>
<body>
<?php 
    $domain = "http://localhost/phpfinalproj";
    if(isset($_POST['submit'])){
           
            if($_POST['pass1'] == $_POST['pass2']){
                $pass = $_POST['pass1'];
                $data = array();
                $data['firstname'] = $_POST['fname'];
                $data['lastname'] = $_POST['lname'];
                $data['username'] = $_POST['username'];
                $data['password'] =  $pass;
                $data['intro'] = nl2br($_POST['intro']);
                $data['email'] = $_POST['email'];
                $data['contact'] = $_POST['contact'];
                echo "<a class = 'btn btn-primary back'href=\"login.php\">Back to Login</a>";

                // User data to send using HTTP POST method in curl
                // Data should be passed as json format
                $data_json = json_encode($data);
                // API URL to send data
                $url =  $domain.'/backend/api/users/register.php';
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
                $message = json_decode($response);
                echo "<script type='text/javascript'>alert('Register success');</script>";
              
                

            } else{
                $message = "PASSWORD DOES NOT MATCH";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }
         

        } else{

        
    
    ?>

    
    <form class="form" method='POST' action='register.php'>
        <h2>Register</h2>
        
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text"placeholder="First Name"class="form-control" required name='fname'>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text"placeholder="Last Name"class="form-control" required name='lname'>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text"placeholder="Username"class="form-control" required name='username'>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" placeholder="Password" class="form-control" required name='pass1'>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" placeholder="Confirm Password" class="form-control" required name='pass2'>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Introduction</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder='Tell me about yourself' name='intro'></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" >Email address</label>
            <input type="email" placeholder="email@example.com" class="form-control" required name='email'>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" placeholder="Contact Number" class="form-control" required name='contact'>
        </div>
        <span class="badge bg-info text-dark"><a href="login.php">Login</a></span><button type="submit" name = 'submit'class="submit btn btn-primary">Submit</button>
    </form>
   
    <?php } ?>
</body>
</html>



