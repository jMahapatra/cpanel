<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");




	if(isset($_POST['BTN_Upl_Event']))
	{
		updateNotice();
	}

	function updateNotice()
	{
    $notice = htmlentities($_POST['MTXT_UpdateData'],ENT_QUOTES,'utf-8');
		mysql_query("UPDATE `update_detail` SET `Updates` = '".$notice."', `UploadDate` = '".$_POST['TXT_EventDt']."' WHERE `Notice_ID` = '".$_GET['id']."'");
		//return $event_id;
	}
	if(isset($_GET['did'])) // category query string "did"
	{
		mysql_query("DELETE FROM `update_detail` WHERE Notice_ID = '".$_GET['did']."'");
		mysql_query("OPTIMIZE TABLE `update_detail`");	
		header("location:UploadNoticeUpdate.php");
	}

  $row_NoticeUpdate=mysql_fetch_array(mysql_query("SELECT * FROM `update_detail` WHERE `Notice_ID` = '".$_GET['id']."'"));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin C-Panel</title>
        
        <link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/main.css"/>
        <link rel="stylesheet" href="../assets/lib/Font-Awesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="../assets/css/theme.css">
        <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
    	<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
        
      <link rel="stylesheet" href="../assets/lib/daterangepicker/daterangepicker-bs3.css">
	  <link rel="stylesheet" href="../assets/lib/datepicker/css/datepicker.css">
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
                        <h3><i class="fa fa-pencil-square-o"></i> Notice</h3>
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
                  <div class="inner" style="min-height: 550px;">
                    <div class="row">
                     <div class="col-lg-6">
                       <div class="box">
                         <header class="dark">
                        <div class="icons"><i class="fa fa-pencil fa-2x"></i></div>
                        <h5>Edit Notice</h5>
                      </header>
                      

                      <div class="body">
                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                              <div class="col-lg-6">
                                <input type="text" class="validate[required] form-control" name="TXT_EventDt" id="TXT_EventDt" placeholder="Notice publish date" value="<?php echo $row_NoticeUpdate['UploadDate']; ?>"/>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg-12">
                                <textarea name="MTXT_UpdateData" id="MTXT_UpdateData" placeholder="Notice content" class="validate[required] form-control"><?php echo html_entity_decode($row_NoticeUpdate['Updates']); ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg-6">
                                <input type="submit" name="BTN_Upl_Event" id="BTN_Upl_Event" value="Save" class="btn btn-block btn-primary" />
                              </div>
                              <div class="col-lg-6">
                                <input type="button" name="BTN_Back" id="BTN_Back" onclick="document.location.href='UploadNoticeUpdate.php'" value="Back" class="btn btn-block btn-warning" />
                              </div>
                            </div>
                          </form>
                      </div>



                      </div>
                      
                      </div>
                      
                      
                      <div class="col-lg-6">
                       <div class="box">
                         <header class="dark">
                        <div class="icons"><i class="fa fa-list fa-2x"></i></div>
                        <h5>Recent Notice</h5>
                      </header>
                         <div class="body">
                         
                         
                         
                         <table width="100%">
                          <tr>
                          <td>
                          <table width="99%" align="left" cellpadding="10" class="table-bordered" style="margin: 0.5%">
						 <?php
                          $res_NoticeList=mysql_query("SELECT * FROM `update_detail`");
                          $slid=1;
                          while($row_NoticeLIst=mysql_fetch_array($res_NoticeList))
                          {
                          ?>
                         
                         
                          <tr>
                          <td width="70%" colspan="2" align="left"><?php echo html_entity_decode($row_NoticeLIst['Updates']); ?></td>
                          <td width="20%" colspan="2" align="center"><?php echo $row_NoticeLIst['UploadDate']; ?></td>
                          
                          <td width="5%" align="center"><a href="Edt_NoticeUpdate.php?cid=<?php echo $row_NoticeLIst['Notice_ID']; ?>" class="text-info"><i class="fa fa-pencil-square-o"></i>&nbsp;</a></td>
                            <td width="5%" align="center"><a href="<?php echo $_SERVER['PHP_SELF']."?did=".$row_NoticeLIst['Notice_ID']; ?>" onclick="return confirm('This action will remove the Notice \nDo you still want to continue . . .?')" class="text-danger"><i class="fa fa-times"></i>&nbsp;</a></td>
                          </tr>
                          
                            <?php
							}
							?>
                              </table>
                          </td></tr></table>
                         
                        
                        
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
 <script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
        <script src="../assets/lib/jquery-1.9.1.min.js"></script>
		<script src="../assets/lib/ckeditor/ckeditor.js"></script>
		<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
          <script src="../assets/js/main.js"></script>

        <script>
        $(function() {
            // Bootstrap
            /*$( 'textarea#MTXT_Reply' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
			]});*/
           $( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});
        });

        // Tiny MCE
       

        </script>  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</body>
</html>
<?php 
	ob_end_flush();
?>