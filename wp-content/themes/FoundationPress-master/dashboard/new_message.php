<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$message_id = $_POST['message_id'];
$html = '';
$html .= '<div class="dashboard_large_widget">';
$html .= '<div class="container">';
$html .= '<input type="hidden" name="message_id" value="'.$message_id.'">';
if($_POST['message_id'])	{
	$message = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication WHERE id='$message_id'");
	foreach($message as $m)	{
		$html .= '<div class="title">Subject: <input id="subject" type="text" value="REPLY: '.$m->subject.'"></div>';
		$html .= '<hr>';
		$html .= '<div class="message_header">';
		$from = $m->from;
		$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
		foreach($from_query as $f)	{
			$message_from = $f->display_name;
			$html .= '<div>Reply to: '.$f->display_name.'<input type="hidden" id="message_to" value="'.$f->ID.'"></div>';
		}
		$html .= '<div>Reply date: '.date("M d, Y h:i:s A").'<input type="hidden" id="sent_date" value="'.strtotime(date("m/d/Y h:i:s")).'"></div>';
		$html .= '</div>';
		$html .= '<hr>';
		$html .= '<div class="message_text">Message: <textarea id="message_text">';
		$html .= '&#13;&#13;--------------------------------------------------&#13;';
		$html .= 'On '.date("M d, Y", $m->date_sent).' at '.date("h:i:s A", $m->date_sent).'&#13;';
		$html .= 'Subject: '.$m->subject.'&#13;';
		$html .= 'From: '.$message_from.'&#13;';
		$html .= '&#13;';
		$html .= $m->message;
		
		$html .= '</textarea></div>';	
	}
} else {
	$html .= '<div class="title"><input id="subject" type="text" value=""></div>';
	$html .= '<hr>';
	$html .= '<div class="text"></div>';
	$html .= '<div class="message_header">';
	$from = $m->from;
	$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
	foreach($from_query as $f)	{
		$html .= '<div>From: '.$f->display_name.'</div>';
	}
	$html .= '<div>Send date: '.date("M d, Y").'<input type="hidden" id="sent_date" value="'.strtotime(date("m/d/Y")).'"></div>';
	$html .= '</div>';
	$html .= '<hr>';
	$html .= '<div class="message_text"><textarea></textarea></div>';	
}


$html .= '</div>';
$html .= '</div>';
if($_POST['message_id'] != '' || $_POST['message_id'] != 0)	{
	$html .= '<div class="message_reply_bar"><button class="message" id="'.$message_id.'">Cancel</button><button class="message_send">Send</button></div>';
} else {
	$html .= '<div class="message_reply_bar"><button class="message_go_back" id="communications">Go Back</button><button class="message_send">Send</button></div>';
}
echo $html;
?>