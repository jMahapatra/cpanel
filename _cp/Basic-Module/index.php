<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 
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
                        <h3><i class="fa fa-dashboard"></i> Dashboard</h3>
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
                            <div class="icons"><i class="fa  fa fa-plus fa-2x"></i></div>
                            <h5>Add new image in <?php echo $row_coverImg['AN_Name']; ?></h5>
                          </header>
                          
                    <div style="height: auto;" id="stripedTable" class="body in">
                      <table border="0" cellpadding="5" cellspacing="0" width="150" align="left">
                        <tr>
                          <th align="center" valign="middle">adsf wldk sw</th>
                        </tr>
                        <tr>
                          <td>Place area1</td>
                        </tr>
                      </table>
                      
                      <table border="0" cellpadding="5" cellspacing="0" width="150" align="left">
                        <tr>
                          <th>adsf wldk s</th>
                        </tr>
                        <tr>
                          <td>PLace area2</td>
                        </tr>
                      </table>
                      
                      <table border="0" cellpadding="5" cellspacing="0" width="150" align="left">
                        <tr>
                          <th>adsf wldk s</th>
                        </tr>
                        <tr>
                          <td>Place area3</td>
                        </tr>
                      </table>
                      </div></div>
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
  
  
  
            <script src="../assets/js/main.js"></script>

  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>