<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$doctors = get_doctors_list();
$user_role = get_user_role();

if ($user_role == 'subscriber')
{
	$schedules = $pdb->get_results("SELECT concat(date_format(date, '%m/%d/%Y'), ' ', startime,'-',endtime) as date, u.display_name as doctor_name, if(s.status = 0, 'Request sent', 'Confirmed') as status FROM ".$wpdb->prefix."schedule s JOIN ".$wpdb->prefix."users u ON u.ID = s.doctor_id WHERE patient_id = " . $patient_id . " ORDER BY date DESC");
}
else
{
	$schedules = $pdb->get_results("SELECT concat(date_format(date, '%m/%d/%Y'), ' ', startime,'-',endtime) as date, u.display_name as doctor_name, u2.display_name as patient_name, if(s.status = 0, 'Request sent', 'Confirmed') as status FROM ".$wpdb->prefix."schedule s JOIN ".$wpdb->prefix."users u ON u.ID = s.doctor_id JOIN ".$wpdb->prefix."users u2 ON u2.ID = s.patient_id WHERE doctor_id = " . $id . " ORDER BY date DESC");
}
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
         
         	<?php if (get_user_role() == 'subscriber') { ?>
         
         	<table class="schedule-table">
            
            	<tr>
                	<td>#</td>
                   	<td>Date/Time</td>
                    <td>Doctor</td>
                    <td>Status</td>
                </tr>
                
                <?php if ($schedules) { ?>
                
                <?php foreach($schedules as $i => $sch) { ?>
                
                <tr>
                	<td><?php echo ($i + 1); ?></td>
                
                	<td><?php echo $sch->date; ?></td>
                   
                    <td><?php echo $sch->doctor_name; ?></td>
                    
                    <td><?php echo $sch->status; ?></td>
                
                </tr>
                
                <?php } ?>
                
                <?php } ?>
            	
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
            
            <?php } else if (get_user_role() == 'doctor') { ?>
            <table class="schedule-table">
            
            	<tr>
                	<td>#</td>
                   	<td>Date/Time</td>
                    <td>Patient Name</td>
                    <td>Action</td>
                </tr>
                
                 <?php if ($schedules) { ?>
                
                <?php foreach($schedules as $i => $sch) { ?>
                
                <tr>
                	<td><?php echo ($i + 1); ?></td>
                
                	<td><?php echo $sch->date; ?></td>
                   
                    <td><?php echo $sch->patient_name; ?></td>
                    
                    <td>Confirm Reset Date Refer</td>
                
                </tr>
                
                <?php } ?>
                
                <?php } ?>
                
            </table>
                
            <?php } ?>      
         
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
			var html = '';
			
			html += '<tr><td>#</td><td>Date/Time</td><td>Doctor</td><td>Status</td></tr>';
			
			for(var i=0; i<data.length; i++)
			{
				html += '<tr>';
				html += '<td>'+(parseInt(i) + 1)+'</td>';
				html += '<td>'+data[i].date+'</td>';
				html += '<td>'+data[i].doctor_name+'</td>';
				html += '<td>'+data[i].status+'</td>';
				
				html += '</tr>';
			}
			
			$('.schedule-table').html(html);
		}
	});
	
	return false;
});
</script>