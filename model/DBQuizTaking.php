<?php
class DBQuizTaking
{
    function BringQuestions($connection,$quiz_id)
    {
        $sql="
            SELECT
            q.id
            AS question_id,
            q.question_text,
            q.order_index,
            o.id
            AS option_id,
            o.option_text,
            quizzes.time_limit_minutes
            FROM questions q
            JOIN options o
            ON q.id=o.question_id
            JOIN quizzes
            ON quizzes.id=q.quiz_id
            WHERE q.quiz_id=?
            ORDER BY
            q.order_index
        ";

        $stmt=$connection->prepare($sql);
        $stmt->bind_param("i",$quiz_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>