function mapInit(element) {
  var markers = {};
  var mapOptions = {
    zoom: 7,
    center: new google.maps.LatLng(41.956667, 44.783333)
  };

  var mapElement = document.getElementById(element);
  var map = new google.maps.Map(mapElement, mapOptions);

  map.addListener('click', function (event) {
    addMarker(event.latLng);
  });

  function addMarker(location) {
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
    var markerLat = marker.position.lat();

    google.maps.event.addListener(marker, 'click', function () {
      deleteMarker(markerLat);
      marker.setMap(null);
      fillMarkersInput();
    });
    markers[markerLat] = marker;
    fillMarkersInput();
  }

  function deleteMarker(index) {
    delete markers[index];
  }

  function fillMarkersInput() {
    var locations = [];
    $.each( markers, function( key, marker ) {
      var latAndLng = {};
      latAndLng.lat = marker.position.lat();
      latAndLng.lng = marker.position.lng();
      locations.push(latAndLng);
    });
    $('#locations').val(JSON.stringify(locations));
  }
}