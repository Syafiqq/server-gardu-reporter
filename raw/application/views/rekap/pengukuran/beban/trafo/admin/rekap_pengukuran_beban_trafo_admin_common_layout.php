<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 06 August 2017, 12:40 PM.
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
    <!-- Jquery UI -->
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/themes/base/jquery-ui.min.css">
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
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- NProgress -->
    <link rel="stylesheet" href="/assets/vendor/nprogress/nprogress.min.css">
    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="/assets/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <!-- Datatabl YADCF -->
    <link rel="stylesheet" href="/assets/vendor/yadcf/jquery.dataTables.yadcf.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/assets/css/layout/common/common_layout.min.css">
    <link rel="stylesheet" href="/assets/css/layout/rekap/pengukuran/beban/trafo/admin/rekap_pengukuran_beban_trafo_admin_common_layout.min.css">

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
    <?php echo $view['sidebar'] ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Edit Profile -->
            <?php echo $view['edit_profile'] ?>

            <!--====================================================================================================-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $string['page_title'] ?>
                    </h1>
                </div>
            </div>
            <!-- mulai konten -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-2 align-right text-right">
                                <strong><?php echo $string['form']['label']['title']['filter_date'] ?></strong>
                            </div>
                            <div class="col-sm-4">
                                <span id="timestamp-filter"></span>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-success pull-right" id="content-download">
                                    <i class="fa fa-download"></i>
                                    <?php echo $string['button']['download'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="margin-top-20">

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table id="tabel_pengukuran" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th><?php echo $string['tabel']['header']['no_gardu']; ?></th>
                                    <th><?php echo $string['tabel']['header']['gardu_induk']; ?></th>
                                    <th><?php echo $string['tabel']['header']['gardu_penyulang']; ?></th>
                                    <th><?php echo $string['tabel']['header']['lokasi']; ?></th>
                                    <th><?php echo $string['tabel']['header']['latitude']; ?></th>
                                    <th><?php echo $string['tabel']['header']['longitude']; ?></th>
                                    <th>Timestamp</th>
                                    <th><?php echo $string['tabel']['header']['date']; ?></th>
                                    <th><?php echo $string['tabel']['header']['time']; ?></th>
                                    <th><?php echo $string['tabel']['header']['f']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn']; ?></th>
                                    <th><?php echo $string['tabel']['header']['w']; ?></th>
                                    <th><?php echo $string['tabel']['header']['percent']; ?></th>
                                    <th><?php echo $string['tabel']['header']['status']; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--====================================================================================================-->
            </div>
            <!-- /.container-fluid -->
        </div>
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
<!-- Jquery UI -->
<script type="text/javascript" src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
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
<script type="text/javascript" src="/assets/js/common/serializer/common_serializer.min.js"></script>
<script type="text/javascript" src="/assets/vendor/jquery-serialize-object/dist/jquery.serialize-object.min.js"></script>
<!-- Notify -->
<script type="text/javascript" src="/assets/vendor/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Moment -->
<script type="text/javascript" src="/assets/vendor/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/assets/vendor/moment/min/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/assets/vendor/moment-timezone/builds/moment-timezone-with-data.min.js"></script>
<!-- Sprintf -->
<script type="text/javascript" src="/assets/vendor/sprintf/dist/sprintf.min.js"></script>
<!-- Bootstrap Date Time Picker -->
<script type="text/javascript" src="/assets/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- Datatable YADCF -->
<script type="text/javascript" src="/assets/vendor/yadcf/jquery.dataTables.yadcf.min.js"></script>
<!-- Custom -->
<script type="text/javascript">
    var sessionFlashdata = <?php echo json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/common/common_function.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/common/profile/common_profile_edit_common_layout.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/rekap/pengukuran/beban/trafo/admin/rekap_pengukuran_beban_trafo_admin_common_layout.min.js"></script>
</body>
</html>
