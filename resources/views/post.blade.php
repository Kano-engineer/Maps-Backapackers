<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 
<head>
    <meta charset="UTF-8">
    <title>チャット</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
 
    </style>
</head>
 
<body>

    <div id="app">
        <example-component></example-component>
    </div>
 
    <script src="{{ mix('js/app.js') }}"></script>
    
    <script>
 $(window).load(function() {
      footerStart();
  });
    </script>
    <footer>
<!--フッターの記述-->
    </footer>
</body>


 
</html>
