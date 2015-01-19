<?php

include "db_include.php";
$user_id = $_POST['user_id'];
$i=0;
$count = $pdb->get_results("SELECT id FROM ".$wpdb->prefix. "communication WHERE user_id='".$user_id."' AND `read`='0'");
foreach($count as $c)	{
	$i++;
}
echo $i;
?>