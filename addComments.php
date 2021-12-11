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
    $_SESSION["media_id"] = $media_id;
    $_SESSION["mediaOwner"] = $mediaOwner;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html14/loose.dtd">
<html>
<head>
    <title>Untitled Document</title>
        <meta http-eqiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<!-- <h2>CURRENT CHANNEL PAGE</h2> -->
<body>
    <form action = "includes/addComments.inc.php" method = "post" name ="addComment">
        <label for="addComment">There is a max character length of 280...</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" placeholder= "Add comment here..." maxlength = "280"></textarea>
        <input type = "submit" name = "submit"> </input>
    </form>
</body>
</html>

    