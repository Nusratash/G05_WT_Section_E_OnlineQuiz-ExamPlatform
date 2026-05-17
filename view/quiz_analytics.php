<?php
session_start();

$quizList=$_SESSION["quizList"] ?? [];
$attemptList=$_SESSION["attemptList"] ?? [];
?>
<html>
<head>
    <title>Quiz Analytics</title>
    <link rel="stylesheet" href="css/quiz_analytics_stylesheet.css">
</head>
<body>
    <table>
        <tr>
            <th colspan="4"><h1>Quiz Analytics</h1></th>
        </tr>
        <tr>
            <th colspan="4">
                <form action="../controller/QuizAnalyticsController.php" method="POST">
                    <select name="quiz_id">
                        <?php
                        foreach($quizList as $quiz)
                        {
                        ?>

                        <option value="<?=$quiz["id"]?>"
                        <?php
                        if(isset($_SESSION["selected_quiz_id"]) && $_SESSION["selected_quiz_id"] == $quiz["id"])
                        {
                            echo "selected";
                        }
                        ?>
                        >
                        <?=$quiz["title"]?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                    <button type="submit">Show Analytics</button>
                </form>
            </th>
        </tr>
        <?php
        if(isset($_SESSION["reportLoaded"]))
        {
        ?>
        <th colspan="4"><h3>Student Attempts</h3></th>
        <tr>
            <td>Student Name</td>
            <td>Score</td>
            <td>Duration</td>
            <td>Pass/Fail</td>
        </tr>
        <?php
        foreach($attemptList as $row)
        {
        ?>
        <tr>
            <td><?=$row["name"]?></td>
            <td><?=$row["score"]?></td>
            <td><?=$row["duration"]?></td>
            <td><?=$row["result_status"]?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <th colspan="4"><h3>Summary</h3></th>
        </tr>
        <tr>
            <td>Average Score</td>
            <td>Highest Score</td>
            <td>Lowest Score</td>
            <td>Pass Rate</td>
        </tr>
        <tr>
            <td><?= $_SESSION["average_score"] ?></td>
            <td><?= $_SESSION["highest_score"] ?></td>
            <td><?= $_SESSION["lowest_score"] ?></td>
            <td><?= $_SESSION["pass_rate"] ?>%</td>
        </tr>
        <?php
        }
        ?>
        <tr><td colspan="4" style="text-align:center"><button><a href="#">Close</a></button></td></tr>
    </table>
</body>

</html>