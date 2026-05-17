<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
$quizId = $_POST["quiz_id"] ?? "";
if($quizId == ""){
    echo "Failed";
    exit();
}
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$result = $quizDB->DeleteQuiz($connection,$quizId);
if($result){
    echo "Deleted";
}
else{
    echo "Failed";
}
exit();
?>