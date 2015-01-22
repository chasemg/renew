<style>
.doctor-list > div
{
	width:33%;
	float:left;
	text-align:center;
}
</style>
<?php if (!$doctors) { ?>

There are no doctor for this practice

<?php } else { ?>

Here is a list of doctors currently at the practice you have chosen. <a>Select a Doctor</a> below to schedule, reschedule or change an appointment.

<div class="doctor-list">

<?php foreach($doctors as $dd) { ?>
<?php $name = sprintf("Dr. %s", $dd->lname); ?>
<?php $title = $dd->title; ?>
	<div>
    	<div class="image"><a data-value="<?php echo $dd->user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/doctor-gray-icon.png"></a></div>
		<div class="name"><a data-value="<?php echo $dd->user_id; ?>"><?php echo $name; ?></a></div>
        <div class="title"><?php echo $title; ?></div>
    </div>

<?php } ?>

</div>

<script language="javascript1.1">
$('.doctor-list a').bind('click', function()
{
	var id = $(this).attr('data-value');
		
	$.ajax(
	{
		url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule.php',
		data: 'patient_id=<?php echo $patient_id; ?>&doctor_id=' + id,
		type: 'post',
		dataType: 'json',
		success: function(data)
		{
			$.fancybox(data.html);
		}
	});
})
</script>

<?php } ?>