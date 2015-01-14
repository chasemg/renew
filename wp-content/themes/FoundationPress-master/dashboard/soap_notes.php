<?php
/*
Author: Kevin Griffiths
URL: http://chasemg.com
*/

echo "soap notes";
include "db_include.php";
$id = $_POST['id'];
$patient_id = $_POST['patient_id'];
$patient = $pdb->get_results("SELECT * FROM ".$wpdb->prefix. "patients WHERE user_id='$patient_id'");
foreach($patient as $p)	{
echo "<div id='paramsArray'>";
	echo '<input id="rcopia_portal_system_name" name="rcopia_portal_system_name" size="30" value="pvendornxunw" readonly>';
	echo '<input id="rcopia_practice_user_name" name="rcopia_practice_user_name" size="30" value="so95104" readonly>';
	echo '<input id="rcopia_user_id" name="rcopia_user_id" size="30" value="pproviderynftve" readonly>';
	echo '<input id="rcopia_user_external_id" name="rcopia_user_external_id" size="30" value="" readonly>';
	echo '<input id="service" name="service" value="rcopia" readonly>';
	//echo '<select id="service" name="service">
	//		<option value="rcopia" selected="selected">rcopia</option>
	//		<option value="rcopia_mini">rcopia_mini</option>
	//		<option value="rcopia_ac">rcopia_ac</option>
	//	</select>';
	echo '<input id="action" name="action" size="30" value="login" readonly>';
	echo '<input id="startup_screen" name="startup_screen" value="patient" readonly>';
	/*echo '<select id="startup_screen" name="startup_screen">
			<option value="patient" selected="selected">patient</option>
			<option value="manage_medications">manage_medications</option>
			<option value="manage_allergies">manage_allergies</option>
			<option value="manage_problems">manage_problems</option>
			<option value="report">report</option>
			<option value="message">message</option>
			<option value="schedule">schedule</option>
			<option value="summary">summary</option>
			<option value="summary_read_only">summary_read_only</option>
		</select>';*/
	echo '<input id="rcopia_patient_id" name="rcopia_patient_id" size="30" value="" readonly>';
	echo '<input id="rcopia_patient_system_name" name="rcopia_patient_system_name" size="30" value="pvendornxunw" readonly>';
	echo '<input id="rcopia_patient_external_id" name="rcopia_patient_external_id" size="30" value="test1234" readonly>';
	echo '<input type="hidden" id="time" name="time" size="30" value="fTime();">';
	echo '<input id="secret_key" name="secret_key" size="30" value="wiaofoh3" type="password" readonly>';
	echo '<input id="close_window" name="close_window"  value="y" readonly>';
	/*echo '<label>
			<input type="radio" id="close_window" name="close_window" value="y"/>
			y</label>
			<label>
			<input type="radio" id="close_window1" name="close_window" value="n" />
		n</label>';*/
	echo '<input id="logout_url" name="logout_url" size="30" value="" readonly>';
	echo '<input id="allow_popup_screens" name="allow_popup_screens" value="y" readonly>';
	/*echo '<label>
			<input type="radio" id= "allow_popup_screens" name="allow_popup_screens" value="y"/>
			y </label>
			<label>
			<input type="radio" id= "allow_popup_screens1" name="allow_popup_screens" value="n" />
		n </label>';*/
	echo '<input id="override_single_patient" name="override_single_patient" value="y" readonly>';
	/*echo '<label>
			<input type="radio" id="override_single_patient" name="override_single_patient" value="y"/>
			y </label>
			<label>
			<input type="radio" id="override_single_patient1" name="override_single_patient" value="n" />
		n </label>';*/	
	echo '<input id="limp_mode" name="limp_mode" value="y" readonly>';		
	/*echo '<label>
			<input type="radio" id="limp_mode" name="limp_mode" value="y"/>
			y </label>
			<label>
			<input type="radio" id="limp_mode1" name="limp_mode" value="n" />
		n </label>';*/		
	echo '<input id="contact_email" name="contact_email" size="30" value="">';
	echo '<input id="timeout_url" name="timeout_url" size="30" value="">';
	echo '<input id="encounter_id" name="encounter_id" size="30" value="">';
	echo '<input id="location_external_id" name="location_external_id" size="30" value="">';
	echo '<input id="rcopia_id_access_list" name="rcopia_id_access_list" size="30" value="">';
	echo '<input id="external_id_access_list" name="external_id_access_list" size="30" value="">';
	echo '<input id="navigation_privilege" name="navigation_privilege" size="30" value="">';
	echo '<input id="skip_auth" name="skip_auth" value="y" readonly>';
	/*echo '<label>
			<input type="radio" id="skip_auth" name="skip_auth" value="y"/>
			y </label>
			<label>
			<input type="radio" id="skip_auth1" name="skip_auth" checked="yes" value="n" />
		n </label>';*/
	echo '</div>';
	
	
}

echo "<br>";
echo "<div class='overlay'><iframe id='drfirst'></iframe></div>";
echo "<button id='drfirst_launch'>Dr First</button>";

?>