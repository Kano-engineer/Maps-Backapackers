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

@foreach ($pins as $pins)
<ol id="pins">
    <li>{{ $pins->text }}</li>
</ol>
@endforeach

<script>
  function initMap() {

var addresses = [
    'pins',
];

var latlng = []; //緯度経度の値をセット
var marker = []; //マーカーの位置情報をセット
var myLatLng; //地図の中心点をセット用
var geocoder;
geocoder = new google.maps.Geocoder();

var map = new google.maps.Map(document.getElementById('gmap'));//地図を作成する

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
        zoom: 16 // 地図のズームを指定
    };//地図作成のオプションのうちcenterとzoomは必須
    map.setOptions(opt);//オプションをmapにセット
}//function aftergeo終了

};//function initMap終了

</script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE&callback=initMap" async defer></script>
</body>
</html>