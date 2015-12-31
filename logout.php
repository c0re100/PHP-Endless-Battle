<?php
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	unset($_SESSION['timeauth']);
	header('Location: index.php');
?>