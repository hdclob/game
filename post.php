<?php
session_start();

if(isset($_SESSION['user'])) {
    $text = $_POST['text'];

    $fp = fopen($_SESSION['room'] . '.html', 'a');
    fwrite($fp, "<div class='msgln'>(" . date("g:i A") . ") <b>" . $_SESSION['user'] . "</b>: " . stripslashes(htmlspecialchars($text)) . "<br></div>");
    fclose($fp);
}