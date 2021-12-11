<?php
    require_once 'header.php';
    require_once 'connectDB.php';
?>

<!-- <section class = "logout form"> -->
    <h2>Logging you out...</h2>

<?php
    session_start(); //to ensure you are using same session
    session_destroy(); //destroy the session
    header("location:index.php"); //to redirect back to "index.php" after logging out
    exit();
?>

<?php
    require_once 'footer.php';
?>