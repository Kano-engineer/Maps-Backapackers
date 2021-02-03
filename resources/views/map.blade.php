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

    function initMap() {

      let data =@json($pins);

    var addresses = [
        'アラスカ',
    ];

var latlng = []; //緯度経度の値をセット
var marker = []; //マーカーの位置情報をセット
var myLatLng; //地図の中心点をセット用
var geocoder;
geocoder = new google.maps.Geocoder();

var map = new google.maps.Map(document.getElementById('map'));//地図を作成する

geo(aftergeo);

function geo(callback){
    var cRef = addresses.length;
    for (var i = 0; i < addresses.length; i++) {
        (function (i) { 
            geocoder.geocode({'address': addresses[i]}, 
                function(results, status) { // 結果
                    if (status === google.maps.GeocoderStatus.OK) { // ステータスがOKの場合
                        latlng[i]=results[0].geometry.location;// マーカーを立てる位置をセット
                        marker[i] = new google.maps.Marker({
                            position: results[0].geometry.location, // マーカーを立てる位置を指定
                            map: map // マーカーを立てる地図を指定
                        });
                    } else { // 失敗した場合
                    }//if文の終了。ifは文なので;はいらない
                    if (--cRef <= 0) {
                        callback();//全て取得できたらaftergeo実行
                    }
                }//function(results, status)の終了
            );//geocoder.geocodeの終了
        }) (i);
    }//for文の終了
}//function geo終了

function aftergeo(){
    myLatLng = latlng[0];//最初の住所を地図の中心点に設定
    var opt = {
        center: myLatLng, // 地図の中心を指定
        zoom: 2 // 地図のズームを指定
    };//地図作成のオプションのうちcenterとzoomは必須
    map.setOptions(opt);//オプションをmapにセット
}//function aftergeo終了

};//function initMap終了

</script>

  </head>
  <body>
    <div id="map"></div>
  </body>
</html>