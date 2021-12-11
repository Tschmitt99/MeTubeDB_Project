<?php

//$mysqli = new mysqli("localhost","my_user","my_password","my_db");
$mysqli = mysqli_connect("mysql1.cs.clemson.edu", "CPSC4620U12_c92s", "U12CPSC4620!", "CPSC4620_U12_5kno");

if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
$query = 'SELECT * FROM UserAccountInfo';
$result = mysqli_query($mysqli, $query) or die("Query error: ". mysqli_error($mysqli)."\n");
// Printing results in HTML
echo "<table>\n";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)){
echo "\t<tr>\n";
foreach($line as $col_value){
echo "\t\t<td>$col_value</td>\n";
}
echo "\t</tr>\n";
}
echo "</table>\n";
// Free resultset
mysqli_free_result($result);
// Closing connection
mysqli_close($mysqli);
?> 