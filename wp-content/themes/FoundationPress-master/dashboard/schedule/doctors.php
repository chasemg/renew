<?php if (!$doctors) { ?>

There are no doctor for this practice

<?php } else { ?>

Here is a list of doctors currently at the practice you have chosen. <a>Select a Doctor</a> below to schedule, reschedule or change an appointment.

<div class="doctor-list">

<?php foreach($doctors as $dd) { ?>
<?php $avatar = get_avatar($dd->ID, 130, 'Doctor Avatar'); ?>
	<div>
    	<div class="image"><?php echo $avatar; ?></div>
		<div class="name"><?php echo $dd->display_name; ?></div>
    </div>

<?php } ?>

</div>

<?php } ?>