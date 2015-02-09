<style>
.doctor-enrollment-success
{
	width:640px;
	bacground-color:#fff;
}

.doctor-enrollment-success .logo
{
	width:120px;
	height:44px;
	margin:5px auto;
	background-image:url(<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/logo.png);
	background-size:contain;
	background-repeat:no-repeat;
}

.doctor-enrollment-success .buttons 
{
	margin:10px 0px;
}

.doctor-enrollment-success .buttons a
{
	background:#009639;
	width:47%;
	display:inline-block;
	padding:5px;
	text-align:center;
	color:#fff;	
}

.doctor-enrollment-success .buttons > a:first-child
{
	margin:0px 10px 0px 0px;
}


.doctor-enrollment-success .close a
{
	color:#009639;
	float:right;
	width:51px;
	height:15px;
	background-image:url(<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/close-x-button.png);
}

.doctor-enrollment-success h3
{
	text-align:center;
	color:#000;
	margin:10px 0px 20px;
	font-size:28px;
}

.doctor-enrollment-success .doctor-icon
{
	width:86px;
	height:97px;
	margin:15px auto 10px;
	background-image:url(<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/doctor-green-icon.png);
	background-size:contain;
	background-repeat:no-repeat;
}
</style>
<div class="doctor-enrollment-success">
<div class="logo"><a href="/"></a></div>
<div class="doctor-icon"></div>
<h3>Thank You</h3>
<p>Registration for your account has been completed successfully.  Check your email for a welcome packet.  If you have not received the welcome packet email, please check your spam and add Renew My Healthcare as a trusted sender.  We look forward to helping you.</p>
<div class="buttons"><a href="/" class="green-button">take me to the home page</a><a href="/login">take me to my login</a></div>
<div class="close"><a onClick="$.fancybox.close()"></a></div>
</div>