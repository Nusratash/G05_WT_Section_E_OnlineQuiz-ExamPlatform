<?php
class DatabaseConnection{
    function openConnection(){
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "wt_g_5";
        $connection = new mysqli($db_host, $db_username, $db_password, $db_name);
        if($connection->connect_error){
            die("Could not connect to the database. Please try again with different parameters. Original Error ".$connection->connect_error);
        }
        return $connection;
    }
}
?>