<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];

$labPatients = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."labs WHERE doctor_id = " . $id);

?>
<div class="dashboard_large_widget">
	<div class="container">
		<div class="icon">
        	<img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/lab_icon.png">
         </div>
		
        <div class="title">Lab Results</div>
		<hr>
		<?php if ($patient_id) { ?>
        
        <?php } else { ?>
        
        <h1>Patient List</h1>
        
        <table width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    	<thead>
        	<tr>
            	<th>Patient</th>
                <th>Laboratory</th>
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
        
        <form>
        	<table width="99%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
            	<tr>
                	<td>Patient Name:</td>
                    <td><select name="patient_id"></select></td>
                </tr>
                <tr>
                	<td>Laboratory:</td>
                    <td><select name="labdoctor_id"></select></td>
                </tr>
                <tr>
                	<td>Remarks:</td>
                    <td><textarea name="remarks"></textarea></td>
                </tr>
                <tr>
                	<td colspan="2"><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
        
        <?php } ?>
	</div>
</div>