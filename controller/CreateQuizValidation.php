<?php
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
elseif ($status != "Draft" && $status != "Published") {
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

} 
else {
    $_SESSION["successMsg"] = "Quiz Created Successfully";
    $_SESSION["quiz_data"] = [
        "title" => $quizTitle,
        "description" => $description,
        "total_mark" => $totalMark,
        "time_limit" => $quizTime,
        "status" => $status
    ];
    header("Location: ../View/InstructorDashboard.php");
    exit();
}
?>