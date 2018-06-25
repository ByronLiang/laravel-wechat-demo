<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="MobileOptimized" content="screen">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height, minimum-scale=1.0, maximum-scale=1.0,initial-scale=1, user-scalable=no"/>
    <title>Loading……</title>

    <!-- 阿里iconfont在线链接 -->
    <!--link rel="stylesheet" href="//at.alicdn.com/t/font_iy91m8e0r2lz0k9.css"-->
    <link rel="stylesheet" href="{{ mix('/static/css/web.css') }}">
</head>
<body>
    <div id="content">
        @yield('body')
    </div>
    <script src="{{ mix('/static/js/web.js') }}"></script>
</body>
</html>
