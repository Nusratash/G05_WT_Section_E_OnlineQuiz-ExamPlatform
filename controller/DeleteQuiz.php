<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$quizId = $_POST["quiz_id"] ?? "";
if($quizId == ""){
    echo "Failed";
    exit();
}
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$instructorId = $_SESSION["user_id"] ?? 1;
$quiz = $quizDB->GetQuizById(
    $connection,
    $quizId,
    $instructorId
);
if($quiz->num_rows == 0){
    echo "Unauthorized";
    exit();
}
$result = $quizDB->DeleteQuiz($connection, $quizId);
if($result){
    echo "Deleted";
}
else{
    echo "Failed";
}
exit();
?>
