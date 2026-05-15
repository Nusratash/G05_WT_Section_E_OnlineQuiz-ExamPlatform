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
         <div class="dashboard">
            <div>
                <div>
                    <h1>Welcome, <?php echo $name; ?>!</h1>
                    <h3>Student Dashboard</h3>
                </div>
                <a href="../Controller/LogoutController.php" class="logout">Logout</a>
            </div>
            
            
        </div>
    
    </head>
    <body>
       



    </body>
</html>