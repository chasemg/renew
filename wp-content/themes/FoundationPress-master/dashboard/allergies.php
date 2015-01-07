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
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/allergies_icon.png"></div>';
$html .= '<div class="title">Allergies</div>';
$html .= '<hr>';

$immunizations = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "allergies WHERE user_id='$patient_id'");
foreach($immunizations as $i)	{
	$html .= '<div class="text"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here is a detailed look</font> at your allergies. Below is a brief description of your symptoms.</div>';
	$html .= '<div class="immun_container">';
	$html .= '<table>';
	$html .= '<tr><td></td><td>Severity</td></tr>';
	//$immunization_array = $i->immunizations;
/*	$array = array(
		array("Peanuts", 10),
		array("Bees", 8),
		array("Molds", 4),
		array("Grass", 1),
		array("Pollens", 3),
		array("Tree Nuts", 2)
	);
	$serialized = serialize($array); */
	$unserialized_array = unserialize($i->allergies);
	$x=0;
	foreach($unserialized_array as $us)	{
		$html .= '<tr>';
		$html .= "<td>".$us[0]."</td><td>".$us[1]."</td>";
		$html .= '</tr>';
		$x++;
	}
	$html .= '</table>';
	$html .= '<div class="description">';
	$html .= '<div>When you have an allergic reaction there may be a combination of these symptoms:</div>';
	$html .= '<ul>';
	$html .= '<li>Sneezing</li>';
	$html .= '<li>Wheezing</li>';
	$html .= '<li>Nasal Congestion</li>';
	$html .= '<li>Coughing</li>';
	$html .= '<li>DEATH</li>';
	$html .= '</ul>';
	$html .= '</div>';
	$html .= '</div>';
}
$html .= '<hr>';
$html .= '<div class="immun_schedule" style="text-align: center;"><img src="'.get_template_directory_uri().'/dashboard/images/reaction_scale.png"></div>';
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>