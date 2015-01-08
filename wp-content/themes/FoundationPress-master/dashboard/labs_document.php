<?php

include "db_include.php";

$id = $_POST['id'];
$lab_id = $_POST['lab_id'];
$user = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix. "users WHERE ID=" . $id);

$patient = $pdb->get_row("SELECT u.display_name as patient_name, u2.display_name as doctor_name, date_format(date_sent, '%M %d, %Y') as date_request, doctor_notes FROM ".$wpdb->prefix."labs l JOIN ".$wpdb->prefix."users u ON u.ID = l.patient_id JOIN ".$wpdb->prefix."users u2 ON u2.ID = l.doctor_id WHERE lab_id = " . $lab_id);

$documents = $pdb->get_results("SELECT * FROM ".$wpdb->prefix."lab_files WHERE lab_id = " . $lab_id);

?>

<div class="dashboard_goals">
	<div class="goal_container">
		<div class="user_image">
			<img src='<?php echo get_template_directory_uri(); ?>/dashboard/profile_photos/avatar.png'>
			
		</div>
		
        <div class='goal_text'>Welcome <font style='color:#00af41'><?php echo $user->display_name; ?></font></div>

	</div>
    
    <hr />
    
    <h1>Patient Info</h1>
    
    <table id="patient-list-table" width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>Patient</th>
                <th>Doctor</th>
                <th>Date Request</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td><?php echo $patient->patient_name; ?></td>
                <td><?php echo $patient->doctor_name; ?></td>
                <td><?php echo $patient->date_request; ?></td>
                <td><?php echo $patient->doctor_notes; ?></td>
            </tr>
        </tbody>
    </table>
    
    <h1>Lab Result</h1>
    
     <table id="lab-result-table" width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>Date</th>
                <th>Remarks</th>
                <th>&nbsp;</th>
            </tr>
        </thead>  
        <tbody>
        <?php if ($documents) { ?>
        <?php foreach($documents as $doc) { ?>
        <?php $href = 'wp-content/themes/FoundationPress-master/lab-result/' . $doc->lab_id . '/' . $doc->filename; ?>
        	<tr>
            	<td><?php echo $doc->date; ?></td>
                <td><?php echo $doc->remarks; ?></td>
                <td><a href="<?php echo $href; ?>" target="_blank">View</a>
            </tr>
        <?php } ?>
        <?php } else { ?>
        	<tr>
            	<td colspan="3" style="text-align:center"> - no document </td>
            </tr>
        <?php } ?>
        </tbody>      
    </table>
    
    <h1>Upload New Result</h1>
    
    <form method="post" enctype="multipart/form-data" target="upload-frame" action="wp-content/themes/FoundationPress-master/dashboard/labs_upload.php">
    	<input type="hidden" name="lab_id" value="<?php echo $lab_id; ?>">
        <input type="hidden" name="labdoctor_id" value="<?php echo $id; ?>">
        <table id="upload-table" width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
        
        	<tr>
            	<td>Remarks</td>
            </tr>
            
            <tr>
            	<td><textarea name="remarks"></textarea></td>
            </tr>
            
            <tr>
            	<td>Upload</td>
            </tr>
            
            <tr>
            	<td><input type="file" name="document"></td>
            </tr>
            
            <tr>
            	<td><input type="submit" value="Upload document"></td>
            </tr>
        
        </table>
    
    </form>
    
    <iframe name="upload-frame" id="upload-frame" width="0" height='0' frameborder="0"></iframe>
    
</div>

<script>
function lab_document(lab_id, labdoctor_id)
{
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
}
</script>