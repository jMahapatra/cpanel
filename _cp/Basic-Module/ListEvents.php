<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 

$res_totEventList = mysql_query("select * from `latest_news` order by LE_Slno DESC");
if(isset($_GET['del_eventsid']))
{
	$newsMainImg = mysql_fetch_assoc(mysql_query("SELECT `LE_Photo` FROM `latest_news` WHERE `LE_Slno` = '".$_GET['del_eventsid']."'"));
	$res_eventImg = mysql_query("SELECT * FROM `latest_news_content` WHERE `LE_C_EventId` = '".$_GET['del_eventsid']."'");
	while($row_eventImg = mysql_fetch_array($res_eventImg))
	{
		if($row_eventImg['LE_C_Type'] == "Image")
		unlink("../../Upl_Images/NewsImage/".$row_eventImg['LE_C_Content']);
	}
	if($newsMainImg['LE_Photo']!=''){
		unlink("../../Upl_Images/NewsImage/".$newsMainImg['LE_Photo']);
	}
	mysql_query("DELETE FROM `latest_news_content` WHERE `LE_C_EventId` = '".$_GET['del_eventsid']."'");
	mysql_query("OPTIMIZE TABLE `latest_news_content`");
	mysql_query("DELETE FROM latest_news WHERE LE_Slno = '".$_GET['del_eventsid']."'") or die(mysql_error());
	mysql_query("OPTIMIZE TABLE `latest_news`");
	echo header("location:".$_SERVER['PHP_SELF']);
}

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
        
        <script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('CHK_delete[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
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
                        <h3><i class="fa fa-calendar"></i> News Updates </h3>
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
                      <form id="form1" name="form1" method="post" action="">
                        <div class="col-lg-12">
                          <div class="box">
                            <header class="dark">
                              <div class="icons"><i class="fa  fa fa-file-text-o fa-2x"></i></div>
                              <h5>Update(s) List</h5>
                            </header>
                            <div style="height: auto;" id="stripedTable" class="body in">
                              <hr />
                              <table class="table table-hover table-responsive table-primary">
                                <thead>  
                                  <tr>
                                    <th>News Heading Name</th>
                                    <th>Date</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                      						$lower = (isset($_GET['lower'])) ? $_GET['lower'] : 0;
                      						$upper = (isset($_GET['upper'])) ? $_GET['upper'] : 10;
                      						$res_EventList = mysql_query("select * from `latest_news` order by LE_Slno DESC LIMIT $lower, $upper");
                      	           $i = 0;
                                  	while($row_EventList=mysql_fetch_array($res_EventList))
                                  	{
    						                    ?>
                                    <tr>
                                      <td><?php echo $row_EventList['LE_Heading']; ?></td>
                                      <td><?php echo date('d M, Y', strtotime($row_EventList['LE_Date']));?></td>
                                      <td>
                                        <a href="UploadEventDescription.php?event_id=<?php echo $row_EventList['LE_Slno']; ?>" class="btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Content</a></td>
                                      <td>
                                        <a href="EventDetail.php?event_id=<?php echo $row_EventList['LE_Slno'] ?>" class="btn-sm btn-primary" style="text-align:left"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</a>
                                        <a href="<?php echo $_SERVER['PHP_SELF']."?del_eventsid=".$row_EventList['LE_Slno']; ?>" class=" btn-sm btn-danger" onclick="return confirm('This action will delete the events with all it\'s content permanently.\n\nDo you still want to continue. . ? ')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</a>
                                      </td>
                                    </tr>
                                    <?php
                	                     }
                						        ?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td align="center" colspan="4"><?php if(mysql_num_rows($res_EventList)==0){ echo "No news added yet ! <a href='UploadEventHeading.php'> Click Here</a> to Add";}?>
                                      </td>
                                    </tr>
                                  </tfoot>
                              </table>

                              <div class="pull-right">
                                <div class="dataTables_paginate paging_bootstrap">
                                  <ul class="pagination">
                                    <?php
						  //echo mysql_num_rows($res_tot_videos);
						  	for($i = 0; $i <= (mysql_num_rows($res_totEventList)/10); $i++)
							{
								if(isset($_GET['type']))
								$query = "type=".$_GET['type']."&lower=".($i*10)."&upper=".(10);
								else $query = "lower=".($i*10)."&upper=".(10);
								?>
                                    <li <?php if($lower == ($i*10)) echo ' class="active"'; ?>><a href="<?php echo 
					  $_SERVER['PHP_SELF']."?".$query; ?>"><?php echo $i+1; ?></a></li>
                                    <?php
							}
							?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
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


  
  
  
  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>