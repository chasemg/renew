<?php
include '../dashboard/db_include.php';
$html = '';

if(is_array($_POST['dob']))	{
	$children = 0;
	$adults = 0;
	$adults_under = 0;
	$seniors = 0;
	foreach($_POST['dob'] as $dob)	{
		$time_check = strtotime("-18 year");
		$adult_under_check = strtotime("-27 year");
		$senior_check = strtotime("-50 year");
		$dob_string = strtotime($dob);
		if($dob_string > $time_check){
			$children++;
		}
		if($dob_string < $time_check && $dob_string > $adult_under_check){
			$adults_under++;
		}		
		if($dob_string < $adult_under_check && $dob_string > $senior_check){
			$adults++;
		}
		if($dob_string < $senior_check){
			$seniors++;
		}		
	}
}
/*
$html .= "Children: ". $children;
$html .= "<br>";
$html .= "Adults under 27 Years old: ". $adults_under;
$html .= "<br>";
$html .= "Adults: ". $adults;
$html .= "<br>";
$html .= "Seniors: ". $seniors;
$html .= "<br>";
*/

$pricing = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "patient_pricing");
foreach($pricing as $price)	{
	if($price->id == 5)	{
		$you = $price->annually;
	}
	if($children > 1)	{
		if($price->id == 1)	{
			$first_child = $price->annually;
		}
		if($price->id == 6)	{
			$children = $children - 1;
			$additional = $price->annually * $children;
		}
		$children_cost = $additional + $first_child;
	} elseif($children == 1) {
		if($price->id == 1)	{
			$children_cost = $price->annually;
		}
	} else {
		$children_cost = 0;
	}
	if($adults_under > 0)	{
		if($price->id == 2)	{
			$adults_under_twentyseven = $price->annually * $adults_under;
		}
	} else	{
		$adults_under_twentyseven = 0;
	}
	if($adults > 0)	{
		if($price->id == 3)	{
			$adults_cost = $price->annually * $adults;
		}
	} else {
		$adults_cost = 0;
	}
	if($seniors > 0)	{
		if($price->id == 4)	{
			$seniors_cost = $price->annually * $seniors;
		}
	} else {
		$seniors_cost = 0;
	}
}
$total = $you + $children_cost + $adults_under_twentyseven + $adults_cost + $seniors_cost;
if($total == 1200)	{
	$fee = 50;
} else {
	$fee == 20;
}
$monthly = round(($total/12) + $fee, 2);

/*
$html .= "You: $" . $you;
$html .= "<br>";
$html .= "Children: $" . $children_cost;
$html .= "<br>";
$html .= "Adults under 27: $" . $adults_under_twentyseven;
$html .= "<br>";
$html .= "Adults: $" . $adults_cost;
$html .= "<br>";
$html .= "Seniors: $" . $seniors_cost;
$html .= "<br>";
$html .= $total;
*/
$html .= '<h1 style="border-bottom: none;">Your Price</h1>';
$html .= '<div>Based off of the information you provided, the annual fee for better healthcare is:</div>';
$html .= '<h1 style="font-size: 88px; font-family: adellesemibold; border-bottom: none;"><font style="font-size: 67px;">$</font>'.$total.'</h1>';
$html .= '<div style="color: #00953a; font-size: 17px; font-family: adellebold;">Here is a breakdown of your costs:</div>';
$html .= '<div style="font-size: 23px; font-family: adellelight; margin: 20px 0;">$'.$total.' annual fee<input type="hidden" id="annually" value="'.$total.'"></div>';
$html .= '<div style="color: #00953a; font-size: 17px; font-family: adellebold;">or</div>';
$html .= '<div style="font-size: 23px; font-family: adellelight; margin: 20px 0 0 0;">$'.$monthly.' monthly fee*<input type="hidden" id="monthly" value="'.$monthly.'"></div>';
$html .= '<div style="font-size: 12px; font-family: adellelight; margin: 10px 0;">*This includes an additional $'.$fee.' a month fee for the monthly model.</div>';

echo $html;

?>