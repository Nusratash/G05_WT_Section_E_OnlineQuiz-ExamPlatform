<?php

session_start();

$email =
    $_SESSION["loginEmail"] ?? "";

$emailError =
    $_SESSION["loginEmailErr"] ?? "";

$passwordError =
    $_SESSION["loginPasswordErr"] ?? "";

$loginErr =
    $_SESSION["loginErr"] ?? "";

$successMsg =
    $_SESSION["successMsg"] ?? "";

unset($_SESSION["loginEmail"]);
unset($_SESSION["loginEmailErr"]);
unset($_SESSION["loginPasswordErr"]);
unset($_SESSION["loginErr"]);
unset($_SESSION["successMsg"]);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Login</title>

</head>

<body>

    <div class="container">

        <h2>Login</h2>

        <?php

        if ($successMsg) {

            echo
                "<p style='color:green;'>$successMsg</p>";
        }

        if ($loginErr) {

            echo
                "<p style='color:red;'>$loginErr</p>";
        }

        ?>

        <form
            method="post"
            action="../Controller/LoginController.php"
        >

            <table>

                <tr>

                    <td>Email :</td>

                    <td>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter Email"
                            value="<?php echo $email; ?>"
                        >

                    </td>

                    <td>

                        <p style="color:red;">

                            <?php
                            echo $emailError;
                            ?>

                        </p>

                    </td>

                </tr>

                <tr>

                    <td>Password :</td>

                    <td>

                        <input
                            type="password"
                            name="password"
                            placeholder="Enter Password"
                        >

                    </td>

                    <td>

                        <p style="color:red;">

                            <?php
                            echo $passwordError;
                            ?>

                        </p>

                    </td>

                </tr>

                <tr>

                    <td></td>

                    <td>

                        <button
                            type="submit"
                        >
                            Login
                        </button>

                    </td>

                </tr>

                <tr>

                    <td></td>

                    <td>

                        Don't have account?

                        <a href="register.php">
                            Register
                        </a>

                    </td>

                </tr>

            </table>

        </form>

    </div>

</body>

</html>