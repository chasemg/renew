<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
error_reporting(E_ALL);
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$html = '';
$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/medhis_icon.png"></div>';
$html .= '<div class="title">Medical History</div>';
$html .= '<hr>';

$exam_dates = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "exams WHERE user_id='$patient_id' AND exam_type='1' ORDER BY exam_date DESC LIMIT 1");
foreach($exam_dates as $exam)	{
	$exam_date = $exam->exam_date;
}

$medical = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "medical_history WHERE user_id='$patient_id' LIMIT 1");
foreach($medical as $m)	{
	$html .= '<div class="last_exam">Date of last physical exam: <font style="color: #00af41;">'.date("m/d/Y", $exam_date).'</font></div>';
	$html .= '<div class="text" style="padding-bottom: 5px;">'.$m->notes.'</div>';
	$html .= '<hr>';
	$html .= '<div class="med_history_container">';

/******************** Test Data ****************************/	
/*
	$array_mc = array(
		array("High Blood Pressure", "1411415705"),
		array("Hypertension", "1411415705"),
		array("Lower Back Pain", "1411415705"),
		array("Depression", "1411415705"),
		array("Dungeon Death", "1411415705")
	);
	$array_sp = array(
		array("Tonsillectomy", "1411415705"),
		array("Adenoidectomy", "1411415705"),
		array("Lymphadenectomy", "1411415705"),
		array("Thymectomy Splenectomy", "1411415705")
	);
	$array_fh = array(
		array("Father", 1, 49),
		array("Mother", 1, 48),
		array("Siblings", 1, 3)
	);	
	$array_fmc = array(
		array("High Blood Pressue", "Father"),
		array("Hypertension", "Mother")
	);		
	$array_oi = array(
		array("Lymphocytic Leukemia", "1411415705")
	);		
	$serialized_mc = serialize($array_mc);
	$serialized_sp = serialize($array_sp);
	$serialized_fh = serialize($array_fh);
	$serialized_fmc = serialize($array_fmc);
	$serialized_oi = serialize($array_oi);
*/
/********************************************************/
	
	$unserialized_mc = unserialize($m->medical_conditions);
	$html .= '<table style="float:left;">';
	$html .= '<tr><td colspan="2">Here is a list of your medical conditions.</td></tr>';	
	foreach($unserialized_mc as $mc)	{
		$html .= '<tr>';
		$html .= "<td>".$mc[0]."</td><td>".date('m/y', $mc[1])."</td>";
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	$unserialized_sp = unserialize($m->surgical_procedures);
	
	$html .= '<table style="float:right;">';
	$html .= '<tr><td colspan="2">Here is a list of your surgical proceedures.</td></tr>';	
	foreach($unserialized_sp as $sp)	{
		$html .= '<tr>';
		$html .= "<td>".$sp[0]."</td><td>".date('m/y', $sp[1])."</td>";
		$html .= '</tr>';
	}
	$html .= '</table>';
	$html .= '<hr>';	
	$unserialized_fh = unserialize($m->family_history);
	$html .= '<table class="family_history" id="family_history" style="float:left;">';
	$html .= '<tr><td colspan="4">Family History.</td></tr>';	
	foreach($unserialized_fh as $fh)	{
		$html .= '<tr>';
		$html .= "<td><input type='hidden' value='".$fh[0]."'>".$fh[0]."</td>";
		$html .= "<td><input type='hidden' value='".$fh[1]."'>Living: <font style='color: #00af41;'>";
		if($fh[1] == 1)	{
			$html .= "Yes";
		} else {
			$html .= "No";
		}
		$html .= "</font></td>";
		$html .= "<td><input type='hidden' value='".$fh[2]."'>Age: <font style='color: #00af41;'>";
	/*	if($fh[0] == "Father" || $fh[0] == "Mother")	{
			$html .= "Age: <font style='color: #00af41;'>";
		} else {
			$html .= "Age: <font style='color: #00af41;'>";
		} */
		$html .= $fh[2]."</font></td><td></td>";
		$html .= '</tr>';
	}
	$html .= '<tr><td colspan="3"><div class="add_entry">+add</div></td></tr>';	$html .= '</table>';
	$unserialized_fmc = unserialize($m->family_conditions);
	$html .= '<table class="family_conditions" id="family_conditions" style="float:right;">';
	$html .= '<tr><td colspan="2">List of family medical conditions.</td></tr>';	
	foreach($unserialized_fmc as $fmc)	{
		$html .= '<tr>';
		$html .= "<td>".$fmc[0]."</td><td>".$fmc[1]."</td><td></td>";
		$html .= '</tr>';
	}
	$html .= '<tr><td colspan="3"><div class="add_entry">+add</div></td></tr>';
	$html .= '</table>';
	$html .= '<div style="width: 100%; height: 1px; display: inline-block;"></div>';
	$unserialized_oi = unserialize($m->other_illnesses);
	$html .= '<table style="float: left;">';
	$html .= '<tr><td colspan="2">List other illnesses.</td></tr>';	
	foreach($unserialized_oi as $oi)	{
		$html .= '<tr>';
		$html .= "<td>".$oi[0]."</td><td>".date('m/y', $oi[1])."</td>";
		$html .= '</tr>';
	}
	$html .= '</table>';	
	$html .= '</div>';
}
$html .= '<hr>';
$html .= '</div>';
$html .= '</div>';
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';
echo $html;
?>