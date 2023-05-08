
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="allpages.css">
<link rel="stylesheet" href="survey_page.css">
<link rel="stylesheet" href="response.css">
<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);
$surveyid = random_num(3);
$c =1;
$counter = 2;
$counter2 = 4;
$RID ;
$num =1;
$mANSnum;

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
echo "<div class='rheader'>";
echo "Survey responses for survey ID: ".$id."<br>";
$query = "select q.questionType from questions q where q.questionID = (select s.questionID from survey s where s.surveyID = $id)";
$result = mysqli_query($con, $query); // get question type from surveyID
$type = mysqli_fetch_assoc($result);

$query = "select * from SurveyQnR where surveyID = $id";
$result2 = mysqli_query($con,$query);
if($type['questionType'] == 'Essay'){ // essay


while ($questions = mysqli_fetch_assoc($result2)){
	echo "Question Number ".$num.": ".$questions['surveyQuestions']."<br>"; //display questions on top 
	$num++;
}
echo "</div>";
$query = "select * from Responses where surveyID = $id";
$result = mysqli_query($con,$query);
$num =1;


}
if($type['questionType'] == 'YesorNo'){ //yesorno

	
		while ($questions = mysqli_fetch_assoc($result2)){
			if($counter % 2 ==0){
		echo "Question Number ".$num.": ".$questions['surveyQuestions']."<br>"; //display questions on top  
		$num++;
			}
			$counter++;
	}
	echo "</div>";
	$query = "select * from Responses where surveyID = $id";
	$result = mysqli_query($con,$query);
	$num =1;

}
if($type['questionType'] == 'mChoice') // multiple choice
{
	while ($questions = mysqli_fetch_assoc($result2)){
		if($counter2 % 4 == 0){
	echo "Question Number ".$num.": ".$questions['surveyQuestions']."<br>"; //display questions on top 
	$num++;
		}
		$counter2++;
}
echo "</div>";
$query = "select * from Responses where surveyID = $id";
	$result = mysqli_query($con,$query);
	$num =1;

}
if($type['questionType'] == 'mAnswers'){
	while ($questions = mysqli_fetch_assoc($result2)){
		if($counter2 % 4 == 0){
	echo "Question Number ".$num.": ".$questions['surveyQuestions']."<br>"; //display questions on top 
	$num++;
		}
		$counter2++;
}
echo "</div>";
$query = "select * from Responses where surveyID = $id";
	$result = mysqli_query($con,$query);
	$num =0;

	while($display = mysqli_fetch_assoc($result)){ 
	if(empty($RID))
	{
		$RID= $display['RID']; //set RID
	}
	
	if($display['RID'] != $RID){ // when RID is not the same means we are showing another response
		
	
		$c = 1;				 // making c = 1 means that it will display the new RID and when it was submitted 
		$RID= $display['RID'];

		echo" <br>";
	}
	
	if($c < 2) // when new reponses entry is seen change id to show it is unique
	{
		echo "Response ID: ".$RID." Response Date: ".date('m-d-y',strtotime($display['TimeStamp']))."<br>";
		$c++;
		
	}
	if(empty($mANSnum)) // will be empty first time around
	{
		$mANSnum = $display['questionNumber'];  // set question number to 1 
		echo "Response to  #".$mANSnum;

	}
	if($display['questionNumber'] != $mANSnum){ // when they are equal the response will display to the number it belongs to
		$mANSnum = $display['questionNumber']; // when they are not equal means that the system has moved on to the next question so change the number being displayed 
		echo "<br> Response to  #".$mANSnum;
		
	}

	
	
		echo " ".$display['answer'];
		
	
}

}
if($type['questionType'] != "mAnswers"){
while($display = mysqli_fetch_assoc($result)){ // display responses 

	if(empty($RID))
	{
		$RID= $display['RID']; //set RID
	}
	if($display['RID'] != $RID){
		
		$num =1;
		$c = 1;
		$RID= $display['RID'];

		echo" <br>";
	}
	if($c < 2) // when new reponses entry is seen change id to show it is unique
	{
		echo "Response ID: ".$RID." Response Date: ".date('m-d-y',strtotime($display['TimeStamp']))."<br>";
		$c++;
	}
	echo "Response to  #".$num." ".$display['answer']."<br>";
	$num++;
}
}







?>
