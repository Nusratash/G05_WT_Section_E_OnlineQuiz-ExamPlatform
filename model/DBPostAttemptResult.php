<?php
class DBPostAttemptResult{
    function BringQuestionResult($connection,$quiz_id,$attempt_id){
        $sql="
        SELECT 
            q.id AS question_id,
            q.question_text,
            q.order_index,
            so.option_text AS selected_answer,
            co.option_text AS correct_answer
        FROM questions q
        LEFT JOIN answers a
            ON q.id=a.question_id
            AND a.attempt_id=?
        LEFT JOIN options so
            ON a.selected_option_id=so.id
        LEFT JOIN options co
            ON q.id=co.question_id
            AND co.is_correct=1
        WHERE q.quiz_id=?
        ORDER BY q.order_index
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii",$attempt_id,$quiz_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    function BringQuizTitleScore($connection, $quiz_id, $attempt_id)
    {
        $sql = "
        SELECT
            quizzes.title,
            quizzes.total_marks,
            attempts.score
        FROM quizzes
        JOIN attempts
            ON quizzes.id = attempts.quiz_id
        WHERE quizzes.id = ?
        AND attempts.id = ?
        ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $quiz_id, $attempt_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>