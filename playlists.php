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
    if($_GET["error"]== "playlistadderror")
    {   
        echo("<p> Looks like there was an error creating a new playlist</p>");
    }
    if($_GET["error"]== "newCreationSuccess")
    {   
        echo("<p>Successfully created new playlist! <br />Click the 'Add to Playlist' button next to individual uploads to add to it!</p>");
    }
    if($_GET["error"]== "addissue")
    {   
        echo("<p>There was an error adding the selected video to the playlist. Please try again.</p>");
    }
    if($_GET["error"]== "addToExistingSuccess") {
        echo("<p>Successfully added the video to the selected playlist!</p>");
    }
    if ($_GET['error'] == 'removeItemIssue') {
        echo "<p>Looks like there was an issue removing this item from your playliist. Please try again!</p><b />";
    }
    if ($_GET['error'] == 'removeItemSuccess') {
        echo "<p>Successfully removed this item from your playlist!</p><b />";
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
    <h2>Create new playlist form:</h2>
    <form action = "includes/playlists.inc.php" method = "post">
        <input type = "text" name = "name" placeholder = "Enter playlist name...">
        <button type = "submit" name = "submit"> Submit Account Information</button>
    </form>
    <br />
    <h3>My Playlists</h3>
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
    myPlaylists($conn, $loginEmail);
    require_once 'footer.php';
?>