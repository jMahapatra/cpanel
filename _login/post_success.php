<?php
ob_start();
include("../_connection/connection.php");
include("../_include/functions.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aarayan Gurukul</title>
</head>

<body>
<?php
if($_GET['type'] == 'pswdchange')
	{
	header("refresh:5;url=Login.php");
	echo "Your Password Has Been Changed Successfully. <a href='login.php'>Click Here</a> If You Are Not Directed To Login Page In Few Seconds.";
	}
?>
</body>
</html>
<?php
ob_flush();
?>