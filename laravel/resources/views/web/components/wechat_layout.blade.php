<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="MobileOptimized" content="screen">
<!--     <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height, minimum-scale=1.0, maximum-scale=1.0,initial-scale=1, user-scalable=no"/> -->
    <title>Loading……</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- 阿里iconfont在线链接 -->
    <!--link rel="stylesheet" href="//at.alicdn.com/t/font_iy91m8e0r2lz0k9.css"-->
    <!-- <link rel="stylesheet" href="{{ mix('/static/css/web.css') }}"> -->
</head>
<body>
    <div>
        @yield('body')
    </div>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- <script src="{{ mix('/static/js/web.js') }}"></script> -->
</body>
</html>
