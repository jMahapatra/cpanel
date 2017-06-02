<?php
	session_start();
	session_unset();
	session_destroy();
	header("refresh:3;url=Login.php");
	die("You are Successfully logged out . . . . . ");
?>