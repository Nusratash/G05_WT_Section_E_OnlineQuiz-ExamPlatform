<?php
include "../Model/DatabaseConnection.php";
include "../Model/QuizCreateConnection.php";
session_start();
$db = new DatabaseConnection();
$quizDB = new QuizCreateConnection();
$connection = $db->openConnection();
$instructorId = $_SESSION["user_id"] ?? 1;
$quizzes = $quizDB->GetInstructorQuizzes($connection, $instructorId);
$successMsg = $_SESSION["successMsg"] ?? "";
unset($_SESSION["successMsg"]);
?>
<html>
<head>
    <title>
        Quizes List
    </title>
    <script src="../Controller/JS/questionAjax.js"></script>
    <style>
        table{
            width:100%;
            border-collapse:collapse;
        }
        th,td{
            border:1px solid black;
            padding:8px;
            text-align:left;
        }
        .btn-active{
            background-color:#4CAF50;
            color:white;
            padding:5px 10px;
            border:none;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>

    <h2>
       Quizes List
    </h2>
    <p style="color:green;">
        <?php echo $successMsg; ?>
    </p>
    <table>
        <thead>
            <tr>
                <th>
                    Title
                </th>
                <th>
                    Description
                </th>
                <th>
                    Total Marks
                </th>
                <th>
                    Time Limit
                </th>
                <th>
                    Status
                </th>
                <th>
                    Publish
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = $quizzes->fetch_assoc()){
                $quizId = $row["id"];
                echo "
                <tr id='quiz_row_$quizId'>
                    <td>
                        {$row["title"]}
                    </td>
                    <td>
                        {$row["description"]}
                    </td>
                    <td>
                        {$row["total_marks"]}
                    </td>
                    <td>
                        {$row["time_limit_minutes"]}
                    </td>
                    <td id='status_$quizId'>
                ";
                if(strtolower($row["status"]) == "published"){
                    echo "Published";
                }
                else{
                    echo "Draft";
                }
                echo "
                    </td>
                    <td>
                        <button type='button' id='toggle_btn_$quizId' onclick='toggleQuizStatus($quizId)'>
                ";
                if(strtolower($row["status"]) == "published"){
                    echo "Unpublish";
                }
                else{
                    echo "Publish";
                }
                echo "
                        </button>
                    </td>
                    <td>
                        <a href='QuestionList.php?quiz_id=$quizId'>
                            Manage Questions
                        </a>
                        <br><br>
                        <a href='EditQuiz.php?quiz_id=$quizId'>
                            Edit Quiz
                        </a>
                        <br><br>
                        <button type='button' onclick='deleteQuiz($quizId)'>
                            Delete Quiz
                        </button>
                    </td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>

    <?php if ($successMsg): ?>
    <script>
        sessionStorage.removeItem("quiz_title");
        sessionStorage.removeItem("description");
        sessionStorage.removeItem("quiz_time");
        sessionStorage.removeItem("status");
    </script>
    <?php endif; ?>
</body>
</html>