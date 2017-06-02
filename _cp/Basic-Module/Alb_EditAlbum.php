<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 

if(!isset($_GET['aid']))
	{
		//header("refresh:5;url=Alb_CreateNew.php");
		//die("There is no operation to perform. Thank you");
	}
$alb_id = $_GET['aid'];
$res_alb = mysql_query("SELECT * FROM `album_name` 
						WHERE `AN_ID` = '$alb_id'");
if(mysql_num_rows($res_alb) == 0)
	{
		//header("refresh:5;url=Alb_CreateNew.php");
		die("The content you are trying to access no longer available. Thank you. <a href='Alb_CreateNewAlbum.php'>Click Here</a> To Go back.");
	}
$row_alb = mysql_fetch_array($res_alb);

if(isset($_POST['BTN_EditAlbum']))
	{
		$dir = "../../Upl_Images/Gallery/";
		$alb_nm = htmlentities($_POST['TXT_AlbNm'], ENT_QUOTES, "UTF-8");
		$alb_desc = htmlentities($_POST['MTXT_Desc'], ENT_QUOTES, "UTF-8");
		$image_nm = $alb_id."_AlbumNm".".jpg";
		//if the image is uploaded then only the following codes will be executed.
		
		if($_FILES['FF_AlbumImage']['name'] != "")
			{
				//die($dir."Main/".$image_nm);
			//unlink($dir."Main/".$image_nm);
			unlink($dir."Thumbnail/".$image_nm);
			upload_image($_FILES['FF_AlbumImage'], $dir."Thumbnail/", $image_nm, 200, 130, "no");
			}
		mysql_query("UPDATE `album_name` SET `AN_Name` = '$alb_nm', `AN_Description` = '$alb_desc', `AN_Image` = '$image_nm' WHERE `AN_ID` = '$alb_id'") or die(mysql_error());
		?>
        <script type="text/javascript">
        	alert("Album Saved Successfully . . .!");
        </script>
        <?php
		header("location:".$_SERVER['PHP_SELF']."?aid=$alb_id&succMsg");
	}
// Function To Validate The Uploading Items

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
                      <div class="col-lg-6">
                        <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-pencil-square-o fa-2x"></i></div>
                            <h5>Edit Album <?php if(isset($_GET['succMsg'])) {?> <span class="text-success pull-right">
                            &nbsp;&nbsp;&nbsp;<i class="fa fa-check"></i> Album Saved Successfully. </span><?php } ?></h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              
                              <div class="form-group">
                                <label class="control-label col-lg-3">Name</label><div class="col-lg-9">
                                
                                  <input type="text" class="validate[required] form-control" name="TXT_AlbNm" id="TXT_AlbNm" value="<?php echo $row_alb['AN_Name']; ?>" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">About the Album</label><div class="col-lg-9">
                                  <textarea name="MTXT_Desc" class="form-control" id="MTXT_Desc" cols="35" rows="4"><?php echo $row_alb['AN_Description']; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">&nbsp;</label>
                                <div class="col-lg-9">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                  
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: auto;"><img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_alb['AN_Image'] ?>" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-primary"><span class="fileupload-new">Change image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbumImage" name="FF_AlbumImage" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            
                            <label class="control-label col-lg-3"></label>
                            
                            <div class="form-actions no-margin-bottom">
                              <input type="submit" name="BTN_EditAlbum" id="BTN_EditAlbum" value="Save Album" class="btn btn-primary" />
                               &nbsp;&nbsp;<a href="Alb_CreateNewAlbum.php" class="btn btn-default">Back</a></div>
                               </form>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="box">
                          <div class="body">
                            <table width="100%">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
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
  
  
        <script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/gritter/js/jquery.gritter.min.js"></script>
<script src="../assets/lib/uniform/jquery.uniform.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/localization/messages_ja.js"></script>
        
<script src="../assets/lib/validationengine/js/jquery.validationEngine.js"></script>
<script src="../assets/lib/validationengine/js/languages/jquery.validationEngine-en.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/localization/messages_ja.js"></script>
        

    <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

        <script src="../assets/js/main.js"></script>

        
        <script>
            //$(function() { formWizard(); });
            $(function() { formValidation(); });
        </script>
        
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        
        


</body>
</html>