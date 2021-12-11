<?php
session_start();
require_once 'header.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

if(isset($_SESSION["useremail"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);   
}

if(isset($_GET["error"]))
{
        if($_GET["error"]== "addSuccess")
        {   
            echo("<p> Subbed successfully!</p>");
        }
        if($_GET["error"]== "addSubIssue")
        {   
            echo("<p> Looks like there was an error subscribing to this channel. Please try again.</p>");
        }
        if($_GET["error"]== "removeSubIssue")
        {   
            echo("<p> Looks like there was an error unsubscribing from this channel. Please try again.</p>");
        }
        if($_GET["error"]== "removeSuccess")
        {   
            echo("<p> Successfully unsubscribed from this channel!</p>");
        }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html14/loose.dtd">
<html>
<head>
    <title>Untitled Document</title>
        <meta http-eqiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
    <form action = "index.php" method = "post">
        <button type = "input" name = ""><-- Return to front page</button>
    </form>
    <br />
    <h3>My Subscriptions</h3>
    <!-- <form action ="includes/browse.inc.php" method = "post">
        <select name="category" style="width: 175px;">
                    <option value="" disabled selected hidden>Select a category to browse</option>
                    <option>Comedy</option>
                    <option>Games</option>
                    <option>Travel</option>
                    <option>Music</option> 
                    <option>Sports</option> 
                    <option>Educational</option> 
                    <option>Other</option> 
        </select>	
    <input type = "submit" name = "submit"> </input> -->

</body>
</html>

<?php
    mySubscriptions($conn, $loginEmail);
    require_once 'footer.php';
?>