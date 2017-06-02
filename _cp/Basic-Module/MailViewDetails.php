<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");

$m_id=(isset($_GET['mailID'])) ? $_GET['mailID']: '';//get the complain ID and store

$res_complaint = mysql_query("SELECT * FROM `contact_mail_us` WHERE `m_id` = '$m_id'");
$row_complaint = mysql_fetch_array($res_complaint);

$comlpaint_sender = $row_complaint['M_Sender'];
$host_mail = 'ganjamlawcollege@gmail.com';
$sender_email = $row_complaint['M_EmailID'];
$comlpaint_subject = $row_complaint['M_Subject'];
$comlpaint_details = $row_complaint['M_Message'];
$complaint_Date = $row_complaint['M_SentDt'];



//This will work if REPLY button is pressed
if(isset($_POST['BTN_Reply_Suggestion']))
{
			//set the error message if message reply text is blank
	if(empty($_POST['MTXT_Reply']))	$error[]="Must Enter Some Text To Reply";
			//check wheater error message is blank or not if not blank than set the messaeg to a variable
	if(!empty($error))	
	{
		foreach($error as $i)
		{
			$msg .= $i."<br />";	
		}
	}
			//if there is no error message than send the mail
			else//if error is empty
			{	
				$name = '';
				$reply_text = htmlentities($_POST['MTXT_Reply'], ENT_QUOTES, "utf-8");
				//$solved_status=$_POST['LST_Message_Status'];
				$subject = "Reply To Your Mail";
				$mail_body = "Dear ".$comlpaint_sender.",<br /><br />";
				//$mail_body .= "You sent a Mail dated ".$complaint_Date."<br />";
				//$mail_body .= "The detail of the Mail is given below.<br /><br />";
				$mail_body .= html_entity_decode($reply_text, ENT_QUOTES, 'utf-8');
				$mail_body .= "The actual mail sent by you on ".$complaint_Date."<br >";
				$mail_body .= "<h3>".$comlpaint_subject."</h3>";
				$mail_body .= $comlpaint_details."<br />";
				$mail_body .= "Regards, <br /> Support Team, ". $OrganizationName;
				
				//get the reply text  from text area
				//set the solved message list to a varriable
				//$check_replied=mysql_query("select * from contact_status where CS_C_ID=$complaint_id and CS_CST_ID=4");
				
				//This query written to store the reply details when a reply send
				mysql_query("INSERT INTO `contact_reply` (`CR_C_ID`,`CR_OI_OrganisationID`, `CR_ReplyDetails`,`CR_ReplyCategory`, R_ReplyDt) VALUES ('$m_id','0', '$reply_text' , 'MAIL', '$dt_time')") or die(mysql_error());

				//this query written to store the reply status of a complain into  contact_status table when a reply send 		
				mysql_query("UPDATE `contact_mail_us` set `M_Replied`=1 where `M_ID`='$m_id'") or die(mysql_error()); 
				//mysql_query("UPDATE `contact_mail_us` set `M_ReplyDt`=now() where `M_ID`='$m_id'") or die(mysql_error());				
				###############
				send_mail($name, $sender_email, $host_mail, $subject, $mail_body);//this function use to send the mail
			}	###############
		}



// All Query Strings Fetched Here. 
		?>

		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Admin C-Panel</title>

			<link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.css">
			<link rel="stylesheet" href="../assets/css/main.css"/>
			<!-- Font Awesome -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

			<link rel="stylesheet" href="../assets/css/theme.css">


			<link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">

			<link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
			<link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css">
			<link rel="stylesheet" href="../assets/lib/CLEditor1_4_3/jquery.cleditor.css">
			<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
			<link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css">
			<link rel="stylesheet" href="../assets/css/custom.css">


			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', 'UA-1669764-16', 'onokumus.com');
				ga('send', 'pageview');

			</script>

			<script src="../assets/lib/modernizr-build.min.js"></script>

		</head>

		<body>




			<div id="wrap">


				<div id="top">
					<!-- .navbar -->
					<nav class="navbar navbar-inverse navbar-static-top">
						<!-- Brand and toggle get grouped for better mobile display -->
						<?php
						include("../require/notifications.inc.php");
						?>






						<!-- /.topnav -->
					</nav>
					<!-- /.navbar -->

					<!-- header.head -->
					<header class="head">

						<div class="search-bar">
							<a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
								<i class="fa fa-resize-full"></i>
							</a>


						</div>
						<!-- ."main-bar -->
						<div class="main-bar">
							<h3><i class="fa fa-inbox"></i> Mail(s)</h3>
						</div>
						<!-- /.main-bar -->
					</header>
					<!-- end header.head -->


				</div>
				<!-- /#top -->

				<?php
				include("../require/leftframe.inc.php");
				?>
				<!-- /#left -->
<div id="content">
	<div class="outer">
		<div class="inner">
			<div class="row">
				<div class="col-lg-12">
				</div>
				<div class="col-md-7">
					<div class="box" style="border:0px">
					<?PHP
					$check_read=mysql_query("select * from `contact_mail_us` where `M_ID` = '$m_id' and `M_Viewed`= 1") or die(mysql_error());
					if(mysql_num_rows($check_read)==0)
					{
						mysql_query("UPDATE `contact_mail_us` set `M_Viewed`=1, `M_ViewedDt`=now(), `M_ViewedBy`='".$_SESSION['username']."'
							where M_ID='$m_id'") or die(mysql_error());
					}


					$check_read=mysql_query("select * from contact_mail_us where M_ID=$m_id and `M_Replied`=1") or die(mysql_error());
					if(mysql_num_rows($check_read)==0)	{ $reply_status='n';	}

					$result=mysql_query("select * from contact_mail_us where M_ID='$m_id'") or die(mysql_error());
					$rows=mysql_fetch_array($result);
					?>
					<header class="dark">
						<div class="icons"><a href="MailViewList.php" class="text-danger"><i class="fa fa-inbox"></i> Inbox</a></div>
						<h5><?php echo '<a href="mailto:'.$rows['M_EmailID'].'">(By:  <strong>'.ucwords($rows['M_Sender']).')</a> '.$rows['M_Subject'].'</strong>' ?></h5>
					</header>

					<div style="min-height : 200px;height: auto;" class="body in">
					<?php
						$status_result=mysql_query("select * from contact_mail_us where M_id=$m_id") or die(mysql_error());
						while($status_rows=mysql_fetch_array($status_result))
						{
							if($status_rows['M_Viewed']=="1")
							{
								?>
									<span class="label label-success">Viewed</span>
								<?php
							}
							if($status_rows['M_Replied']=="1")
							{
								?>
									<span class="label label-info">Replied</span>
								<?php
							}
						}
					?>
						<br/><br/>
						Message : <br>
						<?php echo html_entity_decode($rows['M_Message'], ENT_QUOTES, "utf-8"); ?> 
					</div>
					<?php
						$result_complain=mysql_query("select * from `contact_mail_us` where`M_ID` =$m_id") or die(mysql_error());
						while($rows_complain=mysql_fetch_array($result_complain))
						{
							$SenderNm=$rows_complain['M_Sender'];
							$EmailID=$rows_complain['M_EmailID'];
							$Subject=$rows_complain['M_Subject'];
							$viewed_by=$rows_complain['M_ViewedBy'];

						}
						$result_reply=mysql_query("select * from `contact_reply` where CR_C_ID=$m_id AND CR_ReplyCategory='MAIL' ") or die(mysql_error());
						if(mysql_num_rows($result_reply) > 0)
						{

							?>
							<header class="dark">
								<h5><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Earlier Activities</h5>
							</header>
							<div class="body" style="font-size: 12px">
								<?php

								while($rows_status=mysql_fetch_array($result_reply))
								{
									$ReplyDetails[] =$rows_status['CR_ReplyDetails'];
									$replyDt[] = $rows_status['R_ReplyDt'];
								  //echo $ReplyDetails ;
								}
								foreach($ReplyDetails as $i=> $j )	
								{
									?>
									<div class="body">
										<a href="mailto:<?PHP echo $EmailID; ?>"><?php echo $EmailID; ?></a>
										<span class="text-primary pull-right"><?php echo $replyDt[$i]; ?></span>
										<span><?php echo html_entity_decode($ReplyDetails[$i], ENT_QUOTES, "utf-8"); ?></span>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-5">
					<div class="box" style="border:0px">
						<header class="dark">
							<h5><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply To This Message</h5>
						</header>

						<div class="body in">
							<form method="post">

								<textarea name="MTXT_Reply" id="MTXT_Reply"></textarea>
								<br />

								<div class="form-actions no-margin-bottom" id="cleditorForm">
									<input type="submit" name="BTN_Reply_Suggestion" id="BTN_Reply_Suggestion" value="Reply Now" class="btn btn-primary" />
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- end .inner -->
	</div>
<!-- end .outer -->
</div>
<!-- end #content -->



</div>
<!-- /#wrap -->


<div id="footer">
	<p>&nbsp;</p>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 




<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

<script src="../assets/lib/jquery-1.9.1.min.js"></script>
<script src="../assets/lib/ckeditor/ckeditor.js"></script>
<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
<script src="../assets/js/main.js"></script>

<script>
	$(function() {
            // Bootstrap
            $( 'textarea#MTXT_Reply' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', /*'NewPage',*/ 'Preview', '-'/*, 'Templates' */] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				['NumberedList', 'BulletedList'],
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-'/*, 'Undo', 'Redo'*/ ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
				]});
           // $( 'textarea#ckeditor_full' ).ckeditor({width:'99.6%', height: '350px'});
       });

        // Tiny MCE


    </script>  



    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>



</body>
</html>