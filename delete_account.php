<!-- HTML Login Form -->
<!DOCTYPE html>
<html>
	<head>
		<title>Delete Account</title>
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
	<p class="h4 mb-4">Delete Account</p>
		<input name="email" type="email" placeholder="email" required="" class="form-control mb-4"/>
		<input name="password" type="password" placeholder="password"  required="" class="form-control mb-4"/>
		<button type="submit" formaction="delete_account.php" class="btn btn-outline-danger btn-block my-4">Delete</button>
	<form>
	</div>
	</center>
</html>


<?php
	require_once "db_login.php";
	require_once "session_verification.php";

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

		if ($res = $conn->prepare("SELECT id, fname, lname, username, password, salt1, salt2 FROM users NATURAL JOIN salt WHERE username=?;")) {
			$res->bind_param('s', $user);
			$res->execute();
			$res->store_result();
		}else {
			mysqli_error($conn->error);
		}


		if ($res->num_rows == 1) {
			$res->bind_result($id, $fn, $sn, $user, $database_pass, $s1, $s2);
			$res->fetch();

			$salt1 = $s1;
			$salt2 = $s2;
			$hash = hash('md5', "$salt1$pass$salt2");

			if ($hash === $database_pass) {
				if ($old_user = $conn->prepare("DELETE FROM users WHERE id=?")) {
					if($old_salt = $conn->prepare("DELETE FROM salt WHERE id=?")) {
						$old_user->bind_param('i', $id);
						$old_user->execute();
						$old_user->close();
						$old_salt->bind_param('i', $id);
						$old_salt->execute();
						$old_salt->close();
					} else mysqli_error($conn->error);
				} else mysqli_error($conn->error);

				echo
				'<script>
					alert("You just deleted your account!");
					window.location = "index.php";
				</script>';
			} else {
				echo '<script> alert("Incorrect username or password. Try again."); window.location = "delete_account.php"; </script>';
			}
		} else {
			echo '<script> alert("Incorrect username or password. Try again."); window.location = "delete_account.php"; </script>';
		}
		$res->close();
		$conn->close();
	}
?>
