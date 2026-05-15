<?php
session_start();
$titleError = $_SESSION["titleErr"] ?? "";
$descriptionError = $_SESSION["descriptionErr"] ?? "";
$timeError = $_SESSION["timeErr"] ?? "";
$statusError = $_SESSION["statusErr"] ?? "";
$questionListError = $_SESSION["questionListErr"] ?? "";

$quizTitle = $_SESSION["quiz_title"] ?? "";
$description = $_SESSION["description"] ?? "";
$quizTime = $_SESSION["quiz_time"] ?? "";
$status = $_SESSION["status"] ?? "";

$totalMark = 0;
if (isset($_SESSION["questions"])) {
    foreach ($_SESSION["questions"] as $question) 
    {
        $totalMark += 1;
    }
}

unset($_SESSION["titleErr"]);
unset($_SESSION["descriptionErr"]);
unset($_SESSION["timeErr"]);
unset($_SESSION["statusErr"]);
unset($_SESSION["questionListErr"]);
?>

<html>
<head>
    <title>CREATE QUIZ</title>
    <link rel="stylesheet" href="styleqsbuild.css">
    <script src="../Controller/JS/questionAjax.js"></script>
</head>

<body>
<form action="../Controller/CreateQuizValidation.php" method="post">
    <table class="no-border">
        <tr>
            <td>
                Quiz Title:
            </td>
            <td>
                <input type="text" name="quiz_title" class="input-field" value="<?php echo $quizTitle; ?>" >
                <p style="color:red;">
                    <?php echo $titleError; ?>
                </p>
            </td>
        </tr>

        <tr>
            <td>
                Description:
            </td>
            <td>
                <input type="text" name="description" class="input-field" value="<?php echo $description; ?>" >
                <p style="color:red;">
                    <?php echo $descriptionError; ?>
                </p>
            </td>
        </tr>

        <tr>
            <td>
                Total Mark:
            </td>
            <td>
                <input type="number" name="total_mark" class="input-field" value="<?php echo $totalMark; ?>" readonly >
            </td>
        </tr>

        <tr>
            <td>
                Time Limit:
            </td>
            <td>
                <input type="text" name="quiz_time" class="input-field" value="<?php echo $quizTime; ?>" >
                <p style="color:red;">
                    <?php echo $timeError; ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                Status:
            </td>
            <td>
                <select name="status" class="input-field" >
                    <option value="">
                        Select Status
                    </option>
                    <option value="Draft" <?php if ($status == "Draft") echo "selected"; ?> >
                        Draft
                    </option>
                    <option value="Published" <?php if ($status == "Published") echo "selected"; ?> >
                        Published
                    </option>
                </select>
                <p style="color:red;"> 
                    <?php echo $statusError; ?>
                </p>
            </td>
        </tr>
    </table>

    <div class="question_section">
        <button type="button" class="btn-add" onclick="openModal()" >
            ADD ITEM
        </button>

        <p style="color:red;">
            <?php echo $questionListError; ?>
        </p>

        <div id="questionList">
            <?php
            if (isset($_SESSION["questions"])) {
                foreach ($_SESSION["questions"] as $question) {
                    echo "
                    <div class='question-box'>
                        <h3>
                            Question:  {$question["question"]}
                        </h3>
                        <p>
                            Option 1: {$question["option1"]}
                        </p>
                        <p>
                            Option 2:{$question["option2"]}
                        </p>
                        <p>
                            Option 3:{$question["option3"]}
                        </p>

                        <p>
                            Option 4: {$question["option4"]}
                        </p>

                        <strong>
                            Correct Answer:{$question["correct_answer"]}
                        </strong>
                    </div>
                    ";
                }
            }
            ?>
        </div>

        <input type="submit" value="SAVE" class="btn-save" >
    </div>
</form>
<?php 
include "AddQuestionModal.php"; ?>
<?php

if (isset($_SESSION["openModal"])) {
    unset($_SESSION["openModal"]);
    echo "
    <script>
        openModal();
    </script>
    ";
}
?>
</body>
</html>