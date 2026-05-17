<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
header("Content-Type: application/json");

$questionId   = $_POST["question_id"]  ?? "";
$questionText = $_POST["question"]     ?? "";
$option1      = $_POST["option1"]      ?? "";
$option2      = $_POST["option2"]      ?? "";
$option3      = $_POST["option3"]      ?? "";
$option4      = $_POST["option4"]      ?? "";
$optionId1    = $_POST["option_id1"]   ?? "";
$optionId2    = $_POST["option_id2"]   ?? "";
$optionId3    = $_POST["option_id3"]   ?? "";
$optionId4    = $_POST["option_id4"]   ?? "";
$correctOption = $_POST["correct_option"] ?? ""; // 1, 2, 3, or 4

if ($questionId == "" || $questionText == "") {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit();
}

$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();

$instructorId = $_SESSION["user_id"] ?? 1;

// Verify ownership
$ownership = $quizDB->GetQuestionByIdAndInstructor($connection, $questionId, $instructorId);
if ($ownership->num_rows == 0) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

// Update question text
$quizDB->UpdateQuestion($connection, $questionId, $questionText);

// Determine which option is correct (1-indexed)
$options = [
    1 => ["id" => $optionId1, "text" => $option1],
    2 => ["id" => $optionId2, "text" => $option2],
    3 => ["id" => $optionId3, "text" => $option3],
    4 => ["id" => $optionId4, "text" => $option4],
];

$correctAnswer = "";
foreach ($options as $idx => $opt) {
    $isCorrect = ($idx == (int)$correctOption) ? 1 : 0;
    $quizDB->UpdateOption($connection, $opt["id"], $opt["text"], $isCorrect);
    if ($isCorrect) {
        $correctAnswer = $opt["text"];
    }
}

echo json_encode([
    "success"       => true,
    "question"      => $questionText,
    "option1"       => $option1,
    "option2"       => $option2,
    "option3"       => $option3,
    "option4"       => $option4,
    "optionId1"     => $optionId1,
    "optionId2"     => $optionId2,
    "optionId3"     => $optionId3,
    "optionId4"     => $optionId4,
    "correct_answer"=> $correctAnswer,
]);
exit();
?>