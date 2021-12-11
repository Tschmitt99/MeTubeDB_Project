<?php
session_start();
if(isset($_POST["send"]))
{
    $recipient = $_POST["Recipient"];
    $subject = $_POST["Subject"];
    $content = $_POST["content"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createMessage($conn, $_SESSION["useremail"], $recipient, $subject, $content);
}

if(isset($_POST["reply"]))
{
    $recipient = $_SESSION["curReplyUser"];
    $subject = $_POST["Subject"];
    $content = $_POST["content"];
    $replyTo = $_SESSION["curReplyId"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    replyMessage($conn, $_SESSION["useremail"], $recipient, $subject, $content, $replyTo);
}
?>