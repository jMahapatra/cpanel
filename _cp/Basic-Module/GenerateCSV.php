<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
?>
<?php
if(isset($_GET['doCSV']))
{
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=CSV_Format.csv');
	$output = fopen('php://output', 'w');
	$rows = mysql_query('SELECT `SubjectName` FROM `org_subject_master`');
	$sub = array("", "");
	$blank = array("ID", "Student Name");
	while ($row = mysql_fetch_assoc($rows)) { $sub[] = $row['SubjectName']; $blank[] = "FM";}
	fputcsv($output, $sub);
	fputcsv($output, $blank);
	$students = array();
	$res_students = mysql_query("SELECT BI_Id, BI_Name FROM `stud_basic_info` WHERE `BI_BranchID` = '".$_GET['branch']."' AND `BI_CourseID` = '".$_GET['course']."'");
	while($row_students = mysql_fetch_assoc($res_students))
	fputcsv($output, $row_students);
	die();
}
?>
