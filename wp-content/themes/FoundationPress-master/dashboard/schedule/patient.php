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

.schedule-list h2
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
<?php foreach($results as $result) { ?>
<div class="schedule-list-detail">
	<div class="time"><?php echo $result['date']; ?></div>
    <div class="status <?php echo strtolower($result['status']); ?>"><?php echo $result['status']; ?> with <?php echo $result['doctor']; ?></div>
</div>
<?php } ?>
</div>