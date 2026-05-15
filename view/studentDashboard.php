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

if ($role != 'student') {
    if ($role == 'instructor') {
        Header("Location: instructor_dashboard.php");
    } elseif ($role == 'admin') {
        Header("Location: admin_panel.php");
    }
    exit();
}

$userModel = new UserModel();
$a = $userModel->getStudentDashboardStats($userId);
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
            <a href="../Controller/logoutController.php" class="logout">Logout</a>
        </div>

        <div>
            <div>
                <h3>Available Quizzes :</h3>
                <div><?php echo $a['total_quizzes']; ?></div>

            </div>
            <div>
                <h3>Attempts Taken of quizzes:</h3>
                <div><?php echo $a['total_attempts']; ?></div>

            </div>

            <div>
                <h3>Total Score :</h3>
                <div><?php echo $a['total_score']; ?></div>

            </div>
        </div>

        <div class="nav-links">
            <a href="">Available Quizzes</a>
            <a href="">My Results</a>
            <a href="">Leaderboard</a>
        </div>




    </div>

</head>

<body>




</body>

</html>