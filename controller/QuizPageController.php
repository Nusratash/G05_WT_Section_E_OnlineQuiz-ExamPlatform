<?php

session_start();
require_once("../model/DatabaseConnection.php");
require_once("../model/DBQuizTaking.php");

$db=new DatabaseConnection();

$connection=$db->openConnection();

$quiz_id=$_SESSION["quiz_id"];

$obj=new DBQuizTaking();


$result=$obj->BringQuestions($connection,$quiz_id);

$_SESSION["quizData"]=[];

while($row=$result->fetch_assoc())
{
    $_SESSION["quizData"][]=$row;
}

header("Location:../view/quiz_page.php");
exit();

?>