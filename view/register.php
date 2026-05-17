<?php

session_start();

$nameError =
    $_SESSION["nameErr"] ?? "";

$emailError =
    $_SESSION["emailErr"] ?? "";

$passwordError =
    $_SESSION["passwordErr"] ?? "";

$roleError =
    $_SESSION["roleErr"] ?? "";

$name =
    $_SESSION["name"] ?? "";

$email =
    $_SESSION["email"] ?? "";

$role =
    $_SESSION["role"] ?? "";

$errorMsg =
    $_SESSION["errorMsg"] ?? "";

unset($_SESSION["nameErr"]);
unset($_SESSION["emailErr"]);
unset($_SESSION["passwordErr"]);
unset($_SESSION["roleErr"]);

unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["role"]);

unset($_SESSION["errorMsg"]);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Registration</title>

</head>

<body>

    <div class="container">

        <h2>Registration</h2>

        <?php

        if ($errorMsg) {

            echo
                "<p style='color:red;'>$errorMsg</p>";
        }

        ?>

        <form
            method="post"
            action="../Controller/RegisterController.php"
        >

            <table>

                <tr>

                    <td>Full Name :</td>

                    <td>

                        <input
                            type="text"
                            name="name"
                            placeholder="Enter Full Name"
                            value="<?php echo $name; ?>"
                        >

                    </td>

                    <td>

                        <p style="color:red;">

                            <?php
                            echo $nameError;
                            ?>

                        </p>

                    </td>

                </tr>

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
                            placeholder="Minimum 8 characters"
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

                    <td>Role :</td>

                    <td>

                        <label>

                            <input
                                type="radio"
                                name="role"
                                value="student"
                                <?php
                                echo $role == "student"
                                    ? "checked"
                                    : "";
                                ?>
                            >

                            Student

                        </label>

                        <label>

                            <input
                                type="radio"
                                name="role"
                                value="instructor"
                                <?php
                                echo $role == "instructor"
                                    ? "checked"
                                    : "";
                                ?>
                            >

                            Instructor

                        </label>

                    </td>

                    <td>

                        <p style="color:red;">

                            <?php
                            echo $roleError;
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
                            Register
                        </button>

                    </td>

                </tr>

                <tr>

                    <td></td>

                    <td>

                        Already have account?

                        <a href="login.php">
                            Login
                        </a>

                    </td>

                </tr>

            </table>

        </form>

    </div>

</body>

</html>