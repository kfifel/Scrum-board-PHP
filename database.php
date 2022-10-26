<?php
    
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    $conn = mysqli_connect("localhost", "root", "", "youcodescumboard");
    // Check connection
    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
    return $conn;
?>