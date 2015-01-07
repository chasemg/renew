<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$html = '';
$id = $_POST['id'];
$patients = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients AS p INNER JOIN ".$wpdb->prefix. "users AS u ON u.ID=p.user_id WHERE p.doctor='$id'");
$html .= "<ul id='patients'>";
foreach($patients as $patient)	{
	$html .= "<li class='patient' id='".$patient->user_id."'><div class='search_image'><img src='".get_template_directory_uri()."/dashboard/profile_photos/".$patient->image."'></div><div class='patient_search_name'>".$patient->display_name."</div></li>";
}
$html .= "</ul>";

echo $html;
?>