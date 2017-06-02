    <header class="navbar-header" style="width:100%">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    	</button>
    	<!--top Menu-->
    	<div class="col-md-2">	
    		<a href="../../_cp/" class="navbar-brand"><img src="../assets/img/logo.png" alt=""></a>
    	</div>
    	<div class="col-md-9">  
    		<?php 
    		$resCategories = mysql_query("SELECT `Category_ID`, `CategoryName` FROM `menu_master` WHERE `Parent_ID`='0' ORDER BY `position` ASC");

    		?>
    		<div class="navbar-inverse">
    			<nav class="nav">
    				<ul class="nav navbar-nav">
    					<li><a href="../index.php">Home</a></li>
    					<?php
    					while($mainMenu = mysql_fetch_assoc($resCategories)){
    						$resSubMenu = mysql_query("SELECT `Category_ID`, `CategoryName` FROM `menu_master` WHERE `Parent_ID`='".$mainMenu['Category_ID']."' ORDER BY `position` ASC");
    						if(mysql_num_rows($resSubMenu)==0){
    						?>
    						
    						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucwords($mainMenu['CategoryName'])?> <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    						<li class="divider"></li>
    							<li class=""><a href="../Basic-Module/MenuMaster.php?catid=<?php echo $mainMenu['Category_ID']; ?>&val=<?php echo urlencode($mainMenu['CategoryName']); ?>"><i class="fa fa-plus"></i> Edit Links</a></li>
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
	    							<li class=""><a href="../Basic-Module/UploadMenuDescription.php?menuNm=<?php echo $subMenu['CategoryName']; ?>"><?php echo ucwords($subMenu['CategoryName'])?></a></li>
	    						<?php
    							}
    						?>
    						<li class="divider"></li>
    								<li class=""><a href="../Basic-Module/MenuMaster.php?catid=<?php echo urlencode($mainMenu['Category_ID']); ?>&val=<?php echo urlencode($mainMenu['CategoryName']); ?>"><i class="fa fa-plus"></i> Edit Links</a></li>
    						</ul>
    						</li>     
							<?php
    						}
    					}
    					?>
    					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Results & Forms <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    							<li class=""><a href="../Basic-Module/Adm_UploadData.php">Application Form</a></li>
    							<li class=""><a href="../Basic-Module/Adm_UploadData.php">Examination Form</a></li>
    							<li class=""><a href="../Basic-Module/Adm_UploadData.php">Prospectus</a></li>
    							<li class=""><a href="../Basic-Module/Adm_UploadData.php">Results</a></li>
    						</ul>
    					</li>     
    					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Gallery <span class="caret"></span></a>
    						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    							<li class=""><a href="../Basic-Module/Alb_CreateNewAlbum.php">Create Album</a></li>
    							<li class=""><a href="../Basic-Module/Alb_UploadImg.php">Upload Image</a></li>
    						</ul>
    					</li>   
    					<li class=""><a href="../Basic-Module/MailViewList.php">Mails</a></li>
    					<?php
    						if($_SESSION['role']=='SuperAdmin'){
    							?>
								<li class=""><a href="../Basic-Module/MenuMaster.php"><i class="fa fa-plus-circle fa-2x"></i></a></li>
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
    					<a href="../../_login/Logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
    						<i class="fa fa-power-off"></i>
    					</a>
    				</div>
    			</div>
    		</div>
    	</div>


    </header>
    

    