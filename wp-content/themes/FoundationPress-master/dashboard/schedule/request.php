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
}

.request-list li .buttons a
{
	text-transform:lowercase;
	margin:10px 10px 10px 0px;
	display:inline-block;
	padding:5px 15px;
	text-align:center;
	color:#fff;
	background:#01af40;
	border-radius:10px;
}
</style>

<h2>Request schedule</h2>

<?php if ($results) { ?>

<p>Below is the list of list request from patient.</p>

<ul class="request-list">

	<?php foreach($results as $result) { ?>
    
    <li>
    	<a data-action="details" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>"><?php echo $result['name']; ?>: <?php echo $result['date']; ?></a><br />
        
        <div class="buttons"><a data-action="Confirmed" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Accept</a> <a data-action="Cancelled" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Decline</a>  <a data-action="transfer" data-date="<?php echo $result['date2']; ?>" data-patient-id="<?php echo $result['patient_id']; ?>">Transfer</a></div>
    
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
		
		switch (action)
		{
			case 'Confirmed':
				
				if (confirm("Are you sure you want to CONFIRM the request"))
				{
					$.ajax(
					{
						url: '/wp-content/themes/FoundationPress-master/parts/doctor_schedule_submit.php',
						data: {action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
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
						url: '/wp-content/themes/FoundationPress-master/parts/doctor_schedule_submit.php',
						data: {action:action, date:date, patient_id:id, doctor_id:<?php echo $id; ?>},
						type: 'post',
						success: function(html)
						{
							$('.schedule_list').html(html);
						}		
					});
				}
			
			break;
			
			case 'transfer':
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