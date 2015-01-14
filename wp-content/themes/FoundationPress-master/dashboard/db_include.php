<?php 

global $wpdb, $table_prefix;

if(!isset($wpdb))
{
    require_once('../../../../wp-config.php');
    require_once('../../../../wp-includes/wp-db.php');
	$user_ID = get_current_user_id();
	$practice_id = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users_practice WHERE user_id=".$user_ID."");
//	var_dump($practice_id);
	foreach($practice_id as $pid)	{
		$practice = $pid->practice_id;
	}

	$pdb = new wpdb(DB_USER,DB_PASSWORD,'renew_' . $practice,DB_HOST);
}

?>