function previewImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function() {
		document.getElementById('preview').src = fileReader.result;
	});
	fileReader.readAsDataURL(obj.files[0]);
}

var getMap = (function() {
  function codeAddress(address) {
    // google.maps.Geocoder()コンストラクタのインスタンスを生成
    var geocoder = new google.maps.Geocoder();

    // 地図表示に関するオプション
    var mapOptions = {
      zoom: 4,
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