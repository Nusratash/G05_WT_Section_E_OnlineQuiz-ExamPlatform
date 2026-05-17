<?php
session_start();
header("Content-Type: application/json");

require_once("../../model/DatabaseConnection.php");
$db = new DatabaseConnection();
$connection = $db->openConnection();

$attempt_id = $_POST["attempt_id"] ?? "";

if (!$attempt_id) {
    echo json_encode(["error" => "Invalid attempt ID"]);
    exit();
}

$sql = "SELECT id, completed_at FROM attempts WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $attempt_id);
$stmt->execute();
$attemptCheck = $stmt->get_result()->fetch_assoc();

if ($attemptCheck['completed_at'] !== null) {
    echo json_encode(["error" => "Quiz already submitted. Re-attempt not allowed."]);
    exit();
}

$answers = $_POST["answers"] ?? [];
$total = 0;

foreach ($answers as $question_id => $selected_option) {
    
    $sql = "INSERT INTO answers(attempt_id, question_id, selected_option_id) VALUES(?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iii", $attempt_id, $question_id, $selected_option);
    $stmt->execute();

    $sql = "SELECT options.is_correct, questions.marks 
            FROM options 
            JOIN questions ON options.question_id = questions.id 
            WHERE options.id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $selected_option);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row && $row["is_correct"] == 1) {
        $total += $row["marks"];
    }
}


$sql = "UPDATE attempts SET score = ?, completed_at = NOW() WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ii", $total, $attempt_id);
$stmt->execute();

echo json_encode(["success" => true, "redirect" => "../controller/PostAttemptResultController.php"]);
?>