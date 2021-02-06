<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>


    @foreach ($pins as $pins)
       {{ $pins->text }} 
    @endforeach


    <script>
    let map;
    let marker = []; // マーカーを複数表示させたいので、配列化
    let infoWindow = []; // 吹き出しを複数表示させたいので、配列化
    
    let markerData = @json($pins->text); // コントローラーで定義したインスタンス変数を変数に代入
    let id = @json($pins->id);

  function initMap() {
    geocoder = new google.maps.Geocoder()

    map = new google.maps.Map(document.getElementById('map'), {
      center: { lat: 35.6585, lng: 139.7486 }, // 東京タワーを中心に表示させている
      zoom: 12,
    });

    // 繰り返し処理でマーカーと吹き出しを複数表示させる
    for (var i = 0; i < markerData.length; i++) {
      let id = markerData[i]['id']

      // 各地点の緯度経度を算出
      markerLatLng = new google.maps.LatLng({
        lat: markerData[i]['latitude'],
        lng: markerData[i]['longitude']
      });

      // 各地点のマーカーを作成
      marker[i] = new google.maps.Marker({
        position: markerLatLng,
        map: map
      });

      // 各地点の吹き出しを作成
      infoWindow[i] = new google.maps.InfoWindow({
        // 吹き出しの内容
        content: `<a href='/pins/${ id }'>${ markerData[i]['text'] }</a>`
      });

      // マーカーにクリックイベントを追加
      markerEvent(i);
    }
  }
  
  // マーカーをクリックしたら吹き出しを表示
  function markerEvent(i) {
    marker[i].addListener('click', function () {
      infoWindow[i].open(map, marker[i]);
    });
  }

    </script>
  </head>
  <body>
    <div id="map"></div>
  </body>
</html>