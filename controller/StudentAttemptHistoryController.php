<?php

session_start();

require_once("../model/DatabaseConnection.php");
require_once("../model/DBStudentAttemptHistory.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$student_id = $_SESSION["user_id"];


$obj = new DBStudentAttemptHistory();


$result=$obj->BringAttemptHistory($connection, $student_id);
$_SESSION["attemptHistory"]=[];

while($row=$result->fetch_assoc())
{
    $_SESSION["attemptHistory"][]=[
        "title"=>$row["title"],
        "score"=>$row["score"],
        "date_taken"=>$row["date_taken"],
        "duration"=>$row["duration"],
        "result_status"=>$row["result_status"]
    ];
}

header("Location: ../view/student_attempt_history.php");
exit();
?>