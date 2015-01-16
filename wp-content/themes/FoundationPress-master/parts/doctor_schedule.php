<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];

$month = date("m");
$year = date("Y");
	
$json = array();
	
$html = draw_calendar($month, $year);
	
$json['html'] = $html;
	
echo json_encode($json);

?>