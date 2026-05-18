<?php
session_start();
$data=$_SESSION["quizList"] ?? [];
?>
<html>
    <body>
        <h2>Available Quizzes</h2>
        <table style="border: 1px solid black">
            <tr>
                <th>Quiz</th>
                <th>Marks</th>
                <th>Status</th>
            </tr>
            <?php foreach($data as $row)
            {
                $attempted=$row["attempt_id"]!=NULL;
            ?>
            <tr
            <?php
            if($attempted)
            {
            ?>
            style="background-color:lightgray"
            <?php
            }
            ?>
            >
                <td><?=$row["title"]?></td>
                <td><?=$row["total_marks"]?></td>
                <td><?php
                if($attempted)
                {
                ?>
                Score:<?=$row["score"]?>
                <?php
                }
                else
                {
                ?>
                <form action="../controller/StartQuizController.php" method="POST">
                <input type="hidden" name="quiz_id" value="<?=$row["id"]?>">

                <button type="submit">Start Quiz</button>

                </form>
                <?php
                }
                ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </body>
</html>