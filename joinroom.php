<?php
    session_start();
    unset($_SESSION['room']);
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
    ?>

        <div class="topnav">
            <div class="container">
                <a href="index.php">Home</i></a>
                <a style="float: right" href="logout.php"><i class="fa fa-power-off"></i></a>
            </div>
        </div>

        <div class="container">
            <h1>Hello, <?= $_SESSION['user'] ?></h1>
            <h2>You chose to join a room, good for you!</h2>
            <h2>Input the code for the room you want to join:</h2>
            <form id action="can_join_room.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="room_code" required>
                </div>
                <button type="submit" class="btn btn-default">Join Room</button>
            </form>


        </div>
    <?php
        }
    ?>
    
</body>
</html>