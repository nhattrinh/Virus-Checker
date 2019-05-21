<?php

	function destroySessionAndData() {
		$_SESSION = array();
		setcookie(session_name(), '', time() - 2592000, '/');
		session_destroy();
		header('Location: index.php');
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
	
	function verifySession($currentPage) 
	{
		session_start();

		if (isDifferentUser()) {
			destroySessionAndData();
			echo '<script> alert("Log in again due to a technical error."); window.location = "index.php"; </script>';
		} else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $currentPage !== 'file_check.php') {
			header('Location: file_check.php');
			exit;
		} else if ((isset($_SESSION['user']) || isset($_SESSION['admin'])) && $currentPage === 'file_check.php') {
		} else if ((!isset($_SESSION['user']) || !isset($_SESSION['admin'])) && $currentPage === 'file_check.php') {
			header('Location: index.php');
		} else {
			session_destroy();
		}
	}
?>