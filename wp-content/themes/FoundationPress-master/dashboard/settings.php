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
//$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/allergies_icon.png"></div>';
$html .= '<div class="title">Settings</div>';
$html .= '<hr>';
if($_POST['patient_id'])	{
	$lookup = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=$patient_id");
	foreach($lookup as $lu)	{
		$html .= '<div class="settings_container">';
		$html .= '<div class="profile_image">';
		$patient = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients WHERE user_id=$patient_id");
		foreach($patient as $p)	{
			$goal = $p->top_goal;
			if($p->image != '')	{
				$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/".$p->image."'>";
			} else {
				$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/avatar.png'>";
			}
		}
		$html .= '<button id="change_image">Change Image</button>';
		$html .= '</div>';
		$html .= '<div class="profile_info">';
		$html .= '<div>';
		$html .= '<input type="text" value="'.$lu->display_name.'" disabled>';
		$html .= '<input type="text" value="'.$lu->user_email.'" disabled>';
		$html .= '<div class="password_change">';
		$html .= 'Change Password<input type="text" value="" >';
		$html .= 'Confirm Password<input type="text" value="" >';
		$hmtl .= '<div class="password_message"></div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
	}
}
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>