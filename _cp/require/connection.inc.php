<?php
	$conn = mysql_connect("localhost", "root");
	mysql_select_db("cpanel_db", $conn) or die("Connecting to database is failed . . . ");
	$OrganizationName = 'Atreya Webs';

			
/*
$hostname_Conn = "localhost";
$database_Conn = "<database name>";
$username_Conn = "<username>";
$password_Conn = "<password>";
$Conn = mysql_connect($hostname_Conn, $username_Conn, $password_Conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_Conn,$Conn);
*/
?>