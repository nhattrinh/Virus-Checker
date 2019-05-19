<?php
	function mysql_fatal_error($msg) {
		$msg2 = mysql_error();
		echo <<< _END
		Your requested task completed with an error. The error message was:
		<p>$msg: $msg2</p>
		Click the back button or go back to our homepage.
_END;
}
	function mysql_entities_fix_string($conn, $string) {
		return htmlentities(mysql_fix_string($conn, $string));
	}

	function mysql_fix_string($conn, $string) {
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}
?>