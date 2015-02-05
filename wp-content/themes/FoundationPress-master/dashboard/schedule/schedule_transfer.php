
<style>
.doctor-schedule-wrapper
{
	width:600px;
}
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
	font-weight:bold;
	font-family: 'Didact Gothic', sans-serif;
}

.doctor-schedule-wrapper .name span
{
	display:block;
	font-family: 'adellethin';
	color:#02ac41;
	font-size:24px;
}

.doctor-schedule-wrapper h2
{
	color:#02ac41;
	font-size:22px;
	margin:0px 0px 10px;
}

.doctor-schedule-wrapper h2 span
{
	float:right;
	color:#444;
	font-family: 'Didact Gothic', sans-serif;
	font-weight:normal;
	font-size:18px;
}

.service-fee
{
	background:#efefef;
	padding:10px;
	margin:10px 0px;
	font-style:italic;
	font-family: 'Didact Gothic', sans-serif;
}

.calendar-header,
.doctor-availability h4
{
	background:#efefef;
	padding:5px 10px;
	margin:0px;
	font-size:100%;
	font-weight:normal;
}

.doctor-calendar
{
	float:left;
	width:39%;
	margin:0px 5px 0px 0px;
}

.doctor-availability
{
	float:left;
	width:59%;
	border:solid 1px #efefef;
}


.minutes 
{
	width:31%;
	margin:0px 5px 0px 0px;
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

.calendar td
{
	font-family: 'Didact Gothic', sans-serif;
	padding:4px;
	width:10px;
}

.calendar td:hover,
.calendar td.gray:hover,
.calendar td.selected,
.calendar td.current,
.calendar td.gray.selected
{
	background:#02ac41;
	color:#fff;
}

.calendar td.gray
{
	background:#e1e1e1;
	border:solid 1px #cbcbcb;
}

.calendar-header a
{
	float:right;
	text-outline: none;
	width: 20px;
	height:20px;
	text-align:center;
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

.minutes li
{
	margin:5px;
	padding:5px;
	line-height:15px;
	font-family: 'Didact Gothic', sans-serif;
}

.minutes li:hover,
.minutes li.disabled
{
	background:#00b03e;
	color:#fff;
}

.minutes li input[type=checkbox]
{
	margin:0px;
}

.doctor-schedule-wrapper .buttons
{
	margin:10px 0px;
}

.buttons a
{
	float:right;
	color:#02ac41;
	text-decoration:underline;
	font-weight:normal;
	line-height:30px;
}

.buttons a.submit-button
{
	background:#02ac41;
	color:#fff;
	text-decoration:none;
	padding:5px 10px;
	margin:0px 0px 0px 20px;
	text-transform:uppercase;
	-moz-border-radius:5px;
	border-radius:5px;
	-webkit-border-radius:5px;
	line-height:normal;
}

</style>

<div class="doctor-schedule-wrapper">

<div class="image">
<img src="<?php echo $image; ?>">
</div>

<div class="name"><?php echo $name; ?><span><?php echo $title; ?></span></div>


<hr />

<div class="service-fee">Service: Free Consultation Phone Call on Dec 23, 09:20 AM or Dec. 23, 04:00 PM</div>

<h2>Your preferred time (suggest up to 3) <span>20 minutes</span></h2>

<div class="doctor-calendar">

<?php include('calendar.php'); ?>
    
</div>

<div class="doctor-availability">

<input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
<input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

<div class="minutes-list">

<?php include('minutes.php'); ?>

</div>

</div>



<div style="clear:both"></div>

<div class="buttons">
	<a class="submit-button">Submit</a>
    <a class="close-button">Close</a>
</div>

</div><!-- wrapper -->

<script>



$(document).ready(function()
{
	
	calendar_header();
	calendar_day_select();
	calendar_minutes_select();
	
	$('.close-button').bind('click', function()
	{
		$.fancybox.close();
	});
	
	$('.submit-button').click(function()
	{
		var params = $('.doctor-availability input[type=hidden], .doctor-availability input[type=checkbox]:checked');
		
		$('.buttons').append('<div class="notification">Sending request, please wait...</div>');
		
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/doctor_calendar_submit.php',
			data: params,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				alert('Request successfully sent to doctor');		
				$('.buttons .notification').remove();
			}
		})
	});
})

function calendar_header()
{
	$('.calendar-header a').click(function()
	{
		var m = $(this).attr('data-month');
		var y = $(this).attr('data-year');
		
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/doctor_schedule_calendar.php',
			data: 'doctor_id=<?php echo $doctor_id; ?>&month=' + m + '&year=' + y,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.doctor-calendar').html(data.html);
				calendar_header();
				calendar_day_select();
			}
		});
	});
}


function calendar_day_select()
{
	$('.calendar-day').bind('click', function()
	{
		var dd = $(this).attr('data-value');
		
		$('.calendar-day').removeClass('selected');
		
		$(this).addClass('selected');
		
		$.ajax(
		{
			url: 'wp-content/themes/FoundationPress-master/parts/doctor_calendar_day.php',
			data: 'patient_id=<?php echo $patient_id; ?>&doctor_id=<?php echo $doctor_id; ?>&date=' + dd,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.minutes-list').html(data.html);
				calendar_minutes_select();
			}
		});
		
	});
}


function calendar_minutes_select()
{
	$('.doctor-availability li').bind('click', function()
	{
		var inp = $(this).find('input[type=checkbox]');
		
		if ($(inp).is(':checked'))
		{
			$(inp).prop('checked', false);
		}
		else 
		{
			if ($('.doctor-availability input:checked').length < 3 && !$(inp).prop('disabled'))
			{
				$(inp).prop('checked', true);
			}
		}
	});
	
	$('.doctor-availability input[type=checkbox]').bind('click', function()
	{
		$(this).parent().trigger('click');
	});
}
</script>