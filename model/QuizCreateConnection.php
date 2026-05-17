<?php
class QuizCreateConnection{
    function CreateQuiz($connection, $title, $description, $timeLimit, $status, $instructorId, $totalMarks){
        $sql = "INSERT INTO quizzes(title, description, total_marks, time_limit_minutes, status, instructor_id) VALUES(?,?,?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssissi", $title, $description, $totalMarks, $timeLimit, $status, $instructorId);
        $result = $statement->execute();
        if($result){
            return $connection->insert_id;
        }
        return false;
    }

    function UpdateQuiz($connection, $quizId, $title, $description, $timeLimit, $status){
        $sql = "UPDATE quizzes SET title = ?, description = ?, time_limit_minutes = ?, status = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssisi", $title, $description, $timeLimit, $status, $quizId);
        return $statement->execute();
    }

    function CreateQuestion($connection, $quizId, $questionText, $marks, $orderIndex){
        $sql = "INSERT INTO questions(question_text, marks, order_index, quiz_id) VALUES(?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("sdii", $questionText, $marks, $orderIndex, $quizId);
        $statement->execute();
        return $connection->insert_id;
    }

    function CreateOption($connection, $questionId, $optionText, $isCorrect){
        $sql = "INSERT INTO options(option_text, is_correct, question_id) VALUES(?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("sii", $optionText, $isCorrect, $questionId);
        return $statement->execute();
    }

    function GetInstructorQuizzes($connection, $instructorId){
        $sql = "SELECT * FROM quizzes WHERE instructor_id = ? ORDER BY id DESC";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $instructorId);
        $statement->execute();
        return $statement->get_result();
    }

    function GetQuizById($connection, $quizId, $instructorId = null){
        if($instructorId != null){
            $sql = "SELECT * FROM quizzes WHERE id = ? AND instructor_id = ?";
            $statement = $connection->prepare($sql);
            $statement->bind_param("ii", $quizId, $instructorId);
        }
        else{
            $sql = "SELECT * FROM quizzes WHERE id = ?";
            $statement = $connection->prepare($sql);
            $statement->bind_param("i", $quizId);
        }
        $statement->execute();
        return $statement->get_result();
    }

    function GetQuestionsByQuizId($connection, $quizId){
        $sql = "SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index ASC";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $quizId);
        $statement->execute();
        return $statement->get_result();
    }

    function GetOptionsByQuestionId($connection, $questionId){
        $sql = "SELECT * FROM options WHERE question_id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $questionId);
        $statement->execute();
        return $statement->get_result();
    }
}
?>