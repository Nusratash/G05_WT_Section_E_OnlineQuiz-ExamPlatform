<?php
session_start();
$data=$_SESSION["quizData"];
$attempt_id=$_SESSION["attempt_id"];
$time=$data[0]["time_limit_minutes"];
?>
<html>
    <body>
        <h2>Time: <span id="timer"></span></h2>
        <div id="warning"></div>
        <form id="quizForm" data-time="<?=$time?>">
            <input type="hidden" name="attempt_id" value="<?=$attempt_id?>">
            <?php
            $currentQuestion=0;
            foreach($data as $row)
            {
                if($currentQuestion!=$row["question_id"])
                {
                    $currentQuestion=$row["question_id"];
            ?>
                    <h3><?=$row["question_text"]?></h3>
            <?php
                }
            ?>

            <input type="radio" name="answers[<?=$row['question_id']?>]" value="<?=$row['option_id']?>"><?=$row["option_text"]?>
            <br>
            <?php
            }
            ?>
            <button type="button" id="submitBtn">Submit Quiz</button>
        </form>
        <script src="js/quiz.js"></script>
    </body>
</html>