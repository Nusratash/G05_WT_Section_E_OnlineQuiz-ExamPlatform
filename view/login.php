<?php
session_start();

$email = $_SESSION["loginEmail"] ?? "";
$emailError = $_SESSION["loginEmailErr"] ?? "";
$passwordError = $_SESSION["loginPasswordErr"] ?? "";
$loginErr = $_SESSION["loginErr"] ?? "";
$successMsg = $_SESSION["successMsg"] ?? "";

unset($_SESSION["loginEmailErr"]);
unset($_SESSION["loginPasswordErr"]);
unset($_SESSION["loginErr"]);
unset($_SESSION["loginEmail"]);
unset($_SESSION["successMsg"]);
?>

<!doctype html>
<html>

<head>
    <title>Login Dashboard</title>

</head>

<body>
    <div class="container">
        <h2>Wellcome</h2>
        <?php
        if ($successMsg) {
            echo $successMsg;
        } elseif ($loginErr) {
            echo $loginErr;
        }
        ?>




    </div>
</body>

</html>