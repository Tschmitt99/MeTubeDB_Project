<?php
	session_start();
    require_once 'header.php';
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
    if(!isset($_SESSION["useremail"]))
    {
        header("location:../browse.php?error=mustbeloggedin");
        exit();
    }
    if(!isset($_GET['media_id']))
    {
        header("location:../browse.php?error=somethingwentwrong");
        exit();
    }
    if(!isset($_GET['media_owner']))
    {
        header("location:../browse.php?error=somethingwentwrong");
        exit();
    }
    $media_id = $_GET['media_id'];
    $mediaOwner = $_GET['media_owner'];
    //$_SESSION["media_id"] = $media_id;
    //$_SESSION["mediaOwner"] = $mediaOwner;

    viewComments($conn, $media_id, $mediaOwner);

?>