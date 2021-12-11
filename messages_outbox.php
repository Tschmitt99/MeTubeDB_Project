<?php
session_start();
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';


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
<h3>My Sent Messages</h3>

<!-- <form action = "includes/messages_includes/delete_message.php" method = "post">
        <button type = "input" name = "delete">Delete a Message</button>
</form> -->
<form action = "messages.php" method = "post">
        <button type = "input" name = "">Return to inbox</button>
</form>


<?php
        $query = "SELECT * FROM messages WHERE sender= '$loginEmail'"; //change between sender and recipient
        $result = mysqli_query($conn, $query);

        echo "<table>";

        while ($row = mysqli_fetch_array($result)) {
                echo '<br />';
                echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>" . $row['preview'] . "<tr><td>Subject: " . $row['subject'] . "<tr><td>To: " . $row['recipient'] . "<tr><td>Time: " . $row['sendTime'];
                echo '
                <form action = "includes/messages_includes/current_message.php" method = "post">
                        <button type = "input" name = "viewMessage">Click to view message & Replies</button>
                </form>';
                $_SESSION["currentMessageId"] = $row['messageId'];
        }

        echo "</table>";
        
?>