// <script>
//     $(window).on('load', function() {
//     $(".preloader").fadeOut();
//
//     if(localStorage.getItem('popState') != 'shown'){
//     $('#myModal').modal('show');
//     localStorage.setItem('popState','shown')
// }
//
//     setTimeout(function (){
//     localStorage.clear();
// }, 40000);
// });
// </script>
// <script type="text/javascript">
//     $(document).ready(function() {
//     $('#send_contact').click(function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: "{{ url(\App('language')->current->abbr.'/send_message' ) }}",
//             type: 'POST',
//             data: $('form[name=form]').serialize(),
//             dataType: 'json',
//             success: function(response) {
//                 alert(response.message);
//             }
//         });
//     });
// });
//
//     $(document).ready(function() {
//     $('#send_fact').click(function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: "{{ url(\App('language')->current->abbr.'/send_fact' ) }}",
//             type: 'POST',
//             data: $('form[name=fact-form]').serialize(),
//             dataType: 'json',
//             success: function(response) {
//                 alert(response.message);
//             }
//         });
//     });
// });
//
//
//     $(document).ready(function() {
//     $('#send_subscribe').click(function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: "{{ url(\App('language')->current->abbr.'/send_subscribe' ) }}",
//             type: 'POST',
//             data: $('form[name=subscribe-form]').serialize(),
//             dataType: 'json',
//             success: function(response) {
//                 alert(response.status);
//             }
//         });
//     });
// });
// </script>
// <script type="text/javascript">
//     function myMap() {
//     var lat = {!! Helper::appMap()['lat'] ? Helper::appMap()['lat'] : 0 !!};
//     var lng = {!! Helper::appMap()['lng'] ? Helper::appMap()['lng'] : 0 !!};
//     var map_address = "{!! Helper::appMap()['map_address'] ? Helper::appMap()['map_address'] : '' !!}";
//
//     var mapProp= {
//     center:new google.maps.LatLng(lat, lng),
//     zoom:12,
//     styles: [{"featureType": "all","elementType": "labels.text.fill","stylers": [{"saturation": 36},{"color": "#000000"},{"lightness": 40}]},{"featureType": "all","elementType": "labels.text.stroke","stylers": [{"visibility": "on"},{"color": "#000000"},{"lightness": 16}]},{"featureType": "all","elementType": "labels.icon","stylers": [{"visibility": "off"}]},{"featureType": "administrative","elementType": "geometry.fill","stylers": [{"color": "#000000"},{"lightness": 20}]},{"featureType": "administrative","elementType": "geometry.stroke","stylers": [{"color": "#000000"},{"lightness": 17},{"weight": 1.2}]},{"featureType": "landscape","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 20}]},{"featureType": "poi","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 21}]},{"featureType": "road.highway","elementType": "geometry.fill","stylers": [{"color": "#000000"},{"lightness": 17}]},{"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#000000"},{"lightness": 29},{"weight": 0.2}]},{"featureType": "road.arterial","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 18}]},{"featureType": "road.local","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 16}]},{"featureType": "transit","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 19}]},{"featureType": "water","elementType": "geometry","stylers": [{"color": "#000000"},{"lightness": 17}]}]};
//
//     var map=new google.maps.Map(document.getElementById("map"),mapProp);
//     var marker;
//
//     marker = new google.maps.Marker({
//     position: new google.maps.LatLng(lat,lng),
//     map: map,
//     // icon: '/img/marker.png'
// });
//     google.maps.event.addListener(marker, 'click', (function(marker) {
//     return function() {
//     var infowindow = new google.maps.InfoWindow({
//     content: map_address
// });
//     infowindow.open(map, marker);
// }
// })(marker));
// }
// </script>
// <script src="https://maps.googleapis.com/maps/api/js?key={!! \App('Details')->info->meta['g_api_key'] !!}&callback=myMap"></script>

