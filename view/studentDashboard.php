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

if($role != 'student'){
    if($role == 'instructor'){
        Header("Location: instructor_dashboard.php");
    }elseif($role == 'admin'){
        Header("Location: admin_panel.php");
    }
    exit();
}

$userModel = new UserModel();
$stats = $userModel->getStudentDashboardStats($userId);
?>

<!doctype html>
<html>
    <head>
        <title>Student Dashboard</title>
    
    </head>
    <body>
       



    </body>
</html>