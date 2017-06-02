<?php 
	include("require/session.inc.php");
	if(!$_SESSION['username'])
	{
		header("location:../login");
	}
	include("require/connection.inc.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="msapplication-TileColor" content="#5bc0de"/>
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png"/>
        <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/main.css"/>
        <!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/theme.css">
        <link rel="stylesheet" href="assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" type="text/css" href="assets/css/custom.css"/>
     <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');
</script>
<script src="assets/lib/modernizr-build.min.js"></script>
<title>Admin C-Panel</title>
</head>

<body>
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
		<nav class="navbar navbar-inverse navbar-static-top">
			<header class="navbar-header" style="width:100%">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!--top Menu-->
				<div class="col-md-2">	
					<a href="../_cp/" class="navbar-brand"><img src="assets/img/logo.png" alt=""></a>
				</div>
				<div class="col-md-9">  
				 <?php 
    		$resCategories = mysql_query("SELECT `Category_ID`, `CategoryName` FROM `menu_master` WHERE `Parent_ID`='0' ORDER BY `position` ASC");
				?>
				<div class="navbar-inverse">
				  <nav class="nav">
					<ul class="nav navbar-nav">
					  <li><a href="index.php">Home</a></li>
					  <?php
    					while($mainMenu = mysql_fetch_assoc($resCategories)){
    						$resSubMenu = mysql_query("SELECT `Category_ID`, `CategoryName` FROM `menu_master` WHERE `Parent_ID`='".$mainMenu['Category_ID']."' ORDER BY `position` ASC");
    						if(mysql_num_rows($resSubMenu)==0){
    						?>
    						
    						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($mainMenu['CategoryName'])?> <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    						<li class="divider"></li>
    							<li class=""><a href="Basic-Module/MenuMaster.php?catid=<?php echo $mainMenu['Category_ID']; ?>&val=<?php echo $mainMenu['CategoryName']; ?>"><i class="fa fa-plus"></i> Edit Links</a></li>
    						</ul>
    						</li>  
    						<?php
    						}else{
							?>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($mainMenu['CategoryName'])?> <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    							<?php
    							while($subMenu = mysql_fetch_assoc($resSubMenu)){
	    						?>
	    							<li class=""><a href="Basic-Module/UploadMenuDescription.php?menuNm=<?php echo $subMenu['CategoryName']; ?>"><?php echo ucwords($subMenu['CategoryName'])?></a></li>
	    						<?php
    							}
    						?>
    						<li class="divider"></li>
    								<li class=""><a href="Basic-Module/MenuMaster.php?catid=<?php echo $mainMenu['Category_ID']; ?>&val=<?php echo $mainMenu['CategoryName']; ?>"><i class="fa fa-plus"></i> Edit Links</a></li>
    						</ul>
    						</li>     
							<?php
    						}
    					}
    					?>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Results & Forms <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    							<li class=""><a href="Basic-Module/Adm_UploadData.php">Application Form</a></li>
    							<li class=""><a href="Basic-Module/Adm_UploadData.php">Examination Form</a></li>
    							<li class=""><a href="Basic-Module/Adm_UploadData.php">Prospectus</a></li>
    							<li class=""><a href="Basic-Module/Adm_UploadData.php">Results</a></li>
    						</ul>
    					</li>      
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Gallery <span class="caret"></span></a>
							<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
								<li class=""><a href="Basic-Module/Alb_CreateNewAlbum.php">Create Album</a></li>
								<li class=""><a href="Basic-Module/Alb_UploadImg.php">Upload Image</a></li>
							</ul>
						</li>   
						<li class=""><a href="Basic-Module/MailViewList.php">Mails</a></li>
						<?php
						if($_SESSION['role']=='SuperAdmin'){
							?>
							<li class=""><a href="Basic-Module/MenuMaster.php"><i class="fa fa-plus-circle fa-2x"></i></a></li>
							<?php
						}
    					?>
    					<li class=""><a href="javascript:void(0)" onclick="document.location.reload()"><i class="fa fa-refresh fa-2x"></i></a></li>
					</ul>
				  </nav>
				</div>
				</div>
				<div class="col-md-1">
					<div class="topnav">
						<div class="btn-toolbar">
						   <div class="btn-group">
								<a href="../_login/Logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
						  <i class="fa fa-power-off"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</header>
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
		<h3><i class="fa fa-home"></i> Home</h3>
	</div>
	<!-- /.main-bar -->
</header>
<!-- end header.head -->


             </div>
            <!-- /#top -->

<!-- #menu -->
<?php
include_once("leftframe.inc.php");
?>
<!-- /#menu -->

            <!-- /#left -->

            <div id="content">
                  <div class="outer">
                    <div class="inner" style="min-height: 550px;">
                      <div class="row">
                       <div class="col-lg-12">
                        <div class="box row">
                          
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


        <!-- #helpModal -->        

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 




        <script src="assets/lib/bootstrap/js/bootstrap.js"></script>





        
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        

        
        <script src="assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.min.js"></script>
		<script src="assets/lib/tablesorter/js/jquery.tablesorter.min.js"></script>
        <script src="assets/lib/sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/lib/flot/jquery.flot.js"></script>
        <script src="assets/lib/flot/jquery.flot.selection.js"></script>
        <script src="assets/lib/flot/jquery.flot.resize.js"></script>
                

        <script src="assets/js/main.js"></script>

        
        <script>
            $(function() { dashboard(); });
        </script>
        


</body>
</html>