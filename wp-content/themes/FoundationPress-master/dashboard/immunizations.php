<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];

$immunizations = $wpdb->get_results("SELECT *, date_format(date, '%m/%d/%Y') as date FROM ".$wpdb->prefix. "immunizations WHERE user_id='$patient_id'");

$user_role = get_user_role();

?>
<div class="dashboard_large_widget">
	<div class="container">
    	<div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/immunizations_icon.png"></div>
        <div class="title">Immunizations</div>
        
        <hr>
        
        <div class="text">
        	<font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here is a detailed look</font> at your immunizations. You can downlaod a complete schedule below.
        </div>
        
        <div class="immun_container">
        
        	<table class="table-list">
            	
                <thead>
            
            		<tr>
                		<td>#</td>
                    	<td>Doses</td>
                    	<td>Date</td>
                        <?php if ($user_role == 'doctor') { ?>
                    	<td>Action</td>
                        <?php } ?>
                	</tr>
                    
               	</thead>
                
                <?php $immun_row = 0; ?>
                
            	<?php if ($immunizations) { ?>
                
                <?php foreach($immunizations as $i => $immune) { ?>
                <tbody id="immun_row<?php echo $immun_row; ?>">
                <tr>
                
                	<td nowrap="nowrap"><?php echo $i + 1; ?></td>
                    <td><?php echo $immune->doses; ?></td>
                    <td><?php echo $immune->date; ?></td>   
                     <?php if ($user_role == 'doctor') { ?>                 
                    <td><input type="hidden" value='<?php echo json_encode($immune); ?>'><a data="<?php echo $immun_row; ?>" class="edit-button">edit</a></td>
                    <?php } ?>
                
                </tr>
                </tbody>
                
                <?php $immun_row++; ?>
                
                <?php } ?>
                
                <?php } ?>
                
                 <?php if ($user_role == 'doctor') { ?>
                
                <tfoot>
                
                	<tr>
                    
                    	<td colspan="4" style="text-align:right;"><a class="add-button">+add</a></td>
                    
                    </tr>
                
                </tfoot>
                
                <?php } ?>
            
            </table>
        
        </div>
        
        <hr>
        
        <div class="immun_schedule"><a href="http://www.cdc.gov/vaccines/schedules/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/complete_sched_imm.png"></a></div>
        
	</div><!--- container -->
</div>
    
    
<div class="goback"><img src="<?php echo get_template_directory_uri(); ?>/dashboard/images/goback.png"></div>

<script>
$(document).ready(function()
{
	var immun_row = <?php echo $immun_row; ?>;
	
	$('.edit-button').click(function()
	{
		var id = $(this).attr('data');
		var data = JSON.parse($('#immun_row' + id + ' input[type=hidden]').val());
		
		var html = '<tr><td>'+(parseInt(id) + 1)+'</td>';
	
		html += '<td><input type="text" value="'+data.doses+'" name="doses" size="3"><input type="hidden" name="user_id" value="<?php echo $patient_id; ?>"><input type="hidden" name="doctor_id" value="<?php echo $id; ?>"><input type="hidden" name="id" value="'+data.id+'"></td>';
		html += '<td><input type="text" value="'+data.date+'" name="date" class="date" size="10"></td>';
		html += '<td><a data='+id+' class="submit-button">Update</a></td>'
		html += '</tr>';
	
		$('#immun_row' + id).html(html);	
		$('.date').datepicker();
		
		$('.submit-button').unbind('click');
		
		immun_init_button();	
		
		
	});
	
	$('.add-button').click(function()
	{
		var html = '<tbody id="immun_row'+immun_row+'"><tr><td></td>';
	
		html += '<td><input type="text" name="doses" size="3"><input type="hidden" name="user_id" value="<?php echo $patient_id; ?>"><input type="hidden" name="doctor_id" value="<?php echo $id; ?>"></td>';
		html += '<td><input type="text" name="date" class="date" size="10"></td>';
		html += '<td><a data='+immun_row+' class="submit-button">Add</a></td>'
		html += '</tr></tbody>';
	
		$('.immun_container tfoot').before(html);	
		$('.date').datepicker();
		
		$('.submit-button').unbind('click');
		
		immun_init_button();
		
		immun_row++;
		
	});
	
	
	function immun_init_button()
	{
		$('.submit-button').click(function()
		{
			immun_submit($(this).attr('data'));
		});
	}
	
	function load_user_immunizations()
	{
		
	}
	
	function immun_submit(i)
	{
		var params = $('#immun_row'+i+' input, #immun_row'+i+' textarea');
		
		var dataOk = true;
		
		var date = $('#immun_row'+i+' input[name=date]').val();
		var dose = $('#immun_row'+i+ 'input[name=doses]').val();
		
		if (dose == '') dataOk = false;
		if (date == '') dataOk = false;
		
		if (dataOk)
		{		
			$.ajax({
				url: '/wp-content/themes/FoundationPress-master/dashboard/submit-immunizations.php',
				data: params,
				type: 'post',
				success: function(data)
				{
					$("#dashboard").empty();
					var user_id = <?php echo $id; ?>;
					var patient_id = <?php echo $patient_id; ?>;
					$.ajax({
						type: 'post',
						data: 'id='+ user_id+'&patient_id='+patient_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/immunizations.php',
						success: function(success)	
						{
							$("#dashboard").html(success);
							$(".goback img").click(function()	
							{
								user_dashboard();
							});						
						},
						error: function(error)	
						{
							console.log(error);
						}
					}); 
					
				}
			})
			
			//load_user_immunizations();
		}
		else
		{
			alert('Data can\'t submit, please check your input!');
		}
	}
	
});
</script>

