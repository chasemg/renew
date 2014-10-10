<?php

$html = '';

if($_POST['street'] && $_POST['city'] && $_POST['state'] && $_POST['zip'])	{
	$html .= "<input type='hidden' value='".$_POST['street']."' id='street_verified'>";
	$html .= "<input type='hidden' value='".$_POST['city']."' id='city_verified'>";
	$html .= "<input type='hidden' value='".$_POST['state']."' id='state_verified'>";
	$html .= "<input type='hidden' value='".$_POST['zip']."' id='zip_verified'>";
} else {
	$html .= 0;
}

echo $html;


?>