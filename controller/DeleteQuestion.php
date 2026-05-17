<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
$questionId = $_POST["question_id"] ?? "";
if($questionId == ""){
    echo "Failed";
    exit();
}
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$result = $quizDB->DeleteQuestion($connection,$questionId);
if($result){
    echo "Deleted";
}
else{
    echo "Failed";
}
exit();
?>