<?php
class DBQuizList
{
    function BringQuizList($connection, $student_id)
    {
        $sql="
        SELECT
            quizzes.id,
            quizzes.title,
            quizzes.total_marks,
            attempts.score,
            attempts.id
            AS attempt_id
        FROM quizzes
        LEFT JOIN attempts
        ON quizzes.id = attempts.quiz_id
        AND attempts.student_id=?
        AND attempts.completed_at
        IS NOT NULL

        WHERE quizzes.status = 'published'
        ORDER BY quizzes.created_at DESC
        ";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>