<?php
session_start();
header("Content-Type: application/json");

require_once "../../model/DatabaseConnection.php";
require_once "../../model/QuizCreateConnection.php";

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/api\/questions\/(\d+)/', $request_uri, $matches);
$questionId = $matches[1] ?? ($_POST['question_id'] ?? "");

if (!$questionId) {
    echo json_encode(["success" => false, "error" => "Question ID required"]);
    exit();
}

$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();

$instructorId = $_SESSION["user_id"] ?? 1;


$ownership = $quizDB->GetQuestionByIdAndInstructor($connection, $questionId, $instructorId);
if ($ownership->num_rows == 0) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

if ($method === "DELETE") {
    $result = $quizDB->DeleteQuestion($connection, $questionId);
    echo json_encode(["success" => $result]);
    exit();
}

if ($method === "PATCH") {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $questionText = $input['question_text'] ?? "";
    $options = $input['options'] ?? [];
    $correctOptionIndex = $input['correct_option_index'] ?? 1;
    
    if (!$questionText) {
        echo json_encode(["success" => false, "error" => "Question text required"]);
        exit();
    }
    
   
    $quizDB->UpdateQuestion($connection, $questionId, $questionText);
    
   
    $correctAnswer = "";
    foreach ($options as $idx => $opt) {
        $isCorrect = ($idx + 1 == $correctOptionIndex) ? 1 : 0;
        $quizDB->UpdateOption($connection, $opt['id'], $opt['text'], $isCorrect);
        if ($isCorrect) {
            $correctAnswer = $opt['text'];
        }
    }
    
    echo json_encode([
        "success" => true,
        "question" => $questionText,
        "option1" => $options[0]['text'],
        "option2" => $options[1]['text'],
        "option3" => $options[2]['text'],
        "option4" => $options[3]['text'],
        "optionId1" => $options[0]['id'],
        "optionId2" => $options[1]['id'],
        "optionId3" => $options[2]['id'],
        "optionId4" => $options[3]['id'],
        "correct_answer" => $correctAnswer
    ]);
    exit();
}

echo json_encode(["success" => false, "error" => "Method not allowed"]);
?>