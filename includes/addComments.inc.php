
<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
//require_once '../addComments.php';
if(isset($_POST["submit"]))
{
    $comment = $_POST["comment"];
    $media_id = $_SESSION["media_id"];
    $media_owner = $_SESSION["mediaOwner"];
    $commentor = $_SESSION["useremail"];
    addComment($conn, $comment, $media_id, $media_owner, $commentor);
}
    
    
        
    