<?php

$serverName = 'mysql1.cs.clemson.edu';
$dbUserName = 'CPSC4620U12_c92s';
$dbPassword = 'TestMonkey4620' ;
$dbName = 'CPSC4620_U12_5kno';

$conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if(!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}