(function($) {
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
 
  function validate() {
    clearResults();
    var street = document.getElementById('street').value;
	var city = document.getElementById('city').value;
	var state = document.getElementById('state').value;
	var zip = document.getElementById('zip').value;
	var address = street+" ,"+city+", "+state+" "+zip;
    geocoder.geocode({'address': address }, function(results, status) {
      switch(status) {
        case google.maps.GeocoderStatus.OK:
          document.getElementById('valid').value = 'YES';
          document.getElementById('type').value = results[0].types[0];
          document.getElementById('result').value = results[0].formatted_address;
          mapAddress(results[0]);
		  var latitude = results[0].geometry.location.lat();
		  var longitude = results[0].geometry.location.lng();
		  document.getElementById('latlong').value = latitude+", "+longitude;
          break;
        case google.maps.GeocoderStatus.ZERO_RESULTS:
          document.getElementById('valid').value = 'NO';
          break;
        default:
          alert("An error occured while validating this address")
      }
    });
  }
 
  function clearResults() {
    document.getElementById('valid').value = '';
    document.getElementById('type').value = '';
    document.getElementById('result').value = '';
    map.setCenter(defaultLatLng);
    map.setZoom(0);
    marker.setMap(null);
  }
 
  function mapAddress(result) {
    marker.setPosition(result.geometry.location);
    marker.setMap(map);
    map.fitBounds(result.geometry.viewport);
  }
	
})(jQuery);