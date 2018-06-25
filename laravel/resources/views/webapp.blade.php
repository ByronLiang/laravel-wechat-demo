<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta name="MobileOptimized" content="screen">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width,height=device-height, minimum-scale=1.0, maximum-scale=1.0,initial-scale=1, user-scalable=no"/>
        <meta name="x5-page-mode" content="app">
        <meta name="browsermode" content="application">
        <meta name="description" content="">
        <meta name="format-detection" content="telephone=no">
        <title>Loading……</title>

        @if(env('WEB_DEBUG'))
            <script src="//cdn.bootcss.com/eruda/1.2.2/eruda.min.js"></script>
            <script>eruda.init();</script>
        @endif

        <!-- 阿里iconfont在线链接 -->
        <!--link rel="stylesheet" href="//at.alicdn.com/t/font_iy91m8e0r2lz0k9.css"-->
        <link rel="stylesheet" href="{{ mix('/static/css/web.css') }}">
    </head>
    <body>
        <div id="app"></div>
        <!--script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script-->
        <script src="{{ mix('/static/js/web.js') }}"></script>
    </body>
</html>
