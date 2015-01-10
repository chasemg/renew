<?php

include "db_include.php";
$patient_id = $_POST['patient_id'];
$id = $_POST['id'];
?>
		<style type="text/css">
			body {
				text-align: center;
				font-family: Verdana, Geneva, sans-serif, Arial, Helvetica, sans-serif;
				font-size: 12px;
			}
			p {
				margin: 5px auto;
			}
			.box {
				width: 970px;
				text-align: center;
				border: solid 1px #CCCCCC;
				-moz-border-radius: 10px 10px 10px 10px;
				-webkit-border-radius: 10px 10px 10px 10px;
				border-radius: 10px;
				padding: 5px;
				-moz-box-shadow: 0px 0px 3px #444;
				-webkit-box-shadow: 0px 0px 3px #444;
				box-shadow: 0px 0px 3px #444;
				margin: 0px auto;
			}
			.main_table {
				width: 960px;
			}
			.main_table tr {
				text-align: center;
			}
			.title {
				text-align: center;
				font-size: 13px;
				font-weight: bold;
				color: #FFF;
				background-color: #369;
				text-align: center;
				-moz-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				box-shadow: 1px 1px 1px rgba(0,0,0,.3);
			}
			.main_row {
				font-size: 12px;
				text-align: left;
				padding: 5px;
				border-bottom: solid 1px #999;
			}
			.required td {
				color: #B90000;
				font-size: 13px;
			}
			.MAC {
				text-align: left;
				font-size: 12px;
				padding: 10px;
				word-wrap: break-word;
			}
			h3 {
				color: #304c82;
				border-bottom: solid 1px #999999;
				font-style: italic;
			}
			.button {
				padding: 10px 20px;
				color: #EEE;
				border: solid 1px #999;
				outline: none;
				font-weight: bold;
				font-size: 13px;
				cursor: pointer;
				background: #304C82;
				box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				-moz-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				border-radius: 5px 5px 5px 5px;
				-moz-border-radius: 5px 5px 5px 5px;
				-webkit-border-radius: 5px 5px 5px 5px;
				text-decoration: none;
			}
			.reset {
				padding: 5px 5px;
				color: #EEE;
				border: solid 1px #999;
				outline: none;
				font-size: 12px;
				cursor: pointer;
				background: #777;
				box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				-moz-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.3);
				text-decoration: none;
			}
		</style>

		<script type="text/javascript">
			var HideShow = "Hide";
			//show hide pswd on Mouseover
			function ShowPSW(o){
				o.type = "text";
			}
			function HidePSW(o){
				o.type = "password";
			}
		
			// Hide additional parameters
			function ShowHideTR(id){		
				if(document.getElementsByTagName){  
					var rows = document.getElementsByTagName("tr"); 
					for(i = 0; i < rows.length; i++){  
						if(rows[i].id!='dont touch'){
							if(rows[i].style.display == ''){ 	
								rows[i].style.display = 'none';
								document.getElementById('ShowHide').value = "Show Addional SSO Options";
								HideShow = "Hide";
							}else{
								rows[i].style.display = '';
								document.getElementById('ShowHide').value = "Hide Addional SSO Options"; 
								HideShow = "Shown"								
							}
						 }
					}
				}
				
			}	
			
			//NOT USE FOR NOW: function clearing a text box when focused
			function clearDefault(el) {
				if (el.defaultValue==el.value) el.value = ""
			}

			//Set Time parameter
			function fTime() {
			
				var GMTTime = new Date();
				var month = GMTTime.getUTCMonth() + 1;
				var day = GMTTime.getUTCDate();
				var year = GMTTime.getUTCFullYear() - 2000;
				var hour = GMTTime.getUTCHours();
				var min = GMTTime.getUTCMinutes();
				var sec = GMTTime.getUTCSeconds();
				
				if (month < 10) { month = "0" + month; }
				if (day < 10) { day = "0" + day; }
				if (hour < 10) { hour = "0" + hour; }
				if (hour < 1) { hour = "00"; }
				if (min < 10) { min = "0" + min; }
				if (min < 1) { min = "00"; }				
				if (sec < 10) { sec = "0" + sec; }
				if (sec < 1) { sec = "00"; }
				
				GMTime = month.toString() + day.toString() + year.toString() + hour.toString() + min.toString() + sec.toString();
			
				return GMTime;
			
			}

			//Crete the necessary MAC string
			function generateMAC()
			{
			// Push all SSO variable names into an array. 
			
			var x = ['rcopia_portal_system_name', 
			'rcopia_practice_user_name', 
			'rcopia_user_id', 
			'rcopia_user_external_id', 
			'service', 
			'action', 
			'startup_screen', 
			'rcopia_patient_id', 
			'rcopia_patient_system_name', 
			'rcopia_patient_external_id', 
			'close_window', 
			'logout_url', 
			'allow_popup_screens', 
			'override_single_patient', 
			'limp_mode', 
			'contact_email', 
			'timeout_url', 
			'encounter_id',
			'location_external_id',
			'rcopia_id_access_list',
			'external_id_access_list',
			'navigation_privilege',
			'skip_auth',
			'time'
			 ]; // fTime() returns the current GMT timestamp and pushes it into the  array as the last element
			 	
			var param_url = generateURL(x); //Call function to generate the initial SSO URL
			var append_key = param_url + document.getElementById('secret_key').value; //Append the secret key to the URL
			//alert(document.getElementById('secret_key').value);
			var MAC= calcMD5(append_key).toUpperCase();
			var final_param_url = param_url + '&MAC=' + MAC; // Final string to use for SSO POST

			// Generate the Show Me How section text for the MAC generation process
			document.getElementById('param_url').innerHTML = '<h3>Step 1 - Create Parameter String</h3><p>Create a string of all parameters that have been assigned a value. Exclue any parameters that are not set.</p> Initial string : <strong>'+ param_url + '</strong>';
			document.getElementById('append_key').innerHTML= '<h3>Step 2 - Append Secret Key</h3><p>Append the secret key (vendor password) to the end of the strin.</p>String with Secret Key : <strong>'+ append_key + '</strong>';
			document.getElementById('MAC').innerHTML= '<h3>Step 3 - Generate MAC (md5 hash) for Step 2 string</h3><p>Generate the MAC (md5 hash) and convert it to <strong>upper case</strong></p>MAC : <strong>'+ MAC + '</strong>';
			document.getElementById('append_MAC').innerHTML= '<h3>Step 4 - Append MAC to String in Step 1</h3><p>Remove the secret key and append the MAC value as a parameter</p>Final Parameter String with MAC : <strong>' +  param_url + '&MAC=' + MAC + '</strong>';
			document.getElementById('final_url').innerHTML= '<h3>Step 5 - POST Final string to DrFirst</h3><p>Generate final URL for POST</p> Final URL : <strong>https://cert.drfirst.com/sso/portalServices?' + final_param_url + '</strong>';

			return final_param_url;
			}			
			
			//Generate the string necessary to create the MAC
			function generateURL(params) {
				var parameter_url;
				for (i = 0; i < params.length; i++) {
					// Enter loop for all SSO parameters in the array
					if (document.getElementById(params[i]).value != '') {
						// Check if parameter is set. If not, do not include in SSO request
						if (!parameter_url) {
							// If URL string is empty
							parameter_url = params[i] + "=" + document.getElementById(params[i]).value;
			
						} else if (document.getElementById(params[i]).type == 'radio') { // If SSO parameter is a radio button
							var radioButtons = document.getElementsByName(params[i]);
							for (var x = 0; x < radioButtons.length; x++) { // Loop through all the radio buttons to find which one is checked
								if (radioButtons[x].checked) { // For checked radio button append value to the URL
									parameter_url = parameter_url + "&" + params[i] + "=" + radioButtons[x].value;
								}
							}
			
						} else if (params[i] == 'time') { // If SSO parameter is the time variable
							parameter_url = parameter_url + "&" + params[i] + "=" + fTime(); //Call function fTime() to generate current GMT
							}
						 else { // For all regular textboxes and dropdowns
							parameter_url = parameter_url + "&" + params[i] + "=" + document.getElementById(params[i]).value;
							}
					}
			
				}

			  return parameter_url;
			}

			
			// Function for Launch Rcopia button
			function launchRcopia(url)
			{
				final_param_url = generateMAC(); // Capture final URL string by calling the generateMAC() function
				var oURL = url; // Append final string to URL specified in function call 
				oURL = oURL + final_param_url;

				var leftpos = (screen.width-800)/2;
				var toppos = (screen.height-600)/2;
				
				window.open(oURL,'myWin','toolbar,status,resizable,scrollbars,width=800,height=600, top='+toppos+', left='+leftpos);
			}
			
//********************************* MD5 HASHING ************************************************//			
			/*
			 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
			 * Digest Algorithm, as defined in RFC 1321.
			 * Copyright (C) Paul Johnston 1999 - 2000.
			 * Updated by Greg Holt 2000 - 2001.
			 * See http://pajhome.org.uk/site/legal.html for details.
			 */

			/*
			 * Convert a 32-bit number to a hex string with ls-byte first
			 */
			var hex_chr = "0123456789abcdef";
			function rhex(num)
			{
			  str = "";
			  for(j = 0; j <= 3; j++)
				str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) +
					   hex_chr.charAt((num >> (j * 8)) & 0x0F);
			  return str;
			}

			/*
			 * Convert a string to a sequence of 16-word blocks, stored as an array.
			 * Append padding bits and the length, as described in the MD5 standard.
			 */
			function str2blks_MD5(str)
			{
			  nblk = ((str.length + 8) >> 6) + 1;
			  blks = new Array(nblk * 16);
			  for(i = 0; i < nblk * 16; i++) blks[i] = 0;
			  for(i = 0; i < str.length; i++)
				blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
			  blks[i >> 2] |= 0x80 << ((i % 4) * 8);
			  blks[nblk * 16 - 2] = str.length * 8;
			  return blks;
			}

			/*
			 * Add integers, wrapping at 2^32. This uses 16-bit operations internally 
			 * to work around bugs in some JS interpreters.
			 */
			function add(x, y)
			{
			  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
			  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
			  return (msw << 16) | (lsw & 0xFFFF);
			}

			/*
			 * Bitwise rotate a 32-bit number to the left
			 */
			function rol(num, cnt)
			{
			  return (num << cnt) | (num >>> (32 - cnt));
			}

			/*
			 * These functions implement the basic operation for each round of the
			 * algorithm.
			 */
			function cmn(q, a, b, x, s, t)
			{
			  return add(rol(add(add(a, q), add(x, t)), s), b);
			}
			function ff(a, b, c, d, x, s, t)
			{
			  return cmn((b & c) | ((~b) & d), a, b, x, s, t);
			}
			function gg(a, b, c, d, x, s, t)
			{
			  return cmn((b & d) | (c & (~d)), a, b, x, s, t);
			}
			function hh(a, b, c, d, x, s, t)
			{
			  return cmn(b ^ c ^ d, a, b, x, s, t);
			}
			function ii(a, b, c, d, x, s, t)
			{
			  return cmn(c ^ (b | (~d)), a, b, x, s, t);
			}

			/*
			 * Take a string and return the hex representation of its MD5.
			 */
			function calcMD5(str)
			{
			  x = str2blks_MD5(str);
			  a =  1732584193;
			  b = -271733879;
			  c = -1732584194;
			  d =  271733878;

			  for(i = 0; i < x.length; i += 16)
			  {
				olda = a;
				oldb = b;
				oldc = c;
				oldd = d;

				a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
				d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
				c = ff(c, d, a, b, x[i+ 2], 17,  606105819);
				b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
				a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
				d = ff(d, a, b, c, x[i+ 5], 12,  1200080426);
				c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
				b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
				a = ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
				d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
				c = ff(c, d, a, b, x[i+10], 17, -42063);
				b = ff(b, c, d, a, x[i+11], 22, -1990404162);
				a = ff(a, b, c, d, x[i+12], 7 ,  1804603682);
				d = ff(d, a, b, c, x[i+13], 12, -40341101);
				c = ff(c, d, a, b, x[i+14], 17, -1502002290);
				b = ff(b, c, d, a, x[i+15], 22,  1236535329);    

				a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
				d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
				c = gg(c, d, a, b, x[i+11], 14,  643717713);
				b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
				a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
				d = gg(d, a, b, c, x[i+10], 9 ,  38016083);
				c = gg(c, d, a, b, x[i+15], 14, -660478335);
				b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
				a = gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
				d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
				c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
				b = gg(b, c, d, a, x[i+ 8], 20,  1163531501);
				a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
				d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
				c = gg(c, d, a, b, x[i+ 7], 14,  1735328473);
				b = gg(b, c, d, a, x[i+12], 20, -1926607734);
				
				a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
				d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
				c = hh(c, d, a, b, x[i+11], 16,  1839030562);
				b = hh(b, c, d, a, x[i+14], 23, -35309556);
				a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
				d = hh(d, a, b, c, x[i+ 4], 11,  1272893353);
				c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
				b = hh(b, c, d, a, x[i+10], 23, -1094730640);
				a = hh(a, b, c, d, x[i+13], 4 ,  681279174);
				d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
				c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
				b = hh(b, c, d, a, x[i+ 6], 23,  76029189);
				a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
				d = hh(d, a, b, c, x[i+12], 11, -421815835);
				c = hh(c, d, a, b, x[i+15], 16,  530742520);
				b = hh(b, c, d, a, x[i+ 2], 23, -995338651);

				a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
				d = ii(d, a, b, c, x[i+ 7], 10,  1126891415);
				c = ii(c, d, a, b, x[i+14], 15, -1416354905);
				b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
				a = ii(a, b, c, d, x[i+12], 6 ,  1700485571);
				d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
				c = ii(c, d, a, b, x[i+10], 15, -1051523);
				b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
				a = ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
				d = ii(d, a, b, c, x[i+15], 10, -30611744);
				c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
				b = ii(b, c, d, a, x[i+13], 21,  1309151649);
				a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
				d = ii(d, a, b, c, x[i+11], 10, -1120210379);
				c = ii(c, d, a, b, x[i+ 2], 15,  718787259);
				b = ii(b, c, d, a, x[i+ 9], 21, -343485551);

				a = add(a, olda);
				b = add(b, oldb);
				c = add(c, oldc);
				d = add(d, oldd);
			  }
			  return rhex(a) + rhex(b) + rhex(c) + rhex(d);
			}
//****************************** MD5 HASHING END **************************************************//

			
		</script>
	<form name="ssoForm" id="ssoForm">
		<table id="showhideTable" class="main_table" align="center" border="0" cellspacing="0" cellpadding="2">
			<tr id="dont touch">
				<td class="title" width="200px"><p>Parameter</p></td>
				<td class="title" width="40%"><p>Description</p></td>
				<td class="title"><p>Value</p></td>
				<td class="title"><p>Reset Field</p></td>
			</tr>
			<tr id="dont touch" class="required">
				<td class="main_row"><p>rcopia_portal_system_name</p></td>
				<td class="main_row"><p>System Name = Vendor Name of practice</p></td>
				<td class="main_row"><p>
						<input id="rcopia_portal_system_name" name="rcopia_portal_system_name" size="30" value="pvendornxunw">
					</p></td>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_portal_system_name').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch">
				<td class="main_row"><p>rcopia_practice_user_name</p></td>
				<td class="main_row"><p>Practice username</p></td>
				<td class="main_row"><p>
						<input id="rcopia_practice_user_name" name="rcopia_practice_user_name" size="30" value="so95104">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_practice_user_name').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch" class="required">
				<td class="main_row"><p>rcopia_user_id</p></td>
				<td class="main_row"><p>Rcopia Username for current user. At least this field or External Username is mandatory</p></td>
				<td class="main_row"><p>
						<input id="rcopia_user_id" name="rcopia_user_id" size="30" value="pproviderynftve">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_user_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch" class="required">
				<td class="main_row"><p>rcopia_user_external_id</p></td>
				<td class="main_row"><p>External Username for current user. At least this field or External Username is mandatory</p></td>
				<td class="main_row"><p>
						<input id="rcopia_user_external_id" name="rcopia_user_external_id" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_user_external_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr   id="dont touch" class="required">
				<td class="main_row"><p>service</p></td>
				<td class="main_row"><p>Rcopia Application Services (rcopia, rcopia_mini or rcopia_ac)</p></td>
				<td class="main_row"><p>
						<select id="service" name="service">
							<option value="rcopia" selected="selected">rcopia</option>
							<option value="rcopia_mini">rcopia_mini</option>
							<option value="rcopia_ac">rcopia_ac</option>
						</select>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('service').value='rcopia';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr   id="dont touch" class="required">
				<td class="main_row"><p>action</p></td>
				<td class="main_row"><p>Should be set to "login".</p></td>
				<td class="main_row"><p>
						<input id="action" name="action" size="30" value="login" readonly>
				<td class="main_row"><p> </p></td>
			</tr>
			
			<tr id="dont touch">
				<td class="main_row"><p>startup_screen</p></td>
				<td class="main_row"><p>The Rcopia screen that should be opened upon launch.</p></td>
				<td class="main_row"><p>
						<select id="startup_screen" name="startup_screen">
							<option value="patient" selected="selected">patient</option>
							<option value="manage_medications">manage_medications</option>
							<option value="manage_allergies">manage_allergies</option>
							<option value="manage_problems">manage_problems</option>
							<option value="report">report</option>
							<option value="message">message</option>
							<option value="schedule">schedule</option>
							<option value="summary">summary</option>
							<option value="summary_read_only">summary_read_only</option>
						</select>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('startup_screen').value='patient';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch">
				<td class="main_row"><p>rcopia_patient_id</p></td>
				<td class="main_row"><p>Identifies the patient chart to open in Rcopia.<br>
						<strong>Note:</strong> Either the RcopiaID OR a combination of rcopia_patient_system_name and rcopia_patient_external_id should be provided to launch Rcopia in patient context. </p></td>
				<td class="main_row"><p>
						<input id="rcopia_patient_id" name="rcopia_patient_id" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_patient_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch">
				<td class="main_row"><p>rcopia_patient_system_name</p></td>
				<td class="main_row"><p>Set to
						<SystemName>
						sent in upload request</p></td>
				<td class="main_row"><p>
						<input id="rcopia_patient_system_name" name="rcopia_patient_system_name" size="30" value="pvendornxunw">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_patient_system_name').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch">
				<td class="main_row"><p>rcopia_patient_external_id</p></td>
				<td class="main_row"><p>Identifies the patient to the portal with the patient's id in the EMR. Must have been previously provided to DrFirst as part of a patient upload</p></td>
				<td class="main_row"><p>
						<input id="rcopia_patient_external_id" name="rcopia_patient_external_id" size="30" value="test1234">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_patient_external_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>

			<tr id="dont touch" class="required">
				<td class="main_row"><p>time</p></td>
				<td class="main_row"><p>Timestamp of submission of the SSO request. The value should have the format "MMDDYYHHMMSS" for the GMT time zone. (cf. fTime() for more details)</p></td>
				<td class="main_row"><p>Must be auto generated
						<input type="hidden" id="time" name="time" size="30" value="fTime();">
					</p></td>
				<td class="main_row"><p> </p></td>
			</tr>
			<tr id="dont touch" class="required">
				<td class="main_row"><p>MAC</p></td>
				<td class="main_row"><p>The MAC is an MD5 hash of [parameter string] + [secret key]</p></td>
				<td class="main_row"><p>Will be auto generated </p></td>
				<td class="main_row"><p> </p></td>
			</tr>
			<tr id="dont touch" class="required">
				<td class="main_row"><p>secret_key</p></td>
				<td class="main_row"><p>Secret Key = Vendor Password. <br>
						Used only to generate the MAC. <strong>NEVER</strong> include in the SSO request</p></td>
				<td class="main_row"><p>
						<input id="secret_key" name="secret_key" size="30" value="wiaofoh3" type="password" onmouseover="ShowPSW(this)" onmouseout="HidePSW(this)">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('secret_key').value='';" value="Reset Field"/>
					</p></td>
			</tr>

			<tr id="dont touch">
					
				<td class="main_row" colspan="5" style="text-align:center">
					<input class="button" id="ShowHide" type="button" onClick="ShowHideTR('showhideTable');" value="Show Addional SSO Options" title="Show/Hide Additional Options" />
				</td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>close_window</p></td>
				<td class="main_row"><p>Flag to indicate whether the Rcopia window should be closed on log out. Defaults to "y"</p></td>
				<td class="main_row"><p>
						<label>
							<input type="radio" id="close_window" name="close_window" value="y"/>
							y</label>
						<label>
							<input type="radio" id="close_window1" name="close_window" value="n" />
							n</label>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('close_window').checked = false; document.getElementById('close_window1').checked = false;" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>logout_url</p></td>
				<td class="main_row"><p>The URL to redirect to when user clicks on Logout within Rcopia</p></td>
				<td class="main_row"><p>
						<input id="logout_url" name="logout_url" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('logout_url').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>allow_popup_screens</p></td>
				<td class="main_row"><p>"y" to allow popup screens, "n" to use inline screens within Rcopia. Defaults to "y"</p></td>
				<td class="main_row"><p>
						<label>
							<input type="radio" id= "allow_popup_screens" name="allow_popup_screens" value="y"/>
							y </label>
						<label>
							<input type="radio" id= "allow_popup_screens1" name="allow_popup_screens" value="n" />
							n </label>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('allow_popup_screens').checked = false; document.getElementById('allow_popup_screens1').checked = false;" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>override_single_patient</p></td>
				<td class="main_row"><p>Used only in Single Patient Mode to override SPM settings. Defaults to "n". </p></td>
				<td class="main_row"><p>
						<label>
							<input type="radio" id="override_single_patient" name="override_single_patient" value="y"/>
							y </label>
						<label>
							<input type="radio" id="override_single_patient1" name="override_single_patient" value="n" />
							n </label>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('override_single_patient').checked = false; document.getElementById('override_single_patient1').checked = false;" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
					
				<td class="main_row"><p>limp_mode</p></td>
				<td class="main_row"><p>Used to launch Rcopia in Limited Multi-Patient (LIMP) Mode. Applicable only for Single Patient Mode practices.<br>
						LIMP mode should only be set to "y" when startup_screen is "message" or "report". </p></td>
				<td class="main_row"><p>
						<label>
							<input type="radio" id="limp_mode" name="limp_mode" value="y"/>
							y </label>
						<label>
							<input type="radio" id="limp_mode1" name="limp_mode" value="n" />
							n </label>
					</p>
						<td class="main_row"><p>
								<input type="button" class="reset" onClick="document.getElementById('limp_mode').checked = false; document.getElementById('limp_mode1').checked = false;" value="Reset Field"/>
							</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>contact_email</p></td>
				<td class="main_row"><p>Overrides the private label email value for that session only.</p></td>
				<td class="main_row"><p>
						<input id="contact_email" name="contact_email" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('contact_email').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>timeout_url</p></td>
				<td class="main_row"><p>URL to redirect the Rcopia session to upon expiration due to inactivity.</p></td>
				<td class="main_row"><p>
						<input id="timeout_url" name="timeout_url" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('timeout_url').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>encounter_id</p></td>
				<td class="main_row"><p>Identifies the EMR's encounter id for that particular session. The value will be associated with records modified during that session.</p></td>
				<td class="main_row"><p>
						<input id="encounter_id" name="encounter_id" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('encounter_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>location_external_id</p></td>
				<td class="main_row"><p>Identifies the location/group within an enterprise practice to use as default for that session (value can be associated with a group during practice setup).</p></td>
				<td class="main_row"><p>
						<input id="location_external_id" name="location_external_id" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('location_external_id').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>rcopia_id_access_list</p></td>
				<td class="main_row"><p>Send comma separated provider Rcopia username(s) to restrict the user dropdown list for various Rcopia sections.<br>
						<strong>Note:</strong> Available in Single Patient Mode only. </p></td>
				<td class="main_row"><p>
						<input id="rcopia_id_access_list" name="rcopia_id_access_list" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('rcopia_id_access_list').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>external_id_access_list</p></td>
				<td class="main_row"><p>Send comma separated provider External username(s)  to restrict the user dropdown list for various Rcopia sections. <br>
						<strong>Note:</strong> Available in Single Patient Mode only.  
						.</p></td>
				<td class="main_row"><p>
						<input id="external_id_access_list" name="external_id_access_list" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('external_id_access_list').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>navigation_privilege</p></td>
				<td class="main_row"><p>Restrict navigation outside of current practice or location/group (current_location, practice_location, or any_practice) </p></td>
				<td class="main_row"><p>
						<input id="navigation_privilege" name="navigation_privilege" size="30" value="">
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('navigation_privilege').value='';" value="Reset Field"/>
					</p></td>
			</tr>
			<tr  style="display:none">
				<td class="main_row"><p>skip_auth</p></td>
				<td class="main_row"><p>When "y", the MAC is not used to authenticate the request on the server. <br>
						<strong>Note:</strong> Skipping authentication is available only on the cert server, never in production. </p></td>
				<td class="main_row"><p>
						<label>
							<input type="radio" id="skip_auth" name="skip_auth" value="y"/>
							y </label>
						<label>
							<input type="radio" id="skip_auth1" name="skip_auth" checked="yes" value="n" />
							n </label>
				<td class="main_row"><p>
						<input type="button" class="reset" onClick="document.getElementById('skip_auth').checked = false; document.getElementById('skip_auth1').checked = false;" value="Reset Field"/>
					</p></td>
			</tr>
			<tr id="dont touch">
					
				<td class="main_row" colspan="5" style="text-align:center">
					<input class="button" id="generate_MAC" type="button" value="Show Me How" onClick="generateMAC()" title="See Step by Step Process of URL Generation" />
					<input class="button" id="launch_rcopia" type="button" value="Launch Rcopia" title="Launch Rcopia" onclick="launchRcopia('https://web201.staging.drfirst.com/sso/portalServices?')" />

					<input class="button" id="reset" type="reset" value="Default Form" title="Reset entire form" />
				</td>
			</tr>

			</table>
	</form>
			<div id="param_url" class="MAC"></div>
			<div id="append_key" class="MAC"></div>
			<div id="MAC" class="MAC"></div>
			<div id="append_MAC" class="MAC"></div>
			<div id="final_url" class="MAC"></div>
		</div>














