<?php
    require_once 'header.php';
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';

?>
<!DOCTYPE html>
<html>

    <head>
        <title>MeTube Upload</title>
    </head>
    <body>
        <form action ="includes/upload.inc.php" enctype = "multipart/form-data" method = "post">
            <label>Upload Here</label>
            <input type = "text" name = "title" placeholder = "Enter title here...">
            <input type = "text" name = "description" placeholder = "Enter description here...">
            <input type = "text" name = "keyword1" placeholder = "Enter first keyword here...">
            <input type = "text" name = "keyword2" placeholder = "Enter second keyword here...">
            <input type = "text" name = "keyword3" placeholder = "Enter third keyword here...">
            <select name="category" style="width: 175px;">
                <option value="" disabled selected hidden>Please Choose...</option>
                <option>Comedy</option>
                <option>Games</option>
                <option>Travel</option>
                <option>Music</option> 
                <option>Sports</option> 
                <option>Educational</option> 
                <option>Other</option> 
		    </select>	
            <label>File upload</label>
            <input type = "File" name = "file"> </input>
            <input type = "submit" name = "submit"> </input>
    </body>

</html>
<?php
    require_once 'footer.php';
?>