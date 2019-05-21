<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<center>
	<div class="col-6">
	<form class="text-center border border-light p-5" formaction="login.php" method="post">
	<p class="h4 mb-4">Sign in</p>
 		<!-- Email -->
		<input name="email"    type="email"    placeholder="email"     required="" class="form-control mb-4"/>
		<!-- Password -->
		<input name="password" type="password" placeholder="password"  required="" class="form-control mb-4"/>
		<!-- Sign in button -->
		<button class="btn btn-outline-primary btn-block my-4" type="submit">Sign in</button>
		<!-- Register -->
		<p>Not a member?
        <a href = "account.php">Register</a>
    	</p>
	<form>
	</div>
</center>
</html>

<?php
	require_once "db_login.php";
	require_once "session_verification.php";

	//Alert function
	function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	verifySession(basename(__FILE__));

	function fixString($conn, $string) {
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}

	if (isset($_POST['email']) && isset($_POST['password'])) {
		$conn = new mysqli($host, $user, $pass, $database);
		if ($conn->connect_error) mysqli_error($conn->connect_error);

		$user = fixString($conn, $_POST['email']);
		$pass = fixString($conn, $_POST['password']);

		if (users_table($conn, $user, $pass) === false) admin_table($conn, $user, $pass);

		$conn->close();
	}

	function admin_table($conn, $user, $pass){
		if ($res = $conn->prepare("SELECT fname, password, salt1, salt2 FROM admin WHERE username=?;")) {
			$res->bind_param('s', $user);
			$res->execute();
			$res->store_result();
		} else {
			mysqli_error($conn->error);
		}

		if ($res->num_rows == 1) {
			$res->bind_result($fn, $database_pass, $s1, $s2);
			$res->fetch();
			$salt1 = $s1;
			$salt2 = $s2;
			$hash = hash('md5', "$salt1$pass$salt2");

			if ($hash === $database_pass) {
				session_start();
				$_SESSION['admin'] = 1;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

				echo '<script>
						alert("Successful admin login!");
						window.location = "file_check.php";
				      </script>';
			} else {
				alert("Error with username or password!");
				header('login.php');
			}
		} else {
			alert("Error with username or password!");
			header('login.php');
		}

		$res->close();
	}

	function users_table($conn, $user, $pass){
		if ($res = $conn->prepare("SELECT fname, password, salt1, salt2 FROM users NATURAL JOIN salt WHERE username=?;")) {
			$res->bind_param('s', $user);
			$res->execute();
			$res->store_result();
		}else{
			mysqli_error($conn->error);
		}

		if ($res->num_rows == 1) {
			$res->bind_result($fn, $database_pass, $s1, $s2);
			$res->fetch();
			$salt1 = $s1;
			$salt2 = $s2;
			$hash = hash('md5', "$salt1$pass$salt2");

			if ($hash === $database_pass) {
				session_start();
				$_SESSION['user'] = 1;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

				echo '<script>
						alert("Successful login!");
						window.location = "file_check.php";
				      </script>';
			} else {
				alert("Error with username or password!");
				header('login.php');
			}
		} else {
			return false;
		}
		$res->close();
	}
?>
