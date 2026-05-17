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

    <div class="container">
        <h2>Register Dashboard</h2>

        <?php
        if ($successMsg) {
            echo $successMsg;
        } elseif ($errorMsg) {
            echo $errorMsg;
        }
        ?>



        <form method="post" action="../Controller/registerController.php">

            <table>
                <tr>
                    <td><label>Full Name:</label></td>
                    <td><input type="text" name="name" placeholder="Enter your full name" value="<?php echo $name; ?>" /></td>
                    <td>
                        <p style='color:red;'><?php echo $nameError; ?></p>
                    </td>
                </tr>

                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" /></td>
                    <td>
                        <p style='color:red;'><?php echo $emailError; ?></p>
                    </td>
                </tr>


                <tr>
                    <td><label>Password:</label></td>
                    <td><input type="password" name="password" placeholder="Enter password (>= 8 char)" /></td>
                    <td>
                        <p style='color:red;'><?php echo $passwordError; ?></p>
                    </td>
                </tr>


                <tr>
                    <td><label>Role:</label></td>
                    <td>
                        <div class="radio-group">
                            <label>
                                <input type="radio" name="role" value="student" <?php echo $role == 'student' ? 'checked' : ''; ?> /> Student
                            </label>
                            <label>
                                <input type="radio" name="role" value="instructor" <?php echo $role == 'instructor' ? 'checked' : ''; ?> /> Instructor
                            </label>
                        </div>
                    </td>

                    <td>
                        <p style='color:red;'><?php echo $roleError; ?></p>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><button type="submit" name="submit">Register</button></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Already have an account? <a href='login.php'>Login Here</a></td>
                    <td></td>
                </tr>
            </table>

        </form>
    </div>




</body>

</html>