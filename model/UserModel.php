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

