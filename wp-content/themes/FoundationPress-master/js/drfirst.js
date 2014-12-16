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