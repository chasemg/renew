<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$limit = 10;
$html = '';

$html .= '<div class="dashboard_large_widget" style="max-width: 600px;">';
$html .= '<div class="container">';
$html .= '<div class="icon"><img src="'.get_template_directory_uri().'/dashboard/images/message.png"></div>';
$html .= '<div class="title">Messages</div>';
$html .= "<hr>";
$html .= '<div class="text" style="padding: 10px 0;"><font style="font-weight: bold; text-transform: lowercase; font-variant: small-caps; font-size: 14px;">Here are your communications</font> between your doctor and you. All communications are secure. You will be notified by email if you have a new message.</div>';

$html .= '<div class="message_reply_bar"><button class="new_message">New Message</button></div>';
$html .= "<ul class='messages'>";
$html .= '<input type="hidden" id="message_id" value="0">';
if($_POST['patient_id'] != $id)	{
	$messages = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication AS c INNER JOIN ".$wpdb->prefix. "doctors AS d  ON d.user_id=c.user_id WHERE c.user_id='$id' order by c.id desc LIMIT ". $limit * 2 . "");
} else {
	$messages = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication AS c INNER JOIN ".$wpdb->prefix. "patients AS p  ON p.user_id=c.user_id WHERE c.user_id='$id' order by c.id desc LIMIT ".$limit."");
}if($messages)	{
	foreach($messages as $message)	{
		$html .= "<li class='message' id='".$message->id."'>";
		if($message->read == 0)	{
			$html .= '<div class="message_overview message_overview_unread">';
		} else {
			$html .= '<div class="message_overview">';
		}
		$html .= '<div class="container">';
		$html .= "<div class='subject_container'>";
		$subject = $message->subject;
		$stripped_subject = (strlen($subject) > 50) ? substr($subject,0,50).'...' : $subject;
		$html .= "<div class='subject'>".$stripped_subject."</div><br>";
		$from = $message->from;
		$from_query = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
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
	$html .= "</li>";
}

$html .= "</ul>";

$html .= '<div class="message_reply_bar"><button class="new_message">New Message</button></div>';
$html .= "</div>";
$html .= "</div>";
$html .= '<div class="goback"><img src="'.get_template_directory_uri().'/dashboard/images/goback.png"></div>';

echo $html;
?>