<div class="item-map">
	<style>
		#map-canvas {
			width: {{ Config::get('laravel-places::map.width') }}px;
			height: {{ Config::get('laravel-places::map.height') }}px;
		}
	</style>
	<div id="map-canvas"></div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
	function initialize() {
		var mapLatlng = new google.maps.LatLng( {{ $place->getMapLatitude() }}, {{ $place->getMapLongitude() }});
		var mapOptions = {
			zoom: {{ $place->getMapZoom() }},
			center: mapLatlng
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		var markerLatlng = new google.maps.LatLng({{ $place->getMarkerLatitude() }}, {{ $place->getMarkerLongitude() }});
		var marker = new google.maps.Marker({
			position: markerLatlng,
			map: map,
			title: '{{ addslashes($place->marker_title) }}'
		});
	}
	google.maps.place.addDomListener(window, 'load', initialize);
</script>