<?php
session_start();
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';

if(isset($_GET["error"]))
{
        if($_GET["error"]== "newissue")
        {   
            echo("<p> Looks like there was an error sending your new message. Please try again.</p>");
        }
        if($_GET["error"]== "replyissue")
        {   
            echo("<p> Looks like there was an error sending your reply. Please try again.</p>");
        }
        if($_GET["error"]== "newsuccess")
        {   
            echo("<p> Successfully sent your message!</p>");
        }
        if($_GET["error"]== "replysuccess")
        {   
            echo("<p> Successfully sent your reply!</p>");
        }
}


if(isset($_SESSION["useremail"]))
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
<form action = "index.php" method = "post">
        <button type = "input" name = ""><-- Return to front page</button>
</form>
<h3>My Messages</h3>

<form action = "includes/messages_includes/new_message.php" method = "post">
        <button type = "input" name = "new">New Message</button>
</form>
<!-- <form action = "includes/messages_includes/delete_message.php" method = "post">
        <button type = "input" name = "delete">Delete a Message</button>
</form> -->
<form action = "messages_outbox.php" method = "post">
        <button type = "input" name = "">Outbox</button>
</form>


<?php
        $query = "SELECT * FROM messages WHERE recipient= '$loginEmail'"; //change between sender and recipient
        $result = mysqli_query($conn, $query);

        echo "<table>";

        while ($row = mysqli_fetch_array($result)) {
                echo '<br />';
                echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>" . $row['preview'] . "<tr><td>Subject: " . $row['subject'] . "<tr><td>From: " . $row['sender'] . "<tr><td>Time: " . $row['sendTime'];
                echo '
                <form action = "includes/messages_includes/current_message.php" method = "post">
                        <button type = "input" name = "viewMessage">Click to view message & Replies</button>
                </form>';
                $_SESSION["currentMessageId"] = $row['messageId'];
        }

        echo "</table>";
        
?>