<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$doctors = get_doctors_list();

?>

<div class="dashboard_large_widget">
	<div class="container">
    	<div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/immunizations_icon.png"></div>
        <div class="title">Scheduling</div>
        
        <hr>
        
        <div class="text">
        	text here
        </div>
        
         <div class="schedule_list">
         
         	<table>
            
            	<tr>
                   	<td>Date/Time</td>
                    <td>Doctor</td>
                    <td>Status</td>
                </tr>
            	
            </table>
            
            
            <h3>Request for doctor schedule</h3>
			<form>
            <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
            <table>
            	<tr>
                	<td>Date</td>
                </tr>
                <tr>
                	<td><input class="date" type="text" name="date"></td>
                </tr>
                <tr>
                	<td>Time</td>
                </tr>
                <tr>
                    <td><input class="time" type="text" name="starttime"> - <input class="time" type="text" name="endtime"></td>
                </tr>
                <tr>
                	<td>Doctor</td>
                </tr>
                <tr>
                	<td><select name="doctor_id">
                    	<?php foreach($doctors as $doctor) { ?>
                        <option value="<?php echo $doctor->ID; ?>"><?php echo $doctor->display_name; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td>Message for doctor</td>
                </tr>
                <tr>
                	<td><textarea name="message"></textarea></td>
                </tr>
                <tr>
                	<td><input type="submit" value="Send"></td>
                </tr>
            </table>
            </form>         
         
         </div>
        
        <hr>
        
       
        
	</div><!--- container -->
 
</div>
    
<div class="goback"><img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/goback.png"></div>

<script>
$('.date').datepicker();
$('.time').timepicker();

$('.schedule_list form').submit(function()
{
	var params = $(this).serialize();
	$.ajax(
	{
		url: 'wp-content/themes/FoundationPress-master/dashboard/send_schedule.php',
		data: params,
		type: 'post',
		dataType: 'json',
		success:function(data)
		{
		}
	})
	return false;
});
</script>