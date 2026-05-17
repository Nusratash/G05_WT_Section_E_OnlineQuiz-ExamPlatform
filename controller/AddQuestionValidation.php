<?php
session_start();
$question = $_POST["question"] ?? "";
$option1 = $_POST["option1"] ?? "";
$option2 = $_POST["option2"] ?? "";
$option3 = $_POST["option3"] ?? "";
$option4 = $_POST["option4"] ?? "";
$correctOption = $_POST["correct_option"] ?? "";
$_SESSION["question"] = $question;
$_SESSION["option1"] = $option1;
$_SESSION["option2"] = $option2;
$_SESSION["option3"] = $option3;
$_SESSION["option4"] = $option4;
$_SESSION["correct_option"] = $correctOption;
$hasQuestionError = true;
$hasOption1Error = true;
$hasOption2Error = true;
$hasOption3Error = true;
$hasOption4Error = true;
$hasCorrectOptionError = true;
if (!$question) {
    $_SESSION["questionErr"] = "Question is required";
    $hasQuestionError = true;
}
else {
    unset($_SESSION["questionErr"]);
    $hasQuestionError = false;
}
if (!$option1) {
    $_SESSION["option1Err"] = "Option 1 is required";
    $hasOption1Error = true;
}
else {
    unset($_SESSION["option1Err"]);
    $hasOption1Error = false;
}
if (!$option2) {
    $_SESSION["option2Err"] = "Option 2 is required";
    $hasOption2Error = true;
}
else {
    unset($_SESSION["option2Err"]);
    $hasOption2Error = false;
}
if (!$option3) {
    $_SESSION["option3Err"] = "Option 3 is required";
    $hasOption3Error = true;
}
else {
    unset($_SESSION["option3Err"]);
    $hasOption3Error = false;
}
if (!$option4) {
    $_SESSION["option4Err"] = "Option 4 is required";
    $hasOption4Error = true;
}
else {
    unset($_SESSION["option4Err"]);
    $hasOption4Error = false;
}
if (!$correctOption) {
    $_SESSION["correctOptionErr"] = "Please select correct answer";
    $hasCorrectOptionError = true;
}
else {
    unset($_SESSION["correctOptionErr"]);
    $hasCorrectOptionError = false;
}
if ($hasQuestionError || $hasOption1Error || $hasOption2Error || $hasOption3Error || $hasOption4Error || $hasCorrectOptionError)
{
    $_SESSION["openModal"] = true;
    header("Location: ../View/CreateQuiz.php");
    exit();
}
$options = [
    "option1" => $option1,
    "option2" => $option2,
    "option3" => $option3,
    "option4" => $option4
];
$newQuestion = [
    "question" => $question,
    "option1" => $option1,
    "option2" => $option2,
    "option3" => $option3,
    "option4" => $option4,
    "correct_answer" => $options[$correctOption]
];
if (!isset($_SESSION["questions"])) {
    $_SESSION["questions"] = [];
}
$_SESSION["questions"][] = $newQuestion;
unset($_SESSION["question"]);
unset($_SESSION["option1"]);
unset($_SESSION["option2"]);
unset($_SESSION["option3"]);
unset($_SESSION["option4"]);
unset($_SESSION["correct_option"]);
unset($_SESSION["questionErr"]);
unset($_SESSION["option1Err"]);
unset($_SESSION["option2Err"]);
unset($_SESSION["option3Err"]);
unset($_SESSION["option4Err"]);
unset($_SESSION["correctOptionErr"]);
header("Location: ../View/CreateQuiz.php");
exit();
?>
