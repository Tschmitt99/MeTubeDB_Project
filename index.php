<?php
	session_start();
?>

<?php
    require_once 'header.php';

	if (isset($_GET['error'])) {
		if ($_GET['error'] == 'signupSuccess') {
			echo 'Successfully created a new account! You can now login!';
		}
	}
?>
<html>
 <body> 
         <h2>MeTube</h2> 
         <nav> 
			 
			 <ul> 
				 
				 <li><a href="browse.php">Browse</a></li> 
				 <?php
					if(isset($_SESSION["useremail"]))
					{
						echo "<li> <a href = 'profileUpdateConfirmation.php'> Profile page</a></li>";
						echo "<li> <a href = 'logout.php'> Log out</a></li>";
						echo "<li> <a href = 'upload.php'> Upload Content</a></li>";
						echo "<li> <a href = 'contacts.php'> My Contacts</a></li>";
						echo "<li> <a href = 'messages.php'> Messages</a></li>";
						echo "<li> <a href = 'mySubs.php'> My Subscriptions</a></li>";
						echo "<li> <a href = 'playlists.php'> My Playlists & Favorites</a></li>";

					}
					else
					{
						echo "<li> <a href = 'signup.php'> Sign up</a></li>";
						echo "<li> <a href = 'login.php'> Log in</a></li>";
					}

				?>
			 </ul> 
		 </nav> 
     </body>
</html>

<?php
    require_once 'footer.php';

?>