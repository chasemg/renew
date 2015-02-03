<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];

$month = $_POST['month'];
$year = $_POST['year'];

$current = date("Y-m-d");

list($next_month, $next_year) = explode(" ", date("m Y", mktime(0,0,0, $month + 1, 1, $year)));
list($prev_month, $prev_year) = explode(" ", date("m Y", mktime(0,0,0, $month - 1, 1, $year)));

if ($_SERVER['HTTP_HOST'] == 'renew.local')
{
	$file = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}
else
{
	$file = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}

$dates = array();
$doc_time = array();
$user_time = array();

if (file_exists($file))
{
	$handle = fopen($file, "r");
	$schedule = json_decode(fread($handle, filesize($file)));
	fclose($handle);
	
	foreach($schedule as $ss)
	{
		foreach($ss->dates as $dd)
		{
			$date = date("Y-m-d", strtotime($dd->date));
			$doc_time[$dd->date] = $dd->status;
			$dates[$date] = $date;
		}
	}
}


$json = array();

ob_start();

include('../dashboard/schedule/calendar.php');

$html = ob_get_contents();
		
ob_end_clean();
	
$json['html'] = $html;
	
echo json_encode($json);

?>