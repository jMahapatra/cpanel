<?php
// include this at the top of page
session_start();
$username = $_SESSION['username'];
if(!$_SESSION['username'])
{
	header("location:../../login");
}
?>