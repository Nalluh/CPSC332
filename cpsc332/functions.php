<?php
function check_login($con) // keeps user login valid until log out
{
   if(isset ($_SESSION['id']))
   {
    $id = $_SESSION['id'];
    $query = "Select * from users where id = '$id' limit 1";
    $result = mysqli_query($con,$query);
    if($result and mysqli_num_rows($result) > 0)
    {
        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
    }
   }
   else{
    return false;
   }
   header("Location: login.php");
   die;
}



function hasCapitalLetter($string) {
    $capitalLetters = range('A', 'Z');
    foreach(str_split($string) as $character) {
        if(in_array($character, $capitalLetters)) {
            return true;
        }
    }
    return false;
}
function hasLowerCaseLetter($string) {
    $Lower = range('a', 'z');
    foreach(str_split($string) as $character) {
        if(in_array($character, $Lower)) {
            return true;
        }
    }
    return false;
}
function hasNumber($string) {
    return (preg_match('/\d/', $string) === 1);
}
function PasswordSize($string) {
    return (strlen($string) >= 8);
}
function hasSpecialChar($string) {
    return (preg_match('/[^a-zA-Z0-9]/', $string) === 1);
}


function checkPassword($string){
    if(hasCapitalLetter($string) and hasLowerCaseLetter($string)and hasNumber($string) and PasswordSize($string) and hasSpecialChar($string)){
        return true;
    }
            return false;
}

function splitName($fullName) {
    $names = explode(' ', $fullName);
    $firstName = $names[0];
    $lastName = !empty($names) ? end($names) : "";
    return array($firstName, $lastName);
}
function random_num($length)
{
    $text = "";
    if($length < 3)
    {
        $length =3;
    }
    $len = rand(4,$length);
    for($i=0; $i < $len; $i++)
    {
        $text.= rand(0,9);
    }
    return $text;
}
?>