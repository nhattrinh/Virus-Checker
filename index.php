<!-- PHP Session -->
<?php
	require_once 'verify_session.php'; // programmer defined methods to prevent session hijacking

	verify_session(basename(__FILE__)); // check the session
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<style type="text/css">
html { 
	background: url(http://www.cpd-india.com/blog/wp-content/uploads/2016/07/trojan-word-cloud.jpg) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
</style>
<html>
	<title>Index</title>
	<link rel = "stylesheet" type = "text/css" href = "index_css.css">
	<center><img src="http://robertpeelinternational.co.uk/wp-content/uploads/2017/02/welcome-images-25.png" height="146" width="525"></center><br><br>
	<form  method="post">
		<button type="submit" formaction="authenticate.php">login</button><br><br>
		<button type="submit" formaction="account.php">create account</button>
		<button type="submit" formaction="remove_user.php">delete account</button>
	</form>
</html>