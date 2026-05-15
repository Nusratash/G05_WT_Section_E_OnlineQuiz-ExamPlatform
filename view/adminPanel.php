<?php 
session_start();
include "../Model/UserModel.php";

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";

if(!$isLoggedIn){
    Header("Location: login.php");
    exit();
}

if($role != 'admin'){
    if($role == 'student'){
        Header("Location: studentDashboard.php");
    }elseif($role == 'instructor'){
        Header("Location: instructorDashboard.php");
    }
    exit();
}
?>