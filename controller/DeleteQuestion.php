<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$questionId = $_POST["question_id"] ?? "";
if($questionId == ""){
    echo "Failed";
    exit();
}
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$instructorId = $_SESSION["user_id"] ?? 1;
$ownership = $quizDB->GetQuestionByIdAndInstructor(
    $connection,
    $questionId,
    $instructorId
);
if($ownership->num_rows == 0){
    echo "Unauthorized";
    exit();
}
$result = $quizDB->DeleteQuestion($connection, $questionId);
if($result){
    echo "Deleted";
}
else{
    echo "Failed";
}
exit();
?>
