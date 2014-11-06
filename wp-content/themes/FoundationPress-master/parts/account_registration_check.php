<?php

include '../dashboard/db_include.php';

print_r($_POST); die();

$html = '';
if($_POST['email'])	{
	$email = $_POST['email'];
	if (email_exists($email))	{
		$html .= 0;
	} else {
		$html .= 1;
	}
}
if($_POST['username'])	{
	$username = $_POST['username'];
	if (username_exists($username))	{
		$html .= 0;
	} else {
		$html .= 1;
	}
}
echo $html;

?>