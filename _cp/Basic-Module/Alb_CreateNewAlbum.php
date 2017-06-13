<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");

$dir = "../../Upl_Images/Gallery/"; // Album and Image Directory
if(isset($_POST['BTN_CreateAlbum'])) //Create Album after this button click 
	{
	if(count($error) == 0)// If no error(s) occures
		{
		$alb_nm = htmlentities($_POST['TXT_AlbNm'], ENT_QUOTES, "UTF-8");// Album NAme
		$alb_desc = htmlentities($_POST['MTXT_Desc'], ENT_QUOTES, "UTF-8");// Album Description
		
		// Insert a New Album Information in Table (album_name) 
		mysql_query("INSERT INTO `album_name`(`AN_OI_OrganisationID`,`AN_Name`,`AN_Description`,`AN_Date`,`AN_Visibility`) 
		VALUES ('".$_SESSION['OI_OrganisationID']."', '$alb_nm', '$alb_desc', '$date', '1')") or $error[] = "Insert Failed";
		
		$last_id = mysql_insert_id();// primary id from Table "album_name"
		$image_nm = $last_id."_AlbumNm".".jpg"; //image to be insert as album insert
		
		//Code for insert image to the directory folder 
		upload_image($_FILES['FF_AlbumImage'], $dir."Thumbnail/", $image_nm, 300, 200, "no");
		
		// Insert the above image name by updating the table "album_name"
		mysql_query("UPDATE album_name SET `AN_Image` = '$image_nm' WHERE AN_ID = '$last_id'") or $error[] = "Update Failed";
		header("location:".$_SERVER['PHP_SELF']);// redirect after command execute
		}// Close error count 'IF'
	}// Close Create Album 'IF'
	
	
	if(isset($_GET['daid'])) // Album query string "daid"
	{
		$did = $_GET['daid'];
		$res_album_content = mysql_query("SELECT * FROM `album_image` 
							WHERE `AI_AN_ID` = '$did'");
		if(mysql_num_rows($res_album_content) > 0 )
		{
			while($row_album_content = mysql_fetch_array($res_album_content))
			{
				$img_id = $row_album_content['AI_ID'];
				$res_img = mysql_query("SELECT * FROM `album_image` WHERE `AI_ID` = '$img_id'");
				$row_img = mysql_fetch_array($res_img);
				unlink($dir."Main/".$row_img['AI_Image']);
				unlink($dir."Thumbnail/".$row_img['AI_Image']);
				mysql_query("DELETE FROM album_image WHERE AI_ID = '$img_id'");
				mysql_query("OPTIMIZE TABLE `album_image`");
			}
		}
		$row_albumImg = mysql_fetch_array(mysql_query("SELECT * FROM `album_name` WHERE `AN_ID` = '$did' AND `AN_OI_OrganisationID` = '".$_SESSION['OI_OrganisationID']."'"));
		//unlink($dir."Main/".$row_albumImg['AN_Image']);
		unlink($dir."Thumbnail/".$row_albumImg['AN_Image']);
		
		mysql_query("DELETE FROM album_name WHERE AN_ID = '$did'") or die(mysql_error());
		mysql_query("OPTIMIZE TABLE `album_name`");
		$error[] = "Album Deleted Successfully. ";
		header("location:".$_SERVER['PHP_SELF']);
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


        <link rel="stylesheet" href="../assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
        <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css"><link rel="stylesheet" type="text/css" href="../assets/css/custom.css"/>
        

                
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
                            <div class="icons"><i class="fa fa-folder-open fa-2x"></i></div>
                            <h5>Create a new Album</h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              
                              <div class="form-group">
                                <label class="control-label col-lg-3">Name</label><div class="col-lg-9">
                                
                                  <input type="text" class="form-control" name="TXT_AlbNm" id="TXT_AlbNm" required="required" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">About the Album</label><div class="col-lg-9">
                                  <textarea name="MTXT_Desc" class="form-control" id="MTXT_Desc" cols="35" rows="4"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">Select a File</label>
                                <div class="col-lg-9">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbumImage" name="FF_AlbumImage" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            
                            <label class="control-label col-lg-3"></label>
                            
                            <div class="form-actions no-margin-bottom">
                              <input type="submit" name="BTN_CreateAlbum" id="BTN_CreateAlbum" value="Create this album" class="btn btn-primary" />
                               </div>
                               </form>
                           
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="col-lg-6">
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-camera  fa-2x"></i></div>
                            <h5>Pick an album to upload image</h5>
                          </header>
                          
                          <div class="body">
                          <table width="100%">
                          <tr>
                          <td>
                         <?php 
						 	$res_albList = mysql_query("SELECT * FROM `album_name`");
							while($row_albList = mysql_fetch_array($res_albList))
							{
						 ?>
                         <table width="32.3%" align="left" cellpadding="10" class="table-bordered" style="margin: 0.5%">
                         <tr>
                         <td height="120" colspan="2" align="center">
                          <a href="Alb_UplImg2.php?alb=<?php echo $row_albList['AN_ID']; ?>"><img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_albList['AN_Image']; ?>" alt="<?php echo $row_albList['AN_Name']; ?>" class="img-responsive" style="margin-bottom: 2px; max-width:200px" title="<?php echo $row_albList['AN_Name'];?>" /></a>
                          </td>
                          
                          </tr>
                          <tr>
                          <td colspan="2" align="center"><a href="Alb_UplImg2.php?alb=<?php echo $row_albList['AN_ID']; ?>"><?php echo html_entity_decode($row_albList['AN_Name'], ENT_QUOTES, "UTF-8"); ?></a></td>
                          </tr>
                          <tr><td width="50%" align="center"><a href="Alb_EditAlbum.php?aid=<?php echo $row_albList['AN_ID']; ?>" class="text-info"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a></td>
                            <td width="50%" align="center"><a href="<?php echo $_SERVER['PHP_SELF']."?daid=".$row_albList['AN_ID'] ?>" onclick="return confirm('This action will remove the album and all it\'s images permanently.\n\nDo you still want to continue . . .?')" class="text-danger"><i class="fa fa-times"></i>&nbsp;Delete</a></td>
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
<!--query on product image & other-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <!--<script>window.jQuery || document.write('<script src="../assets/lib/jquery.min.js"><\/script>')</script> -->
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
  
<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>
        
    

        <script src="../assets/js/main.js"></script>

        
        <script>
            //$(function() { formWizard(); });
            $(function() { formValidation(); });
        </script>
        
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
 
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
-->

<script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
		<script src="../assets/lib/ckeditor/ckeditor.js"></script>
		<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
          <script src="../assets/js/main.js"></script>
  
  
  
        
</body>
</html>