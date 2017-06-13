<?php
function send_mail($name, $to_address, $from_address, $subject, $mailbody)
	{	
	ini_set('sendmail_from', '$from_address');
	$headers = array();
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-Type: text/html; charset="utf-8"';
	$headers[] = 'Content-Transfer-Encoding: 7bit';
	$headers[] = "From: $name ".$from_address;
	$header_part = join("\r\n", $headers);
	$success = mail($to_address, $subject , $mailbody, $header_part);	
	}

?>