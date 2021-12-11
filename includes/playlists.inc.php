<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if(isset($_SESSION["useremail"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);   
}


if(isset($_POST["submit"]))
{
    $name = $_POST["name"];

    // require_once 'dbh.inc.php';
    // require_once 'functions.inc.php';

    $sql = "INSERT INTO playlists (playlistName, playlistOwner) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../playlists.php?error=playlistadderror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $loginEmail);
    // $favName = 'Favorites List';
    // mysqli_stmt_bind_param($stmt, "ss", $favName, $loginEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../playlists.php?error=newCreationSuccess");


}

if(isset($_GET['mediaToAdd'])) {
    $curMediaId2 = $_GET['mediaToAdd'];

    echo '<h2>SELECT A PLAYLIST TO ADD THIS TO</h2>';

    $query = "SELECT * FROM playlists WHERE playlistOwner= '$loginEmail' AND mediaId IS NULL"; //change between sender and recipient
    $result = mysqli_query($conn, $query);

    echo "<table>";

    while ($row = mysqli_fetch_array($result)) {
            echo '<br />';
            //echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>Subscribee: " . $row['subscribee'];
            $test = $row['playlistName'];
            echo "<p>Playlist (click to select this playlist): <i><a href='playlists.inc.php?playlist=$test&theChosenOne=$curMediaId2'>$test</i></a></p>";

            // $_SESSION["currentMessageId"] = $row['messageId'];
    }

    echo "</table>";
}

if(isset($_GET['playlist'])) {
    $mediaId_ineed = $_GET['theChosenOne'];
    $playlistName_ineed = $_GET['playlist'];

    $sql = "INSERT INTO playlists (playlistName, playlistOwner, mediaId) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../playlists.php?error=addissue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $playlistName_ineed, $loginEmail, $mediaId_ineed);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../playlists.php?error=addToExistingSuccess");
    exit();
}

if(isset($_GET['itemToRemove'])) {
    echo '<h2>I DONT HAVE CODE WRITTEN TO DO THIS YET</h2>';
    $uno = $_GET['itemToRemove'];
    $dos = $_GET['curPlaylist'];

    echo "<p>uno = " . $uno . "</p><br />";
    echo "<p>dos = " . $dos . "</p><br />";


    $sql = "DELETE FROM playlists WHERE playlistName = '$dos' AND mediaId = '$uno'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../playlists.php?error=removeItemIssue");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../playlists.php?error=removeItemSuccess");
    exit();

}




// else{
//   header("location: ../signup.php");
//   exit();
// }