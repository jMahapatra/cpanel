<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 
$res_alb = mysql_query("SELECT * FROM album_name");

$dir = "../../Upl_Images/Gallery/";

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

  <link rel="stylesheet" href="../assets/lib/validationengine/css/validationEngine.jquery.css">
  
  
  <link rel="stylesheet" href="../assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
  <link rel="stylesheet" href="../assets/lib/gritter/css/jquery.gritter.css">
  <link rel="stylesheet" href="../assets/lib/uniform/themes/default/css/uniform.default.min.css">
  <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css"><link rel="stylesheet" type="text/css" href="../assets/css/custom.css"/>
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
          <h3><i class="fa fa-camera"></i> Gallery</h3>
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
                  <div class="icons"><i class="fa fa-folder-open fa-2x"></i></div>
                  <h5>Pick up an Album to continue</h5>
                </header>
                <div class="body">
                  <table width="100%">
                    <?php
                    if(mysql_num_rows($res_alb)<=0)
                    {
                     ?>
                     <tr>
                       <td align="center">
                         <?php echo "We didn't found any Album. "."<a href='Alb_CreateNewAlbum.php'>Click Here</a> to create a new Album" ; ?>
                         
                       </td>
                     </tr>
                     <?php
                   }?>
                   <tr>
                    <td>
					<table width="33.3%" align="left" cellpadding="10" class="table-bordered" style="margin: 0.5%">
						<tr>
                         <td align="center">
                           <a href="<?php echo "Alb_CreateNewAlbum.php"?>"><img src="..	/assets/img/add-button.png" width="300px" class="img img-responsive" alt="New Album" /></a></td>
                        </tr>
					  </table>
                     <?php
                     while($row_alb = mysql_fetch_array($res_alb))
                     {
                      ?>
					  
                      <table width="33.3%" align="left" cellpadding="10" class="table-bordered" style="margin: 0.5%">
						<tr>
                         <td height="120" align="center">
                           <a href="<?php echo "Alb_UplImg2.php?upload=true&alb=".$row_alb['AN_ID']; ?>"><img src="<?php echo $dir."Thumbnail/".$row_alb['AN_Image']; ?>" class="img img-responsive" alt="<?php echo html_entity_decode($row_alb['AN_Name'], ENT_QUOTES, "UTF-8"); ?>" /></a></td>
                        </tr>
                         <tr>
                           <td align="center"><a href="<?php echo "Alb_UplImg2.php?upload=true&alb=".$row_alb['AN_ID']; ?>"><?php echo html_entity_decode($row_alb['AN_Name'], ENT_QUOTES, "UTF-8"); ?></a></td>
                         </tr>
                         
                       </table>
                       <?php
                     }
                     ?>
                   </td></tr></table>
                   
                 </div>
                 
               </div>
               
             </div>
           </div>
           
         </div>
         
         <hr>
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
<script>window.jQuery || document.write('<script src="../assets/lib/jquery.min.js"><\/script>')</script> 



<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

<script src="../assets/js/main.js"></script>


<script>
            //$(function() { formWizard(); });
            //$(function() { formValidation(); });
          </script>
          
          
          
          <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
          
          
          


        </body>
        </html>