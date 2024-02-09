<?php 
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <?php
           
          error_reporting(0);
          // check if button submit clicked 
          if (isset($_POST['submit'])) {
            // store all $post iputs in variables to make some proccess
            $userName = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_Repeated = $_POST['password_Repeated'];
            // encrypt the passsword  
            $passwordHash = password_hash($password,PASSWORD_DEFAULT);
            // create array to push all errors in it 
            $errors=array();
            // check all fields are correct or have some errors
            if (empty($userName) and empty($email) and empty($password) and empty($password_Repeated)) {
                array_push($errors,"All Fields are required");
            }
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                array_push($email,"Email is not valied eamil ex:......@gmail.com");
            }  
            if (strlen($password)<8) {
                array_push($errors,"Password must be at least 8 char or num ");
            }
            if ($password !== $password_Repeated) {
                array_push($errors,"password does not match");
            }

            // check if email exist or not 
            require_once '../inc/dbconn.php';
            $query ="SELECT * FROM users WHERE email='$email'";
            $result =mysqli_query($conn,$query);
            $row_count =mysqli_num_rows($result);
            if ($row_count>0) {
                array_push($errors,"Email already exists!");
            }

            // print any errors found and if not found any errors insert data in dataBase 
            if (count($errors)>0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";    
                }
            }else {
            // calling the file which connet with database
                require_once '../inc/dbconn.php';
            // insert data     
                $query ="INSERT INTO users (username,email,password) VALUES ( ?, ?,? )";
                $statment =mysqli_stmt_init($conn); 
                $prepare_stmt =mysqli_stmt_prepare($statment,$query);
                if ($prepare_stmt) {
                    mysqli_stmt_bind_param($statment,"sss",$userName,$email,$passwordHash);
                    mysqli_stmt_execute($statment);
                    echo "<div class='alert alert-success'> you are registered successfully.</div>";
                }else {
                    die("some thing went wrong");
                }
                
            }
          }
        ?>
        <form action="registration.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="fullname" placeholder="Full Name: ">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email: ">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password: ">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_Repeated" placeholder="Repaet Password: ">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Register" name="submit">
        </div>
        </form>
        <div><p>Already Registered<a href="login.php">Login Here</a></p></div>
    </div>    

</body>
</html>