<?php
session_start();
require_once '../functions.inc.php';
require_once '../dbh.inc.php';


if(isset($_POST["new"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);   
}
else
{   
    header("location: ../index.php");
    exit();
}
?>
<style>
    h3 {
  font-weight: bold;
  font-size: 24px;
  text-align: left;
}
</style>
<form action = "../../messages.php" method = "post">
        <button type = "input" name = "">Cancel and return to inbox</button>
</form>
<h3>New Message</h3>
<form action = "../messages.inc.php" method = "post">
        <p>To:</p>
        <input type = "text" name = "Recipient" placeholder = "Enter email...">
        <br />
        <p>Subject:</p>
        <input type = "text" name = "Subject" placeholder = "Enter subject...">
        <br />
        <p>Content:</p>
        <textarea name = "content" placeholder = "" rows="4" cols="50">
        </textarea>
        <button type = "submit" name = "send"> Send</button>
</form>