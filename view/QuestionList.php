<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$quizId = $_GET["quiz_id"] ?? "";
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$instructorId = $_SESSION["user_id"] ?? 1;
$quiz = $quizDB->GetQuizById($connection, $quizId, $instructorId);
if($quiz->num_rows == 0){
    header("Location: ../View/QuizesList.php");
    exit();
}
$questions = $quizDB->GetQuestionsByQuizId($connection, $quizId);
?>
<html>
<head>
    <title>QUESTION LIST</title>
    <script src="../Controller/JS/questionAjax.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Question List</h2>
    <table>
        <tr>
            <th>Question</th>
            <th>Option A</th>
            <th>Option B</th>
            <th>Option C</th>
            <th>Option D</th>
            <th>Correct Answer</th>
            <th>Action</th>
        </tr>
        <?php
        while ($question = $questions->fetch_assoc()) {
            $questionId = $question["id"];
            $options = $quizDB->GetOptionsByQuestionId($connection, $questionId);
            $optionArray = [];
            $correctAnswer = "";
            while ($row = $options->fetch_assoc()) {
                $optionArray[] = $row;
                if ($row["is_correct"] == 1) {
                    $correctAnswer = $row["option_text"];
                }
            }
            echo "
            <tr id='question_row_$questionId'>
                <td id='question_text_$questionId'>
                    {$question["question_text"]}
                </td>
                <td id='option1_$questionId' data-option-id='{$optionArray[0]["id"]}'>
                    {$optionArray[0]["option_text"]}
                </td>
                <td id='option2_$questionId' data-option-id='{$optionArray[1]["id"]}'>
                    {$optionArray[1]["option_text"]}
                </td>
                <td id='option3_$questionId' data-option-id='{$optionArray[2]["id"]}'>
                    {$optionArray[2]["option_text"]}
                </td>
                <td id='option4_$questionId' data-option-id='{$optionArray[3]["id"]}'>
                    {$optionArray[3]["option_text"]}
                </td>
                <td id='correct_option_$questionId'>
                    $correctAnswer
                </td>
                <td id='action_$questionId'>
                    <button onclick='editQuestion($questionId)'>Edit</button>
                    <button onclick='deleteQuestion($questionId)'>Delete</button>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>