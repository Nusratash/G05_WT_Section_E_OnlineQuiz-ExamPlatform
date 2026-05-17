<?php
class QuizAnalyticsModel
{
    function BringInstructorQuizList($connection, $instructor_id)
    {
        $sql="
        SELECT
            id,
            title
        FROM quizzes
        WHERE instructor_id=?
        ORDER BY created_at DESC
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $instructor_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    function BringAttemptList($connection, $quiz_id)
    {
        $sql="
        SELECT
            users.name,
            attempts.score,
            CASE
                WHEN attempts.completed_at IS NULL
                THEN 'In Progress'
                ELSE CONCAT(
                    TIMESTAMPDIFF(
                        MINUTE,
                        attempts.started_at,
                        attempts.completed_at
                    ), ' minutes'
                )
            END AS duration,
            CASE
                WHEN attempts.score >= quizzes.total_marks*0.5
                THEN 'Pass'
                ELSE 'Fail'
            END AS result_status
        FROM attempts
        JOIN users
        ON attempts.student_id = users.id
        JOIN quizzes
        ON attempts.quiz_id = quizzes.id
        WHERE attempts.quiz_id=?
        ORDER BY attempts.score DESC
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    function BringSummary($connection, $quiz_id)
    {
        $sql="
        SELECT
        ROUND(
            AVG(attempts.score),
            2
        ) AS average_score,
        MAX(attempts.score) AS highest_score,
        MIN(attempts.score) AS lowest_score,
        ROUND(
            (

                SUM(

                    CASE
                        WHEN attempts.score >= quizzes.total_marks*0.6
                        THEN 1
                        ELSE 0
                    END
                )/COUNT(*)
            )*100
        ,2) AS pass_rate
        FROM attempts
        JOIN quizzes
        ON attempts.quiz_id = quizzes.id
        WHERE attempts.quiz_id=?
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>