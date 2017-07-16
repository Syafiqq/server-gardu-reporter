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
<html class="no-js" lang="<?php echo "{$data['meta']['i18n']['language']}-{$data['meta']['i18n']['country']}" ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Dashboard">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php foreach ($meta as $k => $v)
    {
        echo "<meta name=\"${k}\" content=\"${v}\">";
    }
    ?>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $string['page_title'] ?></title>

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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="index.php" title="Sistem Pendataan Status Gardu Trafo"><?php echo $string['title'] ?></a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>
                    <?php echo $data['profile']['username'] ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a style="color: red">
                            <i class="fa fa-user fa-fw"></i>
                            [ <?php echo $data['profile']['group'] ?> ]
                        </a>
                    </li>
                    <li>
                        <a id="edit-user" data-toggle="modal" data-target="#update" data-email="<?php echo $data['profile']['email'] ?>" data-username="<?php echo $data['profile']['username'] ?>" data-role="<?php echo $data['profile']['group'] ?>">
                            <i class="fa fa-gear fa-fw"></i>
                            <?php echo $string['profile_edit'] ?>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo site_url('/auth/logout') ?>">
                            <i class="fa fa-sign-out fa-fw"></i>
                            <?php echo $string['auth_logout'] ?>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php">
                            <i class="fa fa-home fa-fw"></i>
                            <?php echo $string['sidebar_home'] ?>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa fa-table fa-fw"></i>
                            <?php echo $string['sidebar_recapitulation'] ?>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="?page=gncg67nh8"><?php echo $string['sidebar_recapitulation_measurement'] ?></a>
                            </li>
                            <li>
                                <a href="?page=jf4qo3mx2d20dsk23"><?php echo $string['sidebar_recapitulation_voltage_end'] ?></a>
                            </li>
                            <li>
                                <a href="?page=dyh2c3bh2x32un"><?php echo $string['sidebar_recapitulation_travo_load'] ?></a>
                            </li>
                            <li>
                                <a href="?page=8932neu92d23ssw"><?php echo $string['sidebar_recapitulation_load_balance'] ?></a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa fa-edit fa-fw"></i>
                            <?php echo $string['sidebar_info_gardu'] ?>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="?page=j9e3x2n9"><?php echo $string['sidebar_info_gardu_hq'] ?></a>
                            </li>
                            <li>
                                <a href="?page=g55cx09q2"><?php echo $string['sidebar_info_gardu_feeder'] ?></a>
                            </li>
                            <li>
                                <a href="?page=ms4noi32r"><?php echo $string['sidebar_info_gardu_data'] ?></a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="?page=mfoa3i4fcid">
                            <i class="fa fa-users fa-fw"></i>
                            <?php echo $string['sidebar_info_user_management'] ?>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Edit Profile -->
            <div id="update" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo $string['profile_edit'] ?></h4>
                        </div>
                        <div id="form-message-container">
                        </div>
                        <?php echo form_open('/api/profile/patch', 'id="update_form"'); ?>
                        <?php if (!empty(@$data['session']['redirector']))
                        {
                            echo form_hidden('redirector', $data['session']['redirector']);
                        } ?>
                        <div class="modal-body" id="modal-update">
                            <div class="form-group">
                                <label class="control-label" for="<?php echo $string['inline_client_form_username_id'] ?>"><?php echo $string['client_form_username_label'] ?></label>
                                <input type="text" name="<?php echo $string['inline_client_form_username_id'] ?>" class="form-control" id="update_<?php echo $string['inline_client_form_username_id'] ?>" placeholder="<?php echo $string['client_form_username_placeholder'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="<?php echo $string['inline_client_form_email_id'] ?>"><?php echo $string['client_form_email_label'] ?></label>
                                <input type="text" name="<?php echo $string['inline_client_form_email_id'] ?>" class="form-control" id="update_<?php echo $string['inline_client_form_email_id'] ?>" placeholder="<?php echo $string['client_form_email_placeholder'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="<?php echo $string['inline_client_form_role_id'] ?>"><?php echo $string['client_form_role_label'] ?></label>
                                <input type="text" class="form-control" id="update_<?php echo $string['inline_client_form_role_id'] ?>" disabled>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="<?php echo $string['profile_edit'] ?>">
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $string['welcome_message'] ?>
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
                            <button type="button" class="btn btn-primary btn-block" onClick="window.location='?page=fn9rec98wf3';">Tambah Data Pengukuran</button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=j9e3x2n9';">Tambah Data Gardu Induk</button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=g55cx09q2';">Tambah Data Penyulang</button>
                        </div>
                    </div>
                    <div class="row margin-top-50 margin-bottom-50">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-default btn-block" onClick="window.location='?page=ms4noi32r';">Tambah Data Gardu</button>
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
    var sessionFlashdata = <?php echo json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/dashboard/index/dashboard_index_admin_common_layout.min.js"></script>
</body>
</html>
