<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");


	if(isset($_POST['BTN_Upl_Event']))
	{
		$event = uploadEvent();
		header("location:".$_SERVER['PHP_SELF']);
	}
	if(isset($_POST['BTN_NextCont']))
	{
		$event = uploadEvent();
		header("location:UploadMenuDescription.php?event_id=".$event);
	}

	function uploadEvent()
	{
		$content=htmlentities($_POST['MTXT_EventData'], ENT_QUOTES, "utf-8");
		$heading=htmlentities($_POST['TXT_Event'], ENT_QUOTES, "utf-8");
		$news_dt = $_POST['TXT_EventDt'];
		
		
		
		
		
		
		mysql_query("INSERT INTO `menu_contents`(`MenuName`, `LE_Heading`, `LE_Date`, `LE_UpdatedDate`,`LE_UpdatedBy`) VALUES ('".$_GET['menuNm']."','$heading','$news_dt', 'Never Updated', 'Never Updated')") or die(mysql_error());
		$event_id=mysql_insert_id();
		if(!empty($content))
		{
			$content_Position = 1;
		mysql_query("INSERT INTO `menu_contents_detail`(`LE_C_EventId`, `LE_C_Content`, `LE_C_Type`, `LE_C_Status`, `LE_C_Position`) VALUES ('$event_id', '".$content."', 'Text', 1,'$content_Position')");
		}
		return $event_id;
	}

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
        <link rel="stylesheet" type="text/css" href="../assets/css/sub-menu.css"/>
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
                        <h3><i class="fa fa-info"></i> Upload Menu Info.</h3>
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
                        <div class="icons"><i class="fa fa-file-text-o fa-2x"></i></div>
                        <h5>Upload Headings </h5>
                      </header>
                         <div class="body">
                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">

                                <div class="form-group ">
                                <div class="col-lg-5">
                                <?php
                                $menu = array("About Us" => array("About College", "Mission and Vision", "Founder Message", "Secretary Message", "Principal Message", "Our Faculty"), "Academic" => array("3 Year L.L.B.", "5 Year L.L.B.", "Information"), "Admission" => array("Rules For Admission"));
								
                                  ?>
                                  
                                </div>
                                <?php 
									
								?>
                                <div class="dropdown open hidden">
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li><a href="#">Some action</a></li>
                <li><a href="#">Some other action</a></li>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Hover me for more options</a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">Second level</a></li>
                        <li class="dropdown-submenu">
                            <a href="#">Even More..</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">3rd level</a></li>
                                <li><a href="#">3rd level</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Second level</a></li>
                        <li><a href="#">Second level</a></li>
                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Hover me for more options</a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">Second level</a></li>
                        <li class="dropdown-submenu">
                            <a href="#">Even More..</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">3rd level</a></li>
                                <li><a href="#">3rd level</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Second level</a></li>
                        <li><a href="#">Second level</a></li>
                    </ul>
                </li>
            </ul>
        </div>
                                </div>

                                <div class="navbar-inverse">
                                <nav class="nav">
                                	<ul class="nav navbar-nav">
                                    	<?php 
											foreach($menu as $i => $m)
											{
												if(is_array($m))
												{
												?>
                                                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $i; ?><span class="caret"></span></a>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <?php 
															foreach($m as $z => $k)
															{
																
												if(is_array($k))
												{
													
													?>
                                                     <li class="dropdown-submenu"><a href="?menuNm=<?php echo urlencode($z) ?>"><?php echo $z; ?></a>
                                                                
                                                                <ul class="dropdown-menu">
                                                                <?php 
																	foreach($k as $x => $t)
																	{
																		$res_checkMenu = mysql_query("SELECT `MenuName` FROM `menu_contents` WHERE `MenuName` = '$t'");
													if(mysql_num_rows($res_checkMenu) == 1)
													continue;
																		?>
                                                                        <li class=""><a href="?menuNm=<?php echo urlencode($t); ?>"><?php echo $t; ?></a></li>
                                                                        <?php
																	}
																?>
                                                                </ul>
                                                         </li>
                                                    <?php
												}
												else
												{
													$res_checkMenu = mysql_query("SELECT `MenuName` FROM `menu_contents` WHERE `MenuName` = '$k'");
													if(mysql_num_rows($res_checkMenu) == 1)
													continue;
												
																?>
                                                                <li class=""><a href="?menuNm=<?php echo urlencode($k) ?>"><?php echo $k; ?></a></li>
                                                               
																<?php
												}
															}
														?>
                                                    </ul>
                                                </li>
                                                <?php
												}
												else
												{
													$res_checkMenu = mysql_query("SELECT `MenuName` FROM `menu_contents` WHERE `MenuName` = '$k'");
												if(mysql_num_rows($res_checkMenu) == 1)
													continue;
													?>
                                                    <li class=""><a href="?menuNm=<?php echo urlencode($z); ?>"><?php echo $z; ?></a></li>
                                                    <?php
												}
											}
										?>
                                    </ul>
                                </nav>
                                </div>    <br />
<br />
                            
                                <div class="form-group">
                                <label class="control-label col-lg-2"> Heading  <?php echo $_GET['menuNm']; ?></label><div class="col-lg-5">
                                
                                  <input type="text" class="validate[required] form-control" name="TXT_Event" value="<?php echo $_GET['menuNm'];?>" id="TXT_Event" />
                                </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                
                                <label class="control-label col-lg-2">Date</label><div class="col-lg-3">
                                
                                  <input type="text" class="validate[required] form-control" name="TXT_EventDt" value="<?php date('Y-m-d') ?>" id="TXT_EventDt" />
                                  
                                </div>
                                  </div>
                                  
                                  
                                  
                                  <div class="block">
                            <textarea name="MTXT_EventData" id="MTXT_EventData"></textarea>
                            <br />
                            <input type="submit" name="BTN_NextCont" id="BTN_NextCont" value="Add more Content" class="btn btn-primary" />
                             <input type="submit" name="BTN_Upl_Event" id="BTN_Upl_Event" value="Save & Return" class="btn btn-primary" />
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