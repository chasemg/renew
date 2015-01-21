<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];

$date = $_POST['date'];

list($year, $month, $day) = explode('-', $date);

$json = array();

ob_start();

include('../dashboard/schedule/minutes.php');

$html = ob_get_contents();
		
ob_end_clean();

$json['html'] = $html;
	
echo json_encode($json);

?>