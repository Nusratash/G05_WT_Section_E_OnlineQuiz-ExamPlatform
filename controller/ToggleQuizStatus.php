<?php

include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";

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

$quiz = $quizDB->GetQuizById(
    $connection,
    $quizId
);

if($quiz->num_rows == 0){
    echo json_encode([
        "success" => false
    ]);
    exit();
}

$row = $quiz->fetch_assoc();
$newStatus = "draft";
if($row["status"] == "draft"){
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
$result = $quizDB->ToggleQuizStatus( $connection, $quizId,$newStatus);
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