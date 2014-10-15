<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$html = '';
$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/immunizations_icon.png"></div>';
$html .= '<div class="title">Immunizations</div>';
$html .= '<hr>';


$immunizations = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "immunizations WHERE user_id='$patient_id' LIMIT 1");
foreach($immunizations as $i)	{
	$html .= '<div class="text"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here is a detailed look</font> at your immunizations. You can download a complete schedule below.</div>';
	$html .= '<div class="immun_container">';
	$html .= '<table>';
	$html .= '<tr><td></td><td>Doses</td><td>Date</td></tr>';
	//$immunization_array = $i->immunizations;
	$array = array(
		array("immune 1", 1, "1411415705"),
		array("immune 2", 3, "1411415705"),
		array("immune 3", 1, "1411415705")
	);
	$serialized = serialize($array);
	$unserialized_array = unserialize($i->immunizations);
	$x=0;
	foreach($unserialized_array as $us)	{
		if(ceil($x/5) == 2)	{
			$html .= '</table><table>';
			$html .= '<tr><td></td><td>Doses</td><td>Date</td></tr>';
			$x=0;
		}
		$html .= '<tr>';
		$html .= "<td>".$us[0]."</td><td>".$us[1]."</td><td>".date('m/d/Y', $us[2])."</td>";
		$html .= '</tr>';
		$x++;
	}
	$html .= '</table>';
	$html .= '</div>';
}
$html .= '<hr>';
$html .= '<div class="immun_schedule"><a href="http://www.cdc.gov/vaccines/schedules/" target="_blank"><img src="'.get_template_directory_uri().'/dashboard/images/complete_sched_imm.png"></a></div>';
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>