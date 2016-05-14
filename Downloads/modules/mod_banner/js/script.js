<!-- Distance Calculation -->
jQuery(document).ready(function(){
    google.maps.event.addDomListener(window, 'load', function () {
	    var places = new google.maps.places.Autocomplete(document.getElementById('postto'));
	    google.maps.event.addListener(places, 'place_changed', function () {
		    /*var place = places.getPlace();
		    var address = place.formatted_address;*/
			calculateDistances();
	    });
    });
    calculateDistances();
    var map;
	var geocoder;
	var bounds = new google.maps.LatLngBounds();
	var markersArray = [];
	var origin;
	var destination;

	function calculateDistances() {
	  origin = document.getElementById('postfrom').value;
	  destination = document.getElementById('postto').value;

	  var service = new google.maps.DistanceMatrixService();
	  service.getDistanceMatrix(
	    {
	      origins: [origin],
	      destinations: [destination],
	      travelMode: google.maps.TravelMode.DRIVING,
	      unitSystem: google.maps.UnitSystem.METRIC,
	      avoidHighways: false,
	      avoidTolls: false
	    }, calcDistance);
	}

	function calcDistance(response, status) {
	  if (status != google.maps.DistanceMatrixStatus.OK) {
	    alert('Error was: ' + status);
	  } else {
	    var origins = response.originAddresses;
	    var destinations = response.destinationAddresses;
	    deleteOverlays();

	    for (var i = 0; i < origins.length; i++) {
	      var results = response.rows[i].elements;

	      for (var j = 0; j < results.length; j++) {
	        document.getElementById('distance').value = results[j].distance.text;
	      }
	    }
	  }
	}

	function deleteOverlays() {
	  for (var i = 0; i < markersArray.length; i++) {
	    markersArray[i].setMap(null);
	  }
	  markersArray = [];
	}
});