<?php
	session_start();
	unset($_SESSION['user']);
 	unset($_SESSION['loggedin']);
	 session_destroy();
	 header("location: login.php");
?>