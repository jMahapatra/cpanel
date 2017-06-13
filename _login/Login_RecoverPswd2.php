<?php
session_start();
$temp_un = $_SESSION['tmp_un'];
include("../_cp/require/connection.inc.php");
include("../_cp/require/timezone.inc.php");
include("../_cp/require/common.inc.php");
include("../_cp/require/functions.inc.php");
if(empty($temp_un))
	{
	session_unset();
	session_destroy();
	header("refresh:2;url=index.php");
	die("Ilegal Access To Page.");	
	}
$res_changepwd = mysql_query("SELECT * FROM `login_info` WHERE `LI_UserName` = '$temp_un'");
$row_changepwd = mysql_fetch_array($res_changepwd);
$email = $row_changepwd['LI_Email'];
$secque = $row_changepwd['LI_SecQue'];
$len = strlen(strstr($email, '@'))-3;
for($i =0;$i<$len; $i++)
	{
	$replace .= '*'; 
	}
$new_email = substr_replace($email, $replace, 1, $len);
if(isset($_POST['BTN_Submit_RecoverPswd2']))
	{
	$ans = $_POST['TXT_Answer'];
	if($row_changepwd['LI_IsLocked'] == 0)
		{
		if($_POST['RBL_ResetOption'] == "Email")
			{
			if(!filter_var($ans, FILTER_VALIDATE_EMAIL))
				{
				$error[] = "Email ID Invalid. ";	
				}
			elseif($ans == $row_changepwd['LI_Email'])
				{
				$to = $row_changepwd['LI_Email'];
				$tokenid = md5(time());
				$desc[] = "You Have Requested A Password Reset at ".change_date($dt_time);
				$desc[] = "Please Follow The Link To Change Your Password. ";
				$desc[] = "<a href=\"www.mahaveerbuilders.com/Login_ChangePassword.php?type=email&user=".$temp_un."&token=".$tokenid."\">Click Here</a> To Reset Your Password. ";
				$desc[] = "Thank You. <br /><br/ > <strong> Admin </strong>";
				$subject = "Password Recovery";
				$mail_body = join("\r\n<br/ >", $desc);
				mysql_query("INSERT INTO `login_token` (`LT_TokenID`, `LT_For`, `LT_UserNm`, `LT_CreatedOn`, `LT_Viewed`, `LT_ViewedOn`, `LT_Used`, `LT_UsedOn`) VALUES ('$tokenid', 'PASSWORD_RESET', '$temp_un', '$dt_time', '0', '$nul_date', '0', '$nul_date')") or die(mysql_error());
				send_mail($to, $from = 'sales@gapsprojects.com', $subject, $mail_body);
				header("location:index.html");
				}
			else
				{
				$wrong_attempt = $row_changepwd['LI_PwdTracker'];
				$wrong_attempt++;
				if($wrong_attempt == 3)
					{
					mysql_query("UPDATE `login_info` SET `LI_IsLocked` = '1', `LI_LockedDate` = '$dt_time', `LI_PwdTracker` = '$wrong_attempt' WHERE `LI_UserName` = '$temp_un'");
					$error[] = "You Exceeded 3 Tries. Your Account Is Locked For 24 Hours.";
					}
				else
					{
					mysql_query("UPDATE `login_info` SET `LI_PwdTracker` = '$wrong_attempt' WHERE `LI_UserName` = '$temp_un'");	
					$error[] = "Email ID Not Matched. ";
					}
				}
			}
		elseif($_POST['RBL_ResetOption'] == "SecAns")
			{
			if($ans == $row_changepwd['LI_SecAns'])
				{
				header("location:Login_ChangePassword.php?type=secque");
				}
			else
				{
				$wrong_attempt = $row_changepwd['LI_PwdTracker'];
				$wrong_attempt++;
				if($wrong_attempt == 3)
					{
					mysql_query("UPDATE `login_info` SET `LI_IsLocked` = '1', `LI_LockedDate` = '$dt_time', `LI_PwdTracker` = '$wrong_attempt' WHERE `LI_UserName` = '$temp_un'");
					$error[] = "You Exceeded 3 Tries. Your Account Is Locked For 24 Hours.";
					}
				else
					{
					mysql_query("UPDATE `login_info` SET `LI_PwdTracker` = '$wrong_attempt' WHERE `LI_UserName` = '$temp_un'");	
					$error[] = "Security Answer Not matched. ";
					}
				}	
			}
		}
	else
		{
		$res_check = mysql_query("SELECT hour(timediff(now(), `LI_LockedDate`)) as timediff FROM `login_info` WHERE `LI_UserName` = '$temp_un'");
		$row_check = mysql_fetch_array($res_check);
		if($row_check['timediff'] < 24 )
			{
			$loginafter = 24 - $row_check['timediff'];
			$error[] = "Your Account Was Locked For 24 Hours After 3 Wrong Password Attempt. ";
			$error[] = "You Can Try Changing Password After $loginafter Hours. ";
			}
		elseif($row_check['timediff'] >= 24)
			{
			mysql_query("UPDATE `login_info` SET `LI_IsLocked` = '0', `LI_LockedDate` = '$nul_date', `LI_PwdTracker` = '0' WHERE `LI_UserName` = '$temp_un'");
			$error[] = "Your Account Is Now Unlocked. Please Try Again. ";	
			}	
		}
	}
if(isset($_POST['BTN_Cancel_RecoverPswd2']))
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
    <div class="tab-content row">
        <div id="login" class="tab-pane active">
            <form action="" method="post" name="" class="form-signin" id="form1">
              <p class="text-muted text-center">
                    Choose Method
                </p>
                <table width="100%" border="0" align="center" cellpadding="5" class="table-bordered" style="background-color: #FFF; margin: 10px auto">
                  <tr>
                    <td align="left" valign="middle"><label>
                      <input type="radio" name="RBL_ResetOption" value="Email"<?php
            if($_POST['RBL_ResetOption'] == "Email")
				echo "checked ='checked'";
			?> id="RBL_ResetOption_0" onclick="form.submit()" 
			
			/>
                    </label>
                      Enter Your Email</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"><label>
                      <input type="radio" name="RBL_ResetOption" <?php
            if($_POST['RBL_ResetOption'] == "SecAns")
				echo "checked ='checked'";
			?> value="SecAns" id="RBL_ResetOption_1" onclick="form.submit()"
           
            />
                    </label>
Give Security Answer</td>
                  </tr>
                </table>
                <p class="text-muted text-center">
                <?php
  if(isset($_POST['RBL_ResetOption']))
  	{
  ?>
                    <?php
	 	 if($_POST['RBL_ResetOption'] == "Email") echo $new_email; 
	  	elseif($_POST['RBL_ResetOption'] == "SecAns") echo $secque; 
	  ?>
                </p>
                <input type="text" placeholder="Your Answer" id="TXT_Answer" name="TXT_Answer" class="form-control">
                
                <input type="submit" class="btn btn-lg btn-primary col-lg-6" id="BTN_Submit_RecoverPswd2" name="BTN_Submit_RecoverPswd2"
                 value="Next" /><input type="submit" class="btn btn-lg btn-metis-3  col-lg-6" id="BTN_Cancel_RecoverPswd2" name="BTN_Cancel_RecoverPswd2"
                 value="Back to Login" />
                
            </form>
        </div>
        
    </div>
    <div class="text-center row">
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
	}
	?>
    </div>
</div> <!-- /container -->

	      
	      
      <script src="../_cp/assets/lib/bootstrap/js/bootstrap.js"></script>
      
  </body>
</html>
