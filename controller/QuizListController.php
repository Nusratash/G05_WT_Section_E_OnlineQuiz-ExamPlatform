<?php

session_start();

require_once("../model/DatabaseConnection.php");

require_once("../model/DBQuizList.php");


$db=new DatabaseConnection();
$connection=$db->openConnection();


$student_id=$_SESSION["user_id"];

$obj=new DBQuizList();

$result=$obj->BringQuizList($connection,$student_id);

$_SESSION["quizList"]=[];

while($row=$result->fetch_assoc())
{
    $_SESSION["quizList"][]=[
        "id"=>$row["id"],
        "title"=>$row["title"],
        "total_marks"=>$row["total_marks"],
        "score"=>$row["score"],
        "attempt_id"=>$row["attempt_id"]
    ];
}


header("Location: ../view/quiz_list.php");
exit();

?>