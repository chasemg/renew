<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];
$patient_id = $_POST['patient_id'];

$date = $_POST['date'];

list($year, $month, $day) = explode('-', $date);

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

if (file_exists($file2))
{
	$handle = fopen($file2, "r");
	$schedule = json_decode(fread($handle, filesize($file2)));
	fclose($handle);
	
	foreach($schedule as $ss)
	{
		foreach($ss->dates as $dd)
		{
			$user_time[$dd->date] = $dd->status;
			
		}
	}
}



$json = array();

ob_start();

include('../dashboard/schedule/minutes.php');

$html = ob_get_contents();
		
ob_end_clean();

$json['html'] = $html;
	
echo json_encode($json);

?>