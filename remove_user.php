<!-- HTML Login Form -->
<!DOCTYPE html>
<html>
	<title>Delete Account</title>
	<link rel = "stylesheet" type = "text/css" href = "index_css.css">
	<form  method="post">
		<input name="email"    type="email"    placeholder="email"    maxlength="128" required="" />
		<input name="password" type="password" placeholder="password" maxlength="128" required="" />
		<button type="submit" formaction="remove_user.php">delete</button>	
	<form>
</html>


<!-- PHP Remove User and Salt Value -->
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

		// search if user exists
		if ($result = $conn->prepare("SELECT id, fname, lname, username, password, salt1, salt2 FROM users NATURAL JOIN salt WHERE username=?;")) { // create a prepare statement
			$result->bind_param('s', $un); // bind parameters for markers
			$result->execute(); // execute query
			$result->store_result(); // store result
		}
		else 
			mysql_fatal_error($conn->error);

		if ($result->num_rows == 1) { // user exists
			$result->bind_result($id, $fn, $sn, $un, $db_pw, $s1, $s2); // bind result variables
			$result->fetch(); // fetch value

			// retrieve salt values
			$salt1 = $s1;
			$salt2 = $s2;
			$token = hash('ripemd128', "$salt1$pw$salt2");

			// verify user's password
			if ($token === $db_pw) { // valid password
				// delete data from table users and from table salt
				if ($del_user = $conn->prepare("DELETE FROM users WHERE id=?")) { // create a prepare statement for users
					if($del_salt = $conn->prepare("DELETE FROM salt WHERE id=?")) { // create a prepare statement for salt 
						// delete data from table users
						$del_user->bind_param('i', $id);
						$del_user->execute();
						$del_user->close();
						// delete data from table salt
						$del_salt->bind_param('i', $id);
						$del_salt->execute();
						$del_salt->close();
					}
					else 
						mysql_fatal_error($conn->error);
				}
				else 
					mysql_fatal_error($conn->error);

				echo 
				'<script>
					alert("Hi: '. $fn . ', you\'ve successfully deleted your account '. $un . '"); 
					window.location = "index.php";
				</script>';
			}
			else // invalid password
				echo '<script> alert("Invalid username/password combination"); window.location = "remove_user.php"; </script>';
		}
		else // user not exist
			echo '<script> alert("Invalid username/password combination"); window.location = "remove_user.php"; </script>';
		
		$result->close(); // close statement
		$conn->close(); // close connection	
	}
?>