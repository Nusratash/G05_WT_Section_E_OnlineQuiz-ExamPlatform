<?php

require_once __DIR__ . "/DatabaseConnection.php";

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseConnection();
    }

    public function register($name, $email, $password, $role)
    {
        $connection = $this->db->openConnection();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password_hash, role, is_active, created_at) VALUES (?, ?, ?, ?, 1, NOW())";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        $result = $stmt->execute();

        $connection->close();
        return $result;
    }

    public function findByEmail($email)
    {
        $connection = $this->db->openConnection();

        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

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

        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

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

        $sql = "SELECT id, name, email, role, is_active, created_at FROM users ORDER BY created_at DESC";
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

    public function toggleUserStatus($userId, $currentStatus)
    {
        $connection = $this->db->openConnection();

        $newStatus = $currentStatus == 1 ? 0 : 1;

        $sql = "UPDATE users SET is_active = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $newStatus, $userId);
        $result = $stmt->execute();

        $connection->close();

        if ($result) {
            return ["success" => true, "new_status" => $newStatus];
        }

        return ["success" => false, "error" => "Failed to update user status"];
    }

    public function getStudentDashboardStats($studentId)
    {
        $connection = $this->db->openConnection();

        
        $sqlQuizzes = "SELECT COUNT(*) as total_quizzes FROM quizzes WHERE status = 'published'";
        $result = $connection->query($sqlQuizzes);
        $totalQuizzes = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_quizzes'] : 0;

       
        $sqlAttempts = "SELECT COUNT(*) as total_attempts FROM attempts WHERE student_id = ?";
        $stmt = $connection->prepare($sqlAttempts);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalAttempts = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_attempts'] : 0;

        
        $sqlScore = "SELECT COALESCE(SUM(score), 0) as total_score FROM attempts WHERE student_id = ?";
        $stmt = $connection->prepare($sqlScore);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalScore = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_score'] : 0;

        $connection->close();

        return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts,
            'total_score' => $totalScore
        ];
    }

    public function getInstructorDashboardStats($instructorId)
    {
        $connection = $this->db->openConnection();

        
        $sqlQuizzes = "SELECT COUNT(*) as total_quizzes FROM quizzes WHERE instructor_id = ?";
        $stmt = $connection->prepare($sqlQuizzes);
        $stmt->bind_param("i", $instructorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalQuizzes = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_quizzes'] : 0;

        
        $sqlAttempts = "SELECT COUNT(a.id) as total_attempts FROM attempts a JOIN quizzes q ON a.quiz_id = q.id WHERE q.instructor_id = ?";
        $stmt = $connection->prepare($sqlAttempts);
        $stmt->bind_param("i", $instructorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalAttempts = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total_attempts'] : 0;

        $connection->close();

        return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts
        ];
    }
}
?>