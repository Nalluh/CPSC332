<!DOCTYPE html>
<html>
<link rel="stylesheet" href="allpages.css">
<link rel="stylesheet" href="index_page.css">
<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);
$surveyid = random_num(3);
$insertQuestionFlag = false;
$QuestionTemplate;
echo "<div class='header'>";
echo "<ul>";
if(!empty($user_data["FName"])){
echo "<li>Welcome,   ".$user_data["FName"]."</li>";
echo "<li><a href='Index.php'> Create Survey</a></li>";
echo "<li><a href='mySurveys.php'> My Surveys</a></li>";
echo "<li><a href='logout.php'>Logout</a></li>";
}else{
echo "<li><a href='Index.php'> Create Survey</a></li>";
}
echo "</ul>";
echo "</div>";
?>

<head>
    <title>Create Survey</title>
</head>
<body>
    <div class="container">
    <div class="searchdiv">
    <h1>Search for a survey</h1>
    <form method="GET" action="Survey.php">

    <label for="survey-code">Survey Code:</label><br>
    <br>

        <input type="text" id="survey-code" name="survey-code"><br><br>
        <button> submit </button>

</form>

</div>
<div class="createDiv">
    <h1>Create Survey</h1>
    <form method="post" action="">
        <label for="survey-name">Survey Name:</label><br>
        <br>

        <input type="text" id="survey-name" name="survey-name" ><br><br>
        
        <label for="survey-name">Survey Type:</label><br>
        <select name="surveyType">
            <option value="mAnswers">Multiple Answers</option>
            <option value="mChoice">Multiple choice</option>
            <option value="YesorNo">Yes/No</option>
            <option value="Essay">Essay</option>
        </select><br><br>
        <p> Amount of questions (Minimum 5)</p>
        <input type="text" name="qAmount" ><br>
        <br>
        <button> submit </button>
        <br>
        </div>
        </div>
        <?php 
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(empty($_POST['qAmount'])){ //when form is resubmitted get info that was just insereted and use it 
                $query ="Select * from questions where id = {$user_data['id']} ORDER BY questionID DESC";
                $result = mysqli_query($con,$query);
                $user_info = mysqli_fetch_assoc($result);
                $_POST['qAmount'] = $user_info['QuestionAmount'];
                $insertQuestionFlag = true; // flag that will tell if first form has already been submitted 
                $QuestionTemplate = false;

            }                               // so the database doesnt get two entries 
            $num = $_POST['qAmount'];
            $surveyType = $_POST['surveyType'];
            if($num < 5){
                echo "<div class='createcontainer'>";
                echo "Not enough questions!";
                echo"</div>";

            }
            else{
// submit info to database then have another page that pulls it out and adds the questions
                if(!$insertQuestionFlag){
                    $QuestionTemplate = true;
                //questionID	questionType	QuestionAmount	id	columns in db 
                $query = "insert into questions (QuestionAmount, questionType, id) values ('$num','$surveyType','{$user_data['id']}') ";
                mysqli_query($con, $query); // inserts question template into db 
                $query ="Select * from questions where id = {$user_data['id']} ORDER BY questionID DESC";
                $result = mysqli_query($con,$query); //retrieve question template so we can display 
                 $user_info = mysqli_fetch_assoc($result);
                 $query ="Insert into survey (SurveyID,questionID,id,surveyName, status) values ('$surveyid','{$user_info['questionID']}','{$user_data['id']}','{$_POST['survey-name']}','Active')";
                 mysqli_query($con, $query); // insert into another table survey information 


                }

// MULTIPLE ANSWERS
if($QuestionTemplate){
if($user_info['questionType'] == 'mAnswers'){
    echo "<form method='post'  action='Survey.php'>";
    $num = $user_info['QuestionAmount'];
    if(empty($_POST['qAmount'])){ // if its empty means theres a 2nd submit so get question amount from db
        $_POST['qAmount'] = $user_info['QuestionAmount'];
    }
    echo "<div class='createcontainer'>";
    echo "<div class='createcontainer2'>";
    for ($i = 5; $i - 4 <= $num; $i++) {
        $j = $i - 4;
        echo "Enter question #" . $j."<br>";
        echo " <input type='text' id='input[$j]' name='SurveyQuestions[$j]'><br>";
        echo "A ";
        echo "   <input type='text' name='options[$j][]' ><br>";
        echo "B  ";
        echo "   <input type='text' name='options[$j][]' ><br>";
        echo "C  ";
        echo "   <input type='text' name='options[$j][]' ><br>"; // input fields  
        echo "D  ";
        echo "   <input type='text' name='options[$j][]'    ><br>";
    }
    
        echo "<br><button> Submit </button>";

echo "</form>";
echo"</div>";
echo"</div>";
}


// MULTIPLE CHOIE
if($user_info['questionType'] == 'mChoice'){
   
   echo "<form method='post'  action='Survey.php'>";
        $num = $user_info['QuestionAmount'];
        if(empty($_POST['qAmount'])){ // if its empty means theres a 2nd submit so get question amount from db
            $_POST['qAmount'] = $user_info['QuestionAmount'];
        }
        echo "<div class='createcontainer'>";
        echo "<div class='createcontainer2'>";

        for ($i = 5; $i - 4 <= $num; $i++) {
            $j = $i - 4;
            echo "Enter question #" . $j;
            echo " <input type='text' id='input[$j]' name='SurveyQuestions[$j]'><br>";
            echo "A ";
            echo "   <input type='text' name='options[$j][]' ><br>";
            echo "B  ";
            echo "   <input type='text' name='options[$j][]' <br>";
            echo "C  ";
            echo "   <input type='text' name='options[$j][]' ><br>"; // input fields  
            echo "D  ";
            echo "   <input type='text' name='options[$j][]'><br>";
        }
        
        echo "<br><button> Submit </button>";

   echo "</form>";
   echo"</div>";
  echo"</div>";
}
        

// YES OR NO 
if($user_info['questionType']== 'YesorNo'){
    echo "<form method='post'  action='Survey.php'>";
    $num = $user_info['QuestionAmount'];
    if(empty($_POST['qAmount'])){ // if its empty means theres a 2nd submit so get question amount from db
        $_POST['qAmount'] = $user_info['QuestionAmount'];
    } echo "<div class='createcontainer'>";
    echo "<div class='createcontainer2'>";
    for ($i = 5; $i - 4 <= $num; $i++) {
        $j = $i - 4;
        echo "Enter question #" . $j;
        echo " <input type='text' id='input[$j]' name='SurveyQuestions[$j]'><br>";
        echo "   <input type='hidden' name='options[$j][]' value='Yes'><br>";
        echo "   <input type='hidden' name='options[$j][]' value='No'><br>";
       
       
    }
    
    echo "<br><button> Submit </button>";

echo "</form>";
echo"</div>";
echo"</div>";

}


//ESSAY
if($user_info['questionType']== 'Essay'){
    echo "<form method='post'  action='Survey.php'>";
    $num = $user_info['QuestionAmount'];    
    if(empty($_POST['qAmount'])){ // if its empty means theres a 2nd submit so get question amount from db
        $_POST['qAmount'] = $user_info['QuestionAmount'];
    } echo "<div class='createcontainer'>";
    echo "<div class='createcontainer2'>";
    for ($i = 5; $i - 4 <= $num; $i++) {
        $j = $i - 4;
        echo "Enter question #" . $j;
        echo " <input type='text' id='input[$j]' name='SurveyQuestions[$j]'><br>";
       
    }
    
    echo "<br><button> Submit </button>";

echo "</form>";
echo"</div>";
echo"</div>";

}

}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty($_POST['SurveyQuestions']) and empty($_POST['options'])){
        // if empty means form hasnt apperead so they are undefined do nothing

    }
    else if($user_info['questionType'] == 'mChoice' or $user_info['questionType'] == 'mAnswers'){
    $questions = $_POST['SurveyQuestions']; 
    $options = $_POST['options']; 
    $count = (int)$user_info['QuestionAmount']; // index for displaying questions 
    $query ="Select * from survey where id = {$user_data['id']} order by questionID desc";
                $result = mysqli_query($con,$query); //get surveyID
                 $user_info = mysqli_fetch_assoc($result);
                 echo "<div class='container'>";
                    
                 echo "Your survey code is ".$user_info['SurveyID']."<br>";

                 echo"</div>";


    for ($i = 1; $i <=$count; $i++) {
        $question_text = $questions[$i];
        $question_options = $options[$i];
     //   	SurveyID	id	surveyOptions	surveyQuestions	database columns
        //echo "Question #" . ($i) . ": " . $question_text . "<br>";
        foreach ($question_options as $option_text) {
        //    echo "- " . $option_text . "<br>";
            $question_op = $option_text;
            $query2 = "INSERT INTO surveyQnR (`SurveyID`, `id`,`surveyQuestions`, `surveyOptions`) VALUES ('{$user_info['SurveyID']}', '{$user_data['id']}', '$questions[$i]','$question_op')";
            mysqli_query($con,$query2); // inserts questions and answer choices 
            
        }
    
    }
}
    else if($user_info['questionType'] == 'YesorNo'){
        $questions = $_POST['SurveyQuestions']; 
        $options = $_POST['options']; 
        $count = (int)$user_info['QuestionAmount']; // index for displaying questions 
        $query ="Select * from survey where id = {$user_data['id']} order by questionID desc";
                    $result = mysqli_query($con,$query); //get surveyID
                     $user_info = mysqli_fetch_assoc($result);
                     echo "<div class='container'>";
                   
                     echo "Your survey code is ".$user_info['SurveyID']."<br>";
                     echo"</div>";        for ($i = 1; $i <=$count; $i++) {
            
            $question_text = $questions[$i];
            $question_options = $options[$i];
         //   	SurveyID	id	surveyOptions	surveyQuestions	database columns
         // un comment to see what code will display   echo "Question #" . ($i) . ": " . $question_text . "<br>";
            // 1 -> 2 for loop
            foreach ($question_options as $option_text) {
              // un comment to see what code will display  echo "- " . $option_text . "<br>";
                $question_op = $option_text;
                $query2 = "INSERT INTO surveyQnR (`SurveyID`, `id`,`surveyQuestions`, `surveyOptions`) VALUES ('{$user_info['SurveyID']}', '{$user_data['id']}', '$questions[$i]','$question_op')";
                mysqli_query($con,$query2); // inserts questions and answer choices 
                
            }
        
        }
    }
    else if($user_info['questionType'] == 'Essay'){
        $questions = $_POST['SurveyQuestions']; 
        $count = (int)$user_info['QuestionAmount']; // index for displaying questions 
        $query ="Select * from survey where id = {$user_data['id']} order by questionID desc";
                    $result = mysqli_query($con,$query); //get surveyID
                     $user_info = mysqli_fetch_assoc($result);
                     echo "<div class='container'>";
                     echo "Your survey code is ".$user_info['SurveyID']."<br>";
                     echo"</div>";        for ($i = 1; $i <=$count; $i++) {
            
            $question_text = $questions[$i];
         //   	SurveyID	id	surveyOptions	surveyQuestions	database columns
          // un comment to see what code will display  echo "Question #" . ($i) . ": " . $question_text . "<br>";
               $question_op = "NULL";
                $query2 = "INSERT INTO surveyQnR (`SurveyID`, `id`,`surveyQuestions`, `surveyOptions`) VALUES ('{$user_info['SurveyID']}', '{$user_data['id']}', '$questions[$i]','$question_op')";
                mysqli_query($con,$query2); // inserts questions and answer choices 
                
            }
        
        }

}
}
    
               
            }
        
        

        ?>
    </form>
</body>
</html>


<!--<label for="question1">Question 1:</label>
        <input type="text" id="question1" name="questions[]"><br>
        <input type="radio" name="q1" value="Option 1">Option 1<br>
        <input type="radio" name="q1" value="Option 2">Option 2<br>
        <input type="radio" name="q1" value="Option 3">Option 3<br>
        <input type="radio" name="q1" value="Option 4">Option 4<br><br>

        <label for="question2">Question 2:</label>
        <input type="text" id="question2" name="questions[]"><br>
        <input type="checkbox" name="q2[]" value="Option 1">Option 1<br>
        <input type="checkbox" name="q2[]" value="Option 2">Option 2<br>
        <input type="checkbox" name="q2[]" value="Option 3">Option 3<br>
        <input type="checkbox" name="q2[]" value="Option 4">Option 4<br><br>

        <label for="question3">Question 3:</label>
        <input type="text" id="question3" name="questions[]"><br>
        <select name="q3">
            <option value="Option 1">Option 1</option>
            <option value="Option 2">Option 2</option>
            <option value="Option 3">Option 3</option>
            <option value="Option 4">Option 4</option>
        </select><br><br>

        <input type="submit" value="Create Survey">
    -->