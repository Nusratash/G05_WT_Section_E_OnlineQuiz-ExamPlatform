<?php
session_start();
$resultData = $_SESSION["resultData"] ?? [];
$quizTitle = $_SESSION["quizTitle"] ?? "";
$quizTotalMark = $_SESSION["quizTotalMark"] ?? "";
$quizScore = $_SESSION["quizScore"] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attempt Result</title>
    <link rel="stylesheet" href="css/attempted_result_stylesheet.css">
</head>

<body>
    <table>
        <tr>
            <td colspan="3" style="text-align: center"><h3><?php echo $quizTitle;?></h3></td>
        </tr>
        <tr>
            <td class="cell-align-right"><b>Score:</b> <?php echo $quizScore."/".$quizTotalMark;?></td>
            <td></td>
            <td style="text-align: right"><b>Status:</b> <?php echo ($quizScore/$quizTotalMark>=.6 ? "Passed":"Failed") ?></td>
        </tr>
        <?php
        foreach($resultData as $row)
        {
        ?>
        <tr>
            <td class="cell-align-right"><b><?php echo $row["order_index"].". "; ?></b></td>
            <td colspan="2" class="max-width"><b><?php echo $row["question_text"]; ?></b></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" class="<?php echo($row['selected_answer']==$row['correct_answer'])?'correct':'wrong'?>"><b>Selected Option:</b> <?php echo $row["selected_answer"]; ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><b>Correct Option:</b> <?php echo $row["correct_answer"];?></td>
        </tr>
        <?php
        }
        ?>
        <tr><td colspan="3" class="close-button"><button><a href="#">Close</a></button></td></tr>
    </table>

</body>

</html>