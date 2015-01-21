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
			$patient = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients WHERE user_id=$patient_id");
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
			$goals = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "goals WHERE goal_id=$goal");
			foreach($goals as $g)	{
				$html .= $g->goal.".";
			}
			$html .= '</font></div>';
			$html .= '<div class="goals_button" id="goals"><img src="'.get_template_directory_uri().'/dashboard/images/goals_button.png"></div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<hr>';
/******************** Recent Vitals ***************************/
			$html .= '<div class="widget_row">';			
			$html .= '<div class="dashboard_large_widget">';
			$html .= '<h5>recent vitals</h5>';
			$html .= '<div class="dashboard_vitals_row">';
			$vitals = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "vitals WHERE user_id='$patient_id' ORDER BY taken_date DESC LIMIT 1");
			foreach($vitals as $v)	{
				$bp = $v->bp;
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
			$html .= '</div>'; // END OF .widget_row
			
/********************* Small Widgets *************************************/
			$html .= '<div class="small_widget_container">';
			
/********************** Immunizations ***************************************/
			//$html .= '<div class="widgets_left">';
			
			$html .= '<div class="widget_row">';
			
			$html .= '<div class="dashboard_small_widget">';
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
			$html .= '<p>See full immunizations list</p>';
			$html .= '</div>';
			$html .= '</div>';
			
/********************** Allergies ***************************************/
			//$html .= '<div class="widgets_right">';

			$html .= '<div class="dashboard_small_widget last">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Allergies</div>';
			$html .= '<div class="dash_widget_content">';
			$allergies = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "allergies WHERE user_id='$patient_id'");
			foreach($allergies as $allergy)	{
				$x=0;
				$html .= '<table>';
				$html .= '<tr><td></td><td>Severity</td></tr>';		
				$unserialized_allergies = unserialize($allergy->allergies);
				foreach($unserialized_allergies as $a)	{
					if($x >= 3)	{
						break;
					}			
					$html .= '<tr>';
					$html .= "<td>".$a[0]."</td><td>".$a[1]."</td>";
					$html .= '</tr>';
					$x++;
				}
				$html .= '</table>';
			}
			$html .= '<div><img src="'.get_template_directory_uri().'/dashboard/images/reaction_scale_small.png"></div>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="dashboard_small_widget_lip" id="allergies">';
			$html .= '<p>See full allergies list</p>';
			$html .= '</div>';
			$html .= '</div>';	
			$html .= '</div>';	// END OF .widget_row

/********************** Labs ***************************************/
			$html .= '<div class="widget_row">';

			$html .= '<div class="dashboard_small_widget">';
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
			$html .= '<p>See full recent medical history</p>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';	// END OF .widget_row				
		
/********************** Medications ***************************************/
			$html .= '<div class="widget_row">';
			
			$html .= '<div class="dashboard_small_widget">';
			
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">Medications</div>';
			$html .= '<div>';
			
			$html .= '</div>';
			$html .= '</div>';
			
			$html .= '<div class="dashboard_small_widget_lip" id="meds">';
			$html .= '<p>See medication list</p>';
			$html .= '</div>';
			
			$html .= '</div>';
			
			//$html .= '</div>';

/********************** Social Life ***************************************/
			$html .= '<div class="dashboard_small_widget last">';
			$html .= '<div class="dashboard_small_widget_content">';
			$html .= '<div class="title">My Social Life</div>';
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
			$html .= '<p>My Social Life</p>';
			$html .= '</div>';
			$html .= '</div>';	
			$html .= '</div>';	
			$html .= '</div>';	// END OF .widget_row	
		}		
		echo $html;
} else {
	
		if (get_user_role() == 'lab_doctor')
		{
			include('lab_dashboard.php');
		}
		elseif (get_user_role() == 'doctor')
		{
	
			$lookup = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=$id");
		
			foreach($lookup as $lu)	{
				$html .= '<div class="dashboard_goals doctor">';
					$html .= '<div class="goal_container">';
						$html .= '<div class="user_image doctor default">';
							$html .= '<img src="'.get_template_directory_uri().'/assets/img/dashboard/doctor_default.png">';
						$html .= '</div>';
						$html .= '<div class="doctor_greet">';
							$html .= 'Welcome, <span>Dr. ' . $lu->display_name . '</span>.';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>'; // End .dashboard_goals
				
			$html .= '<hr>';

			$html .= '<div class="widget_row">';			
				$html .= '<div class="dashboard_large_widget">';
					$html .= '<h5>soap notes</h5>';
					$html .= '<div class="large_search">';
						$html .= '<h3>Please select a patient to get started.</h3>';
						$html .= '<img class="mag" src="'.get_template_directory_uri().'/assets/img/dashboard/search_lg.png">';
						$html .= '<div class="link_btn lg_search_btn search_patients_lg">Patient Search</div>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="spacer"></div>';
			
/******************** Small widgets ***************************/			
			$html .= '<div class="small_widget_container">';
			
				$html .= '<div class="widget_row">';
/******************** Scheduling ******************************/
					$html .= '<div class="dashboard_small_widget">';
						$html .= '<div class="dashboard_small_widget_content padding clearfix">';
							$html .= '<div class="dashboard_small_widget_content_col">';
								$html .= '<div class="schedule_date">';
									$html .= '<div class="schedule_month"></div>';
									$html .= '<div class="schedule_day"></div>';
									$html .= '<div class="schedule_day_no"></div>';
								$html .= '</div>';
							$html .= '</div>';
							$html .= '<div class="dashboard_small_widget_content_col last">';
							$html .= '<div class="title">Appointments</div>';
							$html .= '<div class="appointment_dates">';
								$html .= '<ul><li>01/12/15 at 10:00am</li><li>01/12/15 at 10:10am</li><li>01/12/15 at 10:20am</li><li>01/12/15 at 10:30am</li><li>01/12/15 at 10:40am</li><li>01/12/15 at 10:50am</li><li>01/12/15 at 11:00am</li><li>01/12/15 at 11:10am</li><li>01/12/15 at 11:20am</li><li>01/12/15 at 11:30am</li><li>01/12/15 at 11:40am</li><li>01/12/15 at 11:50am</li></ul>';
							$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
						$html .= '<div class="dashboard_small_widget_lip" id="schedule">';
						$html .= '<p>See full schedule</p>';
						$html .= '</div>';
					$html .= '</div>';
/******************** Messaging *******************************/
					$html .= '<div class="dashboard_small_widget last">';
						$html .= '<div class="dashboard_small_widget_content">';
						$html .= '<div class="title">Messages <span class="unread_span">(<div class="unread_ctn"></div>)</span></div>';
						$html .= '<div id="dashboard_messages">';
						$html .= "<ul class='messages'>";
						$html .= '<input type="hidden" id="message_id" value="0">';
							$limit = 3;
								$messages = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication AS c INNER JOIN ".$wpdb->prefix. "doctors AS d  ON d.user_id=c.user_id WHERE c.user_id='$id' order by c.id desc LIMIT ". $limit * 1 . "");
												
							if($messages)	{
								foreach($messages as $message)	{
									$html .= "<li class='message' id='".$message->id."'>";
									if($message->read == 0)	{
										$html .= '<div class="message_overview message_overview_unread">';
									} else {
										$html .= '<div class="message_overview">';
									}
									$html .= '<div class="container">';
									$html .= "<div class='subject_container'>";
									$subject = $message->subject;
									$stripped_subject = (strlen($subject) > 50) ? substr($subject,0,50).'...' : $subject;
									$html .= "<div class='subject'>".$stripped_subject."</div><br>";
									$from = $message->from;
									$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
									foreach($from_query as $f)	{
										$html .= "<div class='from'>".$f->display_name."</div>";
									}
									$html .= "</div>";
									$html .= "<div class='message_date'>".date('M d, Y', $message->date_sent)."</div>";
									$html .= "</div>";
									$html .= "</div>";	
									$html .= "</li>";
								}
							} else {
								$html .= "<li>";
								$html .= '<div class="message_overview">';
								$html .= '<div class="container" style="padding: 20px 0;">';
								$html .= 'No Messages.';
								$html .= "</div>";
								$html .= "</li>";
							}
						$html .= "</ul>";
						$html .= '</div>';
						$html .= '</div>';
						$html .= '<div class="dashboard_small_widget_lip" id="communications">';
						$html .= '<p>See full messages</p>';
						$html .= '</div>';
					$html .= '</div>';
					
				$html .= '</div>';	
				
				$html .= '<div class="widget_row">';
/******************** Labs ************************************/
					$html .= '<div class="dashboard_small_widget">';
						$html .= '<div class="dashboard_small_widget_content padding clearfix">';
						$html .= '<img style="display:block;margin:20px auto 10px auto;" src="'.get_template_directory_uri().'/assets/img/dashboard/logo_DrFirst.jpg" />';
						$html .= '<a class="link_btn lab-link">Launch</a>';
						$html .= '</div>';
						$html .= '<div class="dashboard_small_widget_lip" id="labs">';
						$html .= '<p>See full incoming labs</p>';
						$html .= '</div>';
					$html .= '</div>';
/******************** Referrals *******************************/
					$html .= '<div class="dashboard_small_widget last">';
						$html .= '<div class="dashboard_small_widget_content clearfix">';
						$html .= '<div class="title">Referrals</div>';
						
						$html .= '<div class="referral_container">';
						
						$html .= '<div id="referral_add">';
						$html .= '<img src="'.get_template_directory_uri().'/assets/img/dashboard/refer_add_icon.jpg" />';
						$html .= '<div>Add Referral Doctor</div>';
						$html .= '</div>';
						
						$html .= '<hr />';
						
						$html .= '<div id="referral_view">';
						$html .= '<img src="'.get_template_directory_uri().'/assets/img/dashboard/refer_view_icon.jpg" />';
						$html .= '<div>View all Referral Doctors</div>';
						$html .= '</div>';
						
						$html .= '</div>';
						
						$html .= '</div>';
						$html .= '<div class="dashboard_small_widget_lip" id="referrals">';
						$html .= '<p>See referrals</p>';
						$html .= '</div>';
					$html .= '</div>';
					
				$html .= '</div>';						
				
			$html .= '</div>';
				
			echo $html;
		}
		
	}

}
?>