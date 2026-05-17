<?php
class DBStudentAttemptHistory
{
    function BringAttemptHistory($connection, $student_id)
    {
        $sql="
        SELECT
            quizzes.title,
            attempts.score,
            DATE(attempts.completed_at)
            AS date_taken,
            TIMESTAMPDIFF(MINUTE, attempts.started_at, attempts.completed_at)
            AS duration,
            CASE
                WHEN attempts.score >= quizzes.total_marks*0.5
                THEN 'Pass'
                ELSE 'Fail'
            END
            AS result_status
        FROM attempts
        JOIN quizzes
        ON attempts.quiz_id = quizzes.id
        WHERE attempts.student_id=?
        ORDER BY attempts.completed_at DESC
        ";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>