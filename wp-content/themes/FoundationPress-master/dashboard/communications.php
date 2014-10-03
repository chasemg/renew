<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$limit = 10;
$html = '';

$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/immunizations_icon.png"></div>';
$html .= '<div class="title">Messages</div>';
$html .= '<div class="text" style="padding: 10px 0;"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here are your communications</font> between doctors and patients. You can also send and receive messages from Renew My Healthcare regarding your account. All communications are secure between doctor and patient. They are kept internally inside of Renew My Healthcare and you will be notified by email if you have a new message.</div>';
$html .= "</div>";
$html .= "</div>";
$html .= "<hr>";
$html .= "<div class='dashboard_large_widget'>";
$html .= "<ul class='messages'>";
$messages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication AS c INNER JOIN ".$wpdb->prefix. "users AS u ON u.ID=c.user_id WHERE c.user_id='$id' LIMIT $limit");
if($messages)	{
	foreach($messages as $message)	{
		$html .= "<li class='message' id='".$message->id."'>";
		if($message->read == 0)	{
			$html .= '<div class="message_overview message_overview_unread">';
		} else {
			$html .= '<div class="message_overview">';
		}
		$html .= '<div class="container">';
		$html .= "<div class='subject_container'>";
		$html .= "<div class='subject'>".$message->subject."</div><br>";
		$from = $message->from;
		$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
		foreach($from_query as $f)	{
			$html .= "<div class='from'>".$f->display_name."</div>";
		}
		$html .= "</div>";
		$html .= "<div class='message_date'>".date('M d, Y', $message->date_sent)."</div>";
		$html .= "</div>";
		$html .= "</div>";	
		$html .= "</li>";
	}
} else {
	$html .= "<li>";
	$html .= '<div class="message_overview">';
	$html .= '<div class="container" style="padding: 20px 0;">';
	$html .= 'No Messages.';
	$html .= "</div>";
	$html .= "</div>";	
	$html .= "</li>";
}

$html .= "</ul>";
$html .= "</div>";
echo $html;
?>