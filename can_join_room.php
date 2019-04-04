<?php
session_start();

if(isset($_SESSION['user']) && isset($_POST['room_code'])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connection to database successful! <br>";
        $username = $_SESSION['user'];

        $sql = "SELECT room, players_connected FROM rooms_being_used";

        foreach($conn->query($sql) as $row) {
            if($row['room'] == $_POST['room_code']) {
                if($row['players_connected'] < 2) {

                    $room_code = $row['room'];
                    

                    $sql = "UPDATE users SET room=$room_code WHERE username='$username'";
                    $conn->exec($sql);

                    $_SESSION['room'] = $room_code;

                    echo '
                        <script>
                            window.location.replace("in_room.php");
                        </script>
                    ';

                    $sql = "SELECT room FROM users";

                    $count = 0;
                    foreach($conn->query($sql) as $row) {
                        if($room_code == $row['room']) {
                            $count++;
                        }
                    }

                    $sql = "UPDATE rooms_being_used SET players_connected=$count WHERE room=$room_code"; 
                    $conn->exec($sql);

                    $conn = null;
                    die();
                } else {
                    echo "Room is full, redirecting you to homepage now.";
                    echo '
                        <script>
                        setTimeout(function() {
                            window.location.replace("index.php");
                        },1000);
                        </script>
                    ';

                    $conn = null;
                    die();
                }
            } 
            // else {
            //     echo 
            //     echo "Room doesn't exist redirecting you to homepage now.";
            //     echo '
            //         <script>
            //         setTimeout(function() {
            //             window.location.replace("index.php");
            //         },1000);
            //         </script>
            //     ';

            //     $conn = null;
            //     die();
            // }
        }

        echo "Room doesn't exist redirecting you to homepage now.";
        echo '
            <script>
            setTimeout(function() {
                window.location.replace("index.php");
            },1000);
            </script>
        ';

        $conn = null;
        die();

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    $conn = null;
}