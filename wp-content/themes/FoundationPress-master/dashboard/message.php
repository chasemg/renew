<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/
include "db_include.php";
$id = $_POST['id'];
$message_id = $_POST['message_id'];
$html = '';
$html .= '<div class="dashboard_large_widget" style="max-width: 600px;">';
$html .= '<div class="container" style="width: auto; padding: 20px 50px;">';
$html .= '<input type="hidden" id="message_id" value="'.$message_id.'">';

$message = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "communication WHERE id='$message_id'");
foreach($message as $m)	{
	if($m->read == 0)	{
		$today = date("m/d/Y H:i:s");
		$now = strtotime($today);
		$pdb->update($pdb->prefix."communication", array('read'=>1,'date_read'=>$now), array('id'=>$message_id));
	}
	$html .= '<div class="title" style="font-family: montserratregular;"><font style="color: #00af41;">Subject</font><br>'.$m->subject.'</div>';
	$html .= '<hr>';
	$html .= '<div class="text"></div>';
	$html .= '<div class="message_header">';
	$from = $m->from;
	$from_query = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "users WHERE ID='$from'");
	foreach($from_query as $f)	{
		$html .= '<div style="font-family: adellelight; font-size: 16px; color: #6d6e70;">From: '.$f->display_name.'</div>';
	}
	$html .= '<div style="font-family: adellelight; font-size: 16px; color: #6d6e70;">Date: '.date("M d, Y", $m->date_sent).'</div>';
	$html .= '</div>';
	$html .= '<hr>';
	$html .= '<div class="message_text"><font style="font-family: adellelight; font-size: 16px;">Message:</font> <textarea disabled>'.$m->message.'</textarea></div>';	
}

$html .= '</div>';
$html .= '</div>';
$html .= '<div class="message_reply_bar"><button class="message_go_back" id="communications">Go Back</button><button class="message_reply">Reply</button></div>';
echo $html;
?>