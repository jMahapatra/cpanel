<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 
$type = (isset($_GET['type']))? $_GET['type'] : '';
include("MailViewList_Code.inc.php");


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
    require_once("../require/notifications.inc.php");
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
                        <h3><i class="fa fa-envelope"></i> Mails & Feedback(s)</h3>
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
                              <div class="icons"><i class="fa  fa fa-envelope"></i></div>
                              <h5><?php echo $heading ?> Mails</h5>
                            </header>
                            <div style="height: auto;" id="stripedTable" class="body in">
                              <div class="toolbar" style="padding-top: 7px;">
                                <input name="BTN_Mail_Delete1" class="btn btn-danger btn-sm" type="submit" id="BTN_Mail_Delete1" onclick="return confirm('Do you want to delete the selected query(s)')" value="Delete" />
                            <span class="fc-border-separate" style="width: 3%; display: inline-block"></span> 
                            <a href="MailViewList.php" class="btn-sm btn-primary">All mails</a>
                            <a href="?type=1" class="btn-sm btn-warning"><i class="fa fa-envelope-o"></i> Unread</a> 
                            <a href="?type=2" class="btn-sm btn-success"><i class="fa fa-envelope-open-o"></i> Read</a></div>
                              <br />
                              <table border="0" cellpadding="5" cellspacing="0" class="table table-striped responsive-table col-lg-12">
                                <tr>
                                  <th width="6%"> <label>
                                    <input type="checkbox" name="CHK_all_delete" id="CHK_all_delete" onclick="selectAll(this)" />
                                    All</label></th>
                                  <th width="32%">Name</th>
                                  <th width="49%">Subject</th>
                                  <th width="13%">Date</th>
                                </tr>
                                <?php
                                  $result=mysql_query($query_contact);
                                  $i = 0;
                                  while($rows=mysql_fetch_array($result))
                                  {
                                  ?>
                                <tr>
                                  <td><span class="cF">
                                    <label>
                                      <input type="checkbox" name="CHK_delete[]" id="CHK_delete_<?php echo $i++; ?>" value="<?php echo $rows['M_ID']; ?>" />
                                    </label>
                                  </span></td>
                                  <td><a href="MailViewDetails.php?mailID=<?php echo $rows['M_ID'] ?>"><strong><?php echo $rows['M_Sender']; ?></strong></a></td>
                                  <td><?php echo $rows['M_Subject']; ?></td>
                                  <td><span class="text-info"><?php echo date ("d M, Y", strtotime($rows['M_SentDt'])); ?></span></td>
                                </tr>
                                <?php
                                  }
                                  if(mysql_num_rows($result)==0){
                                   ?> 
                                    <tr>
                                      <td colspan="4" align="center"><i style="font-size: 16px; font-weight: 500">- No mail Received -</i></td>
                                    </tr>
                                <?php
                                  }
                                ?>
                              </table>
                              <div class="pull-right">
                                <div class="dataTables_paginate paging_bootstrap">
                                  <ul class="pagination">
                                    <?php
              //echo mysql_num_rows($res_tot_videos);
                for($i = 0; $i <= (mysql_num_rows(mysql_query($totData))/20); $i++)
              {
                if(isset($_GET['type']))
                $query = "type=".$_GET['type']."&lower=".($i*20)."&upper=".(20);
                else $query = "lower=".($i*20)."&upper=".(20);
                ?>
                                    <li <?php if($lower == ($i*20)) echo ' class="active"'; ?>><a href="<?php echo 
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
            <p>&nbsp;</p>
        </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
  
  
  
  
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
          <script src="../assets/js/main.js"></script>

  
  
  
  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>