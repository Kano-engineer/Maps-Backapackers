<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>

    <p>住所や駅名、目印などで検索できます。</p>
<form onsubmit="return false;">
  <input type="text" value="株式会社Maromaro" id="address">
  <button type="button" value="検索" id="map_button">検索</button>
</form>
<!-- 地図を表示させる要素 -->
<div class="map_box01"><div id="map-canvas" style="width: 500px;height: 350px;"></div></div>
 
<p>マーカーのある位置の<br>
緯度 <input type="text" id="lat" value=""><br>
経度 <input type="text" id="lng" value=""><br>
地図上をクリックするとマーカーを移動できます。</p>

<!-- APIを取得 -->
<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE"></script>

<script>
var getMap = (function() {
  function codeAddress(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();
 
    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    // 地図を表示させるインスタンスを生成
    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
     
    //マーカー変数用意
    var marker;
     
    // geocoder.geocode()メソッドを実行 
    geocoder.geocode( { 'address': address}, function(results, status) {
       
      // ジオコーディングが成功した場合
      if (status == google.maps.GeocoderStatus.OK) {
         
        // 変換した緯度・経度情報を地図の中心に表示
        map.setCenter(results[0].geometry.location);
         
        //☆表示している地図上の緯度経度
        document.getElementById('lat').value=results[0].geometry.location.lat();
        document.getElementById('lng').value=results[0].geometry.location.lng();
         
        // マーカー設定
        marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
       
      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
     
    });
     
    // マップをクリックで位置変更
    map.addListener('click', function(e) {
      getClickLatLng(e.latLng, map);
    });
    function getClickLatLng(lat_lng, map) {
       
      //☆表示している地図上の緯度経度
      document.getElementById('lat').value=lat_lng.lat();
      document.getElementById('lng').value=lat_lng.lng();
         
      // マーカーを設置
      marker.setMap(null);
      marker = new google.maps.Marker({
        position: lat_lng,
        map: map
      });
     
      // 座標の中心をずらす
      map.panTo(lat_lng);
    }
   
  }
   
  //inputのvalueで検索して地図を表示
  return {
    getAddress: function() {
      // ボタンに指定したid要素を取得
      var button = document.getElementById("map_button");
       
      // ボタンが押された時の処理
      button.onclick = function() {
        // フォームに入力された住所情報を取得
        var address = document.getElementById("address").value;
        // 取得した住所を引数に指定してcodeAddress()関数を実行
        codeAddress(address);
      }
       
      //読み込まれたときに地図を表示
      window.onload = function(){
        // フォームに入力された住所情報を取得
        var address = document.getElementById("address").value;
        // 取得した住所を引数に指定してcodeAddress()関数を実行
        codeAddress(address);
      }
    }
   
  };
 
})();
getMap.getAddress();
</script>
    
  </body>
</html>