<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
// All Query Strings Fetched Here. 
	$dir = "../../Upl_Images/Gallery/";
$alb_id = $_GET['albid'];
$img_id = $_GET['imgid'];

$res_img = mysql_query("SELECT * FROM `album_image` WHERE `AI_ID` = '$img_id'");

if(mysql_num_rows($res_img) == 0)
	{
		//header("refresh:5;url=Alb_ViewImage.php?aid=".$alb_id);
		//die("The content you are trying to access no longer available. Thank you.");
	}
$row_img = mysql_fetch_array($res_img);
if(isset($_POST['BTN_EditImage']))
	{
		$alb_desc = htmlentities($_POST['MTXT_Desc'], ENT_QUOTES, "UTF-8");
		$image_nm = $alb_id."_AlbumImg".$img_id.".jpg";
		//if the image is uploaded then only the following codes will be executed.
		
		if($_FILES['FF_AlbumImage']['name'] != "")
		{
			// The Previous Images Are Deleted
			unlink($dir."Main/".$row_img['AI_Image']) or $error[] = "Main Image Delete Failed. ";
			unlink($dir."Thumbnail/".$row_img['AI_Image']) or $error[] = "Thumbnail Image Delete Failed. ";
			upload_image($_FILES['FF_AlbumImage'],$dir."/Main", $image_nm, 600, 400, "yes");
			upload_image($_FILES['FF_AlbumImage'],$dir."/Thumbnail", $image_nm, 120, 80, "no");
		}
		mysql_query("UPDATE `album_image` SET `AI_Description` = '$alb_desc' WHERE `AI_ID` = '$img_id'") or $error[] = mysql_error();
		header("location:Alb_UplImg2.php?upload=true&alb=$alb_id");
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
                            <h5>Edit Album</h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                <label class="control-label col-lg-3">About This Photo</label><div class="col-lg-9">
                                  <textarea name="MTXT_Desc" class="form-control" id="MTXT_Desc" cols="35" rows="4"><?php echo html_entity_decode($row_img['AI_Description'], ENT_QUOTES, "UTF-8"); ?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3"><span class="fileupload fileupload-new"> </span>Select a File</label>
                                <div class="col-lg-9">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <img src="<?php echo $dir."Thumbnail/".$row_img['AI_Image']; ?>" alt="" width="140" height="133" class="img-responsive img-thumbnail pull-right" />
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Replace image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbumImage" name="FF_AlbumImage" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            
                            <label class="control-label col-lg-3"></label>
                            
                            <div class="form-group">
                              <div class="col-lg-4">
                                <input type="submit" name="BTN_EditImage" id="BTN_EditImage" value="Save Image" class="btn btn-primary btn-block" />
                              </div> 
                              <div class="col-lg-4"> 
                                <button type="button" class="btn btn-warning btn-block" name="BTN_Cancel" id="BTN_Cancel" onclick="document.location.href='Alb_UplImg2.php?upload=true&alb=<?php echo $_GET['albid']?>'">Back to Album</button>
                              </div>
                            </div>



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