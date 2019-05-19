<?php
	/**
	 * This method is a more user-friendly error message on a production server 
	 * compared to the PHP die method 
	 * Example:
	 * if ($conn->connect_error) mysql_fatal_error($conn->connect_error);
	 * @param string $msg is the error message of a mysqli error
	 */
	function mysql_fatal_error($msg) {
		$msg2 = mysql_error();
		echo <<< _END
		We are sorry, but it was not possible to complete
		the requested task. The error message we got was:
		<p>$msg: $msg2</p>
		Please click the back button on your browser
		and try again. If you are still having problems,
		please <a href="mailto:cs174sjsu@gmail.com">email
		our administrator</a>. Thank you.
_END;
}

	/**
	 * This method attempts to prevent cross-site scripting, also known as XSS. 
	 * This type of attack occurs when you allow HTML, or more often JavaScript code, to
	 *  be input by a user and then displayed back by your website.
	 * The htmlentities function prevents XSS injections from occuring. 
	 * Example:
	 * $un = mysql_entities_fix_string($conn, $_POST['user']);
	 * $pw = mysql_entities_fix_string($conn, $_POST['pass']);
	 * $query = "SELECT * FROM users WHERE user='$un' AND pass='$pw’”;
	 * @param object $con is used to access the MySQL database
	 * @param string $string is the user-inputted string
	 */
	function mysql_entities_fix_string($conn, $string) {
		return htmlentities(mysql_fix_string($conn, $string));
	}

	/**
	 * This method will remove any "magic quotes" added to a user-inputted string and then properly sanitize it for you.
	 * This method prevents SQL injections. 
	 * Note: get_magic_quotes_gpc function returns TRUE if magic quotes are active.
	 * Example:
	 * $un = mysql_fix_string($conn, $_POST['user']);
	 * $pw = mysql_fix_string($conn, $_POST['pass']);
	 * $query = "SELECT * FROM users WHERE user='$un' AND pass='$pw’”;
	 * @param object $con is used to access the MySQL database
	 * @param string $string is the user-inputted string
	 */
	function mysql_fix_string($conn, $string) {
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}

?>