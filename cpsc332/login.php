<?php
session_start();

include("connect.php");
include ("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{

    $validInfor = true;
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    if(empty($user_name)or empty($password)){ // if no information entered throw error
        echo '<script>window.confirm("Please fill in all the correct fields")</script>';
        $validInfor = false;
    }
    
    if($validInfor){
        $query = "select * from users where user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query);
        if($result && mysqli_num_rows($result) > 0){
        $user_data = mysqli_fetch_assoc($result);

        if($user_data['password'] == $password){   
            $_SESSION['id'] = $user_data['id'];
           $_SESSION['email'] = $user_data['email'];
           header("Location: index.php");
           die;
        }
        else{
            echo '<script>window.confirm("Incorrect Username or Password")</script>';

        }
    }

 }  

}
?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="allpages.css">
    <link rel="stylesheet" href="login_page.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class = "logincontainer">
    <div class = "image">
    <img src="images/Magic Survey-logos_white 2.png" alt = "Magic Survey">
</div>
  <form method="post">
  <div class="info">
    <div class="input">
      <h2 class="login">Username</h2>
      <input type="text" name ="user_name">
      <h2 class="login">Password</h2>
      <input type="password" name ="password">
    </div>
    <br>
    <div class="loginbutton">
      <button>Login</button>
</div>

   </form>
  <div class="bottom-text">
    <h5>Dont have an account? <a href="signup.php">Sign up</a></h5>
  </div>
 </div>
 </div>

</body>
</html>
