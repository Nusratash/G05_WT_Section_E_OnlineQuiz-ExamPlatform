<?php

session_start();

require_once "../Model/UserModel.php";

$isLoggedIn =
    $_SESSION["isLoggedIn"] ?? false;

$role =
    $_SESSION["role"] ?? "";

$name =
    $_SESSION["name"] ?? "";

$userId =
    $_SESSION["user_id"] ?? "";

if (!$isLoggedIn) {

    header("Location: login.php");

    exit();
}

if ($role != "instructor") {

    if ($role == "student") {

        header(
            "Location: studentDashboard.php"
        );

    } elseif ($role == "admin") {

        header(
            "Location: adminPanel.php"
        );
    }

    exit();
}

// USER MODEL
$userModel = new UserModel();

$stats =
    $userModel->getInstructorDashboardStats(
        $userId
    );

?>

<!DOCTYPE html>

<html>

<head>

    <title>Instructor Dashboard</title>

</head>

<body>

    <!-- NAVIGATION -->
    <?php include "nav.php"; ?>

    <div class="dashboard">

        <div>

            <h1>
                Welcome, Instructor
                <?php echo $name; ?> !
            </h1>

            <h3>
                Instructor Dashboard
            </h3>

        </div>

        <hr>

        <div>

            <div>

                <h3>
                    Total Quizzes Created :
                </h3>

                <div class="number">

                    <?php
                    echo $stats['total_quizzes'];
                    ?>

                </div>

            </div>

            <br>

            <div>

                <h3>
                    Total Attempts :
                </h3>

                <div class="number">

                    <?php
                    echo $stats['total_attempts'];
                    ?>

                </div>

            </div>

        </div>

    </div>

</body>

</html>