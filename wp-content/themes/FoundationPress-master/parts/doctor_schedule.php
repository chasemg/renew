<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];

$doctor = $pdb->get_row("SELECT * FROM ".$wpdb->prefix."doctors WHERE user_id = " . $doctor_id, OBJECT);

$name = sprintf("Dr. %s %s", $doctor->fname, $doctor->lname);

$title = "OD"; //$doctor->title;

$image = get_bloginfo('template_url') . '/assets/img/doctor-green-icon.png';

$month = date("m");
$year = date("Y");

$current = date("Y-m-d");

list($next_month, $next_year) = explode(" ", date("m Y", mktime(0,0,0, $month + 1, 1, $year)));
list($prev_month, $prev_year) = explode(" ", date("m Y", mktime(0,0,0, $month - 1, 1, $year)));

$json = array();

ob_start();

include('../dashboard/schedule/schedule.php');

$html = ob_get_contents();
		
ob_end_clean();

	
$json['html'] = $html;
	
echo json_encode($json);

?>