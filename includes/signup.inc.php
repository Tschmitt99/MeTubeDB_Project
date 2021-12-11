<?php
if(isset($_POST["submit"]))
{
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdRepeat"];

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  // if anything besides false then we must throw an error
  if(emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)!== false)
  {
    header("location: ../signup.php?error=emptyinput");
    exit();
  }
  if(invalidEmail($email)!== false)
  {
    header("location: ../signup.php?error=invalidEmail");
    exit();
  }
  if(pwdMatch($pwd,$pwdRepeat)!== false)
  {
    header("location: ../signup.php?error=mismatchedpasswords");
    exit();
  }
  if(UIDExists($conn, $username, $email)!== false)
  {
    header("location: ../signup.php?error=accountexists");
    exit();
  }
  createUser($conn, $name, $email, $username, $pwd);
  
}
else{
  header("location: ../signup.php");
  exit();
}