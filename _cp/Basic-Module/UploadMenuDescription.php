<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");

$_SESSION['menuNm'] = (isset($_GET['menuNm'])) ? $_GET['menuNm'] : $_SESSION['menuNm'];
if(isset($_GET['menuNm']) && $_GET['menuNm'] == "")
{
	unset($_SESSION['menuNm']);
}
$get_event = $_SESSION['menuNm'];
$event_result = mysql_query("SELECT * FROM `menu_contents` WHERE `MenuName`='$get_event'");
$event_row = mysql_fetch_array($event_result);
	if(isset($_POST['BTN_Upl_EventCont']))
	{
		// Content Position //
		$row_Position = mysql_fetch_array(mysql_query("SELECT `LE_C_Position` FROM `menu_contents_detail` WHERE `LE_C_EventId` = '".$event_row['LE_Slno']."' ORDER BY `LE_C_Position` DESC"));
		
		//Define Variable For Position
		if($row_Position['LE_C_Position']>0 && $row_Position['LE_C_Position']!="")
		{
			$final_Position = $row_Position['LE_C_Position']+1;
		}
		else
		{$final_Position = 1;}
		//End Position
		
		if($_POST['RBTN_EventType'] == "Text")
			{
				$description=htmlentities($_POST['MTXT_EventData'], ENT_QUOTES,"utf-8");
			}
			else if($_POST['RBTN_EventType'] == "Image"  && $_FILES['IMG_event']['name']!='')
			{
				$description = "Content_".$event_row['LE_Slno']."_".time().".jpg";
				upload_image($_FILES['IMG_event'], "../../Upl_Images/TextContent", $description, 400, 300, "yes");
			}
			if(!empty($description))
			{
				//die("INSERT INTO `latest_news_content` (`LE_C_EventId`, `LE_C_Content`, `LE_C_Type`, `LE_C_Status`, `LE_C_Position`) VALUES ('".$event_row['LE_Slno']."', '$description', '".$_POST['RBTN_EventType']."', '1','$final_Position')");
				mysql_query("INSERT INTO `menu_contents_detail` (`LE_C_EventId`, `LE_C_Content`, `LE_C_Type`, `LE_C_Status`, `LE_C_Position`) VALUES ('".$event_row['LE_Slno']."', '$description', '".$_POST['RBTN_EventType']."', '1','$final_Position')") or die(mysql_error());
				//header("location:".$_SERVER['PHP_SELF']);
			}
	}
	
### This command for delete content of a Event ###
if(isset($_GET['delcontid']))
{
	$contDetail = mysql_fetch_array(mysql_query("SELECT * FROM `menu_contents_detail` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'"));
	if($contDetail['LE_C_Type'] == "Image")
	{
		unlink("../../Upl_Images/TextContent/".$contDetail['LE_C_Content']);
	}
	mysql_query("DELETE FROM `menu_contents_detail` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'");
	mysql_query("OPTIMIZE TABLE `menu_contents_detail`");
	header("location:".$_SERVER['PHP_SELF']."?menuNm=".$_GET['menuNm']);
}
##################################################
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
        <link rel="stylesheet" type="text/css" href="../assets/css/sub-menu.css"/>
        
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

        <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css"><link rel="stylesheet" type="text/css" href="../assets/css/custom.css"/>

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
                        <h3><i class="fa fa-plus"></i> Add Menu Content</h3>
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
          <div id="content"><form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="outer">
                  <div class="inner">
                    <div class="row">
                     <div class="col-lg-12">
                       <div class="box">
                         <header class="dark">
                        <div class="icons"><i class="fa fa-file-text-o fa-2x"></i></div>
                        <h5>
                        
                        <select id="SE_MenuName" name="SE_MenuName" class="form-control hidden" onchange="form.submit()">
                                  	<option value="">Select</option>
                                    
                                  </select>
                                  <h5>Upload Menu content</h5>
                                  
                      </header>
                      
                      <?php 
					  if($get_event != "")
					  {
					  ?>
                         <div class="body">
                           
                             <div class="form-group">
                               <label class="control-label col-lg-2">Menu Name:</label>
                               <div class="col-lg-5" style="padding-top: 7px;"><strong><?php echo ucwords($_GET['menuNm']); ?></strong></div>
                             </div>
                             <div class="form-group">
                               <label class="control-label col-lg-2">Post Type</label>
                               <div class="col-lg-5 text-info" style="padding-top: 7px;">
							   <label for="RBTN_EventType1"><input type="radio" name="RBTN_EventType" onclick="document.getElementById('textbox').style.display='block';document.getElementById('image').style.display = 'none'" id="RBTN_EventType1" checked="checked"  value="Text"/>
    Text</label>&nbsp;&nbsp;
    <label for="RBTN_EventType2"><input type="radio" name="RBTN_EventType" onclick="document.getElementById('textbox').style.display='none'; document.getElementById('image').style.display='block'" id="RBTN_EventType2"  value="Image"/>
    Image</label>
                               </div>
                             </div>
                             <div id="textbox">
                              <div class="form-group">
                                <label class="control-label col-lg-2">Content</label>
                                <div class="col-md-10">
                                  <textarea name="MTXT_EventData" id="MTXT_EventData"></textarea>
                                </div>
                              </div>
                            </div>
                            <div id="image" style="display: none">
                              <div class="form-group">
                                <label class="control-label col-lg-2">Select a File</label>
                                <div class="col-lg-10">
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="IMG_event" name="IMG_event" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                           <div class="form-group"> 
                            <label class="control-label col-lg-2"></label>
                            <div class="col-md-3">
                              <input type="submit" name="BTN_Upl_EventCont" id="BTN_Upl_EventCont" value="Save" class="btn btn-primary btn-block" />
                            </div>
                            <div class="col-md-3">
                              <button class="btn btn-warning btn-block" onclick="document.location.href='../index.php'">Cancel</button>
                            </div>
                          </div>
                        </div>
                            
                          
                           <br />
                           <br />
                        	<?php
								$res_eventData = mysql_query("SELECT * FROM `menu_contents_detail` WHERE `LE_C_EventId` = '".$event_row['LE_Slno']."' ORDER BY `LE_C_Position` ASC");
								$btn=0;
								while($row_eventData = mysql_fetch_array($res_eventData))
								{
									
							?>
                    <div class="body">
                        <!--<div style="padding-bottom:40px;" class="col-lg-12" >
                           	<div class="col-lg-1" style="padding-top:5px">POSITION</div>
                            <form name="position" method="get" action="UploadEventDescription.php">
                            <div class="col-lg-1">
                            <input name="TXT_Position" type="text" value="<?php //echo $row_eventData['LE_C_Position']; ?>" size="3" class="form-control" />
                            <input type="hidden" name="HDN_Event" value="<?php //echo $get_event;?>" />
                            <input type="hidden" name="HDN_Curr_Position" value="<?php //echo $row_eventData['LE_C_Position'];?>" />
                            <input type="hidden" name="HDN_Slno" value="<?php //echo $row_eventData['LE_C_Slno'];?>" />
                            	  
                            </div>
                           		<div class="col-lg-1" style="padding-top:0px">
                                <input type="submit" class="form-control" name="BTN_Position_<?php //echo $btn; ?>" onclick="submit_btn(this)"  value="Change" />
<!--<a class="btn-default" style="color:#036;font-weight:bold" href="UploadEventDescription.php?event_id=&curr_position=&slno=
&new_position=">Change</a> 
								</div>
                                </form>
                       		<div class="col-lg-9">&nbsp;</div>
                        </div>-->
                            <div>
                            <div class="col-lg-12" style="text-align:justify;">
                            <table style="width: 100%; margin-bottom: 20px; padding-top: 30px;">
                            <tr>
                            <td>
                              <div class="col-lg-10" >
                           	  <?php
								
									if($row_eventData['LE_C_Type'] == "Text")
									{
										echo html_entity_decode($row_eventData['LE_C_Content'], ENT_QUOTES, "utf-8");
									}
									else if($row_eventData['LE_C_Type'] == "Image")
									{
										?>
                              <img src="../../Upl_Images/TextContent/<?php echo $row_eventData['LE_C_Content']; ?>" class="thumbnail img-responsive" />
                                        <?php
										
									}
								?>
                                
                                </div>
                                <div class="col-lg-2">
                            
                            <a href="UpdateMenu.php?event_id=<?php echo $event_row['LE_Slno']; ?>&amp;contid=<?php echo $row_eventData['LE_C_Slno']."&menuNm=".$_GET['menuNm'] ?>" style="padding-right: 20px;"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            
                            <a href="<?php echo $_SERVER['PHP_SELF']."?delcontid=".$row_eventData['LE_C_Slno']."&menuNm=".$_GET['menuNm'] ?>" onclick="return confirm('It will delete permanently,\n\nAre you sure.. ? ')"><i class="fa fa-times fa-2x text-danger"></i></a>
                            
                            </div></td></tr></table>
                                </div>
                                </div>
                            </div>
                           <?php
						   $btn++;
								}
						   ?>
                         </div>
                         
                         
                        <?php 
					  }
						?> 
                      </div>
                      
                      </div>
                    </div>
                  </div>
                  <!-- end .inner -->
                </div></form>
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
<script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
        <script src="../assets/lib/jquery-1.9.1.min.js"></script>
		<script src="../assets/lib/ckeditor/ckeditor.js"></script>
		<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
        
		<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
		<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
		<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
        <script src="../assets/lib/form/jquery.form.js"></script>
        <script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>

          <script src="../assets/js/main.js"></script>

        <script>
        $(function() {
            // Bootstrap
            $( 'textarea#MTXT_EventData' ).ckeditor({width:'100%', height: '200px', toolbar: [
				    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Blockquote',
            '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items : [ 'Link','Unlink' ] },
            { name: 'styles', items : [ 'FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] },
            { name: 'tools', items : [ 'Maximize'] }
			]});
           /*$( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});*/
        });

        // Tiny MCE
       

        </script>  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>