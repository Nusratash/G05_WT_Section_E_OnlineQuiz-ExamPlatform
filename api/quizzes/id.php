<?php
session_start();
header("Content-Type: application/json");

require_once "../../model/DatabaseConnection.php";
require_once "../../model/QuizCreateConnection.php";

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/api\/quizzes\/(\d+)/', $request_uri, $matches);
$quizId = $matches[1] ?? ($_POST['quiz_id'] ?? "");

if (!$quizId) {
    echo json_encode(["success" => false, "error" => "Quiz ID required"]);
    exit();
}

if ($method !== "DELETE") {
    echo json_encode(["success" => false, "error" => "Method not allowed"]);
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

$result = $quizDB->DeleteQuiz($connection, $quizId);
echo json_encode(["success" => $result]);
?>