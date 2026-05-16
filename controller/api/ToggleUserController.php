<?php
include "../../Model/UserModel.php";
session_start();

$userId = $_POST["user_id"] ?? "";
$currentStatus = $_POST["current_status"] ?? "";

if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] != 'admin'){
    echo "Unauthorized access";
    exit();
}

if(!$userId){
    echo "Please provide user id";
    exit();
}

if($currentStatus === ""){
    echo "Please provide current status";
    exit();
}

$userModel = new UserModel();
$result = $userModel->toggleUserStatus($userId, $currentStatus);

if($result["success"]){
    echo json_encode($result);
}else{
    echo $result["error"];
}
?>