<?php
ob_start();
include("../_cp/require/connection.inc.php");
include("../_cp/require/timezone.inc.php");
include("../_cp/require/common.inc.php");
include("../_cp/require/functions.inc.php");

//$mobile = '9040700082';
//echo password_encrypt('admin01!@#');

if(isset($_POST['Btn_Login']))
	{
	$usernm = isset($_POST['TXT_UserNm_Login'])? mysql_real_escape_string($_POST['TXT_UserNm_Login']) : "";
	$password = isset($_POST['PWD_Password_Login']) ? mysql_real_escape_string($_POST['PWD_Password_Login']) : "";
	if(!empty($usernm) && !empty($password))
		{
		$res_login = mysql_query("SELECT * FROM `login_info` WHERE `LI_UserName` = '$usernm'") or die(mysql_error());
		if(mysql_num_rows($res_login) > 0)
			{
			$txt_usernm = $_POST['TXT_UserNm_Login'];
			$row_login = mysql_fetch_array($res_login);
			$enc_pswd = password_encrypt($password);
			$userid = $row_login['LI_ID'];
			$res_status = mysql_query("SELECT * FROM `login_status` WHERE `LS_UserID` = '$userid'");
			$row_status = mysql_fetch_array($res_status);
			if($row_login['LI_PwdTracker'] != 3)
				{
				if($row_status['LS_TypeID'] == 1)
					{
					if($row_login['LI_Password'] == $enc_pswd)
						{
						mysql_query("UPDATE `login_info` SET `LI_PwdTracker` = '0', LI_LastLogin = '$dt_time' WHERE `LI_UserName` = '$usernm'");
						session_start();
						$res_role = mysql_query("SELECT * FROM `login_role` WHERE `LR_ID` = '".$row_login['LI_Role']."'");
						$row_role = mysql_fetch_array($res_role);
						$_SESSION['username'] = $usernm;
						$_SESSION['role'] = $row_role['LR_Name'];
						$_SESSION['lastLogin'] = $row_login['LI_LastLogin'];
						switch($row_role['LR_Name'])
							{
							case "Admin": header("location:../_cp/index.php");break;
							case "SuperAdmin": header("location:../_cp/index.php");break;
							default : 
								{
								session_unset();
								session_destroy();
								header("location:".$_SERVER['PHP_SELF']."?fault=NoPage");
								}
							}
						}
					else
						{
						$wrong_attempt = $row_login['LI_PwdTracker'];
						$wrong_attempt++;
						mysql_query("UPDATE `login_info` SET `LI_PwdTracker` = '$wrong_attempt' WHERE `LI_ID` = '$userid'") or die(mysql_error());
						if($wrong_attempt == 2)
							{
							mysql_query("UPDATE `login_status` SET LS_TypeID = '2', LS_Time = '$dt_time' WHERE `LS_UserID` = '$userid'");
							}
						$error[] = "You Have ".(3 - $wrong_attempt)." Tries Left To Enter Your Correct Password. ";
						}
					}
				else
					{
					if($row_status['LS_TypeID'] == 2)
						{	
						$res_check = mysql_query("SELECT hour(timediff(now(), `LS_Time`)) as timediff FROM login_status WHERE `LS_UserID` = '$userid'");
						$row_check = mysql_fetch_array($res_check);
						if($row_check['timediff'] < 24 )
							{
							$loginafter = 24 - $row_check['timediff'];
							$error[] = "Your Account Was Locked. ";
							$error[] = "You Can Login After $loginafter Hours. ";
							}
						elseif($row_check['timediff'] >= 24)
							{
							mysql_query("UPDATE `login_info` SET `LI_PwdTracker` = '0' WHERE `LI_ID` = '$userid'");
							mysql_query("UPDATE `login_status` SET LS_TypeID = '1', LS_Time = '$dt_time' WHERE `LS_UserID` = '$userid'");
							$error[] = "Your Account Is Now Unlocked. Please Enter Login Details Again. ";	
							}
						}
					elseif($row_status['LS_TypeID'] == 3)
						{
						$error[] = "Your Account Is Suspended. Please Contact Your Admin.";
						}
					elseif($row_status['LS_TypeID'] == 4)
						{
						$error[] = "This Is A Closed Account. You Can No more Access It. ";
						}
					elseif($row_status['LS_TypeID'] == 5)
						{
						$error[] = "This Is Account Was Terminated On ".change_date($row_status['LS_Time']);
						}
					}
				}
			}
			else
				{
				$error[] = "Please Enter A Valid User Name.";
				}
		}
		else
			{
			if(empty($usernm))
				{
				$error[] = "Please Enter Username. ";
				}
			if(empty($password))
				{
				$error[] = "Please Enter Password. ";
				}
			}
	}
if(isset($_GET['fault']) && $_GET['fault'] == "NoPage")
	{
	$error[] = "No Page Found For Your Role. Contact The Admin. ";
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
        <meta name="msapplication-TileColor" content="#5bc0de"/>
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png"/>
        
    <link rel="stylesheet" href="../_cp/assets/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../_cp/assets/css/main.css">
    <link rel="stylesheet" href="../_cp/assets/lib/magic/magic.css">
  </head>
  <body class="login">

	      
<div class="container">
    <div class="text-center">
        <img src="../_cp/assets/img/logo2.png" alt="Logo">
    </div>
    <div class="text-center"></div>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form action="" method="post" name="" class="form-signin" id="form1">
                <p class="text-muted text-center">
                    Enter your username and password
                </p>
                <input type="text" placeholder="Username" name="TXT_UserNm_Login" id="TXT_UserNm_Login" class="form-control">
                <input type="password" placeholder="Password" name="PWD_Password_Login" id="PWD_Password_Login" class="form-control">
                <input type="submit" class="btn btn-lg btn-primary btn-block" id="Btn_Login" name="Btn_Login"
                 value="Login" />
            </form>
            <ul class="list-inline text-center">
              <li><a class="text-muted" href="Login_RecoverPswd1.php" data-toggle="tab">Forgot Password ?</a></li>
            </ul>
        </div>
        
    </div>
    <div class="text-center">
    <?php
		if(!empty($error))
		{
	?>
    <div class="" style="margin-top: 50px;">
        <div class="error label label-danger fa fa-2x" style=" font-size: 14px; margin: 35px; padding: 15px;"><?php echo implode("<br />", $error); ?>
        </div>
    </div>
    <?php
		}
	?>
    </div>
    <div class="text-center"></div>


</div> <!-- /container -->

	      
	      
      <script src="../_cp/assets/lib/bootstrap/js/bootstrap.js"></script>
      
  </body>
</html>
