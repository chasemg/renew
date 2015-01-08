<?php

$user = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=" . $id);

$patients = $wpdb->get_results("SELECT l.*, u.display_name as patient_name, d.display_name as doctor_name, date_format(date_sent, '%M %d, %Y') as date_request FROM ".$wpdb->prefix. "labs l JOIN ".$wpdb->prefix."users u ON u.ID = l.patient_id JOIN ".$wpdb->prefix."users d ON d.ID = l.doctor_id WHERE labdoctor_id = " . $id);

?>

<div class="dashboard_goals">
	<div class="goal_container">
		<div class="user_image">
			<img src='<?php echo get_template_directory_uri(); ?>/dashboard/profile_photos/avatar.png'>
			
		</div>
		
        <div class='goal_text'>Welcome <font style='color:#00af41'><?php echo $user->display_name; ?></font></div>

	</div>
    
    <hr />
    
    <h1>Patient List</h1>
    
    <table id="patient-list-table" width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>No.</th>
            	<th>Patient</th>
                <th>Doctor</th>
                <th>Date Request</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($patients) { ?>
        <?php foreach($patients as $i => $patient) { ?>
        	<tr>
            	<td><?php echo $i + 1; ?></td>
            	<td><?php echo $patient->patient_name; ?></td>
                <td><?php echo $patient->doctor_name; ?></td>
                <td><?php echo $patient->date_request; ?></td>
                <td><a class="upload-document" data="<?php echo $patient->lab_id; ?>">View document</a></td>
            </tr>
        <?php } ?>
        <?php } else { ?>
        	<tr>
            	<td colspan="3" style="text-align:center;"> - no patient record found -</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script>
$(document).ready(function()
{
	var labdoctor_id = <?php echo $id; ?>;
	
	$('#patient-list-table a.upload-document').bind('click', function()
	{
		var lab_id = $(this).attr('data');
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/dashboard/labs_document.php',
			data: 'lab_id=' + lab_id + '&id=' + labdoctor_id,
			type: 'post',
			success:function(html)
			{
				$('#dashboard').html(html);
			}
		})
	});
});
</script>