<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $code = $_POST['code'];
    $type = $_POST['type'];

    $sql = "SELECT room FROM users";

    $count = 0;
    foreach($conn->query($sql) as $row) {
        if($code == $row['room']) {
            $count++;
        }
    }

    $sql = "UPDATE rooms_being_used SET players_connected=$count WHERE room=$code"; 
    $conn->exec($sql);

    if($count < 1) {
        $sql = "DELETE FROM rooms_being_used WHERE room=$code";
        $conn->exec($sql);

        if(file_exists($code . ".html")){
            unlink($code . ".html");
        }

    }
    

} catch(PDOException $e) {
    echo "Oopsie: " . $e->getMessage();
}

$conn = null;

switch($type) {
    case "connected-players":
        echo "Players connected: " . $count . "/2";
        break;
    case "start-button":
        if($count > 1) echo '<div id="startGame"><a href="">Start Game</a></div>';
        break;
}

// try {
//     $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $username = $_POST['user'];
//     $can_delete = false;
    
//     $sql = "SELECT room FROM users WHERE username='$username'";

//     foreach($conn->query($sql) as $row) {
//         $room_to_delete = $row['room'];
//     }

//     $sql = "SELECT players_connected FROM rooms_being_used WHERE room=$room_to_delete";

//     foreach($conn->query($sql) as $row) {
//         if($row['players_connected'] < 1) {
//             $can_delete = true;
//         }
//     }

//     if ($can_delete) {
//         $sql = "DELETE FROM rooms_being_used WHERE room=$room_to_delete";
//         $conn->exec($sql);
//     }
    
//     $sql = "UPDATE users SET room=0 WHERE username='$username'";

//     $conn->exec($sql);
    

// } catch(PDOException $e) {
//     echo "Oopsie: " . $e->getMessage();
// }

// $conn = null;