<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
$questionId = $_POST["question_id"] ?? "";
$question = $_POST["question"] ?? "";
$option1 = $_POST["option1"] ?? "";
$option2 = $_POST["option2"] ?? "";
$option3 = $_POST["option3"] ?? "";
$option4 = $_POST["option4"] ?? "";
$correctOption = $_POST["correct_option"] ?? "";
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$quizDB->UpdateQuestion($connection, $questionId, $question);
$options = $quizDB->GetOptionsByQuestionId($connection, $questionId);
$optionArray = [];
while($row = $options->fetch_assoc()){
    $optionArray[] = $row;
}
$quizDB->UpdateOption($connection, $optionArray[0]["id"], $option1, $correctOption == 1 ? 1 : 0);
$quizDB->UpdateOption($connection, $optionArray[1]["id"], $option2, $correctOption == 2 ? 1 : 0);
$quizDB->UpdateOption($connection, $optionArray[2]["id"], $option3, $correctOption == 3 ? 1 : 0);
$quizDB->UpdateOption($connection, $optionArray[3]["id"], $option4, $correctOption == 4 ? 1 : 0);
$correctAnswer = "";
if($correctOption == 1){
    $correctAnswer = $option1;
}
elseif($correctOption == 2){
    $correctAnswer = $option2;
}
elseif($correctOption == 3){
    $correctAnswer = $option3;
}
else{
    $correctAnswer = $option4;
}
$response = [
    "question" => $question,
    "option1" => $option1,
    "option2" => $option2,
    "option3" => $option3,
    "option4" => $option4,
    "correct_answer" => $correctAnswer
];
echo json_encode($response);
?>