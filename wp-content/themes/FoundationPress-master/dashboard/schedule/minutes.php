<h4>Availability for <?php echo date("l F jS", mktime(0,0,0, $month, $day, $year)); ?></h4>

<?php 

$start = mktime(9, 0, 0, $month, $day, $year); 
$end = mktime(17, 0, 0, $month, $day, $year); 

$interval = 20 * 60; 
$row = 0; 

$break_start = mktime(12, 0, 0, $month, $day, $year); 
$break_end = mktime(13, 0, 0, $month, $day, $year); 

?>

<div class="minutes">
	
    <ul>
    
    <?php for($i = $start; $i < $end; $i+=$interval) { ?>
    
    <?php if ($i < $break_start  || $i >= $break_end) { ?>
    
    <?php $value = date("Y-m-d h:i A", $i); ?>
    
    
	<?php if (array_key_exists($value, $user_time)) { ?>
    
    <?php if ($user_time[$value]['doctor_id'] == $doctor_id) { ?>
    
     <li>
        
    <?php } else { ?>
    
     <li class="disabled">
        
    <?php } ?>
    
    <?php } else { ?>
    
    <li>
    
    <?php } ?>
    
    	<?php if (array_key_exists($value, $user_time)) { ?>
        <?php if ($user_time[$value]['doctor_id'] == $doctor_id) { ?>
        <input name="dates[]" type="checkbox" value="<?php echo $value; ?>" checked="checked">  <?php echo date("h:i A", $i); ?>
        <?php } else { ?>
        <input name="dates[]" type="checkbox" value="<?php echo $value; ?>" disabled="disabled" >  <?php echo date("h:i A", $i); ?>
        <?php } ?>
        <?php } else { ?>
    	<input name="dates[]" type="checkbox" value="<?php echo $value; ?>"> <?php echo date("h:i A", $i); ?>
        <?php } ?>
    </li>
    
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

