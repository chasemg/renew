<?php

include '../dashboard/db_include.php';

$html = '';
if($_POST['email'])	{
	$email = $_POST['email'];
	if (email_exists($email))	{
		$html .= 0;
	} else {
		$html .= 1;
	}
}
echo $html;
?>