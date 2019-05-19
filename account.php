<!DOCTYPE html>
<html>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="index_css.css">
	<body>
		<form method="post">
	    <input name="fname" type="text" placeholder="First Name" required />
	    <input name="lname" type="text" placeholder="Last Name" required />
			<input name="email" type="email" placeholder="Email" required/>
			<input name="password" type="password" placeholder="Password" required/>
			<button type="submit" value="Submit" formaction="account.php">Sign Up</button>
		</form>
	</body>
</html>

<?php
	require_once 'verify_session.php';
	require_once 'mysql_methods.php';
	require_once 'login.php';

	//Sanitize inputs
	function sanitize($input){
		return htmlentities(strip_tags(stripslashes($input)));
	}

	//Alert function
	function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	//Random string
	function rand_string( $length ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $size = strlen($chars);
	    for($i = 0; $i < $length; $i++){
	        $str .= $chars[ rand( 0, $size - 1 ) ];
	    }
	    return $str;
	}

	verify_session(basename(__FILE__));
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) mysqli_error($conn);

	if (isset($_POST['email']) && isset($_POST['password'])) {

		$fname = sanitize($_POST['fname']);
		$lname = sanitize($_POST['lname']);
		$un = sanitize($_POST['email']);
		$pw = sanitize($_POST['password']);

		// Create user
		if ($result = $conn->prepare("SELECT * FROM users WHERE username=?;")) {
			$result->bind_param('s', $un);
			$result->execute();
			$result->store_result();
		}else{
			mysqli_error($conn)
		}

		//If the username does not exist else it does exist
		if ($result->num_rows == 0) {
			$salt1 = rand_string(4);
			$salt2 = rand_string(4);
			$token = hash('md5', "$salt1$pw$salt2");

			if ($stmt = $conn->prepare("INSERT INTO users(fname, lname, username, password) VALUES(?,?,?,?);")) {
				$stmt->bind_param('ssss', $fname, $lname, $un, $token);
				$stmt->execute();
				$stmt->close();
			}else{
				mysqli_error($conn)

			}

			$query = "INSERT INTO salt(salt1, salt2) VALUES('$salt1', '$salt2')";
			$result = $conn->query($query);
			if (!$result) mysqli_error($conn)

			mysqli_refresh($conn, MYSQLI_REFRESH_LOG);
			alert("Account successfully created");
			header("location: authenticate.php");
		}else{
			alert("Invalid username/password combination");
			header("location: account.php");
		}

		$result->close();
		$conn->close();
	}
?>
