<?php
ob_start();
include("../_cp/require/connection.inc.php");
include("../_cp/require/timezone.inc.php");
include("../_cp/require/common.inc.php");
include("../_cp/require/functions.inc.php");
if(isset($_POST['BTN_Submit_RecoverPswd']))
	{
	$usernm = isset($_POST['TXT_UserName']) ? $_POST['TXT_UserName'] : "";
	if(!empty($usernm))
		{
		$res_login = mysql_query("SELECT * FROM `login_info` WHERE `LI_UserName` = '$usernm'");
		if(mysql_num_rows($res_login) > 0 )
			{
			$row_login = mysql_fetch_array($res_login);
			if($row_login['LI_IsLocked'] == 0)
				{
				session_start();
				$_SESSION['tmp_un'] = $usernm;
				header("location:Login_RecoverPswd2.php");
				}
			elseif($row_login['LI_IsLocked'] == 1)
				{
				$res_check = mysql_query("SELECT hour(timediff(now(), `LI_LockedDate`)) as timediff FROM `login_info` WHERE `LI_UserName` = '$usernm'");
				$row_check = mysql_fetch_array($res_check);
				if($row_check['timediff'] < 24 )
					{
					$loginafter = 24 - $row_check['timediff'];
					$error[] = "Your Account Was Locked For 24 Hours After 3 Wrong Password Attempt. ";
					$error[] = "You Can Change Password After $loginafter Hours. ";
					}
				elseif($row_check['timediff'] >= 24)
					{
					mysql_query("UPDATE `login_info` SET `LI_IsLocked` = '0', `LI_LockedDate` = '$nul_date', `LI_PwdTracker` = '0' WHERE `LI_UserName` = '$usernm'");
					$error[] = "Your Account Is Now Unlocked. Please Try Again. ";	
					}
				}
			}
		else
			{
			$error[] = "Please Enter A Valid Username. ";
			}
		}
	else
		{
		$error[] = "Please Enter A Username.";
		}
	}
if(isset($_POST['BTN_Cancel_RecoverPswd']))
	{
	header("location:Login.php");
	}
foreach($error as $i)
	{
	$error_msg .= $i."<br />";
	}
	if(isset($_POST['BTN_Cancel_RecoverPswd2']))
	{
	session_unset();
	session_destroy();
	header("location:Login.php");
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
    <div class="text-center"><img src="../assets/img/logo.png" alt="Metis Logo"></div>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form action="" method="post" name="" class="form-signin" id="form1">
              <p class="text-muted text-center">
                    Enter your username
                </p>
                <input type="text" placeholder="Username" name="TXT_UserName" value="<?php echo $_POST['TXT_UserName']; ?>" id="TXT_UserName" class="form-control">
                
                <input type="submit" class="btn btn-lg btn-primary btn-block" id="BTN_Submit_RecoverPswd" name="BTN_Submit_RecoverPswd"
                 value="Next" />
                 <input type="submit" class="btn btn-lg btn-metis-3 btn-block" id="BTN_Cancel_RecoverPswd2" name="BTN_Cancel_RecoverPswd2"
                 value="Login" />
                
            </form>
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
    

</div> <!-- /container -->

	      
	      
      <script src="../_cp/assets/lib/bootstrap/js/bootstrap.js"></script>
      
  </body>
</html>
