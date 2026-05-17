<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
header("Content-Type: application/json");
$quizId = $_POST["quiz_id"] ?? "";
if($quizId == ""){
    echo json_encode([
        "success" => false
    ]);
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
    echo json_encode([
        "success" => false
    ]);
    exit();
}
$row = $quiz->fetch_assoc();
$newStatus = "draft";
if(strtolower($row["status"]) == "draft"){
    $questions = $quizDB->GetQuestionsByQuizId(
        $connection,
        $quizId
    );
    if($questions->num_rows == 0){
        echo json_encode([
            "success" => false,
            "status" => "draft"
        ]);
        exit();
    }
    $newStatus = "published";
}
$result = $quizDB->ToggleQuizStatus($connection, $quizId, $newStatus);
if($result){
    echo json_encode([
        "success" => true,
        "status" => $newStatus
    ]);
}
else{
    echo json_encode([
        "success" => false
    ]);
}
exit();
?>
