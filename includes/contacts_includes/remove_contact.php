<?php
session_start();
require_once '../functions.inc.php';
require_once '../dbh.inc.php';

if(isset($_POST["remove"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);   
}
elseif (isset($_POST["search_remove"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail); 
}
elseif (isset($_POST["confirm_remove"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);

    echo 'Removing user from contact list...';

    
    removeContact($conn, $loginEmail, $_SESSION["newContactName"], $_SESSION["newContactEmail"], $_SESSION["newContactUID"]);
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
<h3>Input a user's email to remove them from the contact list</h3>
<form action = "" method = "post">
        Search: <input type="text" name="search_remove" /><br />  
        <input type="submit" value="Submit" /> 
        <!-- <button type = "submit" name = "search_add"> Search for existing users</button> -->
</form>


<?php
if (!empty($_REQUEST['search_remove']))
{
    $term = mysqli_real_escape_string($conn, $_REQUEST['search_remove']);

    $sql = "SELECT * FROM contacts WHERE usersEmail = '$loginEmail' AND contactEmail = '$term'"; //does there need to be another semicolon?
    $r_query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($r_query)) {
        echo 'Name: ' .$row['contactName'];
        echo '<br /> Email: ' .$row['contactEmail'];
        echo '<br /> UID: ' .$row['contactUID'];

        echo '<br /><p>Is this the user you would like to remove from your contacts?<p><br />';
        echo '
        <form action = "" method = "post">  
            <input type="submit" name="confirm_remove" value="Confirm and Remove" /> 
        </form>
        ';

        $_SESSION["newContactName"] = $row['contactName'];
        $_SESSION["newContactEmail"] = $row['contactEmail'];
        $_SESSION["newContactUID"] = $row['contactUID'];
    }
}
?>