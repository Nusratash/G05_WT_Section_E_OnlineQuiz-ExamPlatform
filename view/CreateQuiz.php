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
    foreach ($_SESSION["questions"] as $question) {
        $totalMark += 1;
    }
}
// Flag: if there are no leftover session fields, this is a fresh load → clear sessionStorage
$freshLoad = ($quizTitle == "" && $description == "" && $quizTime == "" && $status == "");
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
                    <input type="text" name="quiz_title" id="quiz_title" class="input-field" value="<?php echo $quizTitle; ?>">
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
                    <input type="text" name="description" id="description" class="input-field" value="<?php echo $description; ?>">
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
                    <input type="number" name="total_mark" class="input-field" value="<?php echo $totalMark; ?>" readonly>
                </td>
            </tr>
            <tr>
                <td>
                    Time Limit:
                </td>
                <td>
                    <input type="text" name="quiz_time" id="quiz_time" class="input-field" value="<?php echo $quizTime; ?>">
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
                    <select name="status" id="status" class="input-field">
                        <option value="">
                            Select Status
                        </option>
                        <option value="draft"
                            <?php
                            if ($status == "draft") {
                                echo "selected";
                            }
                            ?>
                        >
                            Draft
                        </option>
                        <option value="published"
                            <?php
                            if ($status == "published") {
                                echo "selected";
                            }
                            ?>
                        >
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
            <button type="button" class="btn-add" onclick="saveQuizFieldsAndOpenModal()">
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
                                Question: {$question["question"]}
                            </h3>
                            <p>
                                Option 1: {$question["option1"]}
                            </p>
                            <p>
                                Option 2: {$question["option2"]}
                            </p>
                            <p>
                                Option 3: {$question["option3"]}
                            </p>
                            <p>
                                Option 4: {$question["option4"]}
                            </p>
                            <strong>
                                Correct Answer: {$question["correct_answer"]}
                            </strong>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
            <input type="submit" value="SAVE" class="btn-save">
        </div>
    </form>
    <?php include "AddQuestionModal.php"; ?>
    <script>
    var freshLoad = <?php echo $freshLoad ? 'true' : 'false'; ?>;

    function saveQuizFieldsAndOpenModal() {
        sessionStorage.setItem(
            "quiz_title",
            document.getElementById("quiz_title").value
        );
        sessionStorage.setItem(
            "description",
            document.getElementById("description").value
        );
        sessionStorage.setItem(
            "quiz_time",
            document.getElementById("quiz_time").value
        );
        sessionStorage.setItem(
            "status",
            document.getElementById("status").value
        );
        openModal();
    }

    window.onload = function () {
        // If this is a fresh load (no leftover PHP session data),
        // it means the previous quiz was saved successfully — clear sessionStorage.
        if (freshLoad) {
            sessionStorage.removeItem("quiz_title");
            sessionStorage.removeItem("description");
            sessionStorage.removeItem("quiz_time");
            sessionStorage.removeItem("status");
            return;
        }

        // Restore from sessionStorage only if PHP didn't already provide a value
        if (document.getElementById("quiz_title").value == "") {
            document.getElementById("quiz_title").value =
                sessionStorage.getItem("quiz_title") ?? "";
        }
        if (document.getElementById("description").value == "") {
            document.getElementById("description").value =
                sessionStorage.getItem("description") ?? "";
        }
        if (document.getElementById("quiz_time").value == "") {
            document.getElementById("quiz_time").value =
                sessionStorage.getItem("quiz_time") ?? "";
        }
        if (document.getElementById("status").value == "") {
            document.getElementById("status").value =
                sessionStorage.getItem("status") ?? "";
        }
    };
    </script>
    <?php
    if (isset($_SESSION["openModal"])) {
        unset($_SESSION["openModal"]);
        echo "
        <script>
            openModal();
        </script>
        ";
    }
    unset($_SESSION["titleErr"]);
    unset($_SESSION["descriptionErr"]);
    unset($_SESSION["timeErr"]);
    unset($_SESSION["statusErr"]);
    unset($_SESSION["questionListErr"]);
    ?>
</body>
</html>