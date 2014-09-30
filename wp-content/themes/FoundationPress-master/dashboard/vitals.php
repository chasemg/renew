<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$html = '';
$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/vitals_icon.png"></div>';
$html .= '<div class="title">Vitals</div>';
$html .= '<hr>';

$vitals = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "vitals WHERE user_id='$id' ORDER BY taken_date DESC LIMIT 1");
foreach($vitals as $v)	{
	$taken_date = $v->taken_date;
	$converted_date = date("m/d/Y", $taken_date);
	$html .= '<div class="text"><b>'.$converted_date.'</b><br>Vivamus ultrices neque eu enim pulvinar vulputate. Phasellus dapibus ornare erat nec dignissim. Cras malesuada augue egestas mauris viverra, nec gravida lacus scelerisque. Aenean fermentum velit tempus sollicitudin egestas. Cras a sapien lorem. Donec ex lectus, pharetra non quam in, maximus porta ipsum. Sed sit amet pellentesque justo. Etiam et felis lorem. Aliquam eget facilisis enim.</div>';
	$html .= '<div class="vitals_container">';
	$html .= '<div class="vitals"><div class="title">Blood Pressure</div><div class="bp">'.$v->bp.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/bp_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Resting Pulse</div><div class="pulse">'.$v->pulse.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/pulse_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Temperature</div><div class="temp">'.$v->temperature.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/temp_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Respiration</div><div class="respiration">'.$v->respiration.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/resp_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Blood Oxygen Saturation</div><div class="bos">'.$v->bos.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/oxy_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">BMI</div><div class="bmi">'.$v->bmi.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/bmi_scale.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Weight</div><div class="weight">'.$v->weight.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/weight_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Height</div><div class="height">'.$v->height.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/height_icon.png"></div></div>';
	$html .= '<div class="vitals"><div class="title">Age</div><div class="age">'.$v->age.'</div><div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/age_icon.png"></div></div>';
	$html .= '</div>';
}
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>