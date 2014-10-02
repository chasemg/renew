<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$immun = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "immunizations WHERE user_id='$patient_id' ORDER BY date DESC LIMIT 1");
?>
<div class="dashboard_large_widget">
	<div class="container">
		<div class="icon">
        	<img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/lab_icon.png">
         </div>
		
        <div class="title">Lab Results</div>
		<hr>
<?php
foreach($immun as $i)	{
	

}
?>
	</div>
</div>