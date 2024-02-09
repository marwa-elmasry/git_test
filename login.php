<?php 
session_start();
if (isset($_SESSION["user"])) {
    header("Location: subjects/new.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php 
   error_reporting(0);
     if ($_POST['login']) {
        $email =$_POST['email'];
        $password =$_POST['password'];

        require_once '../inc/dbconn.php';
        $query ="SELECT * FROM users WHERE email ='$email'";
        $result =mysqli_query($conn,$query);
        $user =mysqli_fetch_array($result,MYSQLI_ASSOC);
        print_r($user);
        if ($user) {
            if (password_verify($password,$user["password"])) {
                session_start();
                $_SESSION["user"]="yes";
                header("Location: subjects/new.php");
                die();
            }else{
                echo "<div class='alert alert-danger'>password does not match</div>";    
            }
        }else {
            echo "<div class='alert alert-danger'>Email does not match</div>";
        }

     }
   ?>

    <div class="container">
        <form action="index.php" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" class="form-control" >
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" >
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login" class="btn btn-primary" >
            </div>
        </form>
        <div><p>Not registered yet<a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>