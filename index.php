<?php
	require_once 'verify_session.php';
	verify_session(basename(__FILE__));
?>

<!DOCTYPE html>
<html>
	<link rel = "stylesheet" type = "text/css" href = "index_css.css">
	<form  method="post">
		<button type="submit" formaction="login.php">Login</button><br><br>
		<button type="submit" formaction="account.php">Create Account</button>
		<button type="submit" formaction="remove_user.php">Delete Account</button>
	</form>
</html>
