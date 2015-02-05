<div class="calendar-header">
<?php echo date("F Y", mktime(0,0,0, $month, 1, $year)); ?>
<a data-month="<?php echo $next_month; ?>" data-year="<?php echo $next_year; ?>" class="next"><span></span></a>
<a data-month="<?php echo $prev_month; ?>" data-year="<?php echo $prev_year; ?>" class="prev"><span></span></a>
</div>

<table cellpadding="0" cellspacing="2" class="calendar">

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
	
		$date = sprintf("%s-%s-%02s", $year, $month, $list_day);
		
		$class = "";
		
		if ($date == date("Y-m-d"))
		{
			$class = 'current';
		}
		else if (in_array($date, $dates))
		{
			$class = 'gray';
		}
	
	?>
		<td data-value="<?php echo $date; ?>" class="calendar-day <?php echo $class; ?>">
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

