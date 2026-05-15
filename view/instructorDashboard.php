<?php 
session_start();
include "../Model/UserModel.php";

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";
$userId = $_SESSION["user_id"] ?? "";

if(!$isLoggedIn){
    Header("Location: login.php");
    exit();
}

if($role != 'instructor'){
    if($role == 'student'){
        Header("Location: studentDashboard.php");
    }elseif($role == 'admin'){
        Header("Location: adminPanel.php");
    }
    exit();
}

$userModel = new UserModel();
$a = $userModel->getInstructorDashboardStats($userId);
?>

<!doctype html>
<html>
    <head>
        <title>Instructor Dashboard </title>
       
    </head>
    <body>
        





    </body>
</html>