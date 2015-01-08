<?php

include "db_include.php";
$user_id = $_POST['user_id'];

$count = $pdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix. "communication WHERE user_id='$user_id' AND read='0'");
echo $count;
?>