<?php

include '../dashboard/db_include.php';

$new_fname = $_POST['new_fname'];
$new_lname = $_POST['new_lname'];
$new_email = $_POST['new_email'];
$new_username = $_POST['new_username'];

$userdata = array(
    'user_login'	=>  $new_username,
    'user_pass'		=>  wp_generate_password(),
	'user_email'	=>	$new_email,
	'first_name'	=>	$new_fname,
	'last_name'		=>	$new_lname,
);

wp_insert_user( $userdata ) ;

?>
