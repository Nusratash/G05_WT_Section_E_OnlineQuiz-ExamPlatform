<?php
session_start();
header("Content-Type: application/json");

require_once "../../../model/DatabaseConnection.php";
require_once "../../../model/QuizCreateConnection.php";

$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/api\/quizzes\/(\d+)\/toggle/', $request_uri, $matches);
$quizId = $matches[1] ?? ($_POST['quiz_id'] ?? "");

if (!$quizId) {
    echo json_encode(["success" => false, "error" => "Quiz ID required"]);
    exit();
}

$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();

$instructorId = $_SESSION["user_id"] ?? 1;

$quiz = $quizDB->GetQuizById($connection, $quizId, $instructorId);
if ($quiz->num_rows == 0) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

$row = $quiz->fetch_assoc();
$newStatus = "draft";

if (strtolower($row["status"]) == "draft") {
    $questions = $quizDB->GetQuestionsByQuizId($connection, $quizId);
    if ($questions->num_rows == 0) {
        echo json_encode(["success" => false, "error" => "Cannot publish quiz without questions"]);
        exit();
    }
    $newStatus = "published";
}

$result = $quizDB->ToggleQuizStatus($connection, $quizId, $newStatus);
echo json_encode(["success" => $result, "status" => $newStatus]);
?>