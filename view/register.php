<?php 
session_start();
$nameError = $_SESSION["nameErr"] ?? "";
$emailError = $_SESSION["emailErr"] ?? "";
$passwordError = $_SESSION["passwordErr"] ?? "";
$roleError = $_SESSION["roleErr"] ?? "";

$name = $_SESSION["name"] ?? "";
$email = $_SESSION["email"] ?? "";
$role = $_SESSION["role"] ?? "";

$successMsg = $_SESSION["successMsg"] ?? "";
$errorMsg = $_SESSION["errorMsg"] ?? "";

unset($_SESSION["nameErr"]);
unset($_SESSION["emailErr"]);
unset($_SESSION["passwordErr"]);
unset($_SESSION["roleErr"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["role"]);
unset($_SESSION["successMsg"]);
unset($_SESSION["errorMsg"]);
?>


<html>
<head>
    <title>Registration</title>

</head>

<body>





</body>
</html>