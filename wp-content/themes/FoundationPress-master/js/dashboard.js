function push_notification(){
	var user_id = $("#user_id").val();
	$.ajax({
		type: "POST",
		data: "user_id="+user_id,
		url: "wp-content/themes/FoundationPress-master/dashboard/push_notifications.php",
		success: function(success)	{
			//console.log(success);
			if($.isNumeric(success))	{
				if(success > 0)	{
					$(".dashboard_icons .unread_ctn, .unread_span").fadeIn();
					$(".unread_ctn").html(success).delay(10000);
					//push_notification();
				} else {
					$(".dashboard_icons .unread_ctn").hide();
					$(".unread_span").hide();
				}
			}
		},
		error: function(error)	{
			console.log(error);
		}
	});
}
function user_dashboard()	{
	$("#dashboard").empty().hide();
	var user_id = $("#user_id").val();
	var patient_id = $("#patient_id").val();
	$.ajax({
		type: 'post',
		data: 'id='+ user_id+'&patient_id='+patient_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/user_dashboard.php',
		success: function(success)	{
			$("#dashboard").html(success).fadeIn();			
			$(".doctor_dash").addClass('dashboard_icons_disabled');
			push_notification();
			$(".dashboard_small_widget_lip").click(function()	{
				var function_name = $(this).attr('id');
				$(".doctor_dash").removeClass('dashboard_icons_disabled');
				$("#dashboard").empty().hide();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success).fadeIn();
						message();
						new_message();						
						$(".goback img").click(function()	{
							user_dashboard();
						});					
						$(".add_entry").click(function()	{
							var this_table = $(this).closest('table').attr('id');
							console.log(this_table);
							if(this_table == "family_conditions")	{
								$("#"+this_table+" tr:last-child").before("<tr><td><input type='text' name='new_family_condition'></td><td><select><option>Father</option><option>Mother</option><option>Sibling</option></select></td><td><div class='save'>Save</div></td></tr>");
							}
							else if(this_table == "family_history")	{
								$("#"+this_table+" tr:last-child").before("<tr><td><select name='family_member'><option value='Father'>Father</option><option value='Mother'>Mother</option><option value='Sibling'>Sibling</option></select></td><td><select name='alive'><option value='1'>Living: Yes</option><option value='2'>Living: No</option></select></td><td><input name='age' type='number'></td><td><div class='save'>Save</div></td></tr>");
							}
							$(".save").click(function()	{
								var data = [];
								var xx = 0;
								var ii = 0;
								var yy = 0;
								var tdCount = $("#"+this_table).children('tr:nth-child(2) :input').length;
								$("#"+this_table+" tr").each(function()	{
									var subarray = [];
									if(xx > tdCount)	{
										data.push(subarray);
										xx = 0;
									} else {
										var tableInputs = $(this).find(':input').val();
										subarray.push(tableInputs);
										xx++;
									}
								});
								console.log(tdCount);
							});
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});	
			$(".dashboard_large_widget_lip").click(function()	{
				var function_name = $(this).attr('id');
				$(".doctor_dash").removeClass('dashboard_icons_disabled');
				$("#dashboard").empty().hide();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success).fadeIn();
						$(".goback img").click(function()	{
							user_dashboard();
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});
			$(".goals_button").click(function()	{
				var function_name = $(this).attr('id');
				$("#dashboard").empty().hide();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
					success: function(success)	{
						$("#dashboard").html(success).fadeIn();
						$(".goback img").click(function()	{
							user_dashboard();
						});						
					},
					error: function(error)	{
						console.log(error);
					}
				}); 
			});
			$(".search_patients_lg").click(function()	{
			
				if($(".patient_results").html() == '')	{
					patient_list();
				}
				$(".left_widget").animate({
					width: "250px"
				},200);
				$(".search_box").delay(200).fadeIn('slow');	
				$(".close_search").delay(200).fadeIn('slow');
			});
			schedule_date();
		},
		error: function(error)	{
			console.log(error);
		}
	}); 
}
function message()	{
	$('.message').click(function()	{
		var messageId = $(this).attr('id');
		var patient_id = $("#patient_id").val();
		$.ajax({
			type: 'POST',
			data: 'message_id='+messageId,
			url: 'wp-content/themes/FoundationPress-master/dashboard/message.php',
			success: function(success)	{
				push_notification();
				$("#dashboard").html(success).fadeIn();
				$(".message_go_back").click(function()	{
					$("#dashboard").empty().hide();
					var user_id = $("#user_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id+'&patient_id='+patient_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/communications.php',
						success: function(success)	{
							$("#dashboard").html(success).fadeIn();
							message();
							new_message();
							$(".goback img").click(function()	{
								user_dashboard();
							});									
						},
						error: function(error)	{
							console.log(error);
						}
					});
				});
				$('.message_reply').click(function()	{
					createMessage();
				});
			},
			error: function(error)	{
				console.log(error);
			}
		});
	});
}
function new_message()	{
	$('.new_message').click(function()	{
		createMessage();
		
	});
}
function createMessage()	{
	var messageId = $("#message_id").val();
	var user_id = $("#user_id").val();
	var patient_id = $("#patient_id").val();
	$.ajax({
		type: 'POST',
		data: 'message_id='+messageId+'&id='+user_id+'&patient_id='+patient_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/new_message.php',
		success: function(success)	{
			$("#dashboard").html(success).fadeIn();
			message();
			$(".message_send").click(function()	{
				var message_to = $("#message_to").val();
				if($("#message_to").val() == '' || $("#message_to").val() == '0' || $("#message_to").val() == 0 || $("#message_text").val() == '' || $("#subject").val() == '')	{
					$(".message_error").show().html(' Please fill out all of the fields before sending your message.').delay(5000).fadeOut();
					return false;
				} else {	
					sendMessage();
					message();
				}
			});	
			$(".cancel_message").click(function()	{
				$("#dashboard").empty().hide();
				var user_id = $("#user_id").val();
				var patient_id = $("#patient_id").val();				
				$.ajax({
					type: 'post',
					data: 'id='+ user_id+'&patient_id='+patient_id,
					url: 'wp-content/themes/FoundationPress-master/dashboard/communications.php',
					success: function(success)	{
						$("#dashboard").html(success).fadeIn();
						message();
						new_message();
						$(".goback img").click(function()	{
							user_dashboard();
						});								
					},
					error: function(error)	{
						console.log(error);
					}
				});
			});
		},
		error: function(error)	{
			console.log(error);
		}
	});
}
function sendMessage()	{
	var message_to = $("#message_to").val();
	var subject = $("#subject").val();
	var message_send = $("#message_text").val();
	var send_date = $("#send_date").val();
	var user_id = $("#user_id").val();
	var patient_id = $("#patient_id").val();
	$.ajax({
		type: 'POST',
		data: 'message_to='+message_to+'&subject='+subject+'&message='+message_send+'&send_date='+send_date+'&user_id='+user_id+'&patient_id='+patient_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/send_email.php',
		success: function(success)	{
			push_notification();
			$("#dashboard").empty().hide();
			var user_id = $("#user_id").val();
			var patient_id = $("#patient_id").val();
			$.ajax({
				type: 'post',
				data: 'id='+ user_id+'&patient_id='+patient_id,
				url: 'wp-content/themes/FoundationPress-master/dashboard/communications.php',
				success: function(success)	{
					$("#dashboard").html(success).fadeIn();
					new_message();
					message();
				},
				error: function(error)	{
					console.log(error);
				}
			});
		},
		error: function(error)	{
			console.log(error);
		}
	});
}
function patient_list()	{
	var doctor_id = $("#user_id").val();
	$.ajax({
		type: 'POST',
		data: 'id='+doctor_id,
		url: 'wp-content/themes/FoundationPress-master/dashboard/patient_list.php',
		success: function(success)	{
			$(".patient_results").html(success);
			$('#patient_input').fastLiveFilter('#patients');
			$(".patient").click(function()	{
				$(".exit-off-canvas").trigger("click");
				$("#dashboard").empty().hide();
				$.ajax({
					type: 'post',
					data: 'id',
					url: 'wp-content/themes/FoundationPress-master/dashboard/patient.php',
					success: function(success) {
						$(".search_box").fadeOut();
						$(".close_search").fadeOut();
						$(".left_widget").delay(200).animate({
							width: "75px"
						},200);
						$("#dashboard").html(success).delay(200).fadeIn();
						$(".doctor_dash").removeClass('dashboard_icons_disabled');
						//$("#soap_notes").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
						//$("#meds").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
						$(".doctor_dash").click(function()	{
							$("#patient_id").val('');
							$("#soap_notes").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
							$("#meds").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
							user_dashboard();
						});			
					},
					error: function(error)	{
						console.log(error);
					}
				});
				dashboard_icons();
			});
		},
		error: function(error)	{
			console.log(error);
		}
	});
}
//function patient_list()	{
//	var doctor_id = $("#user_id").val();
//	$.ajax({
//		type: 'POST',
//		data: 'id='+doctor_id,
//		url: 'wp-content/themes/FoundationPress-master/dashboard/patient_list.php',
//		success: function(success)	{
//			$(".patient_results").html(success);
//			$('#patient_input').fastLiveFilter('#patients');
//			$(".patient").click(function()	{
//				var patient = $(this).attr('id');
//				$("#patient_id").val(patient);
//				user_dashboard();
//				$(".search_box").fadeOut();
//				$(".close_search").fadeOut();
//				$(".left_widget").delay(200).animate({
//					width: "75px"
//				},200);	
//				$("#soap_notes").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
//				$("#meds").removeClass('dashboard_icons_disabled').addClass('dashboard_icons');
//				$(".doctor_dash").click(function()	{
//					$("#patient_id").val('');
//					$("#soap_notes").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
//					$("#meds").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
//					user_dashboard();
//				});				
//				dashboard_icons();
//			});
//		},
//		error: function(error)	{
//			console.log(error);
//		}
//	});
//}
function schedule_date() {
	var monthNames = [ "January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December" ];
	var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
	
	var newDate = new Date();
	newDate.setDate(newDate.getDate());
	$('.schedule_month').html(monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
	$('.schedule_day').html(dayNames[newDate.getDay()]);
	$('.schedule_day_no').html(newDate.getDate());
}
function count_unread() {
	var unreadctn = $('.message_overview_unread').length;
	$('.unread_ctn').html(unreadctn);
}

$(document).ready(function() {

/******************* Dashboard *******************************/

$(".search_patients").click(function()	{

	if($(".patient_results").html() == '')	{
		patient_list();
	}
	$(".left_widget").animate({
		width: "250px"
	},200);
	$(".search_box").delay(200).fadeIn('slow');	
	$(".close_search").delay(200).fadeIn('slow');
});
$(".close_search").click(function()	{
	$(".search_box").fadeOut();
	$(".close_search").fadeOut();
	$(".left_widget").delay(200).animate({
		width: "75px",
	},200);		

});
$(".doctor_dash").click(function()	{
	$("#patient_id").val('');
	$("#soap_notes").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
	$("#meds").removeClass('dashboard_icons').addClass('dashboard_icons_disabled');
	user_dashboard();
});
$("#clear_search").click(function()	{
	$("#patient_input").val('');
	patient_list();
});
$(window).scroll(function(){
	if ($(this).scrollTop() > 100) {
		$('.btnToTop').fadeIn();
	} else {
		$('.btnToTop').fadeOut();
	}
});
$('.btnToTop').click(function(){
	$('html, body').animate({scrollTop : 0},700);
	return false;
});
/*************************** Functions *******************************************/
function drFirst()	{
	var user_id = $("#user_id").val();
	var patient_id = $("#patient_id").val();
	var win_width = $(window).width();
	var doc_height = $(document).height();
	var win_height = $(window).height();
	var body_left = $(".dashboard_container").width();
	var margin = (win_width - body_left);
	var topMargin = $(".center-dashboard").offset();
	$(".overlay").css({
		"width": win_width,
		"height": doc_height,
		"left":  - margin/2,
		"top": - topMargin.top
	});
	
// DR FIRST CODE 
	var HideShow = "Hide";
	//show hide pswd on Mouseover
	function ShowPSW(o){
		o.type = "text";
	}
	function HidePSW(o){
		o.type = "password";
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
	function generateMAC()	{
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
		return final_param_url;
	}			
	
	//Generate the string necessary to create the MAC
	function generateURL(params) {
	//	console.log(params);
		var parameter_url;
		$.each(params, function(index,value)	{
			if($("input[name='"+this+"']").val() != '')	{
				var paramID = $("#"+this).attr("name");
				var paramValue = $("#"+this).val();
			//	console.log(paramID + "=" + paramValue);
				if (!parameter_url) {
					parameter_url = paramID + "=" + paramValue;
				} else if (paramID.type == 'radio') { // If SSO parameter is a radio button
					if(paramID.is("checked"))	{
						parameter_url = parameter_url + "&" + paramID + "=" + paramValue;
					}
				} else if (paramID == 'time') { // If SSO parameter is the time variable
					parameter_url = parameter_url + "&" + paramID + "=" + fTime(); //Call function fTime() to generate current GMT
				} else { // For all regular textboxes and dropdowns
					parameter_url = parameter_url + "&" + paramID + "=" + paramValue;
				}				
			}
			
		});
		//console.log(parameter_url);
/*		for (i = 0; i < params.length; i++) {
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
				} else { // For all regular textboxes and dropdowns
					parameter_url = parameter_url + "&" + params[i] + "=" + document.getElementById(params[i]).value;
				}
			}
				
		}*/
	  return parameter_url;
	}

	//Generate the string necessary to create the MAC
/*	function generateURL(params) {
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
				} else { // For all regular textboxes and dropdowns
					parameter_url = parameter_url + "&" + params[i] + "=" + document.getElementById(params[i]).value;
				}
			}
			
		}
	  return parameter_url;
	}*/
		
	// Function for Launch Rcopia button
	function launchRcopia(url)
	{
		final_param_url = generateMAC(); // Capture final URL string by calling the generateMAC() function
		var oURL = url; // Append final string to URL specified in function call 
		oURL = oURL + final_param_url;
		//var leftpos = (screen.width-800)/2;
		//var toppos = (screen.height-600)/2;
		return oURL;
		//window.open(oURL,'myWin','toolbar,status,resizable,scrollbars,width=800,height=600, top='+toppos+', left='+leftpos);
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
			var drfirstURL = launchRcopia('https://web201.staging.drfirst.com/sso/portalServices?');
		//	console.log(drfirstURL);
			$("#drfirst").prop("src", drfirstURL);
			$(".overlay").fadeIn();

			var sourceHeight = $('#drfirst').contents().height();
			$("#drfirst").fadeIn();
			$("#drfirst").css({
				"max-height": "100%",
				"height": doc_height
			});
}
function dashboard_icons()	{
	$(".dashboard_icons").click(function()	{
		push_notification();
		var function_name = $(this).attr('id');
		$("#dashboard").empty().hide();
		var user_id = $("#user_id").val();
		var patient_id = $("#patient_id").val();
		$(".doctor_dash").removeClass('dashboard_icons_disabled');
		$.ajax({
			type: 'post',
			data: 'id='+ user_id+'&patient_id='+patient_id,
			url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
			success: function(success)	{
				$("#dashboard").html(success).fadeIn();
				push_notification();
				$(".goback img").click(function()	{
					user_dashboard();
				});	
				message();
				new_message();
				$("#drfirst_launch").click(function()	{
					//alert("launch");
					drFirst();
				});				
				$(".dashboard_small_widget_lip").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty().hide();
					var user_id = $("#user_id").val();
					var patient_id = $("#patient_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id+'&patient_id='+patient_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success).fadeIn();
							message();
							new_message();		
							push_notification();
							$(".goback img").click(function()	{
								user_dashboard();
							});
							$(".add_entry_family_condition").click(function()	{
								$(".family_conditions tr:last-child").before("<tr><td><input type='text' name='new_family_condition'></td><td></td></tr>");
							});
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});	
				$(".dashboard_large_widget_lip").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty().hide();
					var user_id = $("#user_id").val();
					var patient_id = $("#patient_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id+'&patient_id='+patient_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success).fadeIn();
							$(".goback img").click(function()	{
								user_dashboard();
							});
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});		
				$(".goals_button").click(function()	{
					var function_name = $(this).attr('id');
					$("#dashboard").empty().hide();
					var user_id = $("#user_id").val();
					$.ajax({
						type: 'post',
						data: 'id='+ user_id,
						url: 'wp-content/themes/FoundationPress-master/dashboard/'+function_name+'.php',
						success: function(success)	{
							$("#dashboard").html(success).fadeIn();
							$(".goback img").click(function()	{
								user_dashboard();
							});						
						},
						error: function(error)	{
							console.log(error);
						}
					}); 
				});	

			},
			error: function(error)	{
				console.log(error);
			}
		}); 
	});	
}


/********************* INIT ***************************************/
	user_dashboard();
	dashboard_icons();
});

