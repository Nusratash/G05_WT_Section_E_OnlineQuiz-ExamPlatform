<?php
session_start();
require_once("../model/DatabaseConnection.php");

$db=new DatabaseConnection();
$connection=$db->openConnection();


$student_id=$_SESSION["user_id"];
$quiz_id=$_POST["quiz_id"];


$sql="
    SELECT id
    FROM attempts
    WHERE student_id=?
    AND quiz_id=?
    AND completed_at
    IS NOT NULL
";

$stmt=$connection->prepare($sql);
$stmt->bind_param("ii",$student_id,$quiz_id);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows>0)
{
    die("Already attempted");
}

$sql="
    INSERT INTO attempts(quiz_id,student_id,score,started_at)
    VALUES(?,?,0,NOW())
";

$stmt=$connection->prepare($sql);
$stmt->bind_param("ii",$quiz_id,$student_id);
$stmt->execute();
$attempt_id=$connection->insert_id;

$_SESSION["quiz_id"]=$quiz_id;

$_SESSION["attempt_id"]=$attempt_id;

header("Location: ../controller/QuizPageController.php");
exit();

?>