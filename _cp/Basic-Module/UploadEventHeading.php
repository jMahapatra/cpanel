<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");


	if(isset($_POST['BTN_Upl_Event']))
	{
		$event = uploadEvent();
		header("location:ListEvents.php");
	}
	if(isset($_POST['BTN_NextCont']))
	{
		$event = uploadEvent();
		header("location:UploadEventDescription.php?event_id=".$event);
	}

	function uploadEvent()
	{
		$content=htmlentities($_POST['MTXT_EventData'], ENT_QUOTES, "utf-8");
		$heading=htmlentities($_POST['TXT_Event'], ENT_QUOTES, "utf-8");
		$news_dt = $_POST['TXT_EventDt'];
		
		
		$row_NewsCode = mysql_fetch_assoc(mysql_query("SELECT `LE_Slno` FROM `latest_news` ORDER BY `LE_Slno` DESC LIMIT 0,1"));
		$varNewsCode=$row_NewsCode['LE_Slno']+1;
		
		if($_FILES['FF_EventFile']['name']!="")
		{
		$News_nm = $varNewsCode."_NewsLetter".".pdf";
		move_uploaded_file($_FILES['FF_EventFile']['tmp_name'], "../../Document/".$News_nm);
		}
		
		
		if($_FILES['FF_NewsPhoto']['name']!="")
		{
		
		$News_photo=$varNewsCode."_NewsPhoto".".jpg";
		move_uploaded_file($_FILES['FF_NewsPhoto']['tmp_name'], "../../Upl_Images/NewsImage/".$News_photo);
		}
		else
		{
			$News_photo="News_img.jpg";
		}
		
		
		mysql_query("INSERT INTO `latest_news` (`LE_NewsCatg`, `LE_Heading`, `LE_Date`, `LE_UpdatedDate`,`LE_UpdatedBy`, `LE_File`,`LE_Photo`) VALUES ('".$_POST['SE_NewsCatg']."', '$heading','$news_dt', '".date('Y-m-d')."', 'Never Updated', '".$News_nm."', '".$News_photo."')") or die(mysql_error());
		$event_id=mysql_insert_id();
		if(!empty($content))
		{
			$content_Position = 1;
		mysql_query("INSERT INTO `latest_news_content` (`LE_C_EventId`, `LE_C_Content`, `LE_C_Type`, `LE_C_Status`, `LE_C_Position`) VALUES ('$event_id', '".$content."', 'Text', 1,'$content_Position')");
		}
		return $event_id;
		
	}

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
        <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
    	<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
        <link rel="stylesheet" href="../assets/css/custom.css">
        
      <link rel="stylesheet" href="../assets/lib/daterangepicker/daterangepicker-bs3.css">
	  <link rel="stylesheet" href="../assets/lib/datepicker/css/datepicker.css">
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
	     <?php
		    include("../require/notifications.inc.php");
	     ?>
        <!-- /.topnav -->
      </nav>
      <!-- /.navbar -->
      <!-- header.head -->
      <header class="head">
        <div class="search-bar">
          <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle"><i class="fa fa-resize-full"></i></a>
        </div>
        <div class="main-bar">
          <h3><i class="fa fa-newspaper-o"></i> News Updates</h3>
        </div>
      </header>
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
                    <div class="icons"><i class="fa fa-plus fa-2x"></i></div><h5>New Updates</h5>
                  </header>
                  <div class="body">
                    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">  
                      <div class="form-group">
                        <div class="col-md-3">
                          <select id="SE_NewsCatg" name="SE_NewsCatg" class="form-control">
                            <option value="updates">Updates</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <input type="text" class="form-control" name="TXT_EventDt" id="TXT_EventDt" placeholder="Date" required="required" oninvalid="this.setCustomValidity('Please specify a date')"
    oninput="setCustomValidity('')"/>
                        </div>
                      </div>                         
                      <div class="form-group">
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="TXT_Event" id="TXT_Event" placeholder="Title" required="required" oninvalid="this.setCustomValidity('Please provide a title')"
    oninput="setCustomValidity('')"/>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-md-9">
                          <textarea name="MTXT_EventData" id="MTXT_EventData"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6">
                          <input type="file" name="FF_NewsPhoto" id="FF_NewsPhoto" class="" />&nbsp; <strong>(Only .JPG File)</strong>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-3">
                          <input type="submit" name="BTN_NextCont" id="BTN_NextCont" value="Save & Add More" class="btn btn-block btn-primary" />
                        </div>
                        <div class="col-md-3">
                          <input type="submit" name="BTN_Upl_Event" id="BTN_Upl_Event" value="Save & Return" class="btn btn-block btn-primary" />
                        </div>
                        <div class="col-md-3">
                          <input type="button" onclick="document.location.href='ListEvents.php'" name="BTN_Cancel" id="BTN_Cancel" value="Cancel" class="btn btn-block btn-warning" />
                        </div>
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
    <p>2013 &copy; Atreyawebs</p>
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
            $( 'textarea#MTXT_EventData' ).ckeditor({width:'100%', height: '150px', toolbar: [
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Blockquote',
            '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links', items : [ 'Link','Unlink' ] },
            { name: 'styles', items : [ 'Format','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] },
			{ name: 'insert', items : [ 'Image','Table'] },
            { name: 'tools', items : [ 'Maximize'] }
    			]});
           /*$( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});*/
        });

        // Tiny MCE
       

        </script>  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</body>
</html>