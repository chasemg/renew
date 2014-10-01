<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$html = '';
$id = $_POST['id'];
$patients = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients AS p INNER JOIN ".$wpdb->prefix. "users AS u ON u.ID=p.user_id WHERE p.doctor='$id'");
$html .= "<ul>";
foreach($patients as $patient)	{
	$html .= "<li class='patient' id='".$patient->user_id."'>".$patient->display_name."</li>";
}
$html .= "</ul>";

echo $html;
?>