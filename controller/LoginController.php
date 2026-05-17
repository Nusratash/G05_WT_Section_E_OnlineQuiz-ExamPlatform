<?php
require_once "../Model/UserModel.php";
session_start();

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$hasError = false;

if (!$email) {

    $_SESSION["loginEmailErr"] =
        "Email is required";

    $hasError = true;

} else {

    unset($_SESSION["loginEmailErr"]);
}

// PASSWORD VALIDATION
if (!$password) {

    $_SESSION["loginPasswordErr"] =
        "Password is required";

    $hasError = true;

} else {

    unset($_SESSION["loginPasswordErr"]);
}

$_SESSION["loginEmail"] = $email;


if ($hasError) {

    header(
        "Location: ../View/login.php"
    );

    exit();
}


$userModel = new UserModel();

$user = $userModel->findByEmail(
    $email
);

if (!$user) {

    $_SESSION["loginErr"] =
        "Invalid email or password";

    header(
        "Location: ../View/login.php"
    );

    exit();
}

if ($user["is_active"] == 0) {

    $_SESSION["loginErr"] =
        "Your account is suspended";

    header(
        "Location: ../View/login.php"
    );

    exit();
}

if (
    password_verify(
        $password,
        $user["password_hash"]
    )
) {

    $_SESSION["user_id"] =
        $user["id"];

    $_SESSION["name"] =
        $user["name"];

    $_SESSION["email"] =
        $user["email"];

    $_SESSION["role"] =
        $user["role"];

    $_SESSION["isLoggedIn"] = true;

    // REDIRECT
    if (
        $user["role"] == "student"
    ) {

        header(
            "Location: ../View/studentDashboard.php"
        );

    } elseif (
        $user["role"] == "instructor"
    ) {

        header(
            "Location: ../View/instructorDashboard.php"
        );

    } elseif (
        $user["role"] == "admin"
    ) {

        header(
            "Location: ../View/adminPanel.php"
        );
    }

    exit();

} else {

    $_SESSION["loginErr"] =
        "Invalid email or password";

    header(
        "Location: ../View/login.php"
    );

    exit();
}

?>