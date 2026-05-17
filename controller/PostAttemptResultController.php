<?php
session_start();
require_once("../model/DatabaseConnection.php");
require_once("../model/DBPostAttemptResult.php");

$quiz_id = $_SESSION["quiz_id"] ?? "";
$attempt_id = $_SESSION["attempt_id"] ?? "";

$db = new DatabaseConnection();
$connection = $db->openConnection();

$dbPostAttemptResult = new DBPostAttemptResult();
$result = $dbPostAttemptResult->BringQuestionResult($connection, $quiz_id, $attempt_id);
$_SESSION["resultData"] = [];
while($row = $result->fetch_assoc())
{
    $_SESSION["resultData"][] = [
        "order_index"=>$row["order_index"],
        "question_text"=>$row["question_text"],
        "selected_answer"=>$row["selected_answer"] ?? "Not Answered",
        "correct_answer"=>$row["correct_answer"]
    ];
}

$quizTitleScore = $dbPostAttemptResult->BringQuizTitleScore($connection, $quiz_id, $attempt_id);
$quizTitleScoreRow = $quizTitleScore->fetch_assoc();
$_SESSION["quizTitle"] = $quizTitleScoreRow["title"];
$_SESSION["quizTotalMark"] = (float)$quizTitleScoreRow["total_marks"];
$_SESSION["quizScore"] = (float)$quizTitleScoreRow["score"];

header("Location: ../view/attempted_result.php");
exit();

?>