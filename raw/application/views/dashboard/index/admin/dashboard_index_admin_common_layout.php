<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 1:01 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

/**
 * @var array $string
 * @var array $meta
 * @var array $data
 * @var array $view
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
if (!isset($view))
{
    $view = [];
}

?>

<!DOCTYPE html>
<html class="no-js" lang="<?php echo @"{$data['meta']['i18n']['language']}-{$data['meta']['i18n']['country']}" ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Dashboard">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php foreach ($meta as $k => $v)
    {
        echo @"<meta name=\"${k}\" content=\"${v}\">";
    }
    ?>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo @$string['page_title'] ?></title>

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
    <!-- Metis Menu -->
    <link rel="stylesheet" href="/assets/vendor/metisMenu/dist/metisMenu.min.css">
    <!-- Start Bootstrap -->
    <link rel="stylesheet" href="/assets/vendor/startbootstrap-sb-admin-2/dist/css/sb-admin-2.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/assets/css/layout/common/common_layout.min.css">
    <link rel="stylesheet" href="/assets/css/layout/dashboard/index/admin/dashboard_index_admin_common_layout.min.css">

    <script type="text/javascript" src="/assets/vendor/html5-boilerplate/dist/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/js/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="/assets/js/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <?php echo @$view['sidebar'] ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Edit Profile -->
            <?php echo @$view['edit_profile'] ?>

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo @$string['welcome_message'] ?>
                    </h1>
                </div>
            </div>
            <!-- /.row -->
            <!-- mulai konten -->
            <div class="row">
                <div class="col-lg-4">
                    <!-- zonk -->
                </div>

                <div class="col-lg-4">
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary btn-block" onClick="window.location='?page=fn9rec98wf3';"><?php echo @$string['menu_add_entry'] ?></button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=j9e3x2n9';"><?php echo @$string['menu_add_gardu_centre'] ?></button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=g55cx09q2';"><?php echo @$string['menu_add_feeder'] ?></button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=ms4noi32r';"><?php echo @$string['menu_add_gardu'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <footer class="main-footer">
        <div style="float:right">
            Powered by PT. PLN (Persero) Area Bali Selatan.
            <br>
            Copyright &copy; 2016 Wyn Eka Yuliana. All rights reserved.
        </div>
    </footer>
</div>
<!-- /#wrapper -->

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
<!-- Metis Menu -->
<script type="text/javascript" src="/assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<!-- Startbootstrap -->
<script type="text/javascript" src="/assets/vendor/startbootstrap-sb-admin-2/dist/js/sb-admin-2.min.js"></script>
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
<script type="text/javascript" src="/assets/js/layout/common/common_function.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/common/profile/common_profile_edit_common_layout.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/dashboard/index/admin/dashboard_index_admin_common_layout.min.js"></script>
</body>
</html>
