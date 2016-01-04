<?php
	if(isset($_POST['login'])){
		session_start();
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['timeauth'] = $_POST['TIMEAUTH'];
		header('Location: gmscrn_main.php?action=proc');
	}
?>