<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="allpages.css">
    <link rel="stylesheet" href="survey_page.css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);
$counter = 4;
$yesnoCounter = 2;
if(!empty($user_data)){
    echo "<div class='header'>";
echo "<ul>";
echo "<li>Welcome,   ".$user_data["FName"]."</li>";
echo "<li><a href='Index.php'> Create Survey</a></li>";
echo "<li><a href='mySurveys.php'> My Surveys</a></li>";
echo "<li><a href='logout.php'>Logout</a></li>";
echo "</ul>";
echo "</div>";
}
$surveyID = $_GET['survey-code']; // gets survey code from from

if(is_numeric($surveyID)){
$query ="select * from survey where SurveyID = ".$surveyID; //query to get question id
                $result = mysqli_query($con,$query); 
                $survey_info= mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result) <1) // if no results come from word enterd into search 
                {                               // just redirect back to homepahe
                    header ("Location: index.php");
                    

                }
}
if(!is_numeric($surveyID)){
    $query ="select * from survey where surveyName = '$surveyID'"; //query to get question id
                    $result = mysqli_query($con,$query); 
                    $survey_info= mysqli_fetch_assoc($result);
                    if(mysqli_num_rows($result) <1) // if no results come from word enterd into search 
                {                               // just redirect back to homepahe
                        header ("Location: index.php");
                                      }
    }
    if($survey_info['status'] == 'Active'){
$query ="select * from questions where questionID = '{$survey_info['questionID']}'"; //with questionID we can now
$result = mysqli_query($con,$query);                                                 // find what type of survey
        $question_info= mysqli_fetch_assoc($result);
        
if($question_info['questionType'] == "mAnswers"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}'";
    $result = mysqli_query($con,$query); //get survey question and answers
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    while($survey= mysqli_fetch_assoc($result))
    {   
        if($counter % 4 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
     }
    echo "<input type='radio' name='q2[]' value='Option 1'>".$survey['surveyOptions']."<br>";
    $counter++;
    }
    echo "<br><button> Submit </button>";

}
if($question_info['questionType'] == "mChoice"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}'";
    $result = mysqli_query($con,$query); //get survey question and answers
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    while($survey= mysqli_fetch_assoc($result))
    {   
        if($counter % 4 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
     }
    echo "<input type='checkbox' name='q2[]' value='Option 1'>".$survey['surveyOptions']."<br>";
    $counter++;
    }
    echo "<br><button> Submit </button>";

}
if($question_info['questionType'] == "YesorNo"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}'";
    $result = mysqli_query($con,$query); //get survey question and answers
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    while($survey= mysqli_fetch_assoc($result))
    {   
        if($yesnoCounter % 2 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
     }
    echo "<input type='radio' name='q2[]' value='Option 1'>".$survey['surveyOptions']."<br>";
    $yesnoCounter ++;
    }
    echo "<br><button> Submit </button>";

}
if($question_info['questionType'] == "Essay"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}'";
    $result = mysqli_query($con,$query); //get survey question and answers
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    $questionNum =1;
    while($survey= mysqli_fetch_assoc($result))
    {   
       echo $questionNum.".  ";
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
       echo "<div class='essaybox'>";
       echo "<textarea id='essaybox' autofocus='autofocus' name='questions[]'></textarea><br>";
       echo "</div>";
       $questionNum++;

    }
    echo "<br><button> Submit </button>";

}
    }
if($survey_info['status'] == 'Closed'){
    echo "Survey is no longer active";
}

//query into survey database to get questionID then query into questions db to get questionType then
// using survey info we get questions out of survey QnR
?>



