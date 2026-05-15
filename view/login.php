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


        <form method="post" action="../Controller/LoginController.php">
            <table>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" /></td>
                    <td>
                        <p style='color:red;'><?php echo $emailError; ?></p>
                    </td>
                </tr>

                <tr>
                    <td><label>Password:</label></td>
                    <td><input type="password" name="password" placeholder="Enter your password" /></td>
                    <td>
                        <p style='color:red;'><?php echo $passwordError; ?></p>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><button type="submit" name="submit">Login</button></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Don't have an account? <a href='register.php'>Registration</a></td>
                    <td></td>
                </tr>
            </table>
        </form>



    </div>
</body>

</html>