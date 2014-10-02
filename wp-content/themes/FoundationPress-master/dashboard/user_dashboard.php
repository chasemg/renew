<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";

$html = '';

$id = $_POST['id'];
$patient_id = $_POST['patient_id'];

if($_POST['patient_id'])	{

		$lookup = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=$patient_id");
		foreach($lookup as $lu)	{
			$html .= '<div class="dashboard_goals">';
			$html .= '<div class="goal_container">';
			$html .= '<div class="user_image">';
			$patient = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients WHERE user_id=$patient_id");
			foreach($patient as $p)	{
				$goal = $p->top_goal;
				if($p->image != '')	{
					$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/".$p->image."'>";
				} else {
					$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/avatar.png'>";
				}
			}
			$html .= '</div>';
			$html .= "<div class='goal_text'>Welcome <font style='color:#00af41'>". $lu->display_name ."</font>";
			$html .= '<div class="goal_text_second_line">Your top goal is to <font style="color: #00af41;">';
			$goals = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "goals WHERE goal_id=$goal");
			foreach($goals as $g)	{
				$html .= $g->goal.".";
			}
			$html .= '</font></div>';
			$html .= '<div class="goals_button" id="goals"><img src="'.get_template_directory_uri().'/dashboard/images/goals_button.png"></div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<hr width="640px">';
/******************** Recent Vitals ***************************/			
			$html .= '<div class="dashboard_large_widget">';
			$html .= '<h5>recent vitals</h5>';
			$html .= '<div class="dashboard_vitals_row">';
			$vitals = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "vitals WHERE user_id='$patient_id' ORDER BY taken_date DESC LIMIT 1");
			foreach($vitals as $v)	{
				$bp = unserialize($v->bp);
				$html .= '<div class="dashboard_vitals"><div class="title">Blood Pressure</div><div class="bp">'.$bp.'</div><div><img src="'.get_template_directory_uri().'/dashboard/images/bp_icon.png"></div></div>';
				$html .= '<div class="dashboard_vitals"><div class="title">Resting Pulse</div><div class="pulse">'.$v->pulse.'</div><div><img src="'.get_template_directory_uri().'/dashboard/images/pulse_icon.png"></div></div>';
				$html .= '<div class="dashboard_vitals"><div class="title">Temperature</div><div class="temp">'.$v->temperature.'</div><div><img src="'.get_template_directory_uri().'/dashboard/images/temp_icon.png"></div></div>';
				$html .= '<div class="dashboard_vitals"><div class="title">Respiration</div><div class="resp">'.$v->respiration.'</div><div><img src="'.get_template_directory_uri().'/dashboard/images/resp_icon.png"></div></div>';
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_large_widget_lip" id="vitals">';
			$html .= '<p>See full recent vitals list</p>';
			$html .= '</div>';
/********************* Small Widgets *************************************/
			$html .= '<div class="small_widget_container">';
			
/********************** Immunizations ***************************************/
			$html .= '<div class="dashboard_small_widget left">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Immunizations</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="immunizations">';
			$html .= '<p>See full immunizations list</p>';
			$html .= '</div>';
			$html .= '</div>';
/********************** Allergies ***************************************/
			$html .= '<div class="dashboard_small_widget right">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Allergies</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="allergies">';
			$html .= '<p>See full allergies list</p>';
			$html .= '</div>';
			$html .= '</div>';	

/********************** Labs ***************************************/
			$html .= '<div class="dashboard_small_widget left">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Lab Results</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="labs">';
			$html .= '<p>See full lab results</p>';
			$html .= '</div>';
			$html .= '</div>';

/********************** Medical History ***************************************/
			$html .= '<div class="dashboard_small_widget right">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Medical History</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="medical_history">';
			$html .= '<p>See full recent medical history</p>';
			$html .= '</div>';
			$html .= '</div>';				
		
/********************** Medications ***************************************/
			$html .= '<div class="dashboard_small_widget left">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Medications</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="meds">';
			$html .= '<p>See medication list</p>';
			$html .= '</div>';
			$html .= '</div>';

/********************** Social Life ***************************************/
			$html .= '<div class="dashboard_small_widget right">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">My Social Life</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="social">';
			$html .= '<p>My Social Life</p>';
			$html .= '</div>';
			$html .= '</div>';				
		}		
		echo $html;
} else {
	
	if (get_user_role() == 'lab_doctor')
	{
		include('lab_dashboard.php');
	}
	else
	{
		echo "Doctor's dashboard";
	}
}
?>