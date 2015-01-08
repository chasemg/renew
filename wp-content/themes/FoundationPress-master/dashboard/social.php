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
$html .= '<div class="title">My Social Life</div>';
$html .= '<hr>';

$social_life = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "social_life WHERE user_id='$patient_id'");
foreach($social_life as $s)	{
	$smoker = $s->smoker;
	$marital_state = $s->marital_state;
	$month = date("m",$s->dob);
	$day = date("d",$s->dob);
	$questions = unserialize($s->questions);
	$html .= '<div class="social_summary">';
		$html .= '<div>';
			$html .= '<div class="social_header_icon">';
				$ms = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "marital_status WHERE id='$marital_state'");
				foreach($ms as $m)	{
					$html .= '<div class="title">'.$m->marital_status.'</div>';
					$html .= '<div><img src="'.get_template_directory_uri().'/dashboard/images/'.$m->icon.'.png"></div>';
				}
			$html .= '</div>';
			$html .= '<div class="social_header_icon">';
				$st = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "smoker_type WHERE id='$smoker'");
				foreach($st as $sp)	{
					$html .= '<div class="title">'.$sp->smoker_type.'</div>';
					$html .= '<div><img src="'.get_template_directory_uri().'/dashboard/images/'.$sp->icon.'.png"></div>';
				}
			$html .= '</div>';
			$html .= '<div class="social_header_icon">';
				$html .= '<div class="title">Birthday</div>';
				$html .= '<div><div class="birthday">'.$month.'<font style="color: #00af41;">|</font>'.$day.'</div></div>';
			$html .= '</div>';
		$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="social_summary"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here is a detailed look</font> at your social life. Here will be a list of your hobbies, your profession and basically a small summary of you.<br><br> '.$s->description.'</div>';

}
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>