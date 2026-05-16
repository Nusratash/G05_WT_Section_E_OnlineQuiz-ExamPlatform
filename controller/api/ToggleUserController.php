<?php 
include "../../model/UserModel.php";
session_start();

header('Content-Type: application/json');

if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] != 'admin'){
    echo json_encode(["success" => false, "error" => "Unauthorized access"]);
    exit();
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
    exit();
}


?>