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
$html .= '<div class="container new-message-box">';
$html .= "<div class='message_error'></div>";

if($_POST['message_id'] != 0)	{
	$message = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication WHERE id='$message_id'");
	foreach($message as $m)	{
		$html .= '<input type="hidden" name="message_id" value="'.$message_id.'">';
		$html .= '<div class="title" style="font-family: montserratregular;"><font style="color: #00af41;">Subject:</font> <input style="margin-top: 5px;" id="subject" type="text" value="REPLY: '.$m->subject.'"></div>';
		$html .= '<hr>';
		$html .= '<div class="message_header">';
		$from = $m->from;
		$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
		foreach($from_query as $f)	{
			$message_from = $f->display_name;
			$html .= '<div style="font-family: adellelight; font-size: 16px; color: #6d6e70;">Reply to: '.$f->display_name.'<input type="hidden" id="message_to" value="'.$f->ID.'"></div>';
		}
		$current_date = date("m/d/Y H:i:s");
		$html .= '<div style="font-family: adellelight; font-size: 16px; color: #6d6e70;">Reply date: '.date("M d, Y h:i:s A").'<input type="hidden" id="send_date" value="'.strtotime($current_date).'"></div>';
		$html .= '</div>';
		$html .= '<hr>';
		$html .= '<div class="message_text"><font style="font-family: adellelight; font-size: 16px;">Message:</font> <textarea id="message_text">';
		$html .= '&#13;&#13;--------------------------------------------------&#13;';
		$html .= 'On '.date("M d, Y", $m->date_sent).' at '.date("h:i:s A", $m->date_sent).'&#13;';
		$html .= 'Subject: '.$m->subject.'&#13;';
		$html .= 'From: '.$message_from.'&#13;';
		$html .= '&#13;';
		$html .= $m->message;
		
		$html .= '</textarea></div>';	
	}
} else {
	$html .= '<div class="title"><font style="color: #00af41;">Subject:</font> <input style="margin-top: 5px;" id="subject" type="text" value=""></div>';
	$html .= '<hr>';
	$html .= '<div class="text"></div>';
	$html .= '<div class="message_header">';
	$from = $m->from;
	$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practices AS p INNER JOIN ".$wpdb->prefix. "doctors WHERE ID='$from'");
	foreach($from_query as $f)	{
		$html .= '<div>Reply to: '.$f->display_name.'</div>';
	}
	$html .= '<input type="hidden" id="message_to" value="0">';
	$to_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
	foreach($to_query as $t)	{
	
	}
	$current_date = date("m/d/Y H:i:s");
	$html .= '<div style="font-family: adellelight; font-size: 16px; color: #6d6e70;">Send date: '.date("M d, Y").'<input type="hidden" id="send_date" value="'.strtotime($current_date).'"></div>';
	$html .= '</div>';
	$html .= '<hr>';
	$html .= '<div class="message_text"><font style="font-family: adellelight; font-size: 16px;">Message: </font><textarea id="message_text"></textarea></div>';	
}


$html .= '</div>';
$html .= '</div>';
if($_POST['message_id'] != 0)	{
	$html .= '<div class="message_reply_bar"><button class="message" id="'.$message_id.'">Cancel</button><button class="message_send">Send</button></div>';
} else {
	$html .= '<div class="message_reply_bar"><button class="cancel_message">Cancel</button><button class="message_send">Send</button></div>';
}
echo $html;
?>