<?php

include "db_include.php";

list($m, $d, $y) = explode("/", $_POST['date']);
$date = sprintf("%s-%s-%s", $y, $m, $d);
$ts = mktime();

if (isset($_POST['id']))
{
	$wpdb->query("UPDATE ".$wpdb->prefix."immunizations SET user_id = '".$_POST['user_id']."', doctor_id = '".$_POST['doctor_id']."', doses = '".$_POST['doses']."', date = '".$date."', modified_date = '".$ts."', modified_user = '".$_POST['doctor_id']."' WHERE id = " . (int)$_POST['id']);
}
else
{	
	$wpdb->query("INSERT INTO ".$wpdb->prefix."immunizations SET user_id = '".$_POST['user_id']."', doctor_id = '".$_POST['doctor_id']."', doses = '".$_POST['doses']."', date = '".$date."',  modified_date = '".$ts."', modified_user = '".$_POST['doctor_id']."'");
}
?>