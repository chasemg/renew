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
			
		$html .= '<div class="dashboard_goals doctor">';
		$html .= '<div class="goal_container">';
		$patient = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients WHERE user_id=$patient_id");
			$html .= '<div class="user_image doctor">';
			foreach($patient as $p)	{
				if($p->image != '')	{
					$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/".$p->image."'>";
				} else {
					$html .= "<img src='".get_template_directory_uri()."/dashboard/profile_photos/avatar.png'>";
				}
			}
			$html .= '</div>';
		
		$html .= '<div class="doctor_greet current_patient">Current patient: <span>' . $lu->display_name . '</span></div>';
		$html .= '<div class="link_btn select_patient">Select New Patient</div>';
		
		
		$html .= '</div>';
		$html .= '</div>';
		
		$html .= '<div class="dashboard_large_widget" style="margin-bottom:8px;">'; // Soap Notes
		$html .= '<h5>soap notes</h5>';
		$html .= '<div id="soap-note-container" class="clearfix">';
		$html .= '<div class="visit_record clearfix">'; // Visit Record
			$html .= '<div class="name">';
				$html .= '<h3>Patient Name:</h3><h4>John Doe</h4>';
			$html .= '</div>';
			$html .= '<div class="date">';
				$html .= '<h3>Date of visit:</h3><h4>11/10/2014</h4>';
			$html .= '</div>';
			$html .= '<div class="diagnosis">';
			$html .= '<h3>Diagnosis 11/10/2014</h3><p>Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel</p>';
			$html .= '</div>';
			$html .= '<div class="fullnote">';
			$html .= '<div class="btn_soapfullnote">See Full Soap Note</div>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
		$html .= '<div class="small_widget_container">';
			$html .= '<div class="widget_row">';
/********************** Social History ***************************************/
				$html .= '<div class="dashboard_small_widget">';
					$html .= '<div class="dashboard_small_widget_content">';
					$html .= '<div class="title">Social History</div>';
					$html .= '<div class="dash_widget_content">';
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
						$description = $s->description;
						$stripped_description = (strlen($description) > 120) ? substr($description,0,120).'...' : $description;
						$html .= '<div class="social_summary" style="padding: 0 20px; width: auto;">'.$stripped_description.'</div>';
					}
					
					$html .= '</div>';
					$html .= '</div>';
					
					$html .= '<div class="dashboard_small_widget_lip" id="social">';
					$html .= '<p>See Full Social History</p>';
					$html .= '</div>';
					
				$html .= '</div>';
				$html .= '<div class="dashboard_small_widget last">';
/********************** Immunizations ***************************************/
					$html .= '<div class="dashboard_small_widget_content">';
					$html .= '<div class="title">Immunizations</div>';					
						$html .= '<div class="dash_widget_content">';
						$immun = $pdb->get_results("SELECT *, date_format(date, '%m/%d/%Y') as date FROM ".$wpdb->prefix. "immunizations WHERE user_id='$patient_id'");
						$html .= '<table style="margin: 0 auto; float: none;">';
						$html .= '<tr><td></td><td>Doses</td><td>Date</td></tr>';
						
						foreach($immun as $x => $i)	
						{
							$html .= sprintf("<tr><td>immune %s</td><td>%s</td><td>%s</td></tr>", $x + 1, $i->doses, $i->date);	
						}
						
						$html .= '</table>';
						$html .= '</div>';					
					$html .= '</div>';
					$html .= '<div class="dashboard_small_widget_lip" id="immunizations">';
					$html .= '<p>See full immunizations</p>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</div>';
			
			
			
			
			$html .= '<div class="widget_row">';
/********************** Medications ***************************************/
				$html .= '<div class="dashboard_small_widget">';
					$html .= '<div class="dashboard_small_widget_content">';
					$html .= '</div>';
					$html .= '<div class="dashboard_small_widget_lip" id="meds">';
					$html .= '<p>See Full Medications</p>';
					$html .= '</div>';
				$html .= '</div>';
/********************** Medical History ***************************************/
				$html .= '<div class="dashboard_small_widget last">';
					$html .= '<div class="dashboard_small_widget_content">';
					$html .= '<div class="title">Medical History</div>';
						$html .= '<div class="dash_widget_content">';
						
						$exam_dates = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "exams WHERE user_id='$patient_id' AND exam_type='1' ORDER BY exam_date DESC LIMIT 1");
						foreach($exam_dates as $exam)	{
							$exam_date = $exam->exam_date;
						}
			
						$medical = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "medical_history WHERE user_id='$patient_id' LIMIT 1");
						foreach($medical as $m)	{
							$html .= '<div class="last_exam">Date of last physical exam: <span>'.date("m/d/Y", $exam_date).'</span></div>';
							$notes = $m->notes;
							$stripped_notes = (strlen($notes) > 225) ? substr($notes,0,225).'...' : $notes;
							$html .= '<div class="text stripped-notes">'.$stripped_notes.'</div>';
							
						}
						
						$html .= '</div>';
					$html .= '</div>';
						$html .= '<div class="dashboard_small_widget_lip" id="medical_history">';
						$html .= '<p>See full Medical History</p>';
						$html .= '</div>';

				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
	
	}
	
	echo $html;
	
}
?>