<?php
session_start();
?>
<html>
<head>
    <title>CREATE QUIZ</title>
    <link rel="stylesheet" href="styleqsbuild.css" >
    <script src="../Controller/JS/questionAjax.js"></script>
</head>
<body>

<form action="" method="">
    <table class="no-border">
        <tr>
            <td class="label-cell">
                Quiz Title:
            </td>
            <td>
                <input type="text" name="quiz_title" class="input-field">
            </td>
        </tr>
        <tr>
            <td>Description:</td>
            <td>
                <input type="text" name="description" class="input-field" >
            </td>
        </tr>
        <tr>
            <td>Total Mark:</td>
            <td>
                <input type="number" name="total_mark" class="input-field">
            </td>
        </tr>
        <tr>
            <td>Time:</td>
            <td>
                <input type="text" name="quiz_time" class="input-field">
            </td>
        </tr>
    </table>

    <div class="question_section">
        <button type="button" class="btn-add" onclick="openModal()" >
            ADD ITEM
        </button>
        <div id="questionList">
            <?php
            if (isset($_SESSION["questions"])) {
                foreach ($_SESSION["questions"] as $question) {
                    echo "
                    <div class='question-box'>
                        <h3>
                            Question:
                            {$question["question"]}
                        </h3>
                        <p>
                            Option 1:
                            {$question["option1"]}
                        </p>
                        <p>
                            Option 2:
                            {$question["option2"]}
                        </p>
                        <p>
                            Option 3:
                            {$question["option3"]}
                        </p>
                        <p>
                            Option 4:
                            {$question["option4"]}
                        </p>
                        <strong>
                            Correct Answer:
                            {$question["correct_answer"]}
                        </strong>
                    </div
                    ";
                }
            }
            ?>
        </div>
        <input type="submit" value="SAVE" class="btn-save">
    </div>
</form>
<?php include "AddQuestionModal.php"; ?>
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