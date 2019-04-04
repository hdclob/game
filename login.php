<?php
session_start();

if(isset($_POST['username'])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connection to database successful! <br>";

        $sql = "SELECT username, password FROM users";

        foreach($conn->query($sql) as $row) {
            if($row['username'] == $_POST['username'] && password_verify($_POST['pwd'], $row['password'])) {
                echo "Logged in!";

                $_SESSION['user'] = $_POST['username'];

                echo '
                    <script>
                        window.location.replace("index.php");
                    </script>
                ';

                $conn = null;
                die();
            }
        }

        echo "Username doesn't exist or password is incorrect, redirecting back in 5 seconds.";
        echo '
            <script>
                setTimeout(function() {
                    window.location.replace("index.php");
                },2000);
            </script>
        ';

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    $conn = null;
}