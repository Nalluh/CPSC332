
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="signup_page.css">
    <link rel="stylesheet" href="allpages.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
<div class ="signupbanner">
<h2>Sign up for Magic Survey Today!</h2>
</div>
<div class="signupcontainer">
<div class="left"> 
<div class="image-sign">
   <img src ="images/Magic Survey-logos_white.png" alt="Magic Survey">
  </div>
</div>
<div class="middle"> 
<form method="post">
    <div class="sign-up">
    <h2>Username</h2>
    <input type="text" name ="user_name">
    <h2>E-mail</h2>
    <input type="text" name ="email">
    <h2>Password</h2>
    <input type="password" name ="password">
    <h2>Name</h2>
    <input type="text" name ="name">
    <h2>Phone Number</h2>
    <input type="text" name ="phone">
    <br>
    <br>
    <br>

    <button>Sign Up</button>
 
   <h5>Already have an account? <a href="login.php">Login</a></h5>
</div>
</form>
</div>
<div class="right"> 
    <div class ="passreq">
    <p> Password must contain: </p>
    <ul>
        <li> Eight Characters  
        <li> An uppercase and lowercase letter 
        <li> A number (0-9)
        <li> Special Character (!, @, #, $, %, ^, &)
</ul>
</div>
</div>
</div>
    
</body>
</html>
<?php
session_start();

include("connect.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $validInfo = true;
    $user_name = trim($_POST['user_name']);
    $password = trim($_POST['password']);
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    if(empty($user_name) or empty($email)){
        echo '<script>window.confirm("Fill in all the correct fields")</script>'; ///info entered is empty 
        $validInfo = false;
    }                                                                              
   else if(!preg_match('/[a-zA-Z]/', $user_name)){ // if username is just numbers return error
        echo '<script>window.confirm("User name not valid, please try again")</script>';
        $validInfo = false;
    }
    else if (!preg_match('/^[^@]+@[^@]+\.[^@]+$/', $email)) { /// if email does not contain @ return error
        echo '<script>window.confirm("Please enter valid email")</script>';
        $validInfo = false;
    }
   if(!checkPassword($password)){
    echo '<script>window.confirm("Please enter valid password")</script>';
    $validInfo = false;
   }


$query = "SELECT * FROM users WHERE user_name = '$user_name'"; // check if user name is unique
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) // if it returns a value greater than 0 means name exsist in database
{
    echo '<script>window.confirm("Username taken, please try again")</script>';
    $validInfo = false;
}
$query = "SELECT * FROM users WHERE email = '$email'";   // check if email is unique
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) // if it returns a value greater than 0 means name exsist in database
{
echo '<script>window.confirm("Email taken, please try again")</script>';
$validInfo = false;
}
else if($validInfo){
        list($firstName, $lastName)=splitName($name);
        $safe_user_name =  mysqli_real_escape_string($con, $user_name);
        $safe_password =  mysqli_real_escape_string($con, $password);
        $safe_email = mysqli_real_escape_string($con, $email);
        $safe_Fname = mysqli_real_escape_string($con, $firstName);
        $safe_Lname = mysqli_real_escape_string($con, $lastName);
        $safe_phone = mysqli_real_escape_string($con, $phone);
       $query = "insert into users (user_name,password,FName,LName,email,PhoneNumber) values ('$safe_user_name','$safe_password' ,'$safe_Fname','$safe_Lname', '$safe_email', '$safe_phone')";
        mysqli_query($con, $query);
       header("Location: login.php");
       die;
    }
  
    }

?>