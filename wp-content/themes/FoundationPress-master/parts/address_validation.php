<?php

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
?>
					
				

<script>
  var geocoder, map, marker;
  var defaultLatLng = new google.maps.LatLng(30,0);
 
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var mapOptions = {
      zoom: 0,
      center: defaultLatLng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(
      document.getElementById("map_canvas"),
      mapOptions
    );
    marker = new google.maps.Marker();
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
 

 
  function mapAddress(result) {
    marker.setPosition(result.geometry.location);
    marker.setMap(map);
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