<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");

$get_event = $_GET['event_id'];
$event_result = mysql_query("SELECT * FROM `latest_news` WHERE `LE_Slno`='$get_event'");
$event_row = mysql_fetch_array($event_result);

##### This Commend for updating Event #####	
	if(isset($_POST['BTN_Upd_Event']))
	{
		$upd_date = date('Y-m-d');	
		$event_heading = htmlentities($_POST['TXT_Event'], ENT_QUOTES,"utf-8");
		$event_date = htmlentities($_POST['TXT_EventDt'], ENT_QUOTES,"utf-8");
		mysql_query("UPDATE `latest_news` SET `LE_NewsCatg` = '".$_POST['SE_NewsCatg']."', `LE_Heading` = '$event_heading', `LE_Date` = '$event_date', `LE_UpdatedDate` = '$upd_date', `LE_UpdatedBy` = 'Admin' WHERE `LE_SlNo` = '".$_GET['event_id']."'") or die(mysql_error());
		
		echo header("location:ListEvents.php");
	}
##################################################
	
### This command for delete content of a Event ###
if(isset($_GET['delcontid']))
{
	$contDetail = mysql_fetch_array(mysql_query("SELECT * FROM `latest_news_content` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'"));
	if($contDetail['LE_C_Type'] == "Image")
	{
		unlink("../../Upl_Images/NewsImage/".$contDetail['LE_C_Content']);
	}
	mysql_query("DELETE FROM `latest_news_content` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'");
	mysql_query("OPTIMIZE TABLE `latest_news_content`");
	header("location:".$_SERVER['PHP_SELF']."?event_id=".$_GET['delcontid']);
}
##################################################

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin C-Panel by Atreyawebs</title>
        
        <link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/main.css"/>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../assets/css/theme.css">

        
        <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" href="../assets/css/custom.css">
        
          <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
<link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css">
<link rel="stylesheet" href="../assets/lib/CLEditor1_4_3/jquery.cleditor.css">
<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
<link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css">
        
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');

</script>
        <script src="../assets/lib/modernizr-build.min.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/lib/calender-picker/epoch_styles.css"/>
<script type="text/javascript" src="../assets/lib/calender-picker/epoch_classes.js"></script>
<script type="text/javascript">
var dp_cal;      
window.onload = function () {
dp_cal = new Epoch('epoch_popup','popup',document.getElementById('TXT_EventDt'));
};
</script>


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
                        <h3><i class="fa fa-newspaper-o"></i> News Updates</h3>
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
                       <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-pencil-square-o fa-2x"></i></div>
                            <h5>Edit News Updates</h5>
                          </header>
                         <div class="body">
                           <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                             <div class="form-group">
                               <div class="col-lg-6">
                                 <input type="text" class="form-control" required="required" name="TXT_Event" value="<?php echo $event_row['LE_Heading'];?>" id="TXT_Event" />
                               </div>
                             </div>
                            <div class="form-group">
                              <div class="col-md-3">
                                <input type="text" class="form-control" value="<?php echo $event_row['LE_Date']; ?>" name="TXT_EventDt" id="TXT_EventDt" required="required" />
                              </div>
                              <div class="col-md-3">
                                <select id="SE_NewsCatg" name="SE_NewsCatg" class="form-control">
                                	<option value="">Select Category</option>
                                  <option value="News" <?php if($event_row['LE_NewsCatg'] == "News") echo 'selected="selected"' ?>>News</option>
                                  <option value="Tender" <?php if($event_row['LE_NewsCatg'] == "Tender") echo 'selected="selected"' ?>>Tender</option>
                                  <option value="updates" <?php if($event_row['LE_NewsCatg'] == "updates") echo 'selected="selected"' ?>>Updates</option>
                                </select>
                              </div>
                            </div>
   					                <div class="form-group">
                              <div class="col-lg-3">
   						                   <input type="submit" name="BTN_Upd_Event" id="BTN_Upl_Event" value="Save" class="btn btn-block btn-primary" />
                              </div>
                              <div class="col-lg-3">
                                <input type="button" onclick="document.location.href='UploadEventDescription.php?event_id=<?php echo $event_row['LE_Slno']; ?>'" class="btn btn-block btn-default" value="Add More Content"/>
                              </div>
                            </div>
                          </form>
                        </div>
                  <hr />
              <?php
								$res_eventData = mysql_query("SELECT * FROM `latest_news_content` WHERE `LE_C_EventId` = '$get_event'");
								
								while($row_eventData = mysql_fetch_array($res_eventData))
								{
								
							?>
                            <div class="body">
                            <a href="EventDetail.php?delcontid=<?php echo $_GET['event_id'] ?>" class="pull-right" onclick="return confirm('It will delete permanently,\n\nAre you sure.. ? ')">
                            <i class="fa fa-times fa-2x text-danger"></i>
                            </a>
                            <a href="UpdateEventContent.php?event_id=<?php echo $_GET['event_id'] ?>&contid=<?php echo $row_eventData['LE_C_Slno']; ?>" class=" pull-right" style="padding-right: 20px;"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                           	  <?php
								
									if($row_eventData['LE_C_Type'] == "Text")
									{
										echo html_entity_decode($row_eventData['LE_C_Content'], ENT_QUOTES, "utf-8");
									}
									else if($row_eventData['LE_C_Type'] == "Image")
									{
										?>
                              <img src="../../Upl_Images/NewsImage/<?php echo $row_eventData['LE_C_Content']; ?>" class="thumbnail img-responsive" />
                                        <?php
									}
								?>
                            </div>
                           <hr />
                           <?php
								}
						   ?>
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
            <p>2013 &copy; Atreyawebs</p>
        </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
  
  
  
  
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
          <script src="../assets/js/main.js"></script>

        <script>
        $(function() {
            // Bootstrap
            /*$( 'textarea#MTXT_Reply' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
			]});*/
          // $( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});
        });

        // Tiny MCE
       

        </script>  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>