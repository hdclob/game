<?php
    session_start();
    unset($_SESSION['room']);

    include "functions.php";

?>

<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>

    <?php
        if(!isset($_SESSION['user'])) { ?>
        <div class="container">
            <div class="col-sm-6">
                <h1>Don't have an account? Sign-up now!</h1>
                <form id action="signup.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" name="pwd" required>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="col-sm-6">
                <h1>Already have an account? Login now!</h1>
                <form id action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" name="pwd" required>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
        <?php } else {

                list($room_to_delete, $username) = getRoomAndUsername();

                try {
                    $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $username = $_SESSION['user'];
                    
                    $sql = "UPDATE users SET room=0 WHERE username='$username'";

                    $conn->exec($sql);

                    $sql = "SELECT room_admin FROM rooms_being_used";

                    foreach($conn->query($sql) as $row) {
                        if($username == $row['room_admin']) {
                            $sql = "DELETE FROM rooms_being_used WHERE room_admin='$username'";
                            $conn->exec($sql);
                        }
                    }
                    

                } catch(PDOException $e) {
                    echo "Oopsie: " . $e->getMessage();
                }

                $conn = null;

    ?>

        <div class="topnav">
            <div class="container">
                <a href="index.php">Home</i></a>
                <a style="float: right" href="logout.php"><i class="fa fa-power-off"></i></a>
            </div>
        </div>

        <div class="container">
            <h1>Hello, <?= $_SESSION['user'] ?></h1>
            <h2>What do you want to do?</h2>

            <div class="row text-center">
                <div class="col-sm-6">
                    <div id="createRoom"><a href="createroom.php">Create a room</a></div>
                    <!-- <a href="#"><div id="createRoom">Create a room</div></a> -->
                </div>
                <div class="col-sm-6">
                    <div id="joinRoom"><a href="joinroom.php">Join a room</a></div>
                    <!-- <a href="#"><div id="joinRoom">Join a room</div></a> -->
                </div>
            </div>

        </div>
    <?php
        }
    ?>
    
    <script>
        //Refresh connected players
        setInterval(function() {

        var username = <?php echo '"' . $username . '"'; ?>

        $(document).load("connected_players.php", {"username": username, "code": <?php echo $room_to_delete; ?>});
        }, 1000);
    </script>
</body>
</html>