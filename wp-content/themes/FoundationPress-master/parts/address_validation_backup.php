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
	$html .= '<ul>';
	$doctors = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix. "practice as p INNER JOIN ".$wpdb->prefix. "doctors as d ON d.practice_id=p.practice_id WHERE p.state='$state'");
	foreach($doctors as $doctor)	{
		$html .= '<li id="doctor-'.$doctor->user_id.'" data="'.$doctor->practice_id.'">';
		$html .= $doctor->fname.' '.$doctor->lname.'<br>'.$doctor->lat.', '.$doctor->long;
		$html .= '</li>';
		
	}
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
	PatientMarker = new google.maps.Marker({
		id: "patient",
		type: "patient",
		icon: 'images/pat_marker.png'
	});
	var patientInfo = new google.maps.InfoWindow({
		content: "You"
	});
	patientInfo.open(map, PatientMarker);
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
				console.log("This is the patient location.");
				$(".enroll_doctor_list ul li").hide();
			} else {
				//$("#doctor-"+ doctorID).siblings.hide();
				$("#doctor-"+ doctorID).each(function()	{
					var practice = $(this).attr('data');
					if(practiceID == practice)	{
						$(this).show();
					}
				});
			}
		//	map.fitBounds(marker.geometry.viewport);
		});		
	}
		<?php foreach($doctors as $doctor) { ?>
			var ThisLocation = new google.maps.LatLng(<?php echo $doctor->lat; ?>, <?php echo $doctor->long; ?>);
				var DoctorMarker = new google.maps.Marker({
					position: ThisLocation,
					map: map,
					icon: 'images/doc_marker.png',
					id: <?php echo $doctor->user_id; ?>,
					type: <?php echo $doctor->practice_id; ?>
				});	
				//DoctorMarker.set('id', <?php echo $doctor->user_id; ?>)
				var DocInfo = new google.maps.InfoWindow({
					content: "<?php echo $doctor->fname." ".$doctor->lname; ?>"
				});
				DocInfo.open(map, DoctorMarker);
				//DoctorMarker.setMap(map);
			markerLookup(DoctorMarker);
		<?php } ?>  	
		//map.fitBounds(DoctorMarker.geometry.viewport);
		
  function mapAddress(result) {
    PatientMarker.setPosition(result.geometry.location);
    PatientMarker.setMap(map);
	markerLookup(PatientMarker);
	DoctorsMapped();
    map.fitBounds(result.geometry.viewport);
	
  }	
	
  
  validate();
  
</script>	
<?php





} else {
	$html .= 0;
}

echo $html;


?>