<!DOCTYPE html>
<html>
    <head>
        <title>Web Admin - Login</title>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/materialadmin4.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/material-design-iconic-font.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/admin/css/admin.min.css">
        <!--[if lt IE 9]>
        <script type="text/javascript" src="/assets/admin/js/html5shiv.min.js"></script>
        <script type="text/javascript" src="/assets/admin/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="menubar-hoverable header-fixed">
        <section class="section-account">
            <!-- 公司标志 -->
            <div class="spacer">
                <div class="logo">
                    <img src="">
                </div>
			</div>
            <div class="card contain-sm style-transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <br/>
                            <span class="text-lg text-bold text-primary">WEB ADMIN</span>
                            <br/><br/>
                            <form class="form" action="" accept-charset="utf-8" method="post" autocomplete="off">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="username" name="account">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <label for="password">Password</label>
                                </div>
                                <br/>
                                <div class="row">
                                    <!--div class="col-xs-6 text-left">
                                        <div class="checkbox checkbox-inline checkbox-styled">
                                            <label>
                                                <input type="checkbox"> <span>Remember me</span>
                                            </label>
                                        </div>
                                    </div-->
                                    <div class="col-xs-6 text-right">
                                        <button class="btn btn-primary btn-raised" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <script src="/assets/admin/js/ganguo-admin.min.js"></script>

    </body>
</html>
