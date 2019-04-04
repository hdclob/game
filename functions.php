<?php

function getRoomAndUsername() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['user'];
        
        $sql = "SELECT room FROM users WHERE username='$username'";

        foreach($conn->query($sql) as $row) {
            $room_to_delete = $row['room'];
        }
        

    } catch(PDOException $e) {
        echo "Oopsie: " . $e->getMessage();
    }

    $conn = null;

    return [$room_to_delete, $username];
}