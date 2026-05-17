<?php
session_start();

$data = $_SESSION["attemptHistory"] ?? [];
?>
<html>
    <head>
        <title>My Result</title>
        <link rel="stylesheet" href="css/leaderboard_stylesheet.css">
    </head>
    <body>
        <table>
            <tr>
                <th colspan="5"><h1>My Quiz Attempts</h1></th>
            </tr>
            <tr>
                <th>Title</th>
                <th>Score</th>
                <th>Date Taken</th>
                <th>Duration</th>
                <th>Result</th>
            </tr>
            <?php
            foreach($data as $row)
            {
            ?>
            <tr>
                <td><?=$row["title"]?></td>
                <td><?=$row["score"]?></td>
                <td><?=$row["date_taken"]?></td>
                <td><?=$row["duration"]?> minutes</td>
                <td><?php if($row["result_status"]=="Pass"){ ?><span>Pass</span><?php }else{ ?><span>Fail</span><?php } ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <tr><td colspan="5" style="text-align: center"><button><a href="#">Close</a></button></td></tr>
            </tr>
        </table>
    </body>
</html>