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
	require_once 'verify_session.php';
	require_once 'login.php';

	//Sanitize inputs
	function sanitize($input){
		return htmlentities(strip_tags(stripslashes($input)));
	}

	//Alert function
	function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	verify_session(basename(__FILE__));

	if (isset($_POST['email']) && isset($_POST['password'])) {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) mysqli_error($conn);

		$un = sanitize($_POST['email']);
		$pw = sanitize($_POST['password']);

		if (users_table($conn, $un, $pw) === false) admin_table($conn, $un, $pw);
		$conn->close();
	}

	function users_table($conn, $un, $pw){
		if ($result = $conn->prepare("SELECT fname, password, salt1, salt2 FROM users NATURAL JOIN salt WHERE username=?;")) {
			$result->bind_param('s', $un);
			$result->execute();
			$result->store_result();
		}else{
			mysqli_error($conn);

			if ($result->num_rows == 1) {
				$result->bind_result($fn, $db_pw, $s1, $s2);
				$result->fetch();

				$salt1 = $s1;
				$salt2 = $s2;
				$token = hash('md5', "$salt1$pw$salt2");

				if ($token === $db_pw) {
					session_start();

					$_SESSION['user'] = 1;
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

					alert("Hi: '. $fn . ', you are now logged in as '. $un . '");
					header("location: infected_file.php");
				}else{
					alert("Invalid username/password combination");
					header("location: authenticate.php");
				}
			}else{
				return false;
			}
			$result->close();
		}
	}

	function admin_table($conn, $un, $pw){
		if ($result = $conn->prepare("SELECT fname, password, salt1, salt2 FROM admin WHERE username=?;")) {
			$result->bind_param('s', $un);
			$result->execute();
			$result->store_result()
		}else{
			mysqli_error($conn);

			if ($result->num_rows == 1) {
				$result->bind_result($fn, $db_pw, $s1, $s2);
				$result->fetch();
				$salt1 = $s1;
				$salt2 = $s2;
				$token = hash('md5', "$salt1$pw$salt2");

				if ($token === $db_pw) {
					session_start();
					$_SESSION['admin'] = 1;
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['check'] = hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
					alert("Hi, admin: '. $fn . ', you are now logged in as '. $un . '");
					header("location: infected_file.php");
				}else{
					alert("Invalid username/password combination");
					header("location: authenticate.php");
				}

			}else{
				alert("Invalid username/password combination");
				header("location: authenticate.php");
			}

			$result->close();
		}
	}
?>
