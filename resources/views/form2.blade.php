<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form2</title>
  <style>
    /* Responsive */
    .map_wrapper {
      position: relative; 
      width:100%;
      padding-top:56.25%;
      border: 1px solid #CCC;  
    }
    .map_wrapper .gmap {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    }
</style>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Fomt Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>



  <div class="map_wrapper">
    <div id="gmap" class="gmap"></div>
  </div>

  <form style="text-align:center;" onsubmit="return false;">
    <input style="text-align:center;" name="text"  id="output" placeholder="address">
    <input style=";" type="" value="日本" placeholder="初期値" id="address">
    <button style=";" type="" value="" id="map_button">場所をザックリ検索</button>
  </form>
  <form style="text-align:center;" onsubmit="return false;">
    <input style=";" type="" value="" placeholder="検索" id="address2">
    <button style=";" type="" value="" id="map_button2">場所をザックリ検索</button>
  </form>
  <!-- Output longitude -->
  <input style="" type="text" id="lng" value=""><br>
  <!-- Output latitude -->
  <input style="" type="text" id="lat" value=""><br>

<script>
var getMap = (function() {
  function codeAddress(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();

    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 5,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // 地図を表示させるインスタンスを生成
    var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
    
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

      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      } 
    });

    var markers = [];
    
    map.addListener('click', function(e){

        /* 既存のマーカーを削除する。 */
        if (markers.length > 0) {
        /* 既存マーカーが参照渡しで渡されているので、marker.setMap(null)で削除できる */
        markers.forEach(marker => marker.setMap(null));
        }

      //reverse geodcording
      geocoder.geocode({location: e.latLng}, function(results, status){
        if(status === 'OK' && results[0]) {

            var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,
            title: results[0].formatted_address,
            animation: google.maps.Animation.DROP
        });

          document.getElementById('output').value=results[0].formatted_address;
          
          /*
           * markers.push(marker)は参照渡しになることを利用する。
           * https://webtechdays.com/?p=221
           */
          markers.push(marker);
          
          //Delete marker 
          infoWindow.addListener('closeclick', function(){
            marker.setMap(null);
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

  function codeAddress2(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();

    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // 地図を表示させるインスタンスを生成
    var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
    
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

      // ジオコーディングが成功しなかった場合
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      } 
    });

    var markers = [];
    
    map.addListener('click', function(e){

        /* 既存のマーカーを削除する。 */
        if (markers.length > 0) {
        /* 既存マーカーが参照渡しで渡されているので、marker.setMap(null)で削除できる */
        markers.forEach(marker => marker.setMap(null));
        }

      //reverse geodcording
      geocoder.geocode({location: e.latLng}, function(results, status){
        if(status === 'OK' && results[0]) {

            var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,
            title: results[0].formatted_address,
            animation: google.maps.Animation.DROP
        });

          document.getElementById('output').value=results[0].formatted_address;
          
          /*
           * markers.push(marker)は参照渡しになることを利用する。
           * https://webtechdays.com/?p=221
           */
          markers.push(marker);
          
          //Delete marker 
          infoWindow.addListener('closeclick', function(){
            marker.setMap(null);
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

            // ボタンに指定したid要素を取得
            var button2 = document.getElementById("map_button2");
       
       // ボタンが押された時の処理
       button2.onclick = function() {
         // フォームに入力された住所情報を取得
         var address = document.getElementById("address2").value;
                                            // 取得した住所を引数に指定してcodeAddress()関数を実行
         codeAddress2(address);
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
<!-- Use Google Maps API / Geocording API -->
<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyCKeJI2_CkK91_yzwlmyIIrzVqyJj2CgdE"></script>
</body>
</html>