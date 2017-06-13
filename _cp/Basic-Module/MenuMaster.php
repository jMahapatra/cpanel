<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");

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
<link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css">
<link rel="stylesheet" href="../assets/css/custom.css"/>        
<script type="text/javascript" src="../assets/lib/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	fetchCategory(0)
	function getQueryStringValue (key) {  
		return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
	} 
	
	var catg_id = getQueryStringValue('catid')
	var val = getQueryStringValue("val")
	if(catg_id){ 
		fillCategory(catg_id,val)
	}
	
	/*$('#TF_Parent').keyup(function(event) {
        $('#TF_Parent').addClass('loading');
		var category = $('#TF_Parent').val()
		dataCont = 'action=suggestParCatg&data='+category;
		
		$('form').attr('onsubmit', "return false");
		if(event.keyCode != 40 && event.keyCode != 38 && event.keyCode != 13)
		{
			$.ajax({
				type: 'POST',
				url: "codes/c_autoSuggest.php",
				data: dataCont,
				success: function(html){
					$('#suggestion').css('display', 'block')
					$('#suggestion').fadeIn(300)
					$('#suggestion').html(html)
					$('#TF_Parent').removeClass('loading');
				}
			})
		}
		else
		{
			switch (event.keyCode)
			{
				 case 13:
				 {
					var encoded_categoryName = $('.suggest li.selected').html();
					var decoded_categoryName = encoded_categoryName.replace(/&amp;/g, '&');
					fillCategory($('.suggest li.selected').attr('id'),decoded_categoryName)
					$('form').attr("onsubmit", "return true");
					$(".suggest").fadeOut("fast");
					return false;
				 }
				 break;
				 case 40:
				 {
					  found = 0;
					  $(".suggest li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $(".suggest li[class='selected']");
						// check if his is a last element in the list
						// if so then add selected class to the first element in the list
						if(sel.next().text() == "")					
							$(".suggest li:first").addClass("selected");
						else
							sel.next().addClass("selected");
						// remove class selected from previous item
						sel.removeClass("selected");
					  }
					  else
						$(".suggest li:first").addClass("selected");
				 }
				 break;
				 case 38:
				 {
					  found = 0;
					  $(".suggest li").each(function(){
						 if($(this).attr("class") == "selected")
							found = 1;
					  });
					  if(found == 1)
					  {
						var sel = $(".suggest li[class='selected']");
						// check if his is a last element in the list
						// if so then add selected class to the first element in the list
						if(sel.prev().text() == "")					
							$(".suggest li:last").addClass("selected");
						else
							sel.prev().addClass("selected");
							// remove class selected from previous item
						sel.removeClass("selected");
					}
					else
					$(".suggest li:last").addClass("selected");
				 }
				 break;
			}
		}
    });*/
	
	$('#BTN_CreateCategory').click(function(e) {
		var menu = ($('#CB_ShowMenu').prop('checked'))?$('#CB_ShowMenu').val():'no'
		var parentName = ($('#TF_Parent').val()=='') ? 'no' : $('#TF_Parent').val()
		var parentId = ($('#HD_Parent').val()=='') ? 0 : $('#HD_Parent').val()
		var categoryName = $('#TF_Category').val();
		if(categoryName==''){
			alert('Mention a category first..!!');
			return false;
		}
		escape_category = encodeURIComponent(categoryName)
		/*if(confirm('Add category '+categoryName+' under '+parentName+' category'))
		{*/
			dataCont = 'action=addCategory&parentId='+parentId+'&categoryName='+escape_category+'&showMenu='+menu
			$.ajax({
				type: 'POST',
				url: "codes/c_Category.php",
				data: dataCont,
				success: function(html){
					$('#TF_Category').val('').focus();
					//$('#CB_ShowMenu').removeAttr('checked')
					fetchCategory(parentId)
				}
			})
		//}
    });
	$('#BTN_UpdateCategory').click(function(e) {
		var menu = ($('#CB_ShowMenu').prop('checked'))?$('#CB_ShowMenu').val():'no'
		var parentName = ($('#TF_Parent').val()=='') ? 'Blank / No' : $('#TF_Parent').val()
		var parentId = ($('#HD_Parent').val()=='') ? 0 : $('#HD_Parent').val()
		var categoryName = $('#TF_Category').val()
		var categoryId = $('#HD_Category').val()
		if(categoryName==''){
			alert('Mention a category first..!!');
			return false;
		}
		escape_category = escape(categoryName)
		if(confirm('Update category '+categoryName+' under '+parentName+' category'))
		{
			dataCont = 'action=updateCategory&parentId='+parentId+'&categoryName='+escape_category+'&categoryId='+categoryId+'&showMenu='+menu
			$.ajax({
				type: 'POST',
				url: "codes/c_Category.php",
				data: dataCont,
				success: function(html){
					fetchCategory(parentId)
					$('#TF_Category').val('')
					$('#HD_Category').val('')
					$('#BTN_CreateCategory').css('display', 'block')
					$('#BTN_UpdateCategory').css('display', 'none')
					$('#CB_ShowMenu').removeAttr('checked')
				}
			})
		}
    });
	
	/*$(".alpha-only").on("input", function(){
	  var regexp = /[^0-9a-zA-Z\s\&]/g;;
  		if($(this).val().match(regexp)){
			$(this).val( $(this).val().replace(regexp,'') );
 		}
	});*/

});
function updateFill(parentId,parentName,categoryId,categoryName,InMenu)
{
	if(parentId!=null && parentName!=null)
	{	$('#TF_Parent').val(parentName)
		$('#HD_Parent').val(parentId);
	}
	if(InMenu == 'yes'){
		$('#CB_ShowMenu').prop('checked', 'checked')
	}else{$('#CB_ShowMenu').removeAttr('checked')}
	$('#TF_Category').val(categoryName)
	$('#HD_Category').val(categoryId)
	$('#BTN_CreateCategory').css('display', 'none')
	$('#BTN_UpdateCategory').css('display', 'block')
}
function fillCategory(categoryId,categoryName)
{
	if(categoryId!=null && categoryName!=null)
	{
		$('#TF_Parent').val(categoryName)
		$('#HD_Parent').val(categoryId);
		fetchCategory(categoryId)
	}
	$('#TF_Category').val('')
	$('#HD_Category').val('')
	$('#BTN_CreateCategory').css('display', 'block')
	$('#BTN_UpdateCategory').css('display', 'none')
	//$('#CB_ShowMenu').removeAttr('checked')
	setTimeout("$('#suggestion').fadeOut();", 100);
}
function fetchCategory(categoryId)
{
	dataCont = 'action=fetchCategory'+'&data='+categoryId;
	$.ajax({
		type: 'POST',
			url: "codes/c_Category.php",
			data: dataCont,
			success: function(html){
				$('#categoryList').css('display', 'block')
				$('#categoryList').fadeIn(300)
				$('#categoryList').html(html)
			}
	})
}
function deactivate(parent_Id,categoryId,status)
{
	dataCont = 'action=deactivate'+'&categoryId='+categoryId+'&status='+status;
	$.ajax({
		type: 'POST',
			url: "codes/c_Category.php",
			data: dataCont,
			success: function(html){
				fetchCategory(parent_Id)
			}
	})
}
function updatePosition(parent_Id,categoryId,position,type){
	dataString = 'action=position&parentId='+parent_Id+'&categoryId='+categoryId+'&position='+position+'&type='+type
	url = 'codes/c_Category.php'
	$.post(url, dataString, function(data){
		fetchCategory(parent_Id)
	});
}
</script>                
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');

</script>
<script src="../assets/lib/modernizr-build.min.js"></script>
<style type="text/css">
.fa-check {
    color: #0C6;
}
.fa-times {
    color: #F00;
}
</style>

</head>

<body>
<div id="suggestion"></div>
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
                        <h3><i class="fa fa-list"></i> Site Menu</h3>
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
                  <div class="inner" style="min-height:500px">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="box">
                          <header class="dark">
                            <h5>Manage Site Menu</h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              
                              <div class="form-group">
                                <div class="col-lg-9">
                                  <input type="text" autocomplete="off" class="alpha-only validate[required] form-control" value="" name="TF_Parent" id="TF_Parent" <?php if($_SESSION['role']=="Admin"){ echo 'readonly="readonly"'; }?> />
                                  <input type="hidden" name="HD_Parent" id="HD_Parent" value=""/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-9">
                                  <input type="text" autocomplete="off" class="validate[required] form-control" name="TF_Category" id="TF_Category" placeholder="Add a menu" />
                                  <input type="hidden" name="HD_Category" id="HD_Category" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-9"><input name="CB_ShowMenu" type="checkbox" id="CB_ShowMenu" value="yes" checked="checked" />&nbsp;&nbsp;Show In Menu
                                   </label>
                              </div>
                            
                            
                            <div class="form-group no-margin-bottom">
                           		<div class="col-lg-5">
                              <input type="button" name="BTN_CreateCategory" id="BTN_CreateCategory" value="Add Menu" class="btn btn-primary btn-block" />
                              <input style="display:none" type="button" name="BTN_UpdateCategory" id="BTN_UpdateCategory" value="Save Chnages" class="btn btn-primary btn-block" />
                              </div>
                              <div class="col-lg-4">
                              <input type="reset" name="BTN_Reset" id="BTN_Reset" value="&nbsp;&nbsp;Reset&nbsp;&nbsp;" class="btn btn-default btn-block"/>
                            </div>
                            </div>
                               </form>
                           
                          </div>
                        </div>
                        

                      </div>
                      <div class="col-lg-6">
                      	<div id="categoryList"></div>
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
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>
        
    <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

        <script src="../assets/js/main.js"></script>

        
        <script>
            //$(function() { formWizard(); });
            $(function() { formValidation(); });
        </script>
        
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
</body>
</html>