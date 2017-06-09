<?php
include("../../require/session.inc.php");
include("../../require/connection.inc.php");
?>

<?php 
	if($_POST['action'] == "fetchCategory")
	{
		$res_category = mysql_query("SELECT * FROM `menu_master` WHERE `Parent_ID` = '".$_POST['data']."' ORDER BY `position` ASC");
		$row_parent = mysql_fetch_assoc(mysql_query("SELECT * FROM `menu_master` WHERE `Category_ID` = '".$_POST['data']."'"));
		?>
        				<div class="box">
                          <header class="dark">
                            <h5>Menu <i class="fa fa-angle-right"></i>
                              <a href="javascript:void(0)"><?php echo ucwords($row_parent['CategoryName'])?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0)" onclick="fillCategory(<?php echo $row_parent['Parent_ID']?>,'<?php echo $row_parent['CategoryName']?>')"><?php if($row_parent['Parent_ID']!=''){?><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back<?php } ?></a>
                            </h5>
                          </header>
                         </div>
                    <?php
					while($row_category = mysql_fetch_assoc($res_category)){
						
						if($row_category['IsDeleted']=='yes')
						{$msg = 'fa-plus-circle text-success'; $status = 'no';}else
						{$msg = 'fa-minus-circle text-danger'; $status = 'yes';}
						if($row_category['InMenu']=='yes')
						{$menu = 'text-success fa-check';}else
						{$menu = 'fa-circle-o';}
						if($row_category['Parent_ID']==0){
							$redirect = "../Basic-Module/Upload_ProductCat.php?query=".$row_category['Category_ID'];
						}else{
							$redirect = "../Basic-Module/Upload_ProductCat.php?query=".$row_parent['Category_ID']."&sub=".$row_category['Category_ID'];
						}
						
						$row_count = mysql_fetch_assoc(mysql_query("SELECT COUNT(`Category_ID`) as `TotalSub` FROM `menu_master` WHERE `Parent_ID`='".$row_category['Category_ID']."'"));
					?>
                        <div class="col-lg-6" style="font-size:13px;font-weight:600">
                         <i class="fa <?php echo $menu;?>"></i>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="fillCategory(<?php echo $row_category['Category_ID']?>,'<?php echo $row_category['CategoryName']?>')"><?php echo ucwords($row_category['CategoryName'])?></a>&nbsp;&nbsp; 
                        </div>
						
                        <div class="col-lg-1" style="font-size:11px;font-weight:600"><?php echo '('.$row_count['TotalSub'].')'?></div>
                        
                        <div class="col-lg-1">
                        	<a href="javascript:void(0)" onclick="updatePosition(<?php echo $row_category['Parent_ID']?>,<?php echo $row_category['Category_ID']?>,<?php echo $row_category['position']?>,'up')"><i class="fa fa-arrow-up"></i></a>
                        </div>

                        <div class="col-lg-1">
                        	<a href="javascript:void(0)" onclick="updatePosition(<?php echo $row_category['Parent_ID']?>,<?php echo $row_category['Category_ID']?>,<?php echo $row_category['position']?>,'down')"><i class="fa fa-arrow-down"></i></a>
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                        <div class="col-lg-1">
                        	<a href="javascript:void(0)" onclick="updateFill(<?php echo $row_category['Parent_ID']?>,'<?php echo $row_parent['CategoryName']?>',<?php echo $row_category['Category_ID']?>,'<?php echo $row_category['CategoryName']?>','<?php echo $row_category['InMenu']?>')"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="col-lg-1"><a href="javascript:void(0)" onclick="deactivate(<?php echo $row_category['Parent_ID']?>,<?php echo $row_category['Category_ID']?>,'<?php echo $status;?>')"><i class="fa <?php echo $msg?>"></i></a></div>
                        <?php
					}
					?>
        <?php
	}
?>

<?php 
	if($_POST['action'] == "addCategory")
	{

 		$parentId = $_POST['parentId'];
		$categoryName = strtolower($_POST['categoryName']);


		$active = 'yes';
		$addedMenu = $_POST['showMenu'];
		$deleted = 'no';
		
		$prevPos = mysql_query("SELECT `position` FROM `menu_master` WHERE Parent_ID = '$parentId' ORDER BY `position` DESC LIMIT 0,1");
		if(mysql_num_rows($prevPos)>0){
			$prevRow = mysql_fetch_assoc($prevPos);
			$newPosition = (int)$prevRow['position']+1;
		}else{
			$newPosition = 1;
		}
		
		mysql_query("INSERT INTO `menu_master`(`Parent_ID`, `CategoryName`, `position`, `InMenu`, `IsDeleted`, `IsActive`)VALUES('$parentId','$categoryName', '$newPosition', '$addedMenu','$deleted','$active')")or die(mysql_error());

		mysql_query("INSERT INTO `menu_contents`(`MenuName`, `LE_UpdatedDate`,`LE_UpdatedBy`) VALUES ('$categoryName', '".date('Y-m-d')."', '".$_SESSION['username']."')") or die(mysql_error());
	}
?>
<?php 
	if($_POST['action'] == "deactivate")
	{
 		$categoryId = $_POST['categoryId'];
		$deleteStatus = $_POST['status'];
		
		mysql_query("DELETE FROM `menu_master` WHERE `Category_ID` = '$categoryId'")or die(mysql_error());// Remove Menu
		mysql_query("DELETE FROM `menu_master` WHERE `Parent_ID` = '$categoryId'"); //Remove Sub Menu(s)
		mysql_query("OPTIMIZE TABLE `menu_master`");
	}
?>
<?php 
	if($_POST['action'] == "updateCategory")
	{
		$parentId = $_POST['parentId']; $parentName = $_POST['parentName'];
 		$categoryId = $_POST['categoryId'];  $categoryName = $_POST['categoryName'];
		$showMenu = $_POST['showMenu'];
		mysql_query("UPDATE `menu_master` SET `Parent_ID`='$parentId',`CategoryName`='$categoryName',`InMenu`='$showMenu' WHERE `Category_ID` = '$categoryId'")or die(mysql_error());
	}
?>
<?php 
	if($_POST['action'] == "position")
	{
		$parentId = $_POST['parentId']; 
 		$categoryId = $_POST['categoryId']; 
		$currPosition = $_POST['position'];
		$type = $_POST['type'];
		if($type=='up'){
			$queryPos = "SELECT Category_ID,position FROM menu_master WHERE Parent_ID='$parentId' AND position<$currPosition ORDER BY position DESC LIMIT 0,1";
		}else if($type=='down'){
			$queryPos = "SELECT Category_ID,position FROM menu_master WHERE Parent_ID='$parentId' AND position>$currPosition ORDER BY position ASC LIMIT 0,1";
		}

		
		$posResult = mysql_query($queryPos);
		$rowPos = mysql_fetch_assoc($posResult);

		$gotoLine = $rowPos['position'];//line to go to
       	$idLine = $rowPos['Category_ID'];
       	//one position up
       	$queryUpdate = "UPDATE menu_master SET position=$gotoLine WHERE Category_ID=$categoryId";
       	$update = mysql_query($queryUpdate);
       	//one position down
       	$queryUpdate2 = "UPDATE menu_master SET position=$currPosition WHERE Category_ID=$idLine";
       	$update2 = mysql_query($queryUpdate2);


	}
?>