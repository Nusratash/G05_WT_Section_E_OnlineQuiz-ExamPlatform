<?php
include "../Model/UserModel.php";
session_start();

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$hasEmailError = true;
$hasPasswordError = true;

if (!$email) {
    $_SESSION["loginEmailErr"] = "Email is required";
    $hasEmailError = true;
} else {
    unset($_SESSION["loginEmailErr"]);
    $hasEmailError = false;
}

if (!$password) {
    $_SESSION["loginPasswordErr"] = "Password is required";
    $hasPasswordError = true;
} else {
    unset($_SESSION["loginPasswordErr"]);
    $hasPasswordError = false;
}

if ($hasEmailError || $hasPasswordError) {
    $_SESSION["loginEmail"] = $email;
    Header("Location: ../View/login.php");
    exit();
}


$userModel = new UserModel();
$user = $userModel->$email;

if (!$user) {
    $_SESSION["loginErr"] = "Invalid email or password";
    Header("Location: ../View/login.php");
    exit();
}

if ($user['is_active'] == 0) {
    $_SESSION["loginErr"] = "Your account has been suspended. Please contact administrator.";
    Header("Location: ../View/login.php");
    exit();
}

if (password_verify($password, $user['password_hash'])) {
    $_SESSION["user_id"] = $user['id'];
    $_SESSION["name"] = $user['name'];
    $_SESSION["email"] = $user['email'];
    $_SESSION["role"] = $user['role'];
    $_SESSION["isLoggedIn"] = true;

    if ($user['role'] == 'student') {
        Header("Location: ../View/studentDashboard.php");
    } elseif ($user['role'] == 'instructor') {
        Header("Location: ../View/instructorDashboard.php");
    } elseif ($user['role'] == 'admin') {
        Header("Location: ../View/adminPanel.php");
    }
} else {
    $_SESSION["loginErr"] = "Invalid email or password";
    Header("Location: ../View/login.php");
}




?>