<?php
session_start();

if(isset($_POST['username'])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connection to database successful! <br>";

        $sql = "SELECT username, email FROM users";

        foreach($conn->query($sql) as $row) {
            if(($row['username'] == $_POST['username']) || ($row['email'] == $_POST['email'])) {
                echo "Username or email already exists, redirecting back in 5 seconds.";
                echo '
                    <script>
                        setTimeout(function() {
                            window.location.replace("index.php");
                        },2000);
                    </script>
                ';
                die();
            }
        }

        $sql = "INSERT INTO users (username, email, password) VALUES (" . stripslashes("\'" . htmlspecialchars($_POST['username']) . "\'") . ", " . stripslashes("\'" . htmlspecialchars($_POST['email']) . "\'") . ", " . stripslashes("\'" . htmlspecialchars(password_hash($_POST['pwd'], PASSWORD_ARGON2I)) . "\'") . ")";
        // $sql = "INSERT INTO users (username, email, password) VALUES ('hdclob', 'hdclob18@gmail.com', '123')";
        // die();

        $conn->exec($sql);

        echo "Registered!";

        $_SESSION['user'] = $_POST['username'];

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