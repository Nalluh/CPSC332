<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cpsc332";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("failed to connect");
}

?>

