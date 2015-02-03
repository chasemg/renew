<?php

global $wpdb, $table_prefix, $pdb;

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

if(!isset($wpdb))
{
    require_once(DOCUMENT_ROOT . '/wp-config.php');
    require_once(DOCUMENT_ROOT . '/wp-includes/wp-db.php');
	
	$user_ID = get_current_user_id();
	
	$practice_id = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users_practice WHERE user_id=".$user_ID."");
	

	foreach($practice_id as $pid)	
	{
		$practice = $pid->practice_id;
	}

	$pdb = new wpdb(DB_USER,DB_PASSWORD,'renew_' . $practice,DB_HOST);
}

$patient_id = $_POST['id'];
$date = $_POST['date'];

$info = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."users WHERE ID = " . $patient_id, OBJECT);
$patient = $pdb->get_row("SELECT * FROM ".$wpdb->prefix."patients WHERE user_id = " . $patient_id, OBJECT);

?>
<style>
.schedule-details
{
	width:500px;
}
.patient-profile
{
	width:100%;
	height:110px;
	border-bottom:solid 1px #000;
}

.patient-profile .image
{
	float:left;
	width:100px;
	height:100px;
	margin:0px 10px 0px 0px;
}

.patient-profile .image img
{
	height:100%;
}

</style>
<div class="schedule-details">
	<div class="patient-profile">
    	<div class="image">
	    	<?php if ($patient->image) { ?>
    			<img src="<?php echo get_template_directory_uri(); ?>/dashboard/profile_photos/<?php echo $patient->image; ?>">
		    <?php } else { ?>
    			<img src="<?php echo get_template_directory_uri(); ?>/dashboard/profile_photos/avatar.png">
    		<?php } ?>
            
         </div>            
         <div class="name">
         	<?php echo $info->display_name; ?>
         </div>
	</div>
</div>    