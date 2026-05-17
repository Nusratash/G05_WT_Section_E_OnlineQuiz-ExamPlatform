<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
$quizId = $_POST["quiz_id"] ?? "";
$quizTitle = $_POST["quiz_title"] ?? "";
$description = $_POST["description"] ?? "";
$quizTime = $_POST["quiz_time"] ?? "";
$status = $_POST["status"] ?? "";
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$quizDB->UpdateQuiz(
    $connection,
    $quizId,
    $quizTitle,
    $description,
    $quizTime,
    $status
);
header("Location: ../View/InstructorDashboard.php");
?>