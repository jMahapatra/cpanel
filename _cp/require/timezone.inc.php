<?php
//timezone of INDIA
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set'))
	{
	date_default_timezone_set($timezone);
	}
$dt_time  = date('Y-m-d H:i:s');
$date = date("Y-m-d");

?>