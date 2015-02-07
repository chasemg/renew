<?php

include '../dashboard/db_include.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];

$userdata = array(
	'user_login'	=>  $username,
	'user_email'	=>	$email,
	'first_name'	=>	$fname,
	'last_name'		=>	$lname,
);
wp_insert_user( $userdata ) ;

?>
