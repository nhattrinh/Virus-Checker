<!-- HTML Login Form -->
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
		<input name="email"    type="email"    placeholder="email"    maxlength="128" required="" class="form-control mb-4"/>
		<!-- Password -->
		<input name="password" type="password" placeholder="password" maxlength="128" required="" class="form-control mb-4"/>
		<!-- Sign in button -->
		<button class="btn btn-info btn-block my-4" type="submit">Sign in</button>
		<!-- Register -->
		<p>Not a member?
        <a href = "/account.php">Register</a>
    	</p>
	<form>
	</div>
</center>
</html>

<!-- PHP Guest Authentication -->
<?php
	require_once 'db_login.php'; // login credentials for MySQL
	require_once 'mysql_methods.php'; // programmer defined mysql methods to prevent hacking attempts
	require_once 'session_verification.php'; // programmer defined methods to prevent session hijacking

	verify_session(basename(__FILE__)); // check the session

	function fixString($conn, $string) {
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}

	if (isset($_POST['email']) && isset($_POST['password'])) {
		
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) mysqli_error($conn->connect_error);
		
		$un = fixString($conn, $_POST['email']); 
		$pw = fixString($conn, $_POST['password']);

		// check if user exists in users table
		if (user_in_users_tbl($conn, $un, $pw) === false)
			user_in_admin_tbl($conn, $un, $pw);

		$conn->close(); // close connection
	}

	function user_in_users_tbl($conn, $un, $pw)
	{
		// search if user exists in users table
		//fname, password, salt1, salt2
		if ($result = $conn->prepare("SELECT fname, password, salt1, salt2 FROM users NATURAL JOIN salt WHERE username=?;")) { // create a prepare statement
			$result->bind_param('s', $un); // bind parameters for markers
			$result->execute(); // execute query
			$result->store_result(); // store result
		}
		else 
			mysqli_error($conn->error);
		
		if ($result->num_rows == 1) { // user exists in users table
			$result->bind_result($fn, $db_pw, $s1, $s2); // bind result variables
			$result->fetch(); // fetch value

			// retrieve salt values
			$salt1 = $s1;
			$salt2 = $s2;
			$token = hash('md5', "$salt1$pw$salt2");

			// verify user's password
			if ($token === $db_pw) { // valid password
				// starting a session
				session_start();
				// set $_SESSION to 1
				$_SESSION['user'] = 1;
				// preventing session hijacking
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);	
				echo '<script>
						alert("Hi: '. $fn . ', you are now logged in as '. $un . '"); 
						window.location = "file_check.php";
				      </script>';
			}
			else // invalid password
				echo '<script> alert("Invalid username/password combination"); window.location = "login.php" </script>';
		}
		else // user not exist in users table
			return false;

		$result->close(); // close statement
	}

	function user_in_admin_tbl($conn, $un, $pw)
	{
		// search if user exists in users table

		if ($result = $conn->prepare("SELECT fname, password, salt1, salt2 FROM admin WHERE username=?;")) { // create a prepare statement
			$result->bind_param('s', $un); // bind parameters for markers
			$result->execute(); // execute query
			$result->store_result(); // store result
		}
		else 
			mysqli_error($conn->error);
		
		if ($result->num_rows == 1) { // user exists in admin table
			$result->bind_result($fn, $db_pw, $s1, $s2); // bind result variables
			$result->fetch(); // fetch value

			// retrieve salt values
			$salt1 = $s1;
			$salt2 = $s2;
			$token = hash('md5', "$salt1$pw$salt2");

			// verify user's password
			if ($token === $db_pw) { // valid password
				// starting a session
				session_start();
				// set $_SESSION to 1
				$_SESSION['admin'] = 1;
				// preventing session hijacking
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);	
				echo '<script>
						alert("Hi, admin: '. $fn . ', you are now logged in as '. $un . '"); 
						window.location = "file_check.php";
				      </script>';
			}
			else // invalid password
				echo '<script> alert("Invalid username/password combination"); window.location = "login.php" </script>';
		}
		else // user not exist in admin table
			echo '<script> alert("Invalid username/password combination"); window.location = "login.php" </script>';

		$result->close(); // close statement
	}
?>