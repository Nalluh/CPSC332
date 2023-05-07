
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="allpages.css">
<link rel="stylesheet" href="survey_page.css">
<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);
$surveyid = random_num(3);
$insertQuestionFlag = false;
$counter =0;
$showQsOnce = true;
$countQs = 0;
$RID ="";
$num =1;

echo "<div class='header'>";
echo "<ul>";
if(!empty($user_data["FName"])){
echo "<li>Welcome,   ".$user_data["FName"]."</li>";
echo "<li><a href='Index.php'> Create Survey</a></li>";
echo "<li><a href='mySurveys.php'> My Surveys</a></li>";
echo "<li><a href='logout.php'>Logout</a></li>";
}else{
echo "<li><a href='Index.php'> Create Survey</a></li>";
echo "<li><a href='login.php'> Login</a></li>";

}
echo "</ul>";
echo "</div>";


$id = $_GET['id'];
$query = "select * from SurveyQnR where surveyID = $id";
$result2 = mysqli_query($con,$query);
while ($questions = mysqli_fetch_assoc($result2)){
	echo "Question Number ".$num." ".$questions['surveyQuestions']."<br>";
	$num++;
}
$query = "select * from Responses where surveyID = $id";
$result = mysqli_query($con,$query);
while($display = mysqli_fetch_assoc($result)){

}

?>
