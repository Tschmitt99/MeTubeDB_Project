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

if(isset($_GET['channel'])) {
    $channel = $_GET['channel'];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html14/loose.dtd">
<html>
<head>
    <title>Untitled Document</title>
        <meta http-eqiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<!-- <h2>CURRENT CHANNEL PAGE</h2> -->
<body>
    <form action = "index.php" method = "post">
        <button type = "input" name = ""><-- Return to front page</button>
    </form>
    <br />
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
<!-- <form action = "includes/subs.inc.php" method = "post">
    <button type = "input" name = "addSub">SUBSCRIBE TO THIS CHANNEL</button>
</form>
<form action = "includes/subs.inc.php" method = "post">
    <button type = "input" name = "removeSub">UNSUBSCRIBE FROM THIS CHANNEL</button>
</form> -->
</html>

<?php
    echo '<br /><h2>Currently viewing: ' . $channel . "'s channel</h2/><br />";
    $query = "SELECT * FROM users WHERE usersEmail= '$channel'";
    $result = mysqli_query($conn, $query);


    while ($row = mysqli_fetch_array($result)) {
            echo "<tr><td>You are viewing <b> " . $row['usersName'] . "'s</b> channel who's email is <b> " . $row['usersEmail'] . "</b><br /><br />";
            // $_SESSION["currentMessageId"] = $row['messageId'];
            $_SESSION["ownerToSubTo"] = $row['usersEmail'];
    }

    //CHECKS TO SEE IF THE LOGGED IN USER IS CURRENTLY SUBSCRIBED TO THIS CHANNEL OR NOT
    $query2 = "SELECT * FROM subscriptions WHERE subscriber= '$loginEmail' AND subscribee= '$channel'";
    $result2 = mysqli_query($conn, $query2);

    $isSubscribed = false;
    while ($row = mysqli_fetch_array($result2)) {
            $isSubscribed = true;
    }
    if ($isSubscribed == TRUE) {
        echo "You ARE currently subscribed to this channel!<br />";
        echo '
        <form action = "includes/subs.inc.php" method = "post">
            <button type = "input" name = "removeSub">UNSUBSCRIBE</button>
        </form>';
    }
    else {
        echo "You are NOT currently subscribed to this channel!<br />";
        echo '
        <form action = "includes/subs.inc.php" method = "post">
            <button type = "input" name = "addSub">SUBSCRIBE</button>
        </form>';
    }



    //CODE TO DISPLAY CURRENT CHANNEL UPLOADS
    viewCurrentChannelUploads($conn, $channel);





    require_once 'footer.php';
?>

