<?php
	require_once 'session_verification.php';
	verify_session(basename(__FILE__));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Infected File</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<center>
<body>
	<div>
	<form class="jumbotron jumbotron-fluid" action="file_check.php" method="post" enctype="multipart/form-data">
		<div class="container">
			<br><h1 class="display-4">ONLINE VIRUS CHECK</h1><br/><br/><br/><br/>
			<p class="lead">
			The idea is to create a web-based Antivirus application that allows the users to upload a file 
			(of any type) to check if it contains malicious content. 
			That is, if it is a Malware or not.
			</p>
		</div>
	</div>
	
	<form  method="post">
		<button type="submit" formaction="login.php" class="btn btn-outline-secondary waves-effect">Login</button><br><br>
		<button type="submit" formaction="account.php" class="btn btn-outline-primary waves-effect">Create Account</button>
		<button type="submit" formaction="delete_account.php" class="btn btn-outline-danger waves-effect">Delete Account</button>
	</form>
</body>
</center>
</html>
