<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];

$month = $_POST['month'];
$year = $_POST['year'];

$current = date("Y-m-d");

list($next_month, $next_year) = explode(" ", date("m Y", mktime(0,0,0, $month + 1, 1, $year)));
list($prev_month, $prev_year) = explode(" ", date("m Y", mktime(0,0,0, $month - 1, 1, $year)));

$json = array();

ob_start();

include('../dashboard/schedule/calendar.php');

$html = ob_get_contents();
		
ob_end_clean();
	
$json['html'] = $html;
	
echo json_encode($json);

?>