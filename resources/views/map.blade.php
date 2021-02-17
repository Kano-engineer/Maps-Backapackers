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
  <div id="gmap" class="gmap"></div>
</div>
 
<script>
  var map;
  function initMap() {
    var target = document.getElementById('gmap');
    var empire = {lat: 40.748441, lng: -73.985664};
    map = new google.maps.Map(target, {
      center: empire,
      zoom: 14
    });

    map.addListener('click', function(e){
      var marker = new google.maps.Marker({
        position: e.latLng,
        map: map,
        title: e.latLng.toString(),
        animation: google.maps.Animation.DROP
    });
      
    marker.addListener("click", function(e) {
      var infoWindow = new google.maps.InfoWindow({
        position: e.latLng,
        content:"<strong>クリック➡︎詳細ページ</strong>",
        })
        infoWindow.open(map,marker);
      }); 
    });
    
  }
</script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>
</body>
</html>