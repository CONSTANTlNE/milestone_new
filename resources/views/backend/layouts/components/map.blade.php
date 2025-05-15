<?php
$data = isset($data) && !empty($data) ? (object)$data : [];
$columnName = isset($column) && $column ? $column : 'map';
if ($data) {
    $latlong = explode("#", $data->{$columnName});
    $lat = $latlong[0] ? $latlong[0] : '';
    $long = $latlong[1] ? $latlong[1] : '';
} else {
    $lat = '';
    $long = '';
}

?>

<div class="form-group col-md-6">
    <label class="form-label" for="phone">{{tr('map')}}</label>

    <div id="map" style="width: auto; height: 400px;">

    </div>
</div>

<div class="form-group col-md-6" style="display: flex">
    <input type="text" id="latitude" name="map_lat" value="{{ $lat }}"
           placeholder="Latitude" class="form-control col-md-3" style="margin-right: 4px" required
    >

    <input type="text" id="longitude" name="map_long" value="{{ $long }}"
           placeholder="Longitude" class="form-control col-md-3" required
    >
</div>

@push('componentScripts')

    <script type="text/javascript"
            src='https://maps.google.com/maps/api/js?&libraries=places&key={{env('GOOGLE_MAP_KEY')}}'></script>
    <script src="{{asset('/cms/locationpicker.jquery.js')}}"></script>
    <script>
        $(document).ready(function () {


            $('#map').locationpicker({

                @if(isset($data->map))
                    @php $latlong =  explode("#",$data->map) @endphp
                location: {
                    latitude: {{$latlong[0]}},
                    longitude: {{$latlong[1]}}
                },
                @else
                location: {
                    latitude: 41.71683196921312,
                    longitude: 44.822512895846224
                },
                @endif
                zoom: 10,
                radius: 0,
                markerInCenter: true,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    mapTypeIds: ['roadmap', 'terrain']
                },
                markerIcon: '{{asset('/cms/img/marker.png')}}',
                onchanged: function (currentLocation, radius, isMarkerDropped) {
                    $('#latitude').val(currentLocation.latitude);
                    $('#longitude').val(currentLocation.longitude);

                },

            });

        });

    </script>
@endPush
