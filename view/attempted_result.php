<?php
session_start();
$resultData = $_SESSION["resultData"] ?? [];
$quizTitle = $_SESSION["quizTitle"] ?? "";
$quizTotalMark = $_SESSION["quizTotalMark"] ?? "";
$quizScore = $_SESSION["quizScore"] ?? "";
?>