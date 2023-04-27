<?php
session_start();
   
include("connect.php");
include("functions.php");

$user_data = check_login($con);

echo "Welcome, ".$user_data["FName"]."<br><br>";
$isPosted = false;
$query ="Select * from questions where id = {$user_data['id']}";
$result = mysqli_query($con,$query);
$user_info = mysqli_fetch_assoc($result);

if($user_info['questionType'] == 'mAnswers'){

}
if($user_info['questionType'] == 'mChoice'){
   
   echo "<form method='post'  action=''>";
        $num = $user_info['QuestionAmount'];
        for ($i = 5; $i - 4 <= $num; $i++) {
            $j = $i - 4;
            echo "Enter question #" . $j;
            echo " <input type='text' id='input[$j]' name='SurveyQuestions[$j]'><br>";
            echo "   <input type='text' name='options[$j][]' value='option1'>Option 1<br>";
            echo "   <input type='text' name='options[$j][]' value='option2'>Option 2<br>";
            echo "   <input type='text' name='options[$j][]' value='option3'>Option 3<br>";
            echo "   <input type='text' name='options[$j][]' value='option4'>Option 4<br>";
            $isPosted = true;
        }
        
            echo "<button> ok </button>";

   echo "</form>";
  

}
        


if($user_info['questionType']== 'Yes|No'){

}
if($user_info['questionType']== 'Essay'){

}
if($_SERVER['REQUEST_METHOD'] == "POST" and $isPosted){

    $questions = $_POST['SurveyQuestions']; // Array of question texts
    $options = $_POST['options']; // Array of arrays containing option texts for each question
    
    // Loop through each question and its options
    for ($i = 0; $i <=count($questions); $i++) {
        $question_text = $questions[$i];
        $question_options = $options[$i];
    
        echo "Question #" . ($i) . ": " . $question_text . "<br>";
        if($question_options !=0 ){
        foreach ($question_options as $option_text) {
            echo "- " . $option_text . "<br>";
        }
    }
}
}
    ?>