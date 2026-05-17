<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$quizTitle = $_POST["quiz_title"] ?? "";
$description = $_POST["description"] ?? "";
$quizTime = $_POST["quiz_time"] ?? "";
$status = $_POST["status"] ?? "";
$totalMark = 0;
if (isset($_SESSION["questions"])) {
    foreach ($_SESSION["questions"] as $question) {
        $totalMark += 1;
    }
}
$_SESSION["quiz_title"] = $quizTitle;
$_SESSION["description"] = $description;
$_SESSION["quiz_time"] = $quizTime;
$_SESSION["status"] = $status;
$hasTitleError = true;
$hasDescriptionError = true;
$hasTimeError = true;
$hasStatusError = true;
if (!$quizTitle) {
    $_SESSION["titleErr"] = "Quiz title is required";
    $hasTitleError = true;
}
else {
    unset($_SESSION["titleErr"]);
    $hasTitleError = false;
}
if (!$description) {
    $_SESSION["descriptionErr"] = "Description is required";
    $hasDescriptionError = true;
}
else {
    unset($_SESSION["descriptionErr"]);
    $hasDescriptionError = false;
}
if (!$quizTime) {
    $_SESSION["timeErr"] = "Time limit is required";
    $hasTimeError = true;
}
elseif (!filter_var($quizTime, FILTER_VALIDATE_INT)) {
    $_SESSION["timeErr"] = "Time limit must be integer";
    $hasTimeError = true;
}
elseif ($quizTime <= 0) {
    $_SESSION["timeErr"] = "Time limit must be positive";
    $hasTimeError = true;
}
else {
    unset($_SESSION["timeErr"]);
    $hasTimeError = false;
}
if (!$status) {
    $_SESSION["statusErr"] = "Status is required";
    $hasStatusError = true;
}
elseif ($status != "draft" && $status != "published") {
    $_SESSION["statusErr"] = "Invalid status selected";
    $hasStatusError = true;
}
else {
    unset($_SESSION["statusErr"]);
    $hasStatusError = false;
}
if (
    !isset($_SESSION["questions"]) ||
    count($_SESSION["questions"]) == 0
)
{
    $_SESSION["questionListErr"] = "At least one question is required";
}
else {
    unset($_SESSION["questionListErr"]);
}
if (
    $hasTitleError ||
    $hasDescriptionError ||
    $hasTimeError ||
    $hasStatusError ||
    !isset($_SESSION["questions"]) ||
    count($_SESSION["questions"]) == 0
)
{
    header("Location: ../View/CreateQuiz.php");
    exit();
}
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$instructorId = $_SESSION["user_id"] ?? 1;
$quizId = $quizDB->CreateQuiz(
    $connection,
    $quizTitle,
    $description,
    $quizTime,
    $status,
    $instructorId,
    $totalMark
);
if(!$quizId){
    $_SESSION["questionListErr"] = "Quiz creation failed";
    header("Location: ../View/CreateQuiz.php");
    exit();
}
$orderIndex = 1;
foreach($_SESSION["questions"] as $question){
    $questionId = $quizDB->CreateQuestion(
        $connection,
        $quizId,
        $question["question"],
        1,
        $orderIndex
    );
    $quizDB->CreateOption(
        $connection,
        $questionId,
        $question["option1"],
        $question["correct_answer"] == $question["option1"] ? 1 : 0
    );
    $quizDB->CreateOption(
        $connection,
        $questionId,
        $question["option2"],
        $question["correct_answer"] == $question["option2"] ? 1 : 0
    );
    $quizDB->CreateOption(
        $connection,
        $questionId,
        $question["option3"],
        $question["correct_answer"] == $question["option3"] ? 1 : 0
    );
    $quizDB->CreateOption(
        $connection,
        $questionId,
        $question["option4"],
        $question["correct_answer"] == $question["option4"] ? 1 : 0
    );
    $orderIndex++;
}
unset($_SESSION["questions"]);
unset($_SESSION["quiz_title"]);
unset($_SESSION["description"]);
unset($_SESSION["quiz_time"]);
unset($_SESSION["status"]);
unset($_SESSION["question"]);
unset($_SESSION["option1"]);
unset($_SESSION["option2"]);
unset($_SESSION["option3"]);
unset($_SESSION["option4"]);
unset($_SESSION["correct_option"]);
$_SESSION["successMsg"] = "Quiz Created Successfully";
header("Location: ../View/QuizesList.php");
exit();
?>
