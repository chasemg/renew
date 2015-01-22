<?php 

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];
$patient_id = $_POST['patient_id'];

if ($_SERVER['HTTP_HOST'] == 'renew.local')
{
	$file = $_SERVER['DOCUMENT_ROOT']. '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = $_SERVER['DOCUMENT_ROOT']. '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}
else
{
	$file =  '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}

$json = array();
$json2 = array();

if (file_exists($file))
{
	$handle = fopen($file, "r");
	
	$results = json_decode(fread($handle, filesize($file)));
	
	fclose($handle);
	
	foreach($results as $row)
	{
		$json[] = array('patient_id' => $row->patient_id,
						'dates' => $row->dates,
						'doctor_id' => $row->doctor_id);
	}
	
}

if (file_exists($file2))
{
	$handle = fopen($file2, "r");
	
	$results = json_decode(fread($handle, filesize($file2)));
	
	fclose($handle);
	
	foreach($results as $row)
	{
		$json2[] = array('patient_id' => $row->patient_id,
						 'dates' => $row->dates,
						 'doctor_id' => $row->doctor_id);
	}
	
}

$dates = array();

foreach($_POST['dates'] as $date)
{
	$dates[] = array('date' => $date, 'status' => 'Pending');
}

$json[] = array('patient_id' => $patient_id,
				'doctor_id' => $doctor_id,
				'dates' => $dates);
				
$json2[] = array('patient_id' => $patient_id,
				'doctor_id' => $doctor_id,
				'dates' => $dates);				

$handle = fopen($file, "w");
$handle2 = fopen($file2, "w");

fwrite($handle, json_encode($json));
fwrite($handle2, json_encode($json2));

fclose($handle);
fclose($handle2);

echo 1;

?>