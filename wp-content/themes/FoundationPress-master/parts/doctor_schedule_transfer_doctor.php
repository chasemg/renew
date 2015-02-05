<?php 

include '../dashboard/db_include.php';

$doctor_to = $_POST['doctor_to'];
$patient_id = $_POST['patient_id'];
$doctor_from = $_POST['doctor_from'];
$date = $_POST['date'];

$doctor_id = $doctor_to;

$doctor = $pdb->get_row("SELECT * FROM ".$wpdb->prefix."doctors WHERE user_id = " . $doctor_id, OBJECT);

if ($_SERVER['HTTP_HOST'] == 'renew.local')
{
	$file = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
	$file3 = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_from . '.js';
}
else
{
	$file = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_id . '.js';
	$file2 = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
	$file3 = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/doctor_' . $doctor_from . '.js';
}

$json = array();
$json2 = array();
$json3 = array();

if (file_exists($file))
{
	$handle = fopen($file, "r");
	$schedule = json_decode(fread($handle, filesize($file)));
	fclose($handle);
	
	foreach($schedule as $row)
	{
		$json[] = array('patient_id' => $patient_id,
						'dates' => $row->dates,
						'doctor_id' => $doctor_id);
	}
}

$json[] = array('patient_id' => $patient_id,
				'dates' => array(array('date' => $date, 'status' => 'Pending', 'transfer_from' => $doctor_from)),
				'doctor_id' => $doctor_id);

if (file_exists($file2))
{
	$handle = fopen($file2, "r");
	$schedule = json_decode(fread($handle, filesize($file2)), true);
	fclose($handle);
	
	foreach($schedule as $row)
	{
		$r_patient_id = $row['patient_id'];
		$r_doctor_id = $row['doctor_id'];
		
		$r_dates = $row['dates'];
		
		if ($r_doctor_id = $doctor_from)
		{
			foreach($r_dates as $i =>  $dates)
			{
				if (isset($dates['date']) && $dates['date'] == $date)
				{
					$r_dates[$i]['transfer_to'] = $doctor_id;
					$r_dates[$i]['status'] = 'Pending';
				}
				
			}
			
			$row['dates'] = $r_dates;
		}
		
		
		$json2[] = $row;
	}
}

$json2[] = array('patient_id' => $patient_id,
				 'doctor_id' => $doctor_id,
				 'dates' => array(array('date' => $date, 'status' => 'Pending', 'transfer_from' => $doctor_from)));


if (file_exists($file3))
{
	$handle = fopen($file3, "r");
	$schedule = json_decode(fread($handle, filesize($file3)), true);
	fclose($handle);
	
	foreach($schedule as $row)
	{
		$r_patient_id = $row['patient_id'];
		$r_doctor_id = $row['doctor_id'];
		
		$r_dates = $row['dates'];
		
		if ($row['patient_id'] == $patient_id)
		{
			foreach($r_dates as $i =>  $dates)
			{
				if ($dates['date'] == $date)
				{
					$r_dates[$i]['transfer_to'] = $doctor_id;
					$r_dates[$i]['status'] = 'Transfer';
				}
				
			}
			
			$row['dates'] = $r_dates;
		}
		
		$json3[] = $row;
	}
}



$handle = fopen($file, "w");
$handle2 = fopen($file2, "w");
$handle3 = fopen($file3, "w");

fwrite($handle, json_encode($json));
fwrite($handle2, json_encode($json2));
fwrite($handle3, json_encode($json3));

fclose($handle);
fclose($handle2);
fclose($handle3);

$results = array();
$today = array();
				
if (file_exists($file3))
{
	$handle = fopen($file3, "r");
	
	$json = fread($handle, 10000);
	
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
								 'name' => $info['name'],
								 'patient_id' => $obj->patient_id,
								 'date2' => $dates->date);
			}
			else if ($ss >= $now)
			{
				if (!isset($dates->transfer_to))
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
				
}


$id = $doctor_from;
				
include('../dashboard/schedule/today.php'); ?>
           
<hr>
                
<?php include('../dashboard/schedule/request.php'); ?>