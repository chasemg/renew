<?php

include '../dashboard/db_include.php';

$html = '';
/*if($_POST['email'])	{
	$email = $_POST['email'];
	
}
if($_POST['username'])	{
	$username = $_POST['username'];
	
}*/

$email = $_POST['email'];

$json = array('email' => 1, 'address' => 1);

if (email_exists($email))	
{
	$json['email'] = 0;
} 


if (username_exists($email))	
{
	$json['email'] = 0;
} 


echo json_encode($json);

?>