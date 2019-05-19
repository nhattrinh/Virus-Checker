<!-- Create Account Form -->
<!DOCTYPE html>
<style type="text/css">
html { 
	background: url(https://www.techbooky.com/wp-content/uploads/2017/07/computer-bug.jpg) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
</style>
<html>
	<title>Create Account</title>
	<!--
	<center><img src="https://cdn0.iconfinder.com/data/icons/web-basics-color-vol-03/512/bug_virus_insect_trojan_malware-256.png" height="128" width="128"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/119515-200.png" height="128" width="128"></center>
	-->
	<center><img src="https://www.voices.com/assets/uploads/ee-client-features/MultiUserIcon.png" height="128" width="170"></center><br><br>
	<!-- External CSS -->
	<link rel="stylesheet" type="text/css" href="index_css.css">
	<body>
		<form method="post">
	    <input name="firstName" placeholder="First Name" type="text" maxlength="128" required />
	    <input name="lastName"  placeholder="Last Name"  type="text" maxlength="128" required />
			<input name="email"     placeholder="Email"      type="email"    maxlength="128" required/>
			<input name="password"  placeholder="Password"   type="password" maxlength="128" required/>
			<button type="submit" formaction="account.php" value="Submit">Submit</button>
		</form>
	</body>
</html>

<!-- Creat Account Form Validation -->
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
		$fname = mysql_fix_string($conn, $_POST['firstName']);
		$lname = mysql_fix_string($conn, $_POST['lastName']);
		$un = mysql_fix_string($conn, $_POST['email']); 
		$pw = mysql_fix_string($conn, $_POST['password']);

		// create user if username not exist
		// using placeholder(s)
		if ($result = $conn->prepare("SELECT * FROM users WHERE username=?;")) { // create a prepare statement
			$result->bind_param('s', $un); // bind parameters for markers
			$result->execute(); // execute query
			$result->store_result(); // store result
		}
		else
			mysql_fatal_error($conn->error);

		/*
		$query = "SELECT * FROM users WHERE username='$un'";
		$result = $conn->query($query);
		if (!$result) mysql_fatal_error($conn->error);
		*/

		if ($result->num_rows == 0) { // username not exist
			$salt1 = rand_salt();
			$salt2 = rand_salt();
			$token = hash('ripemd128', "$salt1$pw$salt2");
			add_user($conn, $fname, $lname, $un, $token);
			add_salt($conn, $salt1, $salt2);
			mysqli_refresh($conn, MYSQLI_REFRESH_LOG);
			echo '<script> alert("Account successfully created"); window.location = "index.php"; </script>';
		}
		else // username exist
			echo '<script> alert("Invalid username/password combination"); window.location = "account.php"; </script>';
		
		$result->close(); // close statement
		$conn->close(); // close connection
	}

	/**
	 * This method generates a random salt of string length 5 to 15
	 * @return string implode("", $salt) the random salt
	 */
	function rand_salt() {
		$len = rand(5, 15); 
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		for ($i = 0; $i < rand(); $i++)
			$salt[rand(0, $len - 1)] = $chars[rand(0, strlen($chars) - 1)];

		return implode("", $salt);
	}

	/**
	 * This method adds data to the users table
	 * @param object $connection is the mysqli object
	 * @param string $fn is the user's first name
	 * @param string $sn is the user's last name
	 * @param string $un is the username
	 * @param string $pw is the user's password
	 */
	function add_user($connection, $fn, $sn, $un, $pw) {
		// using placeholders
		if ($stmt = $connection->prepare("INSERT INTO users(fname, lname, username, password) VALUES(?,?,?,?);")) { // create a prepare statement
			$stmt->bind_param('ssss', $fn, $sn, $un, $pw); // bind parameters for markers
			$stmt->execute(); // execute query
			$stmt->close(); // close statement
		}
		else
			mysql_fatal_error($conn->error);
		/*
		$query = "INSERT INTO users(fname, lname, username, password) VALUES('$fn', '$sn', '$un', '$pw')";
		$result = $connection->query($query);
		if (!$result) mysql_fatal_error($connection->error);
		*/
	}

	/**
	 * This method adds data to the salt table
	 * @param object $connection is the mysqli object
	 * @param string $salt1 is salt one
	 * @param string $salt2 is salt two
	 */
	function add_salt($connection, $salt1, $salt2) {
		$query = "INSERT INTO salt(salt1, salt2) VALUES('$salt1', '$salt2')";
		$result = $connection->query($query);
		if (!$result) mysql_fatal_error($connection->error);
	}
?>