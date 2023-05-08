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
$rid = random_num(3);
$user_data = check_login($con);
$counter = 4;
$yesnoCounter = 2;
$submitCounter =2;
$ansCounter=1;
$num =1;
$c =1;
if(!$user_data = check_login($con)){
    $user_data['id'] = 0;
}
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
$surveyID = $_GET['survey-code']; // gets survey code from from previous page 

if(is_numeric($surveyID)){ // user enters survey code
$query ="select * from survey where SurveyID = ".$surveyID; //query to get question id
                $result = mysqli_query($con,$query); 
                $survey_info= mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result) <1) // if no results come from word enterd into search 
                {                               // just redirect back to homepahe
                    header ("Location: index.php");
                    

                }
}
if(!is_numeric($surveyID)){ //user enters survey name 
    $query ="select * from survey where surveyName = '$surveyID'"; //query to get question id
                    $result = mysqli_query($con,$query); 
                    $survey_info= mysqli_fetch_assoc($result);
                    if(mysqli_num_rows($result) <1) // if no results come from word enterd into search 
                {                               // just redirect back to homepahe
                        header ("Location: index.php");
                                      }
    }


    if($survey_info['status'] == 'Active'){ // if survey is still active 
$query ="select * from questions where questionID = '{$survey_info['questionID']}'"; //with questionID we can now
$result = mysqli_query($con,$query);                                                 // find what type of survey
        $question_info= mysqli_fetch_assoc($result);

if($question_info['questionType'] == "mAnswers"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}' ORDER BY questionNumber ASC";
    $result = mysqli_query($con,$query); //get survey question and answers
    $qamount = mysqli_num_rows($result);
    $qID = $survey_info['questionID'];
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    echo "Survey Description: ".$question_info['description']."<br><br>";

    echo "<form method='post'  action=''>";
    echo  "<input type='hidden' name='questionid' value='$qID'>"; // allows me to use to find questiontype
    echo  "<input type='hidden' name='numofquestion' value='$qamount'>"; // allows me to use #ofquestions in post
    while($survey= mysqli_fetch_assoc($result))
    {   
        if($counter % 4 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
     }
    echo "<input type='checkbox' name='p".$ansCounter."' value='{$survey['surveyOptions']}'>".$survey['surveyOptions']."<br>";
    $ansCounter++;
    $counter++;
    }
    echo "<br><button> Submit </button>";
    echo "</form>";


}




if($question_info['questionType'] == "mChoice"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}' ORDER BY questionNumber ASC";
    $result = mysqli_query($con,$query); //get survey question and answers
    $qamount = mysqli_num_rows($result);
    $qID = $survey_info['questionID'];
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    echo "Survey Description: ".$question_info['description']."<br><br>";

    echo "<form method='post'  action=''>";
    echo  "<input type='hidden' name='questionid' value='$qID'>"; // allows me to use #ofquestions in post
    echo  "<input type='hidden' name='numofquestion' value='$qamount'>"; // allows me to use #ofquestions in post
    while($survey= mysqli_fetch_assoc($result))
    {   
        if($counter % 4 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
     }
    echo "<input type='radio' name='p".$ansCounter."' value='{$survey['surveyOptions']}'>".$survey['surveyOptions']."<br>";
    $ansCounter++;
    $counter++;
    }
    echo "<br><button> Submit </button>";
    echo "</form>";

}


if($question_info['questionType'] == "YesorNo"){
    // this one is commented out because i am testing out question swap
   // $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}'
   $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}' ORDER BY questionNumber ASC";
   $result = mysqli_query($con,$query); //get survey question and answers
    $qamount = mysqli_num_rows($result);
    $qID = $survey_info['questionID'];
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    echo "Survey Description: ".$question_info['description']."<br><br>";

    echo "<form method='post'  action=''>";
    echo  "<input type='hidden' name='questionid' value='$qID'>"; // allows me to use #ofquestions in post
    echo  "<input type='hidden' name='numofquestion' value='$qamount'>"; // allows me to use #ofquestions in post

    while($survey= mysqli_fetch_assoc($result))
    {   
        if($yesnoCounter % 2 == 0){
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
        echo "<input type='radio' name='q".$yesnoCounter."' value='Yes'>".$survey['surveyOptions']."<br>";
        
        
     }  else{
        echo "<input type='radio' name='q".$yesnoCounter."' value='No'>".$survey['surveyOptions']."<br>";


     }
    $yesnoCounter ++;
    }
    echo "<br><button> Submit </button>";
    echo "</form>";


}


if($question_info['questionType'] == "Essay"){
    $query ="select * from surveyQnR where SurveyID ='{$survey_info['SurveyID']}' ORDER BY questionNumber ASC";
    $result = mysqli_query($con,$query); //get survey question and answers
    $qamount = mysqli_num_rows($result);
    $qID = $survey_info['questionID'];
    echo "<h1>".$survey_info['surveyName']  ."</h1>";
    echo "Survey Description: ".$question_info['description']."<br><br>";

    $questionNum =1;
    echo "<form method='post' action=''>";
    echo  "<input type='hidden' name='questionid' value='$qID'>"; // allows me to use #ofquestions in post
    echo  "<input type='hidden' name='numofquestion' value='$qamount'>"; // allows me to use #ofquestions in post

    while($survey= mysqli_fetch_assoc($result))
    {   
       echo $questionNum.".  ";
        echo "<label for='question2'>". $survey['surveyQuestions'].":</label> <br>";
       echo "<div class='essaybox'>";
       echo "<textarea id='essaybox' autofocus='autofocus' name='e".$questionNum."'></textarea><br>";
       echo "</div>";
       $questionNum++;

    }
    echo "<br><button> Submit </button>";
    echo "</form>";
}


    }

if($survey_info['status'] == 'Closed'){
    echo "Survey is no longer active";
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   

    
    $query = "select questionType from questions where questionID = '{$_POST['questionid']}'";
    $result = mysqli_query($con,$query);
    $qType = mysqli_fetch_assoc($result);
    $query = "select surveyID from survey where questionID = '{$_POST['questionid']}'";
    $result = mysqli_query($con,$query);
    $surveyID2= mysqli_fetch_assoc($result);

    $questions =[];
    if($qType['questionType'] == "Essay"){// Essay
        for($i =1; $i <= ($_POST['numofquestion']); $i++){
            if(empty($_POST['e'.$i])){
                $_POST['e'.$i] = NULL; //empty entry give it null
            }
            else{
               
                $input = $_POST['e'.$i];
                $query = "INSERT INTO Responses (`questionNumber`, `answer`, `id`, `surveyID`, `RID`) VALUES ('$num', '$input', '{$user_data['id']}', '{$surveyID2['surveyID']}', '$rid')";
                if(mysqli_query($con,$query) and $c ==1)
                {
                    echo "Survey submitted!";
                    $c++;
                }
                $num++;
            }
        }
    }// Essay
    if($qType['questionType'] == "mChoice"){ //multiple choice
        for($i =1; $i <= ($_POST['numofquestion']); $i++){
            if(empty($_POST['p'.$i])){
                $_POST['p'.$i] = NULL; //empty entry give it null
            }
            else{
                $input = $_POST['p'.$i];
                $query = "INSERT INTO Responses (`questionNumber`, `answer`, `id`, `surveyID`, `RID`) VALUES ('$num', '$input', '{$user_data['id']}', '{$surveyID2['surveyID']}', '$rid')";
                if(mysqli_query($con,$query) and $c ==1)
                {
                    echo "Survey submitted!";
                    $c++;
                }
            }
            if($i % 4 == 0){ // keep track of what question number belongs to answer
                $num++;
            }
        }


    }//multiple choice


    if($qType['questionType'] == "mAnswers"){// multiple answers

        for($i =1; $i <= ($_POST['numofquestion']*4); $i++){
            
            if(empty($_POST['p'.$i])){
                $_POST['p'.$i] = NULL; //empty entry give it null
            }
            else{ //not empty add to db
               $input = $_POST['p'.$i];
                $query = "INSERT INTO Responses (`questionNumber`, `answer`, `id`, `surveyID`, `RID`) VALUES ('$num', '$input', '{$user_data['id']}', '{$surveyID2['surveyID']}', '$rid')";
                if(mysqli_query($con,$query) and $c ==1)
                {
                    echo "Survey submitted!";
                    $c++;
                }

            }
            if($i % 4 == 0){ // keep track of what question number belongs to answer
                $num++;
            }
        }

    }// multiple answers

    if($qType['questionType'] == "YesorNo"){// yes or no
    while($submitCounter <= ($_POST['numofquestion']+1)){
    if($submitCounter % 2 == 0){ // even
        if(empty($_POST['q'.$submitCounter])) // if empty make it equal nothing so no error
        {
           
            $_POST['q'.$submitCounter] = NULL;
        }
        else{
           $question[] = $_POST['q'.$submitCounter];
        }
        
    }
    else{ //odd
        if(empty($_POST['q'.$submitCounter])) // if empty make it equal nothing so no error
        {
            $_POST['q'.$submitCounter] = NULL;
        }
        else{
           $question[] = $_POST['q'.$submitCounter];
        }
        

    }
    $submitCounter++;
}


    foreach($question as $input)
    {
       
            $query = "INSERT INTO Responses (`questionNumber`, `answer`, `id`, `surveyID`, `RID`) VALUES ('$num', '$input', '{$user_data['id']}', '{$surveyID2['surveyID']}', '$rid')";
            if(mysqli_query($con,$query) and $c ==1)
                {
                    echo "Survey submitted!";
                    $c++;
                }
             
            $num++;
    }

    } // yes or no
}

//query into survey database to get questionID then query into questions db to get questionType then
// using survey info we get questions out of survey QnR
?>



