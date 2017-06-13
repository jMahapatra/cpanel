<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");

$id = (isset($_GET['id']))? $_GET['id'] : '';
$row_Detail = mysql_fetch_array(mysql_query("SELECT * FROM `upl_document` WHERE `DocumentID` = '".$id."'"));

if(isset($_POST['BTN_UplData']))
{
	if($_FILES['FF_File']['name'] !="")
	{
    if(file_exists("../../Document/".$row_EventsDetail['File'])){
      echo 'Exist';
    }
    exit;
    if($row_EventsDetail['File']!='' && file_exists("../../Document/".$row_EventsDetail['File'])){
          unlink("../../Document/".$row_EventsDetail['File']);
    }
    $browsefile=$_FILES['FF_File']['name'];
    $exten= pathinfo($browsefile, PATHINFO_EXTENSION);
    $filename = "DocumentNo_".$_GET['id'].".".$exten;
    move_uploaded_file($_FILES['FF_File']['tmp_name'], "../../Document/".$filename);
  }
  else
  {
    $filename=$row_EventsDetail['File'];
  }
  $description = htmlentities($_POST['MTXT_Desc'],ENT_QUOTES,'utf-8');
  mysql_query("UPDATE `upl_document` SET `FileFor` = '".$_POST['SE_FileFor']."', `Subject` = '".$_POST['TXT_DocSubject']."', `Description` = '$description', `FileName` = '".$filename."' WHERE `DocumentID` = '".$_GET['id']."'")or die (mysql_error());

  header("location:Adm_UploadData.php");
}
if(isset($_GET['action']) && $_GET['action'] == "delete")
{
  $id = $_GET['id'];
  $filename = $_GET['doc'];
  $removed = mysql_query("DELETE FROM `upl_document` WHERE `DocumentID` = '$id'") or die(mysql_error());
  if($removed && $filename!=''){
    unlink('../../Document/'.$filename);
  }
  mysql_query("OPTIMIZE TABLE `upl_document` ");
  header("location:Adm_UploadData.php");
  
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
      <nav class="navbar navbar-inverse navbar-static-top" style="width:100%">
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
          <h3><i class="fa fa-folder-open"></i> Manage Documents</h3>
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
                  <div class="icons"><i class="fa fa-plus fa-2x"></i></div>
                  <h5>Update Document</h5>
                </header>
                <div class="body">
                
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-lg-12">
                      <select name="SE_FileFor" id="SE_FileFor" class="form-control" required="required">
                        <option value=""> - Select Document Type - </option>
                        <option value="Application Form">Application Form</option>
                        <option value="Examination Form">Examination Form</option>
                        <option value="Prospectus">Prospectus</option>
                        <option value="Result">Result</option>
                      </select>
                    </div>
                  </div>
                <div class="form-group">
                  <div class="col-lg-12">
                    <input type="text" name="TXT_DocSubject" id="TXT_DocSubject" class="form-control" value="<?php echo $row_Detail['Subject']; ?>" placeholder="Document Title" required="required" oninvalid="this.setCustomValidity('Please Enter Document Title')"
    oninput="setCustomValidity('')"/>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-12">
                    <textarea name="MTXT_Desc" class="form-control" id="MTXT_Desc" rows="4" placeholder="Description (optional)" ><?php echo $row_Detail['Description']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                    <a href="../../Document/<?php echo $row_Detail['FileName']; ?>" target="_blank">Click to view <?php echo $row_Detail['FileName']; ?></a>
                    <div class="cv"><a href="javascript:void(0)" class="btn btn-success btn-sm pull-left" id="file_link" onclick="fileLink()">Browse a File to Upload &nbsp;<i class="fa fa-upload fa-2x"></i></a></div>
                    <input type="file" name="FF_File" id="FF_File" onchange="checkExt()" style="visibility: hidden"/>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12" id="div-alert" style="display: none"></div>
                </div>
                <div class="form-group">
                  <div class="col-lg-6">
                    <input type="submit" name="BTN_UplData" id="BTN_UplData" value="Upload" class="btn btn-block btn-primary" />
                  </div>
                  <div class="col-lg-6">
                    <input type="reset" name="BTN_Reset" id="BTN_Reset" value="Cancel" class="btn btn-block btn-warning" />
                  </div>
                </div>
              </form>
                  

          </div>
        </div>
      </div>


      <div class="col-lg-6">
        <div class="box">
          <header class="dark">
            <div class="icons"><i class="fa fa-file  fa-2x"></i></div>
            <h5>Recent Document(s)</h5>
          </header>

          <div class="body">
            <table width="100%">
              <tr>
                <td>

                 <table class="table table-hover table-responsive" style="font-size: 12px">
                  <thead> 
                    <tr>
                      <th width="40%">HEADING</th>
                      <th width="25%">TYPE</th>
                      <th width="20%">POSTED ON</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $res_EventList=mysql_query("SELECT * FROM `upl_document`");
                  $slid=1;
                  while($row_EventList=mysql_fetch_array($res_EventList))
                  {
                   ?>
                     <tr>
                      <!--<td><strong><?php echo $slid;?>.</strong></td>-->
                      <td><strong><?php echo $row_EventList['Subject']; ?></strong></td>
                      <td><?php echo $row_EventList['FileFor']; ?></td>
                      <td><?php echo $row_EventList['UplDate']; ?></td>
                      <td width="75" align="center"><a href="Adm_Edt_UploadedData.php<?php echo "?action=edt&id=".$row_EventList['DocumentID']; ?>" class="text-info"><i class="fa fa-pencil-square-o"></i></a></td>
                      <td width="75" align="center"><a href="<?php echo $_SERVER['PHP_SELF']."?action=delete&id=".$row_EventList['DocumentID']."&doc=".$row_EventList['FileName']?>" onclick="return confirm('Delete this account . . . ?')"class="text-danger"><i class="fa fa-times"></i></a></td>
                    </tr>
                    <?php
                    $slid++;
                  }
                  ?>
                  </tbody>
              </table>

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
<script>window.jQuery || document.write('<script src="../assets/lib/jquery.min.js"><\/script>')</script> 
<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>



<script src="../assets/js/main.js"></script>


<script>
    
     
      function fileLink() {
          $('#FF_File').trigger('click');
      }

      function checkExt() {
        var filename = $('input[type=file]').val().split('\\').pop();
         var ext = filename.split('.').pop();
         if(ext!="pdf" && ext!="docx" && ext!="doc"){
            $('#div-alert').html('Warning : Only PDF and Word Documents can be uploaded..!').css({"display":"block","color":"red"})
         }else{
            $('#div-alert').html('Selected File : '+filename).css({"display":"block","color":"blue"})
         } 
      }

</script>

          <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
          <!-- ---------------------------------------------------------  ------------------------------------ --> 

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
-->

<script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
<script src="../assets/lib/jquery-1.9.1.min.js"></script>
<script src="../assets/lib/ckeditor/ckeditor.js"></script>
<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
<script src="../assets/js/main.js"></script>




</body>
</html>