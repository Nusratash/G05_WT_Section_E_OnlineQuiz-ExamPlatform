<?php

require_once __DIR__ . "/DatabaseConnection.php";

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseConnection();
    }

    public function register(
        $name,
        $email,
        $password,
        $role
    ) {

        $connection = $this->db->openConnection();

        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $role = $connection->real_escape_string($role);

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO users
            (
                name,
                email,
                password_hash,
                role,
                is_active,
                created_at
            )
            VALUES
            (
                '$name',
                '$email',
                '$hashedPassword',
                '$role',
                1,
                NOW()
            )
        ";

        $result = $connection->query($sql);

        $connection->close();

        return $result;
    }

    public function findByEmail($email)
    {
        $connection = $this->db->openConnection();

        $email = $connection->real_escape_string($email);

        $sql = "
            SELECT *
            FROM users
            WHERE email = '$email'
            LIMIT 1
        ";

        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {

            $user = $result->fetch_assoc();

            $connection->close();

            return $user;
        }

        $connection->close();

        return null;
    }

    public function findById($id)
    {
        $connection = $this->db->openConnection();

        $id = (int)$id;

        $sql = "
            SELECT *
            FROM users
            WHERE id = '$id'
            LIMIT 1
        ";

        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {

            $user = $result->fetch_assoc();

            $connection->close();

            return $user;
        }

        $connection->close();

        return null;
    }

    public function getAllUsers()
    {
        $connection = $this->db->openConnection();

        $sql = "
            SELECT
                id,
                name,
                email,
                role,
                is_active,
                created_at
            FROM users
            ORDER BY created_at DESC
        ";

        $result = $connection->query($sql);

        $users = [];

        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $users[] = $row;
            }
        }

        $connection->close();

        return $users;
    }

    public function toggleUserStatus(
        $userId,
        $currentStatus
    ) {

        $connection = $this->db->openConnection();

        $userId = (int)$userId;

        $newStatus = $currentStatus == 1 ? 0 : 1;

        $sql = "
            UPDATE users
            SET is_active = '$newStatus'
            WHERE id = '$userId'
        ";

        $result = $connection->query($sql);

        $connection->close();

        if ($result) {

            return [
                "success" => true,
                "new_status" => $newStatus
            ];
        }

        return [
            "success" => false,
            "error" => "Failed to update user status"
        ];
    }
    public function getStudentDashboardStats(
        $studentId
    ) {

        $connection = $this->db->openConnection();

        $studentId = (int)$studentId;

  
        $sqlQuizzes = "
            SELECT COUNT(*) as total_quizzes
            FROM quizzes
            WHERE status = 'published'
        ";

        $result = $connection->query($sqlQuizzes);

        $totalQuizzes = 0;

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $totalQuizzes =
                $row['total_quizzes'];
        }

        $sqlAttempts = "
            SELECT COUNT(*) as total_attempts
            FROM attempts
            WHERE student_id = '$studentId'
        ";

        $result = $connection->query($sqlAttempts);

        $totalAttempts = 0;

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $totalAttempts =
                $row['total_attempts'];
        }

        $sqlScore = "
            SELECT
                COALESCE(SUM(score),0)
                as total_score
            FROM attempts
            WHERE student_id = '$studentId'
        ";

        $result = $connection->query($sqlScore);

        $totalScore = 0;

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $totalScore =
                $row['total_score'];
        }

        $connection->close();

        return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts,
            'total_score' => $totalScore
        ];
    }

    public function getInstructorDashboardStats(
        $instructorId
    ) {

        $connection = $this->db->openConnection();

        $instructorId = (int)$instructorId;

        
        $sqlQuizzes = "
            SELECT COUNT(*) as total_quizzes
            FROM quizzes
            WHERE instructor_id = '$instructorId'
        ";

        $result = $connection->query($sqlQuizzes);

        $totalQuizzes = 0;

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $totalQuizzes =
                $row['total_quizzes'];
        }

     
        $sqlAttempts = "
            SELECT COUNT(a.id)
            as total_attempts
            FROM attempts a
            JOIN quizzes q
            ON a.quiz_id = q.id
            WHERE q.instructor_id =
            '$instructorId'
        ";

        $result = $connection->query($sqlAttempts);

        $totalAttempts = 0;

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $totalAttempts =
                $row['total_attempts'];
        }

        $connection->close();

        return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts
        ];
    }
}

?>