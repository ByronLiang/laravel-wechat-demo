<!DOCTYPE html>
<html>
    <head>
        <title>Web Admin - Dashboard</title>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/materialadmin4.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/material-design-iconic-font.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/admin.css">
        <!--[if lt IE 9]>
        <script type="text/javascript" src="/assets/admin/js/html5shiv.min.js"></script>
        <script type="text/javascript" src="/assets/admin/js/respond.min.js"></script>
        <![endif]-->
        @yield('style')
    </head>
    <body class="menubar-hoverable header-fixed menubar-pin">
        <header id="header">
            <div class="headerbar">
                <div class="headerbar-left">
                    <ul class="header-nav header-nav-options">
                        <li class="header-nav-brand" >
                            <div class="brand-holder">
                                <a href="">
                                    <span class="text-lg text-bold text-primary">MATERIAL ADMIN</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="headerbar-right">
                    <ul class="header-nav header-nav-profile">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                                <span class="profile-info">
                                    Ganguo
                                    <small>Administrator</small>
                                </span>
                            </a>
                            <ul class="dropdown-menu animation-dock">
                                <li class="dropdown-header">Config</li>
                                <li><a href="../../html/pages/profile.html">My profile</a></li>
                                <li><a href="../../html/pages/blog/post.html">My blog <span class="badge style-danger pull-right">16</span></a></li>
                                <li><a href="../../html/pages/calendar.html">My appointments</a></li>
                                <li class="divider"></li>
                                <li><a href="../../html/pages/locked.html"><i class="fa fa-fw fa-lock"></i> Lock</a></li>
                                <li><a href="../../html/pages/login.html"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div id="base">
            <div id="content">
                <section>
                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            <div id="menubar">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="../../html/dashboards/dashboard.html">
                            <span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">
                    <ul id="main-menu" class="gui-controls">
                        <li>
                            <a href="../../html/dashboards/dashboard.html" class="active">
                                <div class="gui-icon"><i class="md md-home"></i></div>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <script src="/assets/admin/js/ganguo-admin.min.js"></script>
        @yield('script')

    </body>
</html>
