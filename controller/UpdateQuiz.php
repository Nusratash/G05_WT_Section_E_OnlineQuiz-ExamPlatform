<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$quizId = $_POST["quiz_id"] ?? "";
$quizTitle = $_POST["quiz_title"] ?? "";
$description = $_POST["description"] ?? "";
$quizTime = $_POST["quiz_time"] ?? "";
$status = $_POST["status"] ?? "";
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
    header("Location: ../View/QuizesList.php");
    exit();
}
$questions = $quizDB->GetQuestionsByQuizId($connection, $quizId);
$totalMark = $questions->num_rows;
$quizDB->UpdateQuiz(
    $connection,
    $quizId,
    $quizTitle,
    $description,
    $quizTime,
    $status,
    $totalMark
);
header("Location: ../View/QuizesList.php");
?>
