<!DOCTYPE html>
<html>
  <head>
    <title>Test Map</title>
    <meta charset="utf-8">
    <style>
      #test-map {
        width: 600px;
        height: 400px;
      }
    </style>
  </head>
  <body>
  <!-- Jenkins jobtest -->
    <div id="test-map"></div>
    <script>
    function initMap() {
    var myLatLng = {lat: -36.84928607472707, lng: 174.76711015}; // 緯度・経度
    var map = new google.maps.Map(document.getElementById('test-map'), { // HTMLのIDセレクタ名
          center: myLatLng,
          zoom: 14, // 拡大率設定
          styles: 
          // Styling Wizard：Darak 
          [
            {
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#1d2c4d"
                }
                ]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#8ec3b9"
                }
                ]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [
                {
                    "color": "#1a3646"
                }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [
                {
                    "color": "#4b6878"
                }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#64779e"
                }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [
                {
                    "color": "#4b6878"
                }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                {
                    "color": "#334e87"
                }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#023e58"
                }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#283d6a"
                }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#6f9ba5"
                }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.stroke",
                "stylers": [
                {
                    "color": "#1d2c4d"
                }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                {
                    "color": "#023e58"
                }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#3C7680"
                }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#304a7d"
                }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#98a5be"
                }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                {
                    "color": "#1d2c4d"
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#2c6675"
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                {
                    "color": "#255763"
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#b0d5ce"
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.stroke",
                "stylers": [
                {
                    "color": "#023e58"
                }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#98a5be"
                }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.stroke",
                "stylers": [
                {
                    "color": "#1d2c4d"
                }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry.fill",
                "stylers": [
                {
                    "color": "#283d6a"
                }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#3a4762"
                }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                {
                    "color": "#0e1626"
                }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                {
                    "color": "#4e6d70"
                }
                ]
            }
        ]
          // ここまで
    });
    // マーカー表示
    var marker = new google.maps.Marker({
          map: map,
          position: myLatLng
    });
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap"  async defer></script>
  </body>
</html>

</body>
</html>