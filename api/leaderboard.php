<?php
require_once("../model/DatabaseConnection.php");
require_once("../model/DBLeaderboard.php");

$db=new DatabaseConnection();

$connection=$db->openConnection();

$obj=new DBLeaderboard();


$result=$obj->BringLeaderboard($connection);

$data=[];


while($row=$result->fetch_assoc())
{
    $data[]=["name"=>$row["name"],"total_score"=>$row["total_score"]];
}

header("Content-Type:application/json");

echo json_encode($data);
?>