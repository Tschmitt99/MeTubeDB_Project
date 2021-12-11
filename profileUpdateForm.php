<?php
session_start();
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';
if(isset($_POST["Yes"]))
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
  text-align: center;
}
</style>
<h3>Edit Profile Information</h3>
<form action = "includes/profile.inc.php" method = "post">
        <input type = "text" name = "name" placeholder = "Enter full name...">
        <input type = "text" name = "email" placeholder = "Enter email address...">
        <input type = "text" name = "uid" placeholder = "Enter username...">
        <input type = "password" name = "pwd" placeholder = "Enter password...">
        <input type = "password" name = "pwdRepeat" placeholder = "Enter password again...">
        <button type = "submit" name = "update"> Update Account Information</button>
</form>