<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Simple Map Sample</title>
<meta charset="utf-8">
<style>
/* レスポンシブ */
.map_wrapper {
  position: relative; /* 子要素の基準とする */
  width:100%;
  padding-top:56.25%; /* 幅の 56.25% を高さとする場合（16:9）*/
  border: 1px solid #CCC;  
}
.map_wrapper .gmap {
  position: absolute; /* 親要素のパディング領域に配置 */
  width: 100%; /* 親コンテナの幅いっぱいに表示 */
  height: 100%; /* 親コンテナの高さいっぱいに表示 */
  top: 0;
  left: 0;
} 
</style>
</head>
<body>

<div class="map_wrapper">
<div id="gmap" class="gmap"></div> <!-- 地図を表示する領域 -->
</div>

<script>
function initMap() {
  var target = document.getElementById('gmap');  
  //マップを生成
  var map = new google.maps.Map(target, {  
    center: {lat: 35, lng: 135},
    zoom: 2
  });
  //ジオコーディングのインスタンスの生成
  var geocoder = new google.maps.Geocoder();  
  
  //マップにリスナーを設定
  map.addListener('click', function(e){
    //リバースジオコーディングでは location を指定
    geocoder.geocode({location: e.latLng}, function(results, status){
      if(status === 'OK' && results[0]) {
        //マーカーの生成
        var marker = new google.maps.Marker({
          position: e.latLng,
          map: map,
          title: results[0].formatted_address,
          animation: google.maps.Animation.DROP
        });
        
        //情報ウィンドウの生成
        var infoWindow = new google.maps.InfoWindow({
          content:  results[0].formatted_address,
          pixelOffset: new google.maps.Size(0, 5)
        });
 
        //マーカーにリスナーを設定
        marker.addListener('click', function(){
          infoWindow.open(map, marker);
        });
        
        //情報ウィンドウリスナーを設定
        infoWindow.addListener('closeclick', function(){
          marker.setMap(null);  //マーカーを削除
        });
      }else if(status === 'ZERO_RESULTS') {
        alert('不明なアドレスです： ' + status);
        return;
      }else{
        alert('失敗しました： ' + status);
        return;
      }
    });
  });
} 
</script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>
</body>
</html>