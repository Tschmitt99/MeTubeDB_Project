<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_SESSION["useremail"]))
{
    $loginEmail = $_SESSION["useremail"];
    $UidExist = UIDExists($conn, $loginEmail);
    echo 'Set loginemail to :' . $loginEmail;
}

if(isset($_POST["submit"]))
{
    
    $category = $_POST["category"];
    displayCategory($conn, $category);
    
}
if(isset($_GET["search"]))
{
    $search = $_GET["search"];
    displayKeywords($conn,$search);
}