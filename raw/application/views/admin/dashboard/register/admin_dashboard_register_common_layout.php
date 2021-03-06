<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 30 June 2017, 6:38 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

if (!isset($meta))
{
    $meta = [];
}
if (!isset($string))
{
    $string = [];
}
if (!isset($data))
{
    $data = [];
}

?>

<!DOCTYPE html>
<html class="no-js" lang="<?php echo @"{$data['meta']['i18n']['language']}-{$data['meta']['i18n']['country']}" ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="This is Client Registrator">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php foreach ($meta as $k => $v)
    {
        echo @"<meta name=\"${k}\" content=\"${v}\">";
    }
    ?>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register</title>

    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="/assets/vendor/html5-boilerplate/dist/css/normalize.min.css">
    <link rel="stylesheet" href="/assets/vendor/html5-boilerplate/dist/css/main.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/vendor/components-font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/vendor/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/vendor/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/vendor/AdminLTE/dist/css/skins/skin-blue.min.css">
    <!-- NProgress -->
    <link rel="stylesheet" href="/assets/vendor/nprogress/nprogress.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/assets/css/layout/admin/dashboard/register/admin_dashboard_register_common_layout.min.css">

    <script type="text/javascript" src="/assets/vendor/html5-boilerplate/dist/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/js/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="/assets/js/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="<?php echo @site_url('/') ?>" class="navbar-brand">
                        <b><?php echo @$string['title'] ?></b>
                    </a>
                </div>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <!-- Menu Toggle Button -->
                            <a id="sign-out" href="<?php echo @site_url('admin/dashboard/register') ?>">
                                <!-- The user image in the navbar-->
                                <i class="fa fa-sign-in"></i>
                                &nbsp;&nbsp;<?php echo @$string['client_register'] ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-custom-menu -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo @$string['client_register'] ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div id="form-message-container">
                                        </div>
                                        <?php echo @form_open('/admin/api/register/client', 'id="register" class="form-horizontal'); ?>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="<?php echo @$string['inline_client_form_username_id'] ?>" class="col-sm-3 control-label"><?php echo @$string['client_form_username_label'] ?></label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="username" id="<?php echo @$string['inline_client_form_username_id'] ?>" placeholder="<?php echo @$string['client_form_username_placeholder'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="<?php echo @$string['inline_client_form_email_id'] ?>" class="col-sm-3 control-label"><?php echo @$string['client_form_email_label'] ?></label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="identity" id="<?php echo @$string['inline_client_form_email_id'] ?>" placeholder="<?php echo @$string['client_form_email_placeholder'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="<?php echo @$string['inline_client_form_password_id'] ?>" class="col-sm-3 control-label"><?php echo @$string['client_form_password_label'] ?></label>

                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" name="password" id="<?php echo @$string['inline_client_form_password_id'] ?>" placeholder="<?php echo @$string['client_form_password_placeholder'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="<?php echo @$string['inline_client_form_password_confirmation_id'] ?>" class="col-sm-3 control-label"><?php echo @$string['client_form_password_confirmation_label'] ?></label>

                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" name="password_conf" id="<?php echo @$string['inline_client_form_password_confirmation_id'] ?>" placeholder="<?php echo @$string['client_form_password_confirmation_placeholder'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-info pull-right"><?php echo @$string['client_register'] ?></button>
                                        </div>
                                        <!-- /.box-footer -->
                                        <?php echo @form_close() ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">

            </div>
            <strong></strong>
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="/assets/vendor/jquery/dist/jquery.min.js"></script>
<script>window.jQuery || document.write('<script type="text/javascript" src="/assets/vendor/jquery/dist/jquery.min.js"><\/script>')</script>
<script type="text/javascript" src="/assets/vendor/html5-boilerplate/dist/js/plugins.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script type="text/javascript" src="/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="/assets/vendor/fastclick/lib/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="/assets/vendor/AdminLTE/dist/js/app.min.js"></script>
<!-- NProgress -->
<script type="text/javascript" src="/assets/vendor/nprogress/nprogress.min.js"></script>
<!-- Serialize Object -->
<script type="text/javascript" src="/assets/vendor/jquery-serialize-object/dist/jquery.serialize-object.min.js"></script>
<!-- Notify -->
<script type="text/javascript" src="/assets/vendor/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- Custom -->
<script type="text/javascript">
    var sessionFlashdata = <?php echo @json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/admin/dashboard/register/admin_dashboard_register_common_layout.min.js"></script>
</body>
</html>
