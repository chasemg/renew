<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$message_to = $_POST['message_to'];
$user_id = $_POST['user_id'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$send_date = $_POST['send_date'];

if($_POST['message_to'])	{
	$update_query = $wpdb->insert($wpdb->prefix."divorce_packages", array('package_name'=>$name, 'status'=>$status,'type'=>$type,'price'=>$price,'highlights'=>$highlights,'info'=>$info));
}
?>