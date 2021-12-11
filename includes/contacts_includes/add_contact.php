<?php
session_start();
require_once '../functions.inc.php';
require_once '../dbh.inc.php';

if(isset($_POST["add"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);   
}
elseif (isset($_POST["search_add"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail); 
}
elseif (isset($_POST["confirm_add"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);

    echo 'Adding user to contact list...';

    
    addContact($conn, $loginEmail, $_SESSION["newContactName"], $_SESSION["newContactEmail"], $_SESSION["newContactUID"]);
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
<h3>Input a user's email to add them to the contact list</h3>
<form action = "" method = "post">
        Search: <input type="text" name="search_add" /><br />  
        <input type="submit" value="Submit" /> 
        <!-- <button type = "submit" name = "search_add"> Search for existing users</button> -->
</form>


<?php
if (!empty($_REQUEST['search_add']))
{
    $term = mysqli_real_escape_string($conn, $_REQUEST['search_add']);

    $sql = "SELECT * FROM users WHERE usersEmail LIKE '%".$term."%'"; //does there need to be another semicolon?
    $r_query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($r_query)) {
        echo 'Name: ' .$row['usersName'];
        echo '<br /> Email: ' .$row['usersEmail'];
        echo '<br /> UID: ' .$row['usersUID'];

        echo '<br /><p>Is this the user you would like to add to your contacts?<p><br />';
        echo '
        <form action = "" method = "post">  
            <input type="submit" name="confirm_add" value="Confirm and Add" /> 
        </form>
        ';

        $_SESSION["newContactName"] = $row['usersName'];
        $_SESSION["newContactEmail"] = $row['usersEmail'];
        $_SESSION["newContactUID"] = $row['usersUID'];
    }
}
?>