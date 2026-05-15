<?php
session_start();
$questionError = $_SESSION["questionErr"] ?? "";
$option1Error = $_SESSION["option1Err"] ?? "";
$option2Error = $_SESSION["option2Err"] ?? "";
$option3Error = $_SESSION["option3Err"] ?? "";
$option4Error = $_SESSION["option4Err"] ?? "";
$correctOptionError =$_SESSION["correctOptionErr"] ?? "";

$questionValue = $_SESSION["question"] ?? "";
$option1Value = $_SESSION["option1"] ?? "";
$option2Value = $_SESSION["option2"] ?? "";
$option3Value = $_SESSION["option3"] ?? "";
$option4Value = $_SESSION["option4"] ?? "";
$correctOptionValue =$_SESSION["correct_option"] ?? "";

unset($_SESSION["questionErr"]);
unset($_SESSION["option1Err"]);
unset($_SESSION["option2Err"]);
unset($_SESSION["option3Err"]);
unset($_SESSION["option4Err"]);
unset($_SESSION["correctOptionErr"]);
?>

<html>
<head>
    <link rel="stylesheet" href="styleqsbuild.css">
</head>

<body>
    <div id="modalOverlay" class="modal">
        <form method="POST" action="../Controller/AddQuestionValidation.php" class="modal-form">
            <table class="modal-content">
                <tr class="no-border">
                    <th colspan="2">
                        <h2>Question</h2>
                    </th>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="text" name="question" id="question" class="question-input" placeholder="Enter your question" value="<?php echo $questionValue; ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p style="color:red;">
                            <?php echo $questionError; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th colspan="2">
                        <h2>Options</h2>
                    </th>
                </tr>
                <tr>
                    <td class="radio-cell">
                        <input type="radio" id="correct1" name="correct_option" value="option1"
                            <?php
                            if ($correctOptionValue == "option1") {
                                echo "checked";
                            }
                            ?>
                        >
                        <label for="correct1">
                            Correct
                        </label>
                    </td>
                    <td>
                        <input type="text" name="option1" id="option1" class="input-field"  placeholder="Option 1"  value="<?php echo $option1Value; ?>" />
                        <p style="color:red;">
                            <?php echo $option1Error; ?>
                        </p>
                    </td>
                </tr>


                <tr>
                    <td class="radio-cell">
                        <input
                            type="radio" id="correct2" name="correct_option" value="option2"
                            <?php
                            if ($correctOptionValue == "option2") {
                                echo "checked";
                            }
                            ?>
                        >
                        <label for="correct2">
                            Correct
                        </label>
                    </td>
                    <td>
                        <input type="text" name="option2" id="option2" class="input-field" placeholder="Option 2" value="<?php echo $option2Value; ?>" />
                        <p style="color:red;">
                            <?php echo $option2Error; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td class="radio-cell">
                        <input type="radio" id="correct3" name="correct_option" value="option3"
                            <?php
                            if ($correctOptionValue == "option3") {
                                echo "checked";
                            }
                            ?>
                        >
                        <label for="correct3">
                            Correct
                        </label>
                    </td>
                    <td>
                        <input type="text" name="option3" id="option3" class="input-field" placeholder="Option 3" value="<?php echo $option3Value; ?>" />
                        <p style="color:red;">
                            <?php echo $option3Error; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td class="radio-cell">
                        <input type="radio" id="correct4" name="correct_option" value="option4"
                            <?php
                            if ($correctOptionValue == "option4") {
                                echo "checked";
                            }
                            ?>
                        >
                        <label for="correct4">
                            Correct
                        </label>
                    </td>
                    <td>
                        <input type="text" name="option4" id="option4" class="input-field" placeholder="Option 4" value="<?php echo $option4Value; ?>" />
                        <p style="color:red;">
                            <?php echo $option4Error; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <p style="color:red;">
                            <?php echo $correctOptionError; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn-add">
                            Add
                        </button>

                        <button type="button" class="btn-cancel" onclick="closeModal()">
                            Cancel
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>