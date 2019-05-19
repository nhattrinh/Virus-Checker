<?php
	/**
	 * This method first starts a session and further authenticate users by checking if the stored IP address matches the current one.
	 * Otherwise, destroy session and data. 
	 * Else if the IP address matches the current one then check if $_SESSION is set
	 *  If $_SESSION is set then go to infected_file.php if $current_page !== 'infected_file.php'
	 * Else if $_SESSION is set and if $current_page === 'infected_file.php' then do nothing
	 * Else destroy session
	 */
	function verify_session($current_page) 
	{
		session_start();

		// prevent session hijacking
		if (different_user()) {
			destroy_session_and_data();
			echo '<script> alert("Log in again due to a technical error."); window.location = "index.php"; </script>';
		}
		else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $current_page !== 'infected_file.php') {
			header('Location: infected_file.php');
			exit;
		}
		else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $current_page === 'infected_file.php') {
			// do nothing
		}
		else if ((!isset($_SESSION['user']) || !isset($_SESSION['admin'])) && $current_page === 'infected_file.php') {
			header('Location: index.php');
		}		
		else
			session_destroy();
	}

	/**
	 * This method deletes the current session and asks the user to log in again due to a
	 * technical error. Don’t say any more than that, or you’re giving away potentially useful
	 * information.
	 */
	function different_user() {
		// prevent session hijacking
		if(isset($_SESSION['ip']) && isset($_SERVER['REMOTE_ADDR']) && isset($_SESSION['ua']) && isset($_SERVER['HTTP_USER_AGENT']) && 
		   isset($_SESSION['check']) && isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_USER_AGENT'])) {
			if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT'] ||  
				$_SESSION['check'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']))
				return true;
		}
		
		return false;
	}

	/**
	 * This method destroys a session, logging a user out, and unsetting all session variables.
	 */
	function destroy_session_and_data() {
		$_SESSION = array();
		setcookie(session_name(), '', time() - 2592000, '/');
		session_destroy();
		header('Location: index.php');
	}
?>