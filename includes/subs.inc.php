<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

// if(isset($_SESSION["useremail"]))
// {
//     $loginEmail = $_SESSION["useremail"];
//     $UidExist = UIDExists($conn, $loginEmail);
//     echo 'Set loginemail to :' . $loginEmail;
// }
// if(isset($_SESSION["ownerToSubTo"]))
// {
//     $contentOwner = $_SESSION["ownerToSubTo"];   
// }




// if(isset($_GET["error"]))
// {
//         if($_GET["error"]== "addSuccess")
//         {   
//             echo("<p> Subbed successfully!</p>");
//         }
//         if($_GET["error"]== "addSubIssue")
//         {   
//             echo("<p> Looks like there was an error subscribing to this channel. Please try again.</p>");
//         }
//         if($_GET["error"]== "removeSubIssue")
//         {   
//             echo("<p> Looks like there was an error unsubscribing from this channel. Please try again.</p>");
//         }
//         if($_GET["error"]== "removeSuccess")
//         {   
//             echo("<p> Successfully unsubscribed from this channel!</p>");
//         }
// }
if(isset($_POST["addSub"]))
{
    $contentOwner = $_SESSION["ownerToSubTo"];
    $loginEmail = $_SESSION["useremail"];

    //echo '<br /> Set contentowner to: ' . $_SESSION["ownerToSubTo"];


    newSubscription($conn, $contentOwner, $loginEmail);

} 
if(isset($_POST["removeSub"]))
{
    $contentOwner = $_SESSION["ownerToSubTo"];
    $loginEmail = $_SESSION["useremail"];

    //echo '<br /> Set contentowner to: ' . $_SESSION["ownerToSubTo"];


    removeSubscription($conn, $contentOwner, $loginEmail);

} 