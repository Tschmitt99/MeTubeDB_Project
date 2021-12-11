<?php
session_start();
require_once '../functions.inc.php';
require_once '../dbh.inc.php';



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

if(isset($_SESSION["currentMessageId"]))
{
    $curMesId = $_SESSION["currentMessageId"];
}
?>


<style>
    h3 {
  font-weight: bold;
  font-size: 24px;
  text-align: left;
}
</style>
<h3>Message contents</h3>

<!-- <form action = "reply_message.php" method = "post">
        <button type = "input" name = "reply">Reply to this message</button>
</form> -->
<form action = "../../messages.php" method = "post">
        <button type = "input" name = "">Return to Inbox</button>
</form>


<?php
        $query = "SELECT * FROM messages WHERE messageId= '$curMesId'";
        $result = mysqli_query($conn, $query);

        echo "<table>";

        while ($row = mysqli_fetch_array($result)) {
                $_SESSION["curReplyId"] = $row['messageId'];
                $_SESSION["curReplyUser"] = $row['sender'];
            
                echo '<br />';
                echo "<tr><td>" . "<tr><td>" . $row['preview']
                 . "<tr><td>Subject: " . $row['subject']
                 . "<tr><td>From: " . $row['sender']
                 . "<tr><td>To: " . $row['recipient']
                 . "<tr><td>Time: " . $row['sendTime']
                 . "<tr><td>Content:<br /><br />" . $row['content'];
                echo '
                <form action = "reply_message.php" method = "post">
                    <button type = "input" name = "reply">Reply to this message</button>
                </form>';
                
                
                //INSERT CODE TO VIEW REPLIES TO THE CURRENT MESSAGE HERE
        }

        echo "</table>";

        //CODE FOR REPLIES
        $query = "SELECT * FROM messages WHERE replyId= '$curMesId'";
        $result = mysqli_query($conn, $query);
        echo '<br />---------------------REPLIES---------------------<br />';


        echo "<table>";

        while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . "<tr><td>" . $row['preview']
                 . "<tr><td>Subject: " . $row['subject']
                 . "<tr><td>From: " . $row['sender']
                 . "<tr><td>To: " . $row['recipient']
                 . "<tr><td>Time: " . $row['sendTime']
                 . "<tr><td>Content:<br /><br />" . $row['content'];
                 echo '<br /><br />------------------------------<br />';

            }

        
?>