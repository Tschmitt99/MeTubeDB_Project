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
    
    header("location: index.php");
    exit();
}

if(isset($_GET["error"]))
{
        if($_GET["error"]== "none")
        {   
                echo("<p> Action performed successfully!</p>");
        }
        if($_GET["error"]== "addissue")
        {   
                echo("<p> Looks like there was an error adding your contact, please try again.</p>");
        }
        if($_GET["error"]== "removeissue")
        {   
                echo("<p> Looks like there was an error removing your contact, please try again.</p>");
        }
}
?>


<style>
    h3 {
  font-weight: bold;
  font-size: 24px;
  text-align: left;
}
</style>
<h3>My Contacts</h3>

<form action = "includes/contacts_includes/add_contact.php" method = "post">
        <button type = "input" name = "add">Add a Contact</button>
</form>
<form action = "includes/contacts_includes/remove_contact.php" method = "post">
        <button type = "input" name = "remove">Remove a Contact</button>
</form>


<?php
        $query = "SELECT * FROM contacts WHERE usersEmail= '$loginEmail'";
        $result = mysqli_query($conn, $query);

        echo "<table>";

        while ($row = mysqli_fetch_array($result)) {
                echo '<br />';
                echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>Name: " . $row['contactName'] . "<tr><td>Email: " . $row['contactEmail'] . "<tr><td>Username: " . $row['contactUID'];
        }

        echo "</table>";
        
?>



<!-- <form action = "includes/profile.inc.php" method = "post">
        <input type = "text" name = "name" placeholder = "Enter full name...">
        <input type = "text" name = "email" placeholder = "Enter email address...">
        <input type = "text" name = "uid" placeholder = "Enter username...">
        <input type = "password" name = "pwd" placeholder = "Enter password...">
        <input type = "password" name = "pwdRepeat" placeholder = "Enter password again...">
        <button type = "submit" name = "update"> Update Account Information</button>
</form> -->