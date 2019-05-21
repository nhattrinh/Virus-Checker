<?php
	echo <<< _END
	<!DOCTYPE html>
	<html>
		<head>
			<title>Sign Up</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		</head>
		<center>
			<div class="col-6">
			<form class="text-center border border-light p-5" method="post">
				<p class="h4 mb-4">Create Account</p>
				<input name="fname" type="text" placeholder="First Name" required class="form-control mb-4"/>
				<input name="lname" type="text" placeholder="Last Name" required class="form-control mb-4"/>
				<input name="email" type="email" placeholder="Email" required class="form-control mb-4"/>
				<input name="password" type="password" placeholder="Password" required class="form-control mb-4"/>
				<button type="submit" value="Submit" formaction="account.php" class="btn btn-outline-primary btn-block my-4">Sign Up</button>
			</form>
			</div>

		</center>
	</html>
_END;

	require_once "session_verification.php";
	require_once "db_login.php";

	//Sanitize inputs
	function sanitize($input){
		return htmlentities(strip_tags(stripslashes($input)));
	}

	//Alert function
	function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	//Random string
	function rand_string($length) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $size = strlen($chars);
	    for($i = 0; $i < $length; $i++){
	        $str .= $chars[rand(0, $size - 1)];
	    }
	    return $str;
	}

	verifySession(basename(__FILE__));
	$conn = new mysqli($host, $user, $pass, $database);
	if ($conn->connect_error) mysqli_error($conn);

	if (isset($_POST['email']) && isset($_POST['password'])) {

		$fname = sanitize($_POST['fname']);
		$lname = sanitize($_POST['lname']);
		$user = sanitize($_POST['email']);
		$pass = sanitize($_POST['password']);

		// Create user
		if ($res = $conn->prepare("SELECT * FROM users WHERE username=?;")) {
			$res->bind_param('s', $user);
			$res->execute();
			$res->store_result();
		}else{
			mysqli_error($conn);
		}

		//If the username does not exist else it does exist
		if ($res->num_rows == 0) {
			$salt1 = rand_string(4);
			$salt2 = rand_string(4);
			$hash = hash('md5', "$salt1$pass$salt2");

			if ($stmt = $conn->prepare("INSERT INTO users(fname, lname, username, password) VALUES(?,?,?,?);")) {
				$stmt->bind_param('ssss', $fname, $lname, $user, $hash);
				$stmt->execute();
				$stmt->close();
			}else{
				mysqli_error($conn);
			}

			$query = "INSERT INTO salt(salt1, salt2) VALUES('$salt1', '$salt2')";
			$res = $conn->query($query);
			if (!$res) mysqli_error($conn);

			mysqli_refresh($conn, MYSQLI_REFRESH_LOG);
			alert("Account successfully created");
			header("location: login.php");
		}else{
			alert("Incorrect username or password. Try again.");
			header("location: account.php");
		}

		$res->close();
		$conn->close();
	}
?>
