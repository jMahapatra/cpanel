<?php 
	require_once("../../require/connection.inc.php");
	require("../../require/functions.inc.php");

	if($_POST['action'] == "selectDist")
	{
		$res_dist = mysql_query("SELECT `DistrictName` FROM `z_district` WHERE `State_ID` IN (SELECT `State_ID` FROM `z_state` WHERE `StateName` = '".$_POST['stateVal']."')");
		?>
        <option value="">Select</option>
        <?php
		while($row_dist = mysql_fetch_assoc($res_dist))
		{
			?>
            <option value="<?php echo $row_dist['DistrictName']; ?>"><?php echo $row_dist['DistrictName']; ?></option>
            <?php
		}
	}
	
	if($_POST['action'] == "selectCity")
	{
		$res_city = mysql_query("SELECT `CityName` FROM `z_city` WHERE `District_ID` IN (SELECT `District_ID` FROM `z_district` WHERE `DistrictName` = '".$_POST['distVal']."')");
		echo "SELECT `CityName` FROM `z_city` WHERE `District_ID` IN (SELECT `District_ID` FROM `z_district` WHERE `DistrictName` = '".$_POST['distVal']."')";
		?>
        <option value="">Select</option>
        <?php
		while($row_city = mysql_fetch_assoc($res_city))
		{
			?>
           	<option value="<?php echo $row_city['CityName']; ?>"><?php echo $row_city['CityName']; ?></option>
            <?php
		}
	}
	
	if($_POST['action'] == "checkUserNm")
	{
		$res_chkUserNm = mysql_query("SELECT * FROM `login_info` WHERE `LI_UserName` = '".$_POST['userNm']."'");
		if(mysql_num_rows($res_chkUserNm) > 0)
			die("error");
		else
			die("success");
			
	}
	if($_POST['action'] == "userRegister")
	{
		mysql_query("INSERT INTO `login_info` (`LI_UserName`, `LI_Password`, `LI_Email`, `LI_SecQue`, `LI_SecAns`, `LI_DateCreated`, `LI_Role`) VALUES ('".$_POST['userNm']."', '".password_encrypt($_POST['password'])."', '".$_POST['userNm']."', '".$_POST['secQues']."', '".$_POST['secAns']."', TIMESTAMP(NOW()), '3')");
		$userId = mysql_insert_id();
		
		mysql_query("INSERT INTO `login_status` (`LS_UserID`, `LS_TypeID`, `LS_Time`) VALUES ('".$userId."', '1', TIMESTAMP(NOW()))");
		$userImg = ($_POST['gender'] == "Male") ? "MaleUser.jpg" : "FemaleUser.jpg";
		
		mysql_query("INSERT INTO `stud_basic_info` (`BI_LoginName`, `BI_Name`, `BI_DOB`, `BI_Gender`, `BI_Mob1`, `BI_Image`, `BI_ImageLoc`, `BI_CreatedOn`,`BI_BranchID`, `BI_CourseID`) VALUES ('".$_POST['userNm']."', '".$_POST['name']."', '".$_POST['dob']."', '".$_POST['gender']."', '".$_POST['mobNo']."', '$userImg', 'Relative', DATE(NOW()), '".$_POST['branch']."', '".$_POST['course']."')");
		
		mysql_query("INSERT INTO `address_detail` (`AddressType`, `UserType`, `LoginName`, `Address`, `State`, `District`, `City`, `PIN`) VALUES ('Present', 'Student', '".$_POST['userNm']."', '".$_POST['address']."', '".$_POST['state']."', '".$_POST['dist']."', '".$_POST['city']."', '".$_POST['pin']."')");
		session_start();
		$_SESSION['username'] = $_POST['userNm'];
		$_SESSION['role'] = "Student";
		$_SESSION['userGroup'] = "User";
	}
?>