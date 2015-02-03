<?php

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];
$patient_id = $_POST['patient_id'];
$date = $_POST['date'];
$status = $_POST['action'];

if ($_SERVER['HTTP_HOST'] == 'renew.local')
{
	$file = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}
else
{
	$file = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
}

$handle = fopen($file, "r");
$data = json_decode(fread($handle, filesize($file)));
fclose($handle);

foreach($data as $row)
{
	if ($row->patient_id == $patient_id)
	{
		foreach($row->dates as $dates)
		{
			if ($dates->date == $date)
			{
				$dates->status = $status;
			}
		}
	}
}

$new = json_encode($data);

$handle = fopen($file, "w");
fwrite($handle, $new);
fclose($handle);

$handle = fopen($file2, "r");
$data = json_decode(fread($handle, filesize($file2)));
fclose($handle);

foreach($data as $row)
{
	if ($row->doctor_id == $doctor_id)
	{
		foreach($row->dates as $dates)
		{
			if ($dates->date == $date)
			{
				$dates->status = $status;
			}
		}
	}
}

$new = json_encode($data);

$handle = fopen($file2, "w");
fwrite($handle, $new);
fclose($handle);

$results = array();
$today = array();
				
if (file_exists($file))
{
	$handle = fopen($file, "r");
	$json = fread($handle, filesize($file));
					
	$now = strtotime(date("Y-m-d"));
					
	foreach(json_decode($json) as $obj)
	{
		$info = get_patient_info($obj->patient_id, $practice);
			
		foreach($obj->dates as $dates)
		{
							
			$ss = strtotime(date("Y-m-d", strtotime($dates->date)));
							
			$date = sprintf("%s at %s", date("m/d/y", strtotime($dates->date)), date("h:i A", strtotime($dates->date)));
							
			if (date("Y-m-d", strtotime($dates->date)) == date("Y-m-d") && $dates->status == 'Confirmed')
			{
				$today[] = array('date' => $date,
					     'status' => $dates->status,
						 'name' => $info['name']);
			}
			else if ($ss >= $now)
			{
				$results[] = array('date' => $date,
						   'status' => $dates->status,
						   'date2' => $dates->date,
						   'patient_id' => $obj->patient_id,
						   'name' => $info['name']);
			}
		}
	}
				
}

$id = $doctor_id;
				
				
include('../dashboard/schedule/today.php'); ?>
           
<hr>
                
<?php include('../dashboard/schedule/request.php'); ?>

