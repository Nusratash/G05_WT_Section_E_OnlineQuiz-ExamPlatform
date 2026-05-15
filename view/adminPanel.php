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



        <h3>User Management</h3>
        <div class="tableContainer">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) {
                        $userId = $user['id'];
                        $userName = $user['name'];
                        $userEmail = $user['email'];
                        $userRole = $user['role'];
                        $createdAt = $user['created_at'];
                        $isActive = $user['is_active'];

                        $statusText = $isActive == 1 ? 'Active' : 'Suspended';
                        $btnText = $isActive == 1 ? 'Suspend' : 'Activate';

                        echo "<tr data-user-id='$userId'>
                                    <td>$userId</td>
                                    <td>$userName</td>
                                    <td>$userEmail</td>
                                    <td>$userRole</td>
                                    <td>
                                        <span class='" . ($isActive == 1 ? 'active' : 'inactive') . "'>$statusText</span>
                                    </td>
                                    <td>$createdAt</td>
                                    <td>
                                        <button 
                                            class='toggle-btn " . ($isActive == 1 ? 'btn-active' : 'btn-inactive') . "' 
                                            onclick='toggleUserStatus($userId, $isActive)'>
                                            $btnText
                                        </button>
                                    </td>
                                 </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>




</body>

</html>