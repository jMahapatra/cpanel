<?php
session_start();
$temp_un = $_SESSION['tmp_un'];
include("../_cp/require/connection.inc.php");
include("../_cp/require/timezone.inc.php");
include("../_cp/require/common.inc.php");
include("../_cp/require/functions.inc.php");
if(!isset($_GET['type']))
	{
	session_destroy();
	die("invalid action on this page. ");	
	}
if(empty($temp_un))
	{
	if(isset($_GET['user']) && !empty($_GET['user']) && isset($_GET['token']) && !empty($_GET['token']))
		{
		$temp_un = $_GET['user'];
		$tokenid = $_GET['token'];
		mysql_query("UPDATE `login_token` SET `LT_Viewed` = '1' AND `LT_ViewedOn` = '$dt_time' WHERE `LT_UserNm` = '$temp_un' AND `LT_TokenID` = '$tokenid' AND `LT_Viewed` = '0'") or die(mysql_error());
		$res_token = mysql_query("SELECT * FROM `login_token` WHERE `LT_UserNm` = '$temp_un' AND `LT_TokenID` = '$tokenid' AND LT_For = 'PASSWORD_RESET'") or die(mysql_error());
		if(mysql_num_rows($res_token) == 0)
			{
			session_destroy();
			die("invalid token type. Please Check The Link Or Contact The Admin. ");
			}
		$row_token = mysql_fetch_array($res_token);
		if($row_token['LT_Used'] == 1)
			{
			session_destroy();
			die("You Have Already Used This Token. You Can't Use A Token For More Than Once.");
			}
		}
	else
		{
		session_destroy();
		die("invalid action on this page. ");	
		}
	}
if(isset($_POST['BTN_Submit_ChangePassword']))
	{
	$newpwd = isset($_POST['PWD_NewPassword']) ? $_POST['PWD_NewPassword'] : "";
	$confpwd = isset($_POST['PWD_ConfPassword']) ? $_POST['PWD_ConfPassword'] : "";
	if(!empty($newpwd) && !empty($confpwd))
		{
		if($newpwd == $confpwd)
			{
			$enc_pwd = password_encrypt($newpwd);
			mysql_query("UPDATE `login_info` SET `LI_Password` = '$enc_pwd', `LI_PwdChangedOn` = '$dt_time' WHERE `LI_UserName` = '$temp_un'") or die(mysql_error());
			if($_GET['type'] == 'email')
				{
				mysql_query("UPDATE `login_token` SET `LT_Used` = '1', `LT_UsedOn` = '$dt_time' WHERE `LT_UserNm` ='$temp_un' AND `LT_TokenID` = '$tokenid'") or die(mysql_error());
				}
			session_unset();
			session_destroy();
			header("location:post_success.php?type=pswdchange");
			}
		else
			{
			$error[] = "Both Passwords Not Matched. ";
			}
		}
	else
		{
		if(empty($newpwd))
			{
			$error[] = "Please Enter New Password";	
			}
		if(empty($confpwd))
			{
			$error[] = "Please Confirm Your Password";		
			}
		}
	}
if(isset($_POST['BTN_Cancel_ChangePassword']))
	{
	session_unset();
	session_destroy();
	header("location:Login.php");	
	}
foreach($error as $i)
	{
	$error_msg .= $i."<br />";
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
            <p class="text-muted text-center">Change your Password</p>
              <input type="password" placeholder="Type your new Password" name="PWD_NewPassword" id="PWD_NewPassword" class="form-control">
            <input type="password" placeholder="Re-Type Password" name="PWD_ConfPassword" id="PWD_ConfPassword"  class="form-control">
              <input type="submit" class="btn btn-lg btn-primary btn-block" id="BTN_Submit_ChangePassword" name="BTN_Submit_ChangePassword"
                 value="Next" />
               <input type="submit" class="btn btn-lg btn-metis-3 btn-block" id="BTN_Cancel_ChangePassword" name="BTN_Cancel_ChangePassword"
                 value="Back to Login" />
                
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
