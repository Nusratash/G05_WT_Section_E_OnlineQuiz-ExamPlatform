<?php

class DBLeaderboard
{
    function BringLeaderboard($connection)
    {
        $sql="
        SELECT
            users.name,
            SUM(attempts.score) AS total_score
        FROM attempts
        JOIN users
        ON attempts.student_id=users.id
        GROUP BY users.id
        ORDER BY total_score DESC
        LIMIT 10
        ";
        $result=$connection->query($sql);

        return $result;
    }
}

?>