<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";



$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$doctors = get_doctors_by_practice($practice);
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
        	
        </div>
        
         <div class="schedule_list">
         
         	<?php if (get_user_role() == 'subscriber') {  
			
				if ($_SERVER['HTTP_HOST'] == 'renew.local')
				{
					$file = DOCUMENT_ROOT . '/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
				}
				else
				{
					$file = '/home/renew/renew/wp-content/themes/FoundationPress-master/dashboard/schedule/json/patient_' . $patient_id . '.js';
				}
				
				$results = array();
				
				if (file_exists($file))
				{
					$handle = fopen($file, "r");
					$json = fread($handle, filesize($file));
					
					foreach(json_decode($json) as $obj)
					{
						$doctor = get_doctor_info($obj->doctor_id, $practice);
						
						foreach($obj->dates as $dates)
						{
							if (date("Y-m-d", strtotime($dates->date)) == date("Y-m-d"))
							{
								$date = sprintf("%s at %s", date("m/d/y", strtotime($dates->date)), date("h:i A", strtotime($dates->date)));
							
								$results[] = array('date' => $date,
												   'status' => $dates->status,
												   'doctor' => sprintf("Dr. %s", $doctor->lname));
							}
						}
					}
				}
				
			        
          
          		include('schedule/patient.php');
				
			?>
            <hr >
            <?php
				include('schedule/doctors.php');
                
             } ?>      
         
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