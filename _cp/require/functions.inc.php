<?php
function filter_qsid($qsname)
	{
	if(strchr($qsname, " ") || strchr($qsname, " & "))
		{
		if(strchr($qsname, " "))
			{
			$newqsname = str_replace(" ", "", $qsname);
			}
		if(strchr($qsname, " & "))
			{
			$newqsname = str_replace(" & ", "", $qsname);
			}
		return strtolower($newqsname);
		}
	else
		{
		return strtolower($qsname);
		}
	}

function trim_body($text, $max_length) 
{
$tail = '...';
$tail_len = strlen($tail);
if (strlen($text) > $max_length) 
	{
	$tmp_text = substr($text, 0, $max_length - $tail_len);
	if (substr($text, $max_length - $tail_len, 1) == ' ') 
		{
		$text = $tmp_text;
		}
	else
		{
		$pos = strrpos($tmp_text, ' ');
		$text = substr($text, 0, $pos);
		}
$text = $text . $tail;
	}	
return $text;
}

function clean($str)
	{
    $str = @trim($str);
    if(get_magic_quotes_gpc())
		{
        $str = stripslashes($str);
    	}
    return mysql_real_escape_string($str);
	}
function password_encrypt($pwd1)
{
	$test = str_split($pwd1);
	$temp = "";
	for($i = 0; $i < strlen($pwd1); $i++)
	{
		if($i%2 == 0)
		{
			$temp .= ord(str_rot13($test[$i])).ord('*');
		}
		else
		{
				$temp .= ord($test[$i]).ord('@');
		}
	}
	$source = array('0','1','2','3','4','5','6','7','8','9');
	$replace = array('!','@','#','$','%','^','&','*','(');
	$pwd2 = str_replace($source, $replace, $temp);
	return $pwd2;
}

function change_date($resource)
	{
	$new_dt = date('d-m-Y h:i:s A', strtotime($resource));
	return $new_dt;
	}

function getip()
	{
	if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
		 //check for ip from share internet
		 $ip = $_SERVER["HTTP_CLIENT_IP"];
		}
	elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
		 // Check for the Proxy User
		 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
	else
		{
		 $ip = $_SERVER["REMOTE_ADDR"];
		}
	return $ip;
	}

// 	Function To Validate The Image
function validate_img($resource)
	{
	global $error;
	if($resource['error'] > 0)
	{
	switch($resource['error'])
		{
		case UPLOAD_ERR_INI_SIZE:
		$error[] = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
		break;
		case UPLOAD_ERR_FORM_SIZE:
		$error[] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
		break;
		case UPLOAD_ERR_PARTIAL:
		$error[] = "The uploaded file was only partially uploaded. ";
		break;
		case UPLOAD_ERR_NO_FILE:
		$error[] = "Please Upload A File. ";
		break;
		case UPLOAD_ERR_NO_TMP_DIR:
		$error[] = "The server is missing a temporary folder. ";
		break;
		case UPLOAD_ERR_CANT_WRITE:
		$error[] = "The server failed to write the uploaded file to disk. ";
		break;
		case UPLOAD_ERR_EXTENSION:
		$error[] = "File upload stopped by extension. ";
		break;
		}
	}
	if($resource['name'] != "")
	{
	list($width, $height, $type, $attr) = getimagesize($resource['tmp_name']);
	switch($type)
		{
		case IMAGETYPE_GIF:
		 // To keep The Array Empty
		break;
		case IMAGETYPE_JPEG:
		 // To keep The Array Empty
		break;
		case IMAGETYPE_PNG:
		 // To keep The Array Empty
		break;
		default:
		$error[] = "The file you uploaded was not a supported filetype. ";
		}
	}
	if($resource['size'] > 80000000)
		{
		$error[] = "The File Exceeds Maximum Upload Limit. ";	
		}
	}
	
	
//Upload Image Script
function upload_image($resource, $dir, $image_nm, $new_width, $new_height, $aspectratio)
{
	list($width, $height, $type, $attr) = getimagesize($resource['tmp_name']);
	switch($type)
		{
		case IMAGETYPE_GIF:
		$image = imagecreatefromgif($resource['tmp_name']);
		break;
		case IMAGETYPE_JPEG:
		$image = imagecreatefromjpeg($resource['tmp_name']);
		break;
		case IMAGETYPE_PNG:
		$image = imagecreatefrompng($resource['tmp_name']);
		break;
		}
	if($aspectratio == "yes")
	{	
	$ratio = $width / $height;
	if($new_width / $new_height > $ratio)
		{
		$new_width = $new_height * $ratio;	
		}
	else
		{
		$new_height = $new_width / $ratio;
		}
	}
	$new_image = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	imagejpeg($new_image, $dir."/".$image_nm, 100);
	imagedestroy($new_image);
	
	imagedestroy($image);
}
?>
