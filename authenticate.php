<!DOCTYPE html>
<html>
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" href = "index_css.css">
	<form  formaction="authenticate.php" method="post">
		<input name="email" type="email" placeholder="email" />
		<input name="password" type="password" placeholder="password" />
		<button type="submit">Login</button>
	<form>
</html>

<?php
	require_once 'login.php'; // login credentials for MySQL
	require_once 'mysql_methods.php'; // programmer defined mysql methods to prevent hacking attempts
	require_once 'verify_session.php'; // programmer defined methods to prevent session hijacking

	verify_session(basename(__FILE__)); // check the session

	if (isset($_POST['email']) && isset($_POST['password'])) {

		// connecting to a MySQL database
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) mysql_fatal_error($conn->connect_error);

		// prevent hacking attempts: SQL injections
		$un = mysql_fix_string($conn, $_POST['email']);
		$pw = mysql_fix_string($conn, $_POST['password']);

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
			mysql_fatal_error($conn->error);

		if ($result->num_rows == 1) { // user exists in users table
			$result->bind_result($fn, $db_pw, $s1, $s2); // bind result variables
			$result->fetch(); // fetch value

			// retrieve salt values
			$salt1 = $s1;
			$salt2 = $s2;
			$token = hash('ripemd128', "$salt1$pw$salt2");

			// verify user's password
			if ($token === $db_pw) { // valid password
				// starting a session
				session_start();
				// set $_SESSION to 1
				$_SESSION['user'] = 1;
				// preventing session hijacking
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
				echo '<script>
						alert("Hi: '. $fn . ', you are now logged in as '. $un . '");
						window.location = "infected_file.php";
				      </script>';
			}
			else // invalid password
				echo '<script> alert("Invalid username/password combination"); window.location = "authenticate.php" </script>';
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
			mysql_fatal_error($conn->error);

		if ($result->num_rows == 1) { // user exists in admin table
			$result->bind_result($fn, $db_pw, $s1, $s2); // bind result variables
			$result->fetch(); // fetch value

			// retrieve salt values
			$salt1 = $s1;
			$salt2 = $s2;
			$token = hash('ripemd128', "$salt1$pw$salt2");

			// verify user's password
			if ($token === $db_pw) { // valid password
				// starting a session
				session_start();
				// set $_SESSION to 1
				$_SESSION['admin'] = 1;
				// preventing session hijacking
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
				echo '<script>
						alert("Hi, admin: '. $fn . ', you are now logged in as '. $un . '");
						window.location = "infected_file.php";
				      </script>';
			}
			else // invalid password
				echo '<script> alert("Invalid username/password combination"); window.location = "authenticate.php" </script>';
		}
		else // user not exist in admin table
			echo '<script> alert("Invalid username/password combination"); window.location = "authenticate.php" </script>';

		$result->close(); // close statement
	}
?>
