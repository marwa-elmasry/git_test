<?php
   
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
} 
require_once '../inc/dbconn.php';
require_once '../users/login.php';
//header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
         
<?php 

error_reporting(0);
         
        // global $email;
        // print_r($email);
    
     if ($_POST['add']) {
        $title =$_POST['title'];
       // $id =$_POST['id'];
        
        $query ="INSERT INTO subjects (title) VALUES ( ? )";
        $statment =mysqli_stmt_init($conn); 
        $prepare_stmt =mysqli_stmt_prepare($statment,$query);
        if ($prepare_stmt) {
            mysqli_stmt_bind_param($statment,"s",$title);
            mysqli_stmt_execute($statment);
            echo "<div class='alert alert-success'> you are registered successfully.</div>";
        }else {
            die("some thing went wrong");
        }   
    }                
       ?>
    <div class="container">
        <h1>Welcom to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>

        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="Subject title: ">
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="id" placeholder="id user: ">
        </div>
        
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Add" name="add">
        </div>
        </form>
    </div>
</body>
 

 
