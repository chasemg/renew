<?php

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$userid = $_POST['userid'];
$practice = $_POST['practice'];

include '../dashboard/db_include.php';

$pdb->query("INSERT INTO ". $wpdb->prefix."patients
	SET user_id = '".$userid."',
	fname = '".$fname."',
	lname = '".$lname."',
	practice_id = '".$practice."'"
);

?>