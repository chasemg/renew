<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

echo "SCHEDULING";
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$immun = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "immunizations WHERE user_id='$patient_id' ORDER BY date DESC LIMIT 1");
foreach($immun as $i)	{
	

}
?>