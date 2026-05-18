<?php

include "../model/UserModel.php";

session_start();

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";

$hasError = false;

if (!$name) {

    $_SESSION["nameErr"] =
        "Name is required";

    $hasError = true;

} else {

    unset($_SESSION["nameErr"]);
}

if (!$email) {

    $_SESSION["emailErr"] =
        "Email is required";

    $hasError = true;

} elseif (
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
) {

    $_SESSION["emailErr"] =
        "Invalid email format";

    $hasError = true;

} else {

    unset($_SESSION["emailErr"]);
}

if (!$password) {

    $_SESSION["passwordErr"] =
        "Password is required";

    $hasError = true;

} elseif (strlen($password) < 8) {

    $_SESSION["passwordErr"] =
        "Password must be at least 8 characters";

    $hasError = true;

} else {

    unset($_SESSION["passwordErr"]);
}

if (!$role) {

    $_SESSION["roleErr"] =
        "Please select a role";

    $hasError = true;

} elseif (
    !in_array(
        $role,
        ["student", "instructor"]
    )
) {

    $_SESSION["roleErr"] =
        "Invalid role";

    $hasError = true;

} else {

    unset($_SESSION["roleErr"]);
}

$_SESSION["name"] = $name;
$_SESSION["email"] = $email;
$_SESSION["role"] = $role;

if ($hasError) {

    header(
        "Location: ../View/register.php"
    );

    exit();
}

$userModel = new UserModel();

$existingUser =
    $userModel->findByEmail($email);

if ($existingUser) {

    $_SESSION["emailErr"] =
        "Email already registered";

    header(
        "Location: ../View/register.php"
    );

    exit();
}

$result = $userModel->register(
    $name,
    $email,
    $password,
    $role
);

if ($result) {

    unset($_SESSION["name"]);
    unset($_SESSION["email"]);
    unset($_SESSION["role"]);

    $_SESSION["successMsg"] =
        "Registration successful! Please login.";

    header(
        "Location: ../View/login.php"
    );

} else {

    $_SESSION["errorMsg"] =
        "Registration failed";

    header(
        "Location: ../View/register.php"
    );
}

?>