<?php

include '../dashboard/db_include.php';

$doctor_id = $_POST['doctor_id'];
$patient_id = $_POST['patient_id'];
$date = $_POST['date'];
$status = $_POST['action'];
$practice = $_POST['practice'];

$doctors = get_doctors_by_practice($practice);

?>
<style>
.transfer h2
{
	font-family: "montserratbold";
    margin-top: 5px;
    text-align: left;
    text-transform: uppercase;
    width: 100%;
	font-size:100%;
	padding:10px 0px;
	border-bottom:solid 1px #ccc;
	margin:0px 0px 10px;
}

.transfer h3
{
    color: #01af40;
    font-size: 16px;
    margin: 0px 0px 10px;
    padding: 5px 0;
}

.doctor-list > div
{
	float:left;
	margin:0px 10px 0px 10px;
	text-align:center;
}
</style>
<div class="transfer">

<h2>Transfer</h2>
<h3>Select a doctor</h3>

<div class="doctor-list">
<?php foreach($doctors as $dd) { ?>

<?php if ($dd->user_id != $doctor_id) { ?>

<?php $name = sprintf("Dr. %s", $dd->lname); ?>
<?php $title = $dd->title; ?>
	<div>
    	<div class="image"><a data-doctor-id-from="<?php echo $doctor_id; ?>" data-date="<?php echo $date; ?>" data-patient-id="<?php echo $patient_id; ?>" data-doctor-id="<?php echo $dd->user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/doctor-gray-icon.png"></a></div>
		<div class="name"><a data-doctor-id-from="<?php echo $doctor_id; ?>" data-date="<?php echo $date; ?>" data-patient-id="<?php echo $patient_id; ?>" data-doctor-id="<?php echo $dd->user_id; ?>"><?php echo $name; ?></a></div>
        <div class="title"><?php echo $title; ?></div>
    </div>
<?php } ?>
<?php } ?>

</div>



</div>

<script>
$('.transfer .doctor-list a').click(function()
{
	var name = $(this).parent().parent().find('.name a').html();
	var doctor_id_to = $(this).attr('data-doctor-id');
	var patient_id = $(this).attr('data-patient-id');
	var date = $(this).attr('data-date');
	var doctor_id_from = $(this).attr('data-doctor-id-from');
	
	if (confirm("Select " + name + "?"))
	{
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_transfer_doctor.php',
			data: {doctor_to:doctor_id_to, doctor_from:doctor_id_from, patient_id:patient_id, date:date},
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$.fancybox(data.html);
			}
		});
	}
});
</script>