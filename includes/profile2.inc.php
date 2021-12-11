<?php
session_start();
if(isset($_POST["update"]))
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)!== false)
    {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if(pwdMatch($pwd,$pwdRepeat)!== false)
    {
        header("location: ../signup.php?error=mismatchedpasswords");
        exit();
    }
    updateUser($conn, $name, $email, $username, $pwd);
}