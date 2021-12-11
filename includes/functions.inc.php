<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)
{
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat))
    {
        // we at least know one input was empty
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function invalidEmail($email)
{
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function pwdMatch($pwd,$pwdRepeat)
{
    $result;
    if($pwd !== $pwdRepeat)
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function UIDExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../signup.php?error=statementfailedUIDExists");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result))
    {
        return $row;
    }

    else
    {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd)
{
    $sql = "INSERT INTO users (usersName, usersEmail, usersUID, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../signup.php?error=statementfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../signup.php?error=none");


    //CREATE FAVORITES LIST PLAYLIST UPON CREATION OF NEW USER
    $sql = "INSERT INTO playlists (playlistName, playlistOwner) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        //header("location:playlists.php?error=playlistadderror");
        exit();
    }
    $favName = 'Favorites List';
    mysqli_stmt_bind_param($stmt, "ss", $favName, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //header("location:/playlists.php?error=newCreationSuccess");
    
}
function emptyInputLogin($email,$pwd)
{
    $result;
    if(empty($email) || empty($pwd))
    {
        // we at least know one input was empty
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function loginUser($conn, $email, $pwd)
{
    $UidExists = UIDExists($conn, $email);


    if($UidExists=== false)
    {
        
        header("location:../login.php?error=wrongemail");
        exit();
    }

    $pwdHashed = $UidExists["usersPwd"];
    $checkPwd = password_verify($pwd,$pwdHashed);

    if($checkPwd === false)
    {
        echo("issue is in checkPwd");
        header("location:../login.php?error=wrongpwd");
        exit();
    }
    else if($checkPwd === true)
    {
        session_start();
        $_SESSION["userid"] = $UidExists["usersId"];
        $_SESSION["useremail"] = $UidExists["usersEmail"];
        header("location:../index.php");
        exit();
    }
}
function emptyInputProfileUpdate($name, $email, $username, $pwd, $pwdRepeat)
{
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat))
    {
        // we at least know one input was empty
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function updateUser($conn, $name, $email, $username, $pwd)
{
    //need to add some sql to check for exising email in the db before changing it
    
    $sql = "UPDATE users SET usersUID = ?, usersPwd = ?, usersEmail = ?, usersName = ? WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../signup.php?error=statementfailed");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPwd, $email, $name, $_SESSION["useremail"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../index.php?error=none");
    exit();
}
function emptyInputUpload($title, $description, $kw1, $kw2, $kw3, $category)
{
    $result;
    if(empty($title) || empty($description) || empty($kw1) || empty($kw2) || empty($kw3)
    || empty($category))
    {
        // we at least know one input was empty
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function displayCategory($conn, $category)
{
    if(isset($_POST["submit"]))
    {
        
        $sql = "SELECT * FROM media WHERE media_category = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location:../browse.php?error=statementfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $category);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(!$result)
        {
            header("location:../browse.php?error=$result");
            exit();
        }
        echo '
        <form action = "../browse.php" method = "post">
            <button type = "input" name = ""><-- Return to Browse</button>
        </form> <br />';
        while($data = $result->fetch_array())
        {
            if($data['extension']=='jpg')
            {
                echo "<h2> {$data['media_title']}</h2>";
                echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo " <img src = '{$data['media_path']}' width = '320px' height = '320px'>";
            }
            if($data['extension']== 'mp4')
            {
                echo "<h2> {$data['media_title']}</h2>";
                echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo "<video src='{$data['media_path']}' controls width='320px' height='320px' ></video>     
                <br>";
            }
            //download file
            echo "<p><a href='../download2.php?path=includes/{$data['media_path']}'>Download {$data['media_title']} file</a></p>";
            //COMMENTS
            echo "<p> <a href = '../viewComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'> Click to view Comments</a></p>";
            echo "<p><a href = '../addComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'>Click to add comment</a></p>";
        }
    }
}
function displayAllBrowse($conn)
{
        $sql = "SELECT * from media";
        $result = $conn->query($sql);

        while($data = $result->fetch_array())
        {
            if($data['extension']=='jpg')
            {
                echo "<br /><h2> {$data['media_title']}</h2>";
                echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo "<p><i><a href='includes/playlists.inc.php?mediaToAdd={$data['media_id']}'>Add to Playlist</i></a></p>";
                echo " <img src = 'includes/{$data['media_path']}' width = '320px' height = '320px'>";
                $_SESSION['test'] = $data['media_id']; 
            }
            if($data['extension']== 'mp4')
            {
                
                echo "<h2> {$data['media_title']}</h2>";
                echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo "<video src='includes/{$data['media_path']}' controls width='320px' height='320px' ></video>     
                    <br>";
                $_SESSION['test'] = $data['media_id'];
                //echo "media _id is $test<br>";
            }
            //DOWNLOAD FILE
            echo "<p><a href='download2.php?path=includes/{$data['media_path']}'>Download {$data['media_title']} file</a></p>";
            //COMMENTS
            echo "<p> <a href = 'viewComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'> Click to view Comments</a></p>";
            //echo "<p>Comments (click to add a comment): <i><a href='addComments.php'?media_id={$data['media_id']}'>{$data['media_id']}</i></a></p>";
            echo "<p><a href = 'addComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'>Click to add comment</a></p>";

        }
        
    
}

function viewCurrentChannelUploads($conn, $channel)
{
        $sql = "SELECT * from media WHERE mediaOwner= '$channel'";
        $result = $conn->query($sql);

        while($data = $result->fetch_array())
        {
            if($data['extension']=='jpg')
            {
                echo "<br /><h2> {$data['media_title']}</h2>";
                //echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo " <img src = 'includes/{$data['media_path']}' width = '320px' height = '320px'>";
            }
            if($data['extension']== 'mp4')
            {
                echo "<h2> {$data['media_title']}</h2>";
                //echo "<p>Channel (click to view & subscribe): <i><a href='currentChannel.php?channel={$data['mediaOwner']}'>{$data['mediaOwner']}</i></a></p>";
                echo "<video src='includes/{$data['media_path']}' controls width='320px' height='320px' ></video>     
                    <br>";
            }
            //DOWNLOAD FILE
            echo "<p><a href='download2.php?path=includes/{$data['media_path']}'>Download {$data['media_title']} file</a></p>";
        }

}

function mySubscriptions($conn, $loginEmail)
{
    $query = "SELECT * FROM subscriptions WHERE subscriber= '$loginEmail'"; //change between sender and recipient
    $result = mysqli_query($conn, $query);

    echo "<table>";

    while ($row = mysqli_fetch_array($result)) {
            echo '<br />';
            echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>Subscribee: " . $row['subscribee'];
            $test = $row['subscribee'];
            echo "<p>Channel (click to view channel): <i><a href='currentChannel.php?channel=$test'>$test</i></a></p>";

            // $_SESSION["currentMessageId"] = $row['messageId'];
    }

    echo "</table>";

}
// function addToPlaylist($conn) {

// }
function myPlaylists($conn, $loginEmail)
{
    $query = "SELECT * FROM playlists WHERE playlistOwner= '$loginEmail' AND mediaId IS NULL"; //change between sender and recipient
    $result = mysqli_query($conn, $query);

    echo "<table>";

    while ($row = mysqli_fetch_array($result)) {
            echo '<br />';
            //echo "<tr><td>" . "<p>----------------</p>" . "<tr><td>Subscribee: " . $row['subscribee'];
            $test = $row['playlistName'];
            echo "<p>Playlist (click to view playlist): <i><a href='currentPlaylist.php?playlist=$test'>$test</i></a></p>";

            // $_SESSION["currentMessageId"] = $row['messageId'];
    }

    echo "</table>";

}
function newSubscription($conn, $contentOwner, $loginEmail)
{
    $sql = "INSERT INTO subscriptions (subscriber, subscribee) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../mySubs.php?error=addSubIssue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $loginEmail, $contentOwner);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../mySubs.php?error=addSuccess");
    exit();
}
function removeSubscription($conn, $contentOwner, $loginEmail)
{
    //$sql = "DELETE FROM contacts (usersEmail, contactName, contactEmail, contactUID) VALUES (?, ?, ?, ?);";
    $sql = "DELETE FROM subscriptions WHERE subscriber = '$loginEmail' AND subscribee = '$contentOwner'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../mySubs.php?error=removeSubIssue");
        exit();
    }

    //mysqli_stmt_bind_param($stmt, "ssss", $currentEmail, $name, $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../mySubs.php?error=removeSuccess");
    exit();
}

function uploadFile($conn, $title, $target_file, $extension, $category, $useremail, $kw1, $kw2, $kw3)
{
    $sql = "INSERT INTO media (media_title, media_path, extension, media_category) VALUES (?, ?, ?, ?);";
    $sql = "INSERT INTO media (media_title, media_path, extension, media_category, mediaOwner, media_keyword1, media_keyword2, media_keyword3) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../upload.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss", $title, $target_file, $extension, $category);
    mysqli_stmt_bind_param($stmt, "ssssssss", $title, $target_file, $extension, $category, $useremail, $kw1, $kw2, $kw3);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../index.php?error=none");
    exit();
}
function addContact($conn, $currentEmail, $name, $email, $username)
{
    //NEEDS TO CREATE A NEW TABLE THAT HAS A NAME RELATED TO THE CURRENT USER SOMEHOW
    $sql = "INSERT INTO contacts (usersEmail, contactName, contactEmail, contactUID) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../../contacts.php?error=addissue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $currentEmail, $name, $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../../contacts.php?error=none");
    exit();
    
}
function removeContact($conn, $currentEmail, $name, $email, $username)
{
    //$sql = "DELETE FROM contacts (usersEmail, contactName, contactEmail, contactUID) VALUES (?, ?, ?, ?);";
    $sql = "DELETE FROM contacts WHERE usersEmail = '$currentEmail' AND contactEmail = '$email'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../../contacts.php?error=removeissue");
        exit();
    }

    //mysqli_stmt_bind_param($stmt, "ssss", $currentEmail, $name, $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../../contacts.php?error=none");
    exit();
    
}
function displayKeywords($conn, $search)
{
    if(isset($_GET["search"]))
    {
        $sql = "SELECT * FROM media WHERE media_keyword1 = ? OR media_keyword2 = ? OR media_keyword3 = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location:../browse.php?error=statementfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(!$result)
        {
            header("location:../browse.php?error=$result");
            exit();
        }
        while($data = $result->fetch_array())
        {
            if($data['extension']=='jpg')
            {
                echo "<h2> {$data['media_title']}</h2>";
                echo " <img src = '{$data['media_path']}' width = '320px' height = '320px'>";
            }
            if($data['extension']== 'mp4')
            {
                echo "<h2> {$data['media_title']}</h2>";
                echo "<video src='{$data['media_path']}' controls width='320px' height='320px' ></video>     
                <br>";
            }
            //download file
            echo "<p><a href='../download2.php?path=includes/{$data['media_path']}'>Download {$data['media_title']} file</a></p>";
            //COMMENTS
            echo "<p> <a href = '../viewComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'> Click to view Comments</a></p>";
            echo "<p><a href = '../addComments.php?media_id= {$data['media_id']}&media_owner={$data['mediaOwner']}'>Click to add comment</a></p>";
        }
    }
}
function createMessage($conn, $loginEmail, $recipient, $subject, $content)
{
    $sql = "INSERT INTO messages (sender, recipient, subject, content) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../messages.php?error=newissue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $loginEmail, $recipient, $subject, $content);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../messages.php?error=newsuccess");
    exit();
}
function replyMessage($conn, $loginEmail, $recipient, $subject, $content, $replyTo)
{
    $sql = "INSERT INTO messages (sender, recipient, subject, content, replyId) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../messages.php?error=replyissue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $loginEmail, $recipient, $subject, $content, $replyTo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../messages.php?error=replysuccess");
    exit();
}
function addComment($conn, $comment, $media_id, $media_owner, $commentor)
{
    $sql = "INSERT INTO comments (comment, media_id, mediaOwner, commentor) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location:../messages.php?error=replyissue");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $comment, $media_id, $media_owner, $commentor);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location:../browse.php?error=commentsuccess");
    exit();
}
function viewComments($conn, $media_id, $mediaOwner)
{
        $sql = "SELECT * FROM comments WHERE media_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location:../browse.php?error=statementfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $media_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(!$result)
        {
            header("location:../browse.php?error=$result");
            exit();
        }
        while($data = $result->fetch_array())
        {
            echo "<br /><h1> {$data['commentor']}:</h1>";
            echo "<pre><br/><h3>\t{$data['comment']}</h3></pre>";
        }
}
