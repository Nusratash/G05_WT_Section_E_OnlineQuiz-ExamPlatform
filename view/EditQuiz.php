<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
$quizId = $_GET["quiz_id"] ?? "";
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$quiz = $quizDB->GetQuizById($connection, $quizId);
$row = $quiz->fetch_assoc();
?>
<html>
<head>
    <title>EDIT QUIZ</title>
    <link rel="stylesheet" href="styleqsbuild.css">
</head>
<body>
<h2>Edit Quiz</h2>
<form action="../Controller/UpdateQuiz.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?php echo $quizId; ?>">
    <table>
        <tr>
            <td>Quiz Title</td>
            <td>
                <input
                    type="text"
                    name="quiz_title"
                    class="input-field"
                    value="<?php echo $row["title"]; ?>"
                >
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <input
                    type="text"
                    name="description"
                    class="input-field"
                    value="<?php echo $row["description"]; ?>"
                >
            </td>
        </tr>
        <tr>
            <td>Time Limit</td>
            <td>
                <input
                    type="text"
                    name="quiz_time"
                    class="input-field"
                    value="<?php echo $row["time_limit_minutes"]; ?>"
                >
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <select name="status" class="input-field">
                    <option value="Draft"
                        <?php
                        if($row["status"] == "Draft"){
                            echo "selected";
                        }
                        ?>
                    >
                        Draft
                    </option>
                    <option value="Published"
                        <?php
                        if($row["status"] == "Published"){
                            echo "selected";
                        }
                        ?>
                    >
                        Published
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input
                    type="submit"
                    value="UPDATE QUIZ"
                    class="btn-add"
                >
            </td>
        </tr>
    </table>
</form>
</body>
</html>