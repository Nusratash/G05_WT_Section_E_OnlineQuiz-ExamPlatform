<?php
include "../Model/UserModel.php";
session_start();

$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";

$hasNameError = true;
$hasEmailError = true;
$hasPasswordError = true;
$hasRoleError = true;

if(!$name){
    $_SESSION["nameErr"] = "Name is required";
    $hasNameError = true;
}else{
    unset($_SESSION["nameErr"]);
    $hasNameError = false;
}

if(!$email){
    $_SESSION["emailErr"] = "Email is required";
    $hasEmailError = true;
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION["emailErr"] = "Please enter a valid email address";
    $hasEmailError = true;
}else{
    unset($_SESSION["emailErr"]);
    $hasEmailError = false;
}

if(!$password){
    $_SESSION["passwordErr"] = "Password is required";
    $hasPasswordError = true;
}elseif(strlen($password) < 8){
    $_SESSION["passwordErr"] ="Mmust be at least 8 char";
    $hasPasswordError = true;
}else{
    unset($_SESSION["passwordErr"]);
    $hasPasswordError = false;
}

if(!$role){
    $_SESSION["roleErr"] = "Please select a role";
    $hasRoleError = true;
}elseif(!in_array($role, ['student', 'instructor'])){
    $_SESSION["roleErr"] = "Invalid role selected";
    $hasRoleError = true;
}else{
    unset($_SESSION["roleErr"]);
    $hasRoleError = false;
}

?>