<?php
require_once '../php.ini';
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once 'dbh.inc.php';
if(isset($_POST["submit"]))
{
    $title = $_POST["title"];
    $description = $_POST["description"];
    $kw1 = $_POST["keyword1"];
    $kw2 = $_POST["keyword2"];
    $kw3 = $_POST["keyword3"];
    $category = $_POST["category"];
    $file = $_FILES["file"];
    $useremail=$_SESSION['useremail'];
    $date = date("m/d/Y");
    $img = $_FILES["file"]["name"];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    //CHECKS IF ANY UPLOAD USER INPUTS ARE EMPTY
    if(emptyInputUpload($title, $description, $kw1, $kw2, $kw3, $category)!== false)
    {
        header("location: ../upload.php?error=emptyinput");
        exit();
    }
    //IF THE uploads FOLDER DOESN'T EXIST, THEN CREATE IT
    if(!file_exists('uploads/'))
    {
        mkdir('uploads/', 0757);
    }
    $dirfile = 'uploads/'.$useremail.'/';   //DIRECTORY FOR UPLOADING FILES
    //IF THE DIRECTORY FOR CURRENT USER'S UPLOADS DOESN'T EXIST, THEN CREATE IT
    if(!file_exists($dirfile))
    {
        mkdir($dirfile,0755);
    }
    //CHANGE PERMISSIONS FOR DIRECTORIES
    chmod('uploads/', 0755);
    chmod($dirfile,0755);
    if($_FILES["file"]["error"] > 0 )
    {
        $result= $_FILES["file"]["error"]; 
    }
    $path_info = pathinfo($_FILES["file"]["name"]);
    //$array = explode('.', $_FILES['image']['name']);
    $target_dir = 'uploads/'.$useremail.'/';
    $target_file = $target_dir . $_FILES["file"]["name"];   //TARGET DIR FOR FILE
    $extension = pathinfo($target_file, PATHINFO_EXTENSION);
    if(!move_uploaded_file($_FILES['file']['tmp_name'],$target_file))
    {
            
        header("location: ../upload.php?error=$result");
        exit();
    }
    else{
        uploadFile($conn, "$title", "$target_file", "$extension", "$category", $useremail, $kw1, $kw2, $kw3);        header("location:../browse.php?error=none");
        exit();
    }
    
}
