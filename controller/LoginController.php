<?php
include "../Model/UserModel.php";
session_start();

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$hasEmailError = true;
$hasPasswordError = true;

if(!$email){
    $_SESSION["loginEmailErr"] = "Email is required";
    $hasEmailError = true;
}else{
    unset($_SESSION["loginEmailErr"]);
    $hasEmailError = false;
}

if(!$password){
    $_SESSION["loginPasswordErr"] = "Password is required";
    $hasPasswordError = true;
}else{
    unset($_SESSION["loginPasswordErr"]);
    $hasPasswordError = false;
}

if($hasEmailError || $hasPasswordError){
    $_SESSION["loginEmail"] = $email;
    Header("Location: ../View/login.php");
    exit();
}


?>