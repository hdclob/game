<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['user'];
    $can_delete = false;
    
    $sql = "SELECT room FROM users WHERE username='$username'";

    foreach($conn->query($sql) as $row) {
        $room_to_delete = $row['room'];
    }

    $sql = "SELECT players_connected FROM rooms_being_used WHERE room=$room_to_delete";

    foreach($conn->query($sql) as $row) {
        if($row['players_connected'] < 1) {
            $can_delete = true;
        }
    }

    if ($can_delete) {
        $sql = "DELETE FROM rooms_being_used WHERE room=$room_to_delete";
        $conn->exec($sql);
    }
    
    $sql = "UPDATE users SET room=0 WHERE username='$username'";

    $conn->exec($sql);
    

} catch(PDOException $e) {
    echo "Oopsie: " . $e->getMessage();
}

$conn = null;