<?php

include '../dashboard/db_include.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$ssn = $_POST['ssn'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// $userdata = array(
//    'user_login'	=>  $username,
//    'user_pass'		=>  $password,
//	'user_email'	=>	$email,
//	'first_name'	=>	$fname,
//	'last_name'		=>	$lname,
//);

//wp_insert_user( $userdata ) ;

$html = '';
$html .= '<div id="address_validated">';
if($_POST['street'] && $_POST['city'] && $_POST['state'] && $_POST['zip'])	{
	$html .= "<input type='hidden' value='".$_POST['street']."' id='street_verified'>";
	$html .= "<input type='hidden' value='".$_POST['city']."' id='city_verified'>";
	$html .= "<input type='hidden' value='".$_POST['state']."' id='state_verified'>";
	$html .= "<input type='hidden' value='".$_POST['zip']."' id='zip_verified'>";
	$html .= '<div id="results">';
	$html .= '<input type="hidden" id="valid_address" />';
	$html .= '<input type="hidden" id="type" />';
	$html .= '<input type="hidden" id="result" />';
	$html .= '<input type="hidden" id="lat" />';
	$html .= '<input type="hidden" id="long" />';
	$html .= '</div>';
	$html .= '</div>';

	$state = $_POST['state'];
	$html .= '<div class="enroll_doctor_list">';

	$html .= '<h1 id="scroll_to_doctors" style="width: 100%; text-align: center; margin-bottom: 5px;">Pick your doctor</h1><div style="display: inline-block; width: 100%; text-align: center; font-family: adellelight; font-size: 15px;">Click on the location icon to select your doctor.</div>';
	$html .= '<ul>';
	$doctors = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practice as p INNER JOIN ".$wpdb->prefix. "doctors as d ON d.practice_id=p.practice_id WHERE p.state='$state' AND d.new_patients='1'");
	foreach($doctors as $doctor)	{
		$html .= '<li class="doctor" data="'.$doctor->practice_id.'" id="'.$doctor->user_id.'"><input type="radio" id="doc-'.$doctor->user_id.'" name="doctors" value="'.$doctor->user_id.'"><label for="doc-'.$doctor->user_id.'">';
		$html .= '<div>Doctor '.$doctor->fname.' '.$doctor->lname.'<input type="hidden" id="doctor_name_'.$doctor->user_id.'" value="'.$doctor->fname.' '.$doctor->lname.'"></div>';
		$html .= '</label></li>';
	}
	$practices = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practice WHERE state='$state'");

	$html .= '</ul>';
	$html .= '</div>';
	
?>



<script>

function scrollToAnchor(aid){
	var aTag = $("#"+ aid +"");
	var wWidth = $(window).width();
	var wHeight = $(window).height();
	topMargin = wHeight/2 - aTag.height()/2;
	$('html,body').animate({scrollTop: aTag.offset().top - topMargin},'slow');
}

var geocoder, map, marker;
var defaultLatLng = new google.maps.LatLng(30,0);

function initialize() {
	geocoder = new google.maps.Geocoder();
	var mapOptions = {
		zoom: 15,
		center: defaultLatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(
		document.getElementById("map_canvas"),
		mapOptions
	);
	var patientText = "<div style='font-family: adelleregular; font-size: 14px;padding: 10px 10px 10px 15px;'>You</div>";
	var patient_info = new google.maps.InfoWindow({
		content: patientText
	});		
	PatientMarker = new google.maps.Marker({
		id: "patient",
		type: "patient",
		icon: 'images/pat_marker.png',
		infowindow: patient_info
	});
	patient_info.open(map, PatientMarker);
}	
initialize();  

$('html,body').animate({scrollTop: '0px'},'slow');
	function validate() {
		var street = $('#street_verified').val();
		var city = $('#city_verified').val();
		var state = $('#state_verified').val();
		var zip = $('#zip_verified').val();
		
		var address = street+" ,"+city+", "+state+" "+zip;
		
		geocoder.geocode({'address': address }, function(results, status) 
		{
			switch(status) 
			{
				case google.maps.GeocoderStatus.OK:
				document.getElementById('valid_address').value = 'YES';
				document.getElementById('type').value = results[0].types[0];
				var addressType = results[0].types[0];
				document.getElementById('result').value = results[0].formatted_address;
				mapAddress(results[0]);
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				document.getElementById('lat').value = latitude;
				document.getElementById('long').value = longitude;
				break;
				
				case google.maps.GeocoderStatus.ZERO_RESULTS:
				document.getElementById('valid_address').value = 'NO';
				break;
				
				default:
				console.log("An error occured while validating this address")
			}
		});
	}
	
	function markerLookup(marker)	{
		google.maps.event.addListener(marker, 'click', function() {
			$("#form_three").slideUp();
			$(".calculate_costs").hide();
			$('#map_canvas').animate({
				height: "550px"
			},200);					
			$('.header_image').animate({
				height: "0px"
			}, 200);
			$('.row_container').animate({
				marginTop: "0px"
			}, 200);				
			$("#map_canvas").show();
			$('.header_map').animate({
				height: "550px",
				maxHeight: "550px"
			},200);				
			$("#form_two").delay(1000).slideDown();
			map.setZoom(15);
			map.setCenter(marker.getPosition());
			var doctorID = this.get("id");
			var practiceID = this.get("type");
			$(".doctor input[name='doctors']").prop('checked',false);
			if(doctorID == "patient" || practiceID == "patient")	{
				//console.log("This is the patient location.");
				$(".doctor").hide();
				$(".no_doctor").show();
				$(".calculate_costs").hide();
				$("#doctor_selected").html('');
				$(".chosen").hide();				
			} else {
				$(".doctor").each(function()	{
					var practice = $(this).attr('data');
					if(doctorID == practice)	{
						$(this).show();
						$(this).click(function()	{
							var doctorID = $(this).attr('id');
							var doctorName = $("#doctor_name_"+doctorID).val();
							$("#doctor_selected").html("Doctor "+ doctorName);
							$(".chosen").show();
							$(".calculate_costs").show();
							scrollToAnchor('calculate_costs');
						});

						$.ajax({
							type: 'POST',
							data: 'username='+username+'email='+email+'&fname='+fname+'&lname='+lname+'&practice='+practice,
							url: 'wp-content/themes/FoundationPress-master/parts/patient_create.php',
							success: function(success)	{
	
							},
						});

					} else {
						$(this).hide();
						$(".chosen").hide();
					}
				});
				function validateEmail(email) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					return emailReg.test( email );
				}					
				var v = 0;
				$("#add_cost").click(function()	{
					$('.access_table').removeClass('error_hightlight');
					$('#new_dob').removeClass('error_hightlight');
					$('#new_fname').removeClass('error_hightlight');
					$('#new_lname').removeClass('error_hightlight');
					$('#new_email').removeClass('error_hightlight');
					$('#new_username').removeClass('error_hightlight');
					var sex = $("#new_patient_sex").val();
					if(sex == 'M')	{
						var patientSex = "Male";
					} else {
						var patientSex = "Female";
					}
					var dob = $("#new_dob").val();
					if(dob == '')	{
						$('#new_dob').addClass('error_hightlight');
						return false;
					}
					var new_fname = $("#new_fname").val();
					if(new_fname == '')	{
						$('#new_fname').addClass('error_hightlight');
						return false;
					}
					var new_lname = $("#new_lname").val();
					if(new_lname == '')	{
						$('#new_lname').addClass('error_hightlight');
						return false;
					}	
					var new_username = $("#new_username").val();
					var new_email = $("#new_email").val();
					if(new_username == '' || new_username == '<?php echo $username; ?>')	{
						$('#new_username').addClass('error_hightlight');
						return false;
					} else {
						$.ajax({
							type: 'POST',
							data: 'username='+new_username+'&email='+new_email,
							url: 'wp-content/themes/FoundationPress-master/parts/account_registration_check.php',
							success: function(success)	{
								console.log(success);
								if(success == 11)	{


				//	( !validateEmail(new_email) ) ? console.log('no') : console.log('yes'); 
					if(!validateEmail(new_email) || new_email == '')	{
						$('#new_email').addClass('error_hightlight');
						return false;
					}						
					var access = '';
					$(".calculate_costs input[type='radio']").each(function()	{
						if($(this).is(':checked'))	{
							access = $(this).val();
						}
					});
					if(access == "0")	{
						var access_level = "Primary Access";
					} else if(access == "1") {
						var access_level = "Secondary Access";
					} else {
						console.log("No access level selected");
						$('.access_table').addClass('error_hightlight');
						return false;
					}
					
					$.ajax({
						type: 'POST',
						data: 'new_username='+new_username+'&new_email='+new_email+'&new_fname='+new_fname+'&new_lname='+new_lname,
						url: 'wp-content/themes/FoundationPress-master/parts/addcost_user.php',
						success: function(success)	{

						},
					});
					
					$(".calculate_costs table tr:first").before("<tr><td style='padding-top: 15px;'><font style='color: #ccc;'>M/F</font><br>"+patientSex+"<input type='hidden' id='sex["+ v +"]' value='"+sex+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>D.O.B</font><br>"+dob+"<input type='hidden' id='dob["+ v +"]' value='"+dob+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>First Name</font><br>"+new_fname+"<input type='hidden' id='new_fname["+ v +"]' value='"+new_fname+"'></td><td style='padding-top: 15px;'><font style='color: #ccc;'>Last Name</font><br>"+new_lname+"<input type='hidden' id='new_lname["+ v +"]' value='"+new_lname+"'></td></tr><tr><td style='padding-bottom: 15px;'><font style='color: #ccc;'>Username</font><br>"+new_username+"<input type='hidden' id='new_username["+ v +"]' value='"+new_username+"'></td><td colspan='2' style='padding-bottom: 15px;'><font style='color: #ccc;'>Email Address</font><br>"+new_email+"<input id='access["+ v +"]' type='hidden' value='"+new_email+"'></td><td style='padding-bottom: 15px;'><font style='color: #ccc;'>Account Access:</font><br>"+access_level+"<input id='access["+ v +"]' type='hidden' value='"+access+"'></td></tr>");
					
					
					$(".access_table input[name='access']").prop('checked',false);
					$('#new_dob').val('');
					$('#new_fname').val('');
					$('#new_lname').val('');
					$('#new_email').val('');
					$("#new_patient_sex").val('M');
					$("#new_username").val('');	
					v++;
					$(".calculate_costs table tr:first").css('border-top','1px solid #e5e5e5');
								} else {
									$('#new_username').addClass('error_hightlight');
									return false;
								}
								
							},
							error: function(error)	{
								console.log(error);
								return false;
							}
						});
					}					
				});
				$("#calculate_price").click(function()	{
					var dataSet = '';
					var count = 0;				
					$(".more_patients input[type='hidden']").each(function()	{
						var fieldName = $(this).attr('id');
						var fieldValue = $(this).val();
						if(count == 0)	{
							dataSet += fieldName+"="+fieldValue;
						} else {
							dataSet += "&"+fieldName+"="+fieldValue;
						}
						count++;
					});
					$.ajax({
						type: 'POST',
						data: dataSet,
						url: 'wp-content/themes/FoundationPress-master/parts/calculate_cost.php',
						success: function(success)	{
							$("#calculated").html(success);
							scrollToAnchor('calculated');
							$("#go_to_payment").show();
						},
						error: function(error)	{
							console.log(error);
						}
					});
				});				
			}
			this.infowindow.open(map,marker);

		});		
	}
		<?php foreach($practices as $p) { 
			$practice_id = $p->practice_id;
			$ii = 0;
			$doctors_count = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "doctors WHERE practice_id='$practice_id' AND new_patients='1'");
			foreach($doctors_count as $d_count)	{
				$ii++;
			}
			if($ii > 0)	{
			?>
			var mytext = "<div style='font-family: adelleregular; font-size: 14px; max-height:100px;max-width:150px;padding:15px 0px 15px 10px;min-height:20px;min-width:150px; overflow: hidden; text-align: center;'><?php echo $p->name; ?></div>";
			var myinfowindow = new google.maps.InfoWindow({
				content: mytext
			});		
			var ThisLocation_<?php echo $p->practice_id; ?> = new google.maps.LatLng(<?php echo $p->lat; ?>, <?php echo $p->long; ?>);
			var DoctorMarker_<?php echo $p->practice_id; ?> = new google.maps.Marker({
				position: ThisLocation_<?php echo $p->practice_id; ?>,
				map: map,
				icon: 'images/doc_marker.png',
				id: <?php echo $p->practice_id; ?>,
				type: "practice",
				infowindow: myinfowindow
			});	

			markerLookup(DoctorMarker_<?php echo $p->practice_id; ?>);
			<?php } ?>  
		<?php } ?>  	
		
function mapAddress(result) {
    PatientMarker.setPosition(result.geometry.location);
    PatientMarker.setMap(map);
	markerLookup(PatientMarker);
    map.fitBounds(result.geometry.viewport);	
	map.setZoom(9);
}	
	

  
validate();
  
</script>	
<?php

	$html .= '<div class="chosen">';
	$html .= 'You have selected: <div id="doctor_selected"></div>';
	$html .= '</div>';		
	$html .= '<div class="calculate_costs">';
	$html .= '<h1 id="calculate_costs">Calculate your costs.</h1>';
	$html .= '<div>';
	$html .= '<div style="padding: 30px 0;"><font style="font-size: 18px; font-weight: bold;">To add additional individuals:</font><br>Fill out the information below and click "add".<br>When you are done, click "calculate" to get your total.</div>';
	$html .= '<table class="more_patients">';
	$html .= '<tr>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;"><font style="color: #ccc;">M/F</font><br>--</td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;"><font style="color: #ccc;">D.O.B</font><br>'.$dob.'</div></td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;"><font style="color: #ccc;">First Name</font><br>'.$fname.'</td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;"><font style="color: #ccc;">Last Name</font><br>'.$lname.'</td>';
	$html .= '</tr>';	
	$html .= '<tr>';
	$html .= '<td><font style="color: #ccc;">Username</font><br>'.$username.'</td>';
	$html .= '<td colspan="2"><font style="color: #ccc;">Email Address</font><br>'.$email.'</td>';
	$html .= '<td>';
	$html .= '<font style="color: #ccc;">Account Access:</font><br>';
	$html .= 'Primary Access';
	$html .= '</td>';
	$html .= '</tr>';	
	$html .= '<tr>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">M/F<select id="new_patient_sex"><option value="M">Male</option><option value="F">Female</option></select></td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">D.O.B<input type="date" id="new_dob"></td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">First Name<input type="text" id="new_fname"></td>';
	$html .= '<td style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">Last Name<input type="text" id="new_lname"></td>';
	$html .= '</tr>';	
	$html .= '<tr>';
	$html .= '<td>Username (required)<input type="text" id="new_username"></td>';
	$html .= '<td colspan="2">Email Address (optional)<input type="email" id="new_email"></td>';
	$html .= '<td>';
	$html .= 'Account Access:';
	$html .= '<table class="access_table">';
	$html .= '<tr>';
	$html .= '<td><input type="radio" id="primary_access" name="access" value="0"><label for="primary_access">Primary</label></td>';
	$html .= '<td><input type="radio" id="secondary_access" name="access" value="1"><label for="secondary_access">Secondary</label></td>';	
	$html .= '</tr>';
	$html .= '</table>';	
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td colspan="4"><div class="add_cost" id="add_cost">+ add</div></td>';
	$html .= '</tr>';
	$html .= '</table>';	
	$html .= '<div style="text-align: left;"><button class="button" id="calculate_price">calculate</button></div>';
	$html .= '</div>';
	$html .= '<div class="calculated_price" id="calculated"></div>';
	$html .= '<div class="next" id="go_to_payment"></div>';
} else {
	$html .= 0;
}

echo $html;


?>