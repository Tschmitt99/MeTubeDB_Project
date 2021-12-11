<?php
  function insert($name, $email, $pwd)
  {
    $name = $_REQUEST['name'];
    $email = $_REQUEST ['email'];
    $pwd = $_REQUEST['pwd'];
    $today = date('m/d/Y');
    $link = mysqli_connect('mysql1.cs.clemson.edu', 'CPSC4620U12_c92s', 'U12CPSC4620!', 'CPSC4620_U12_5kno')
  or die('Could not connect: ' . mysqli_error($link));
  $sql = "INSERT INTO NewUserTable VALUES ('$name', '$email, '$pwd')";
  if ($link->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $link->error;
  }
  $query = 'SELECT * FROM NewUserTable';
  $result = mysqli_query($link, $query) or die("Query error: ". mysqli_error($link)."\n");
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
mysqli_close($link);
  }
?> 