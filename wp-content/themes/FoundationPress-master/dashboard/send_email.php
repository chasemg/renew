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
	$wpdb->insert($wpdb->prefix."communication", array('user_id'=>$message_to, 'read'=>0,'message'=>$message,'date_sent'=>$send_date,'from'=>$user_id,'subject'=>$subject));
}
?>