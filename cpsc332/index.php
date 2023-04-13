<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);

echo "Welcome, ".$user_data["FName"];
?>

