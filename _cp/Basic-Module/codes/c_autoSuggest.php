<?php
include("../../require/session.inc.php");
include("../../require/connection.inc.php");


if($_POST['action'] == "suggestParCatg")
{
	if($_POST['data'] != "")
	{
		$res_Category = mysql_query("SELECT `Category_ID`, `CategoryName` FROM `menu_master` WHERE `CategoryName` LIKE '".$_POST['data']."%' LIMIT 0, 10");
		if(mysql_num_rows($res_Category) > 0)
		{
			?>
				<ul class="suggest" id="suggest">
				<?php
				$i=1;
				while($row_Category = mysql_fetch_array($res_Category))
				{
				?>
				<li id="<?php echo $row_Category['Category_ID']?>"><?php echo $row_Category['CategoryName'];?></li>
				<?php
				$i++;
				}
				?>
			</ul>
			<?php
		}
		else{?>
			<ul class="suggest" id="suggest">
				<li>Not Available</li>
			</ul>
			<?php
		}
	}
}

if($_POST['action'] == "suggestCategory")
{
	if($_POST['data'] != "")
	{
		$cond = ($_POST['parent'] != "")?"AND `Parent_ID`=".$_POST['parent']:"";
		 
		$res_Category = mysql_query("SELECT `Parent_ID`, `Category_ID`, `CategoryName` FROM `menu_master` WHERE `CategoryName` LIKE '%".$_POST['data']."%' AND `Parent_ID`!='0' $cond LIMIT 0, 10");
		if(mysql_num_rows($res_Category) > 0)
		{
			?>
            <ul class="suggest" id="suggest">
            <?php
            $i=1;
            while($row_Category = mysql_fetch_array($res_Category))
            {
            ?>
            <li title="<?php echo $row_Category['Parent_ID'].','.$row_Category['CategoryName'].','.$row_Category['Category_ID'];?>"><?php echo $row_Category['CategoryName'];?>
            </li>
            <?php
            $i++;
            }
            ?>
			</ul>
			<?php
		}
		else{?>
			<ul class="suggest" id="suggest">
				<li>Not Available</li>
			</ul>
			<?php
		}
	}
}


?>


