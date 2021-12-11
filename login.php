<?php
    require_once 'header.php';
    require_once 'connectDB.php';
?>

<!-- <section class = "sign up form"> -->
    <h2>Log in</h2>
    <form action = "includes/login.inc.php" method = "post">
        <input type = "text" name = "email" placeholder = "Enter email address...">
        <input type = "password" name = "pwd" placeholder = "Enter password...">
        <button type = "submit" name = "submit">Login</button>
    </form>

<?php
    if(isset($_GET["error"]))
    {
        if($_GET["error"]== "emptyinput")
        {   
            echo("<p> Looks like you forgot to fill in at least one field.</p>");
        }
        else if($_GET["error"]== "wronglogin")
        {
            echo("<p> Wrong log in information.</p>");
        }
        else if($_GET["error"]== "none")
        {
            echo("<p> Success!.</p>");
        }
    }

?>

<?php
    require_once 'footer.php';
?>