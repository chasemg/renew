<?php 

include '../dashboard/db_include.php';

$doctor_to = $_POST['doctor_to'];
$patient_id = $_POST['patient_id'];
$doctor_from = $_POST['doctor_from'];

$doctor_id = $doctor_to;

$doctor = $pdb->get_row("SELECT * FROM ".$wpdb->prefix."doctors WHERE user_id = " . $doctor_id, OBJECT);

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


$name = sprintf("Dr. %s %s", $doctor->fname, $doctor->lname);

$title = "OD"; //$doctor->title;

$image = get_bloginfo('template_url') . '/assets/img/doctor-green-icon.png';

$month = date("m");
$year = date("Y");
$day = date("d");

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