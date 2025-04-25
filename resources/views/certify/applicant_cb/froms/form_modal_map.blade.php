
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <div class="modal-body">
                <style>
                    .controls {
                        margin-top: 10px;
                        border: 1px solid transparent;
                        border-radius: 2px 0 0 2px;
                        box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        height: 32px;
                        outline: none;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
                    }

                    #pac-input {
                        background-color: #fff;
                        font-size: 15px;
                        font-weight: 300;
                        margin-left: 12px;
                        padding: 0 11px 0 13px;
                        text-overflow: ellipsis;
                        width: 300px;
                    }

                    #pac-input:focus {
                        border-color: #4d90fe;
                    }

                </style>

                <input id="pac-input" class="controls"  type="text" placeholder="Search Box">
                <div id="map" style="height: 400px;"></div>
                <input id="lat1" class="controls" type="text"   placeholder="ละติจูด" disabled>
                <input id="lng1" class="controls" type="text"  placeholder="ลองติจูด" disabled>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success"  id="button-modal-default">
                    <span aria-hidden="true">ยืนยัน</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwr5rmzY9btU08sQlU9N0qfmo8YmE91Y&libraries=places&callback=initAutocomplete"   async defer></script>
<script>
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    var markers = [];
    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 13.7563309, lng: 100.50176510000006},
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });
        markers = new google.maps.Marker({
            position: {lat: 13.7563309, lng: 100.50176510000006},
            map: map,
        });

        google.maps.event.addListener(map, 'click', function (event) {
            markers.setMap(null);

            markers = new google.maps.Marker({
                position: { lat: event.latLng.lat(), lng: event.latLng.lng() },
                map: map,
            });

            $('#lat1').val(event.latLng.lat());
            $('#lng1').val(event.latLng.lng());
        });

        searchBox.addListener('places_changed', function () {
            markers.setMap(null);
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                 $('#lat1').val(place.geometry.location.lat());
                 $('#lng1').val(place.geometry.location.lng());

                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers = new google.maps.Marker({
                    position: { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() },
                    map: map,
                });

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    // bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

    }
</script>
@endpush