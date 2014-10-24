<?php

include '../dashboard/db_include.php';
$fname = $_POST['fname'];
$lname = $_POST['lname'];
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
	$html .= '<h1 style="width: 100%; text-align: center; margin-bottom: 5px;">Pick your doctor</h1><div style="display: inline-block; width: 100%; text-align: center; font-family: adellelight; font-size: 15px;">Click on the location icon to select your doctor.</div>';
	$html .= '<ul>';
	$doctors = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practice as p INNER JOIN ".$wpdb->prefix. "doctors as d ON d.practice_id=p.practice_id WHERE p.state='$state' AND d.new_patients='1'");
	foreach($doctors as $doctor)	{
		$html .= '<li class="doctor" data="'.$doctor->practice_id.'"><input type="radio" id="doc-'.$doctor->user_id.'" name="doctors" value="'.$doctor->user_id.'"><label for="doc-'.$doctor->user_id.'">';
		$html .= $doctor->fname.' '.$doctor->lname.'<br>'.$doctor->lat.', '.$doctor->long;
		$html .= '</label></li>';
	}
	$practices = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practice WHERE state='$state'");

	$html .= '</ul>';
	$html .= '</div>';
?>



<script>
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
	function validate() {
		var street = $('#street_verified').val();
		var city = $('#city_verified').val();
		var state = $('#state_verified').val();
		var zip = $('#zip_verified').val();
		
		var address = street+" ,"+city+", "+state+" "+zip;
		//alert(address);
		geocoder.geocode({'address': address }, function(results, status) {
			switch(status) {
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
			map.setZoom(15);
			map.setCenter(marker.getPosition());
			var doctorID = this.get("id");
			var practiceID = this.get("type");
			if(doctorID == "patient" || practiceID == "patient")	{
				//console.log("This is the patient location.");
				$(".doctor").hide();
				$(".no_doctor").show();
			} else {
				$(".doctor").each(function()	{
					var practice = $(this).attr('data');
					if(doctorID == practice)	{
						$(this).show();
					} else {
						$(this).hide();
					}
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
	map.setZoom(15);
}	
	
  
validate();
  
</script>	


	<div class="chosen">
		You have selected: <div class="doctor_selected"></div>
	</div>


<?php
} else {
	$html .= 0;
}

echo $html;


?>