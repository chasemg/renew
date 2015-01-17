
<style>
.doctor-schedule-wrapper .image
{
	float:left;
	width:90px;
	height:70px;
	text-align:center;
}

.doctor-schedule-wrapper .image img
{
	height:100%;
}

.doctor-schedule-wrapper .name
{
	text-transform:uppercase;
	color:#000;
	font-size:30px;
}

.doctor-schedule-wrapper .name span
{
	display:block;
}

.service-fee
{
	background:#efefef;
	padding:10px;
	margin:10px;
	font-style:italic;
}

.doctor-calendar
{
	float:left;
	width:40%;
}

.doctor-availability
{
	float:left;
	width:60%;
}

.minutes 
{
	width:31%;
	margin:0px 10px 0px 0px;
	float:left;
}

.minutes ul
{
	list-style:none;
	margin:0;
	padding:0;
}

.doctor-calendar .next
{
	margin:0px 0px 0px 5px;
	background:none;
}

.calendar-header a
{
	float:right;
	text-outline: none;
	width: 20px;
	height:20px;
	text-align:center;
	content: "<span></span>";
	border:solid 1px #ccc;
	border-radius:3px;
	margin:0px 0px 0px 5px;
}

.calendar-header a > span
{
	display:inline-block;
	margin:2px;
}

.calendar-header a.next span
{
	width:0;
	height:0;
	border-top:solid 7px transparent;
	border-bottom:solid 7px transparent;
	border-left:7px solid #000;
}

.calendar-header a.prev span
{
	width:0;
	height:0;
	border-top:solid 7px transparent;
	border-bottom:solid 7px transparent;
	border-right:7px solid #000;
}


</style>

<div class="doctor-schedule-wrapper">

<div class="image">
<img src="<?php echo $image; ?>">
</div>

<div class="name"><?php echo $name; ?><span><?php echo $title; ?></span></div>


<hr />

<div class="service-fee">Service: Free Consultation Phone Call on Dec 23, 09:20 AM or Dec. 23, 04:00 PMA</div>

<h2>Your preferred time (suggest up to 3) <span>20 minutes</span></h2>

<div class="doctor-calendar">

<div class="calendar-header">
<?php echo date("F Y", mktime(0,0,0, $month, 1, $year)); ?>
<a data-month="<?php echo $next_month; ?>" data-year="<?php echo $next_year; ?>" class="next"><span></span></a>
<a data-month="<?php echo $prev_month; ?>" data-year="<?php echo $prev_year; ?>" class="prev"><span></span></a>
</div>

<table cellpadding="0" cellspacing="0" class="calendar">

	<?php
    
	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();
	
	?>
	<tr class="calendar-row"><td class="calendar-day-head"><?php echo implode('</td><td class="calendar-day-head">',$headings); ?></td></tr>

	<tr class="calendar-row">

	<?php  for($x = 0; $x < $running_day; $x++): ?>
	
		<td class="calendar-day-np"> </td>
     
    <?php    
		
		$days_in_this_week++;
		
	endfor;
	
	?>

	<?php
    
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	
	?>
		<td class="calendar-day">
			<?php echo $list_day; ?>
		</td>
        
    <?php if($running_day == 6): ?>
	
    </tr>
    
    <?php if(($day_counter+1) != $days_in_month): ?>
	
    <tr class="calendar-row">
    
    <?php endif; 
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;
	
	?>

	
	<?php if($days_in_this_week < 8): ?>
	<?php	for($x = 1; $x <= (8 - $days_in_this_week); $x++): ?>
			<td class="calendar-day-np"> </td>
            
    <?php
	        
		endfor;
	endif;

	?>
    
	</tr>


	</table>
    
</div>

<div class="doctor-availability">

<h4>Availability for <?php echo date("l F jS"); ?></h4>

<?php 

$start = mktime(9, 0, 0, date("m"), date("d"), date("Y")); 
$end = mktime(17, 0, 0, date("m"), date("d"), date("Y")); 
$interval = 20 * 60; 
$row = 0; 
$break_start = mktime(12, 0, 0, date("m"), date("d"), date("Y")); 
$break_end = mktime(13, 0, 0, date("m"), date("d"), date("Y")); 

?>

<div class="minutes">
	
    <ul>

	<?php for($i = $start; $i < $end; $i+=$interval) { ?>
    
    <?php if ($i < $break_start  || $i >= $break_end) { ?>

	<li><input type="checkbox"> <?php echo date("h:i A", $i); ?></li>
    
    <?php if ($row == 6) { ?>
    
    </ul>
    
    </div>
    
    <div class="minutes">
    
    <ul>
    
    <?php $row = 0; ?>
    
    <?php } else { ?>
    
    <?php $row++; ?>
    
    <?php } ?>
    
    <?php } ?>
    
	<?php } ?>

	</ul>
    
</div>

</div>

</div><!-- wrapper -->

<script>
$(document).ready(function()
{
	$('.calendar-header a').click(function()
	{
		var m = $(this).attr('data-month');
		var y = $(this).attr('data-year');
		
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_calendar.php',
			data: 'doctor_id=<?php echo $doctor_i; ?>&month=' + m + '&year=' + y,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.doctor-calendar').html(data.html);
			}
		});
	});
})
</script>