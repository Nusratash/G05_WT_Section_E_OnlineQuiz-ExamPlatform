<?php

session_start();

require_once("../model/DatabaseConnection.php");
require_once("../model/QuizAnalyticsModel.php");

$db=new DatabaseConnection();

$connection=$db->openConnection();

$_SESSION["instructor_id"] = 8; //This is demo
$instructor_id = $_SESSION["instructor_id"];

$obj = new QuizAnalyticsModel();

$quizList = $obj->BringInstructorQuizList($connection, $instructor_id);

$_SESSION["quizList"]=[];

while($row=$quizList->fetch_assoc())
{
    $_SESSION["quizList"][]=[
    "id"=>$row["id"],
    "title"=>$row["title"]
    ];
}

if(!isset($_POST["quiz_id"]))
{
    unset($_SESSION["attemptList"]);
    unset($_SESSION["average_score"]);
    unset($_SESSION["highest_score"]);
    unset($_SESSION["lowest_score"]);
    unset($_SESSION["pass_rate"]);
    unset($_SESSION["reportLoaded"]);
}

if(isset($_POST["quiz_id"]))
{
    $quiz_id=$_POST["quiz_id"];
    $_SESSION["selected_quiz_id"]=$quiz_id;
    $_SESSION["reportLoaded"]=true;

    $result=$obj->BringAttemptList($connection, $quiz_id);

    $summary=$obj->BringSummary($connection, $quiz_id);

    $_SESSION["attemptList"]=[];

    while($row=$result->fetch_assoc())
    {
        $_SESSION["attemptList"][]=[
            "name"=>$row["name"],
            "score"=>$row["score"],
            "duration"=>$row["duration"],
            "result_status"=>$row["result_status"]
        ];
    }

    $summaryRow=$summary->fetch_assoc();
    $_SESSION["average_score"]=$summaryRow["average_score"];
    $_SESSION["highest_score"]=$summaryRow["highest_score"];
    $_SESSION["lowest_score"]=$summaryRow["lowest_score"];
    $_SESSION["pass_rate"]=$summaryRow["pass_rate"];
}


header("Location: ../view/quiz_analytics.php");

exit();

?>