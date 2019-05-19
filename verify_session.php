<?php
	function verify_session($current_page) 
	{
		session_start();

		if (isDifferentUser()) {
			destroySession();
			echo '<script> alert("Please log in again."); window.location = "index.php"; </script>';
		} else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $current_page !== 'infected_file.php') {
			header('Location: infected_file.php');
			exit;
		}
		else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $current_page === 'infected_file.php') {
		} else if ((!isset($_SESSION['user']) || !isset($_SESSION['admin'])) && $current_page === 'infected_file.php') {
			header('Location: index.php');
		} else {
			session_destroy();
		}
	}

	function isDifferentUser() {
		if(isset($_SESSION['ip']) && isset($_SERVER['REMOTE_ADDR']) && isset($_SESSION['ua']) && isset($_SERVER['HTTP_USER_AGENT']) && 
		   isset($_SESSION['check']) && isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_USER_AGENT'])) {
			if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT'] ||  
				$_SESSION['check'] != hash('md5', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']))
				return true;
		}
		return false;
	}

	function destroySession() {
		$_SESSION = array();
		setcookie(session_name(), '', time() - 2592000, '/');
		session_destroy();
		header('Location: index.php');
	}
?>