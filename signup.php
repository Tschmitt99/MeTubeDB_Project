<?php
    require_once 'header.php';
    require_once 'connectDB.php';
?>

<!-- <section class = "sign up form"> -->
    <h2>Sign Up Form </h2>
    <form action = "includes/signup.inc.php" method = "post">
        <input type = "text" name = "name" placeholder = "Enter full name...">
        <input type = "text" name = "email" placeholder = "Enter email address...">
        <input type = "text" name = "uid" placeholder = "Enter username...">
        <input type = "password" name = "pwd" placeholder = "Enter password...">
        <input type = "password" name = "pwdRepeat" placeholder = "Enter password again...">
        <button type = "submit" name = "submit"> Submit Account Information</button>
    </form>

<?php
    if(isset($_GET["error"]))
    {
        if($_GET["error"]== "emptyinput")
        {   
            echo("<p> Looks like you forgot to fill in at least one field.</p>");
        }
        else if($_GET["error"]== "invalidEmail")
        {
            echo("<p> Please try a valid email address.</p>");
        }
        else if($_GET["error"]== "mismatchedpasswords")
        {
            echo("<p> Please make sure your passwords match.</p>");
        }
        else if($_GET["error"]== "accountexists")
        {
            echo("<p> It looks like an account with this email exists already.</p>");
        }
        else if($_GET["error"]== "statementfailed")
        {
            echo("<p> Something went wrong.</p>");
        }
        else if($_GET["error"]== "none")
        {
            echo("<p> Success!.</p>");
            header("location: /index.php?error=signupSuccess");
        }
    }
    
?>

<?php
    require_once 'footer.php';
?>