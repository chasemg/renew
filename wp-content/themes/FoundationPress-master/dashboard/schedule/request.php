<style>
.request-list
{
	list-style:none;
	padding:0;
	margin:0;
}

.request-list li
{
	padding:5px;
	color:#ccc;
}

.request-list li a
{
	margin:0px 0px 5px;
}

.request-list li:nth-child(2n)
{
	background:#f9f9f9;
}

.request-list li .buttons
{
	margin:0px;
	float:right;
}

.request-list li .buttons a,
.request-list li.cancelled .buttons a
{
	display:inline-block;
	padding:0px 10px;
	text-align:center;
	color:#01af40;
	border-radius:10px;
}


.request-list li:hover .buttons a
{
	display:inline-block;
}

.request-list .buttons a:hover
{
	text-decoration:underline;
}

.request-list li.cancelled a
{
	color:#bbd323;
}


</style>

<h2>Request schedule</h2>

<?php if ($results) { ?>

<p>Below is the list of list request from patient.</p>

<ul class="request-list">

	<?php foreach($results as $result) { ?>
    <li class="<?php echo strtolower($result['status']); ?>">
    	<a data-action="details" data-practice="<?php echo $practice; ?>" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>"><?php echo $result['name']; ?>: <?php echo $result['date']; ?></a>
        
        <div class="buttons">
        	<a data-practice="<?php echo $practice; ?>" data-action="Confirmed" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Accept</a> 
            <a style="color:#F00" data-practice="<?php echo $practice; ?>" data-action="Cancelled" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Decline</a>  
            <a data-practice="<?php echo $practice; ?>" data-action="Transfer" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Transfer</a>
        </div>
    
    </li>
    
    <?php } ?>

</ul>

<?php } else { ?>


<div class="no-request">No request schedule</div>

<?php } ?>

<script>
$(document).ready(function()
{
	$('.request-list a').click(function()
	{
		var date = $(this).attr('data-date');
		var id = $(this).attr('data-patient-id');
		var action = $(this).attr('data-action');
		var practice = $(this).attr('data-practice');
		
		switch (action)
		{
			case 'Confirmed':
				
				if (confirm("Are you sure you want to CONFIRM the request"))
				{
					$.ajax(
					{
						url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_submit.php',
						data: {practice:practice,action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
						type: 'post',
						success: function(html)
						{
							$('.schedule_list').html(html);
						}		
					});
				}
			
			break;
			
			case 'Cancelled':
			
				
				if (confirm("Are you sure you want to CANCEL the request"))
				{
					$.ajax(
					{
						url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_submit.php',
						data: {practice:practice,action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
						type: 'post',
						success: function(html)
						{
							$('.schedule_list').html(html);
						}		
					});
				}
			
			break;
			
			case 'Transfer':
				
				if (confirm("Are you sure you want to TRANSFER the request"))
				{
					$.ajax(
					{
						url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_transfer.php',
						data: {practice:practice, action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
						type: 'post',
						success: function(html)
						{
							$.fancybox(html);
						}		
					});
				}
			
			
			break;
		}
		
		
		/*$.ajax(
		{
			url: '/wp-content/themes/FoundationPress-master/dashboard/schedule/patient-details.php',
			data: {date:date, id:id},
			type: 'post',
			success: function(html)
			{
				$.fancybox(html);
			}
		});*/
	});
});
</script>