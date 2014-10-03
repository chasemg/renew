<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

include "db_include.php";
if (isset($_POST['action']))
{
	$wpdb->query("INSERT INTO ".$wpdb->prefix."labs SET patient_id = '".$_POST['patient_id']."', doctor_id = '".$_POST['doctor_id']."', labdoctor_id = '".$_POST['labdoctor_id']."', doctor_notes = '".$_POST['remarks']."', date_sent = NOW()");
	
	$labpatients = $wpdb->get_results("SELECT l.*, u.display_name as patient_name, u2.display_name as labdoctor_name, date_format(date_sent, '%M %d, %Y') as date_request, date_format(date_result, '%M %d %Y') as date_result FROM ".$wpdb->prefix."labs l JOIN ".$wpdb->prefix."users u ON u.ID = l.patient_id JOIN ".$wpdb->prefix."users u2 ON u2.ID = l.labdoctor_id WHERE doctor_id = " . $_POST['doctor_id']);
	
	echo json_encode($labpatients);
	
	die();
}

$id = $_POST['id'];
$patient_id = $_POST['patient_id'];

$labpatients = $wpdb->get_results("SELECT l.*, u.display_name as patient_name, u2.display_name as labdoctor_name, date_format(date_sent, '%M %d, %Y') as date_request, date_format(date_result, '%M %d %Y') as date_result FROM ".$wpdb->prefix."labs l JOIN ".$wpdb->prefix."users u ON u.ID = l.patient_id JOIN ".$wpdb->prefix."users u2 ON u2.ID = l.labdoctor_id WHERE doctor_id = " . $id);

$patients = get_patient_list();

$labdoctors = get_labdoctor_list();

if ($patient_id)
{
	//echo $patient_id;
	$documents = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."labs l JOIN ".$wpdb->prefix."lab_files f ON f.lab_id = l.lab_id WHERE patient_id = " . $patient_id);
}

?>
<style>
.pdf-icons
{
	list-style:none;
	margin:20px 0px;
}

.pdf-icons li
{
	float:left;
	margin:0px 20px 20px 0px;
	width:50px;
	overflow:hidden;
	height:100px;
}

.pdf-icons a
{
	text-outline:none;
	text-indent:-9999px;
	display:inline-block;
	width:46px;
	height:53px;
	background:url(wp-content/themes/FoundationPress-master/dashboard/images/pdf-icon.jpg);
}
</style>
<div class="dashboard_large_widget">
	<div class="container">
		<div class="icon">
        	<img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/lab_icon.png">
         </div>
		
        <div class="title">Lab Results</div>
		<hr>
		<?php if ($patient_id) { ?>
        
        <p style="text-align:left;"><strong>Here is a detailed look</strong> at your recent labs results. You can download a PDF of your paperwork or you can view them through your browser.</p>
        
        <ul class="pdf-icons">
        
        <?php foreach($documents as $doc) { ?>
        
        
        	<li>
            	<a href="wp-content/themes/FoundationPress-master/lab-result/<?php echo $doc->lab_id; ?>/<?php echo $doc->filename; ?>" target="_blank" class="pdf-icon"><?php echo $doc->filename; ?></a>
                <p class="doctor-notes"><?php echo $doc->doctor_notes; ?></p>
                <p class="labdoctor-notes"><?php echo $doc->remarks; ?></p>
            </li>
        
        <?php } ?>
        
        </ul>
        
        <?php } else { ?>
        
        <h1>Patient List</h1>
        
        <table id="patient-list-table" width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>No.</th>
            	<th>Patient</th>
                <th>Laboratory</th>
                <th>Request Date</th>
                <th>Date Result</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($patients) { ?>
        <?php } else { ?>
        	<tr>
            	<td colspan="3" style="text-align:center;"> - no patient record found -</td>
            </tr>
        <?php } ?>
        </tbody>
    	</table>
        
        <h1>Send Request</h1>
        
        <form id="send_request">
        	<input type="hidden" name="action" value="send-request">
            <input type="hidden" name="doctor_id" value="<?php echo $id; ?>">
        	<table width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
            	<tr>
                	<td>Patient Name:</td>
                    <td><select name="patient_id">
                    	<?php foreach($patients as $patient) { ?>
                        <option value="<?php echo $patient->ID; ?>"><?php echo $patient->display_name; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td>Laboratory:</td>
                    <td><select name="labdoctor_id">
                    	<?php foreach($labdoctors as $labdoctor) { ?>
                        <option value="<?php echo $labdoctor->ID; ?>"><?php echo $labdoctor->display_name; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td>Remarks:</td>
                    <td><textarea name="remarks"></textarea></td>
                </tr>
                <tr>
                	<td colspan="2"><input type="submit" value="Submit"><span class="notification"></span></td>
                </tr>
            </table>
        </form>
        
        <?php } ?>
	</div>
</div>
<script>

$(document).ready(function()
{
	function lab_patient_list(data)
	{
		var html = '';
		
		for(var x = 0; x < data.length; x++)
		{
			html += '<tr>';
			
			html += '<td>' + (x + 1) + '</td>';
			html += '<td>' + data[x].patient_name + '</td>';
			html += '<td>' + data[x].labdoctor_name + '</td>';
			html += '<td>' + data[x].date_request + '</td>';
			html += '<td>'
			
			if (data[x].date_result == null)
			{
				html += '---';
			}
			else
			{
				html += data[x].date_result
			}
			
			html += '</td>';
			
			html += '<td>';
			
			if (data[x].date_result == null)
			{
				html += '---';
			}
			else
			{
				html += '<a>View Result</a>';
			}
			
			html += '</td>'
			
			html += '</tr>';
		}
		
		$('#patient-list-table tbody').html(html);
	}
	
	$('#send_request').bind('submit', function()
	{
		var params = $(this).serialize();
	
		$('#send_request .notification').html('Submitting, please wait...');
	
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/dashboard/labs.php',
			data: params,
			type: 'post',
			dataType: 'json',
			success:function(data)
			{
				$('#send_request textarea').val('');	
				$('#send_request .notification').html('');	
				lab_patient_list(data);
				alert('Request submitted!');	
			}
		});
	
		return false;
	});

	
	lab_patient_list(<?php echo json_encode($labpatients); ?>);

});
</script>