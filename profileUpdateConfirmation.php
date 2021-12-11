<?php
//require_once 'header.php';
require_once 'connectDB.php';
require_once 'includes/functions.inc.php';

//$email = $_POST["email"];
//$_SESSION['user_name'] = $email;
//echo $_SESSION['user_name'];
?>

<h2> 

<h2> Would you like to update your profile information?</h2>
<form action = "profileUpdateForm.php" method = "post">
        <!-- <input type = "text" name = "email" placeholder = "Enter email address..."> -->
        <!-- <input type = "password" name = "pwd" placeholder = "Enter password..."> -->
        <button type = "input" name = "Yes">Yes</button>
        <button type = "input" name = "No">No</button>
</form>
