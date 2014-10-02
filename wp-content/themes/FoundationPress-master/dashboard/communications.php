<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];

$html = '';

$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/immunizations_icon.png"></div>';
$html .= '<div class="title">Communications</div>';
$html .= '<div class="text" style="padding: 10px 0;"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here is your communications</font> between you and your doctors. You can also send and receive messages from Renew My Healthcare regarding your account.</div>';
$html .= "</div>";
$html .= "</div>";
$html .= "<ul class='messages'>";
for($i=0;$i<500;$i++)	{
$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
	$html .= "<li>".$i."</li>";
$html .= "</div>";
$html .= "</div>";	
}
$html .= "</ul>";

echo $html;
?>