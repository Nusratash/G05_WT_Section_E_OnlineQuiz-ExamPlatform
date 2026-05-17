<?php
include "../../model/UserModel.php";
session_start();
header("Content-Type: application/json");

$userId = $_POST["user_id"] ?? "";
$currentStatus = $_POST["current_status"] ?? "";

if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] != 'admin'){
    echo json_encode(["success" => false, "error" => "Unauthorized access"]);
    exit();
}

if(!$userId){
    echo json_encode(["success" => false, "error" => "Please provide user id"]);
    exit();
}

if($currentStatus === ""){
    echo json_encode(["success" => false, "error" => "Please provide current status"]);
    exit();
}

$userModel = new UserModel();
$result = $userModel->toggleUserStatus($userId, $currentStatus);

echo json_encode($result);
?>
