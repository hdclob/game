<?php
    session_start();
    $isReady = false;
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
                <form action="login.php" method="POST">
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
            <h2>You chose to create a room, good for you!</h2>
            <h2>Your room code is: <?php
            
            if(!isset($_SESSION['room'])) {
                try {
                    $conn = new PDO("mysql:host=localhost;dbname=gamedb", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                    $alreadyUsed = false;
    
                    $sql = "SELECT room FROM rooms_being_used";
    
                    do {
                        $code = round(rand(1000, 9999));
                        foreach($conn->query($sql) as $row) {
                            if($row['room'] == $code) {
                                $alreadyUsed = true;
                            } else {
                                $alreadyUsed = false;
                            }
                        }
                    } while ($alreadyUsed);
    
                    $_SESSION['room'] = $code;
                    
    
                    $username = $_SESSION['user'];
    
                    $sql = "UPDATE users SET room=$code WHERE username='$username'";
    
                    $conn->exec($sql);
                    
                    $sql = "INSERT INTO rooms_being_used (room, room_admin) VALUES ($code, '$username')";
    
                    $conn->exec($sql);
                    
            
                } catch(PDOException $e) {
                    echo "Oopsie: " . $e->getMessage();
                }
                
                $conn = null;
            } else {
                $username = $_SESSION['user'];
                $code = $_SESSION['room'];
            }
            

            echo $code;
            
            ?></h2>

            <p id="connected-players"></p>

            <div class="row text-center">
                <div class="col-sm-6" id="start-button"></div>
            </div>
            
            <div id="chat">
                <?php
                    if(file_exists($_SESSION['room'] . ".html") && filesize($_SESSION['room'] . ".html") > 0){
                        $handle = fopen($_SESSION['room'] . ".html", "r");
                        $contents = fread($handle, filesize($_SESSION['room'] . ".html"));
                        fclose($handle);
                        
                        echo $contents;
                    }
                ?>
            </div>
            
            <form action="">
                <div class="form-group">
                    <input name="message" type="text" class="form-control" id="message" name="message" required>
                </div>
                <button name="submit_message" id="submit_message" type="submit" class="btn btn-default">Send</button>
            </form>

        </div>
    <?php
        }
    ?>

    <script>

        //Chat in lobby
        $("#submit_message").click(function() {
            var msg = $("#message").val();
            $.ajax({
                type: "POST",
                url: 'post.php',
                data: {
                    text: msg,
                },
                //the success function is automatically passed the XHR response
                success: function(html) {
                    $("#chat").html(html);
                },
            });
            $("#message").val("");
            return false;
        });

        //Refresh connected players
        var username = <?php echo '"' . $username . '"'; ?>

        $("#connected-players").load("connected_players.php", {"username": username, "code": <?php echo $code; ?>, "type": "connected-players"});
        $("#start-button").load("connected_players.php", {"username": username, "code": <?php echo $code; ?>, "type": "start-button"});

        setInterval(function() {

        username = <?php echo '"' . $username . '"'; ?>

        $("#connected-players").load("connected_players.php", {"username": username, "code": <?php echo $code; ?>, "type": "connected-players"});
        $("#start-button").load("connected_players.php", {"username": username, "code": <?php echo $code; ?>, "type": "start-button"});
        }, 1000);
    </script>
    <script>
        setInterval(function() {
            $.ajax({
                url: "<?php echo $_SESSION['room']; ?>.html",
                cache: false,
                success: function(html) {
                    $("#chat").html(html);
                    $("#chat").animate({scrollTop: $('#chat').get(0).scrollHeight}, '500');
                }
            });
        }, 1000);
    </script>
    
</body>
</html>