<style>
.schedule-today
{
	width:40%;
	float:left;
}
.schedule-list
{
	width:60%;
	float:left;
}
.date-today
{
	margin:0px 20px 20px 0px;
	border:solid 1px #bcbdbf;
}
.month-year
{
	color:#fff;
	background:#bcbdbf;
	text-align:center;
	padding:5px;
}
.day-text
{
	text-align:center;
	padding:5px;
	margin:30px 0px 10px 0px;
}
.day-number
{
	text-align:center;
	color:#fff;
	background:#01af40;
	font-size:50px;
	width:70px;
	margin:0 auto 20px;
	padding:5px 0px;
}
.schedule-list h2,
.schedule_list h2
{
	color:#01af40;
	font-size:16px;
	margin:0;
	padding:5px 0px;
	border-bottom:solid 1px #eee;
}
.schedule-list-detail
{
	margin:5px 0px 10px 5px;
}
.schedule-list-detail .status
{
	font-size:12px;
}
.schedule-list-detail .pending
{
	color: #FF0;
}
.schedule-list-detail .cancelled
{
	color: #F00;
}
.schedule-list-detail .confirmed
{
	color: #060;
}

.schedule-list a
{
	color:#fff;
	background:#01af40;
	font-size:9px;
	padding:0px 15px;
	margin:0px 0px 0px 10px;
	float:right;
	border-radius:5px;
	display:none;
}

.schedule-time
{
	line-height:20px;
}


.schedule-list-detail:hover a
{
	display:inline-block;
}

</style>
<div class="schedule-today">

	<div class="date-today">
    
    	<div class="month-year"><?php echo date("F Y"); ?></div>
        
        <div class="day-text"><?php echo date("l"); ?></div>
        
        <div class="day-number"><?php echo date("d"); ?></div>
    
    
    </div>
		
</div>

<div class="schedule-list">
<h2>Scheduled appointments</h2>
<?php if ($today) { ?>
<?php foreach($today as $result) { ?>
<div class="schedule-list-detail">
	<div class="schedule-time"><?php echo $result['date']; ?> <a data-practice="<?php echo $practice; ?>" data-action="Cancel" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Cancel</a> <a data-action="Transfer" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Transfer</a></div>
    <div class="status <?php echo strtolower($result['status']); ?>"><?php echo $result['status']; ?> with <?php echo $result['name']; ?></div>
</div>
<?php } ?>
<?php } else { ?>
<div class="no-schedule-today">No appointment today</div>
<?php } ?>
</div>


<script>
$('.schedule-time a').click(function()
{
	var action = $(this).attr('data-action');
	var id = $(this).attr('data-patient-id');
	var date = $(this).attr('data-date');
	var practice = $(this).attr('data-practice');
	
	switch (action)
	{
		case 'Cancel':
		
			if (confirm('Are you sure you want to CANCEL this appointment?'))
			{
				$.ajax(
				{
					url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_submit.php',
					data: {practice:practice, action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
					type: 'post',
					success: function(html)
					{
						$('.schedule_list').html(html);
					}		
				});
			}
		
		break;
		
		case 'Transfer':
		
			if (confirm('Are you you want to tranfer to another this appointment'))
			{
				$.ajax(
				{
					url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_transfer.php',
					data: {practic:practice,action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
					type: 'post',
					success: function(html)
					{
						
					}		
				});
			}
		
		break;
	}
});
</script>