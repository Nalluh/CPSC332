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
$sID;

echo "<div class='header'>";
echo "<ul>";
echo "<li>Welcome,   ".$user_data["FName"]."</li>";
echo "<li><a href='Index.php'> Create Survey</a></li>";
echo "<li><a href='mySurveys.php'> My Surveys</a></li>";
echo "<li><a href='logout.php'>Logout</a></li>";
echo "</ul>";
echo "</div>";


echo "<div class='mySurveysName'>";
echo $user_data['user_name']." Survey's";
echo "</div>";

echo "<div class='mySurveys'>";
echo "<div class='Surveys'>";

$query = "select surveyID, surveyName, TimeStamp, status from survey where id = {$user_data['id']} order by TimeStamp DESC";
$result = mysqli_query($con, $query);


echo "<span class='temp' id = 'sName'>Survey Name</span>"; 
echo "<span class='temp' id = 'sID'>ID</span>"; 
echo "<span class='temp' id = 'sTime'>Date Created</span>"; 
echo "<span class='temp' id = 'sStatus'>Status</span>"; 
echo "<br>";


while($surveys = mysqli_fetch_assoc($result)){
    if($counter <= 15){ // only show 15 surveys
    echo "<div class='SurveysText'>";
echo "<span class='temp' id = 'sName'>".$surveys['surveyName']."</span>"; 
echo "<span class='temp' id = 'sID'>".$surveys['surveyID']."</span>"; 
echo "<span class='temp' id = 'sTime'>".$surveys['TimeStamp']."</span>";
echo "<span class='temp' id = 'sStatus'>".$surveys['status']."</span>"; 
echo "</div>"; // SurveysText
    }
$counter++;

}

if($counter == 15){
echo ($counter-15)." surveys hidden";
}
echo "</div>"; // Surveys
echo "<div  class='editInfo'>";
ECHO " Edit survey: ";
echo "<form method='post'  action=''>";
echo "<input type='text' id='edit' name='editTextBox' value ='Enter Code'><br>";
echo "<button> submit </button>";
echo " </form>";
echo "</div>";  //editInfo


echo "</div>"; // mySurveysName



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(empty($_POST['editTextBox']))    {
    $_POST['editTextBox'] = "";
    if(empty($_POST['delete'])){
        $_POST['delete'] = "";// assign a value or it will give error
    }
    if(empty($_POST['close'])){
        $_POST['close'] = ""; // assign a value or it will give error
    }
    echo "<div class='editS'>";
    if($_POST['delete'] == "on"){ // delete survey 
    $query = "update survey set id = null,   status = 'Closed'  where surveyID = '{$_POST['survey']}' ";
    mysqli_query($con,$query);
        
    }
    if($_POST['close'] == "on"){ // close active survey
        $query = "update survey set status = 'Closed' where surveyID = '{$_POST['survey']}' ";
        mysqli_query($con,$query);
     

    }
    echo "</div>";
    //header('Location: mySurveys.php');
   // exit();  


    }
    else{
        $sID = $_POST['editTextBox'];

        echo "<div class='editS'>";
        echo  "Edit Survey: ".$sID ;

        echo "<form method ='post' action =''>";
        echo "<input type='radio' name='close' >Close Survey<br>";
        echo "<input type='radio' name='delete' >Delete Survey<br>";
       echo  "<input type='hidden' name='survey' value='$sID'>";
        echo "<button> submit </button>";
        echo "</form>";
        echo "</div>";  

        
    }
   
}

?>
