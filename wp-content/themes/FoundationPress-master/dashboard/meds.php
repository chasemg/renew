<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

echo "MEDICATIONS";
include "db_include.php";
$id = $_POST['id'];
$immun = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "immunizations WHERE user_id='$id' ORDER BY date DESC LIMIT 1");
foreach($immun as $i)	{
	

}
?>