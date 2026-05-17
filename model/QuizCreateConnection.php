<?php
class QuizCreateConnection
{
    function CreateQuiz($connection,$title,$description,$timeLimit,$status,$instructorId,$totalMarks) 
    {
        $sql = "INSERT INTO quizzes(title,description,total_marks,time_limit_minutes,status,instructor_id)VALUES(?,?,?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssissi",$title,$description,$totalMarks,$timeLimit,$status,$instructorId);

        $result = $statement->execute();
        if ($result) {
            return $connection->insert_id;
        }
        return false;
    }

    function UpdateQuiz($connection,$quizId,$title,$description,$timeLimit,$status) 
    {
        $sql = "UPDATE quizzes SET title = ?,description = ?, time_limit_minutes = ?, status = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssisi",$title,$description,$timeLimit,$status,$quizId);
        return $statement->execute();
    }

    function CreateQuestion($connection,$quizId,$questionText,$marks,$orderIndex) {
        $sql = "INSERT INTO questions(question_text,marks,order_index,quiz_id)VALUES(?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("siii",$questionText,$marks,$orderIndex,$quizId);
        $statement->execute();
        return $connection->insert_id;
    }

    function CreateOption($connection,$questionId,$optionText,$isCorrect) {
        $sql = "INSERT INTO options(option_text,is_correct,question_id)VALUES(?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("sii",$optionText,$isCorrect,$questionId);
        return $statement->execute();
    }

    function GetInstructorQuizzes($connection,$instructorId) {
        $sql = "SELECT * FROM quizzes WHERE instructor_id = ? ORDER BY id DESC";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i",$instructorId);
        $statement->execute();
        return $statement->get_result();
    }

    function GetQuizById($connection,$quizId,$instructorId = null) {
        if ($instructorId != null) {
            $sql = "SELECT * FROM quizzes WHERE id = ? AND instructor_id = ?";
            $statement = $connection->prepare($sql);
            $statement->bind_param("ii",$quizId,$instructorId);
        } else {
            $sql = "SELECT * FROM quizzes WHERE id = ?";
            $statement = $connection->prepare($sql);
            $statement->bind_param("i",$quizId);
        }
        $statement->execute();
        return $statement->get_result();
    }

    function GetQuestionsByQuizId($connection,$quizId) {
        $sql = "SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index ASC";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i",$quizId);
        $statement->execute();
        return $statement->get_result();
    }

    function GetOptionsByQuestionId($connection,$questionId) {
        $sql = "SELECT * FROM options WHERE question_id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i",$questionId);
        $statement->execute();
        return $statement->get_result();
    }

    function DeleteQuiz($connection,$quizId) {
        $questions = $this->GetQuestionsByQuizId($connection,$quizId);
        while ($row = $questions->fetch_assoc()) {
            $questionId = $row["id"];
            $sql1 = "DELETE FROM options WHERE question_id = ?";
            $statement1 = $connection->prepare($sql1);
            $statement1->bind_param("i",$questionId);
            $statement1->execute();
        }
        $sql2 = "DELETE FROM questions WHERE quiz_id = ?";
        $statement2 = $connection->prepare($sql2);
        $statement2->bind_param("i",$quizId);
        $statement2->execute();

        $sql3 = "DELETE FROM quizzes WHERE id = ?";
        $statement3 = $connection->prepare($sql3);
        $statement3->bind_param("i",$quizId);
        return $statement3->execute();
    }

    function ToggleQuizStatus($connection,$quizId,$status) {
        $sql = "UPDATE quizzes SET status = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        if (!$statement) { die($connection->error); }
        $statement->bind_param("si",$status,$quizId);
        $result = $statement->execute();
        if (!$result) { die($statement->error); }
        return $result;
    }
    function DeleteQuestion( $connection, $questionId)
    {
        $sql1 = "DELETE FROM options WHERE question_id = ?";
        $statement1 = $connection->prepare($sql1);
        $statement1->bind_param("i",$questionId);
        $statement1->execute();
        $sql2 = "DELETE FROM questions WHERE id = ?";
        $statement2 = $connection->prepare($sql2);
        $statement2->bind_param("i",$questionId);
        return $statement2->execute();
    }
       function UpdateQuestion($connection,$questionId,$questionText)
    {
        $sql = "UPDATE questions SET question_text = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("si",$questionText,$questionId);
        return $statement->execute();
    }
    function UpdateOption($connection, $optionId,$optionText,$isCorrect)
    {
        $sql = "UPDATE options SET option_text = ?,is_correct = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param( "sii",$optionText,$isCorrect,$optionId);
        return $statement->execute();
    }

}