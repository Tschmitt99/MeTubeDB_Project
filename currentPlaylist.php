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

if(isset($_GET['playlist'])) {
    $playlist = $_GET['playlist'];
}

// if(isset($_GET['error'])) {
//     if ($_GET['error'] == 'removeIssue') {
//         echo "<p>Looks like there was an issue removing this item from your playliist. Please try again!</p><b />";
//     }
//     if ($_GET['error'] == 'removeSuccess') {
//         echo "<p>Successfully removed this item from your playlist!</p><b />";
//     }
// }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html14/loose.dtd">
<html>
<head>
    <title>Untitled Document</title>
        <meta http-eqiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<!-- <h2>CURRENT PLAYLIST PAGE</h2> -->
<body>
    <form action = "index.php" method = "post">
        <button type = "input" name = ""><-- Return to front page</button>
    </form>
    <br />

</body>
</html>

<?php
    echo '<br /><h2>Currently viewing playlist: ' . $playlist . "</h2/><br />";
    echo 'currently logged in user is ' . $loginEmail;
    $query = "SELECT * FROM playlists WHERE playlistOwner= '$loginEmail' AND playlistName= '$playlist' AND mediaId IS NOT NULL";
    $result = mysqli_query($conn, $query);


    while ($row = mysqli_fetch_array($result)) {
            

            $curId = $row['mediaId'];
            //echo '<br /><p>THIS IS THE MEDIA ID: ' . $curId . '</p>';
            $sql = "SELECT * from media WHERE media_id= '$curId'";
            $result2 = $conn->query($sql);

            while($data = $result2->fetch_array())
            {
                if($data['extension']=='jpg')
                {
                    echo "<br /><h2> {$data['media_title']}</h2>";
                    echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                    echo "<p><i><a href='includes/playlists.inc.php?itemToRemove={$data['media_id']}&curPlaylist=$playlist'>Remove from this playlist</i></a></p>";
                    echo " <img src = 'includes/{$data['media_path']}' width = '320px' height = '320px'>";
                }
                if($data['extension']== 'mp4')
                {
                    echo "<h2> {$data['media_title']}</h2>";
                    echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                    echo "<p><i><a href='includes/playlists.inc.php?itemToRemove={$data['media_id']}&curPlaylist=$playlist'>Remove from this playlist</i></a></p>";
                    echo "<video src='includes/{$data['media_path']}' controls width='320px' height='320px' ></video>     
                        <br>";
                }
                //DOWNLOAD FILE
                echo "<p><a href='download2.php?path=includes/{$data['media_path']}'>Download {$data['media_title']} file</a></p>";
            }
    }


    //CODE TO DISPLAY CURRENT CHANNEL UPLOADS
    //viewCurrentPlaylistUploads($conn, $playlist);





    require_once 'footer.php';
?>