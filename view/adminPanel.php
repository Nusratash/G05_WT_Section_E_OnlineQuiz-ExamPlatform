<?php
session_start();
include "../Model/UserModel.php";

$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
$role = $_SESSION["role"] ?? "";
$name = $_SESSION["name"] ?? "";

if (!$isLoggedIn) {
    Header("Location: login.php");
    exit();
}

if ($role != 'admin') {
    if ($role == 'student') {
        Header("Location: studentDashboard.php");
    } elseif ($role == 'instructor') {
        Header("Location: instructorDashboard.php");
    }
    exit();
}


$userModel = new UserModel();
$users = $userModel->getAllUsers();

$totalUsers = count($users);
$activeUsers = 0;
$suspendedUsers = 0;

foreach ($users as $user) {
    if ($user['is_active'] == 1) {
        $activeUsers++;
    } else {
        $suspendedUsers++;
    }
}
?>


<!doctype html>
<html>

<head>
    <title>Admin Panel</title>

</head>

<body>
    <div class="dashboard">
        <div>
            <div>
                <h1>Admin Panel</h1>
                <h3>Welcome, Mr. <?php echo $name; ?>!</h3>
            </div>
            <a href="../Controller/logoutController.php" class="logout">Logout</a>
        </div>

        <div>
            <strong>System Statistics:</strong> Total Users: <?php echo $totalUsers; ?> and
            Active Users: <?php echo $activeUsers; ?> and
            Suspended Users: <?php echo $suspendedUsers; ?>
        </div>

        
    </div>


</body>

</html>