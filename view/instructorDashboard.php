<?php
session_start();
include "../Model/UserModel.php";

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";
$userId = $_SESSION["user_id"] ?? "";

if (!$isLoggedIn) {
    Header("Location: login.php");
    exit();
}

if ($role != 'instructor') {
    if ($role == 'student') {
        Header("Location: studentDashboard.php");
    } elseif ($role == 'admin') {
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
    <div class="dashboard">
        <div>
            <div>
                <h1>Welcome, Instructor <?php echo $name; ?>!</h1>
                <h3>Instructor Dashboard</h3>
            </div>
            <a href="../Controller/LogoutController.php" class="logout">Logout</a>
        </div>


        <div>
            <div>
                <h3>Total Quizzes Created :</h3>
                <div class="number"><?php echo $a['total_quizzes']; ?></div>

            </div>
            <div>
                <h3>Total Attempts :</h3>
                <div class="number"><?php echo $a['total_attempts']; ?></div>

            </div>
        </div>

        
    </div>







</body>

</html>