<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
   integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin="">
 </script>

</head>
<body onload="setupMap();">

<div id="mapid" style="height:400px"></div>

<script>
function setupMap() {
	var mymap = L.map('mapid').setView([51.505, -0.09], 13);

	//mymap.setZoom(0);

	L.tileLayer('http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
	 attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	 maxZoom: 18,
	}).addTo(mymap);

	var marker = L.marker([51.5, -0.09]).addTo(mymap);
	marker.bindPopup("<b>Hello world!</b><br>I am a popup."); //.openPopup();
}
</script>

</body>
</html>