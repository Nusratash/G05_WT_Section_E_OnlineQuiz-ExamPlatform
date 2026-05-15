<?php
include "DatabaseConnection.php";

class UserModel{
    private $db;

    public function userModel(){
        $this->db = new DatabaseConnection();
    }

    public function register($name, $email, $password, $role){
        $connection = $this->db->openConnection();
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, email, password_hash, role, is_active, created_at) 
                VALUES('". $name."', '". $email."', '". $hashedPassword."', '". $role."', 1, NOW())";
        
        $result = $connection->query($sql);
        $connection->close();
        return $result;
    }

    public function findByEmail($email){
        $connection = $this->db->openConnection();
        
        $sql = "SELECT * FROM users WHERE email = '". $connection->$email."'";
        $result = $connection->query($sql);
        $connection->close();
        
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }
        return null;
    }



        public function findById($id){
        $connection = $this->db->openConnection();
        
        $sql = "SELECT * FROM users WHERE id = '". $connection->$id."'";
        $result = $connection->query($sql);
        $connection->close();
        
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }
        return null;
    }

     public function getAllUsers(){
        $connection = $this->db->openConnection();
        
        $sql = "SELECT id, name, email, role, is_active, created_at FROM users ORDER BY created_at DESC";
        $result = $connection->query($sql);
        $connection->close();
        
        $users = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $users[] = $row;
            }
        }
        return $users;
    }

    public function toggleUserStatus($userId, $currentStatus){
        $connection = $this->db->openConnection();
        
        $newStatus = $currentStatus == 1 ? 0 : 1;
        
        $sql = "UPDATE users SET is_active = $newStatus WHERE id = '". $connection->real_escape_string($userId)."'";
        $result = $connection->query($sql);
        $connection->close();
        
        if($result){
            return ["success" => true, "new_status" => $newStatus];
        }
        return ["success" => false, "error" => "Failed to update user status"];
    }

    public function getStudentDashboardStats($studentId){
        $connection = $this->db->openConnection();
        
        
        $sqlQuizzes = "SELECT COUNT(*) as total_quizzes FROM quizzes WHERE status = 'published'";
        $result = $connection->query($sqlQuizzes);
        $totalQuizzes = 0;
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalQuizzes = $row['total_quizzes'];
        }
        
        

        $sqlAttempts = "SELECT COUNT(*) as total_attempts FROM attempts WHERE student_id = '". $connection->real_escape_string($studentId)."'";
        $result = $connection->query($sqlAttempts);
        $totalAttempts = 0;
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalAttempts = $row['total_attempts'];
        }
        
    
        $sqlScore = "SELECT COALESCE(SUM(score), 0) as total_score FROM attempts WHERE student_id = '". $connection->$studentId."' AND score IS NOT NULL";
        $result = $connection->query($sqlScore);
        $totalScore = 0;
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalScore = $row['total_score'];
        }
        
        $connection->close();
         return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts,
            'total_score' => $totalScore
        ];
    }

    

    public function getInstructorDashboardStats($instructorId){
        $connection = $this->db->openConnection();
        
        
        $sqlQuizzes = "SELECT COUNT(*) as total_quizzes FROM quizzes WHERE instructor_id = '". $connection->$instructorId."'";
        $result = $connection->query($sqlQuizzes);
        $totalQuizzes = 0;
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalQuizzes = $row['total_quizzes'];
        }
        
  

        $sqlAttempts = "SELECT COUNT(a.id) as total_attempts FROM attempts a JOIN quizzes q ON a.quiz_id = q.id WHERE q.instructor_id = '". $connection->$instructorId."'";


        $result = $connection->query($sqlAttempts);
        $totalAttempts = 0;
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalAttempts = $row['total_attempts'];
        }
        
        $connection->close();
        
        return [
            'total_quizzes' => $totalQuizzes,
            'total_attempts' => $totalAttempts
        ];
     
    }

   
}
?>