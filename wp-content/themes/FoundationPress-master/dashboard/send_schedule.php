<?php

include "db_include.php";

list($m, $d, $y) = explode('/', $_POST['date']);

$pdb->query("INSERT INTO ".$wpdb->prefix."schedule SET date = '".sprintf("%s-%s-%s", $y, $m, $d)."', startime = '".$_POST['starttime']."', endtime = '".$_POST['endtime']."', doctor_id = '".$_POST['doctor_id']."', patient_id = '".$_POST['patient_id']."', message = '".$_POST['message']."', date_added = now()");

//notify doctor code here

$patient_id = $_POST['patient_id'];

$schedules = $pdb->get_results("SELECT concat(date_format(date, '%m/%d/%Y'), ' ', startime,'-',endtime) as date, u.display_name as doctor_name, if(s.status = 0, 'Request sent', 'Confirmed') as status FROM ".$wpdb->prefix."schedule s JOIN ".$wpdb->prefix."users u ON u.ID = s.doctor_id WHERE patient_id = " . $patient_id . " ORDER BY date DESC");

echo json_encode($schedules);

?>