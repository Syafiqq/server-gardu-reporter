<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 04 August 2017, 9:33 PM.
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
    <link rel="stylesheet" href="/assets/css/layout/rekap/pengukuran/gardu/admin/rekap_pengukuran_gardu_admin_common_layout.min.css">

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
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['no_gardu'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['gardu_induk'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['gardu_penyulang'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['lokasi'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['latitude'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['longitude'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['petugas_1'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['petugas_2'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['no_kontrak'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle">Timestamp</th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['date'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['time'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['ir'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['is'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['it'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['in'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vrn'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vsn'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vtn'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vrs'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vrt'] ?></th>
                                    <th rowspan="2" style="vertical-align:middle"><?php echo $string['tabel']['header']['vst'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['umum_1'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['umum_2'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['umum_3'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['umum_4'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['khusus_1'] ?></th>
                                    <th colspan="11"><?php echo $string['tabel']['header']['khusus_2'] ?></th>
                                </tr>
                                <tr>
                                    <th><?php echo $string['tabel']['header']['id_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_u1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['id_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_u2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['id_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_u3']; ?></th>
                                    <th><?php echo $string['tabel']['header']['id_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_u4']; ?></th>
                                    <th><?php echo $string['tabel']['header']['id_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_k1']; ?></th>
                                    <th><?php echo $string['tabel']['header']['id_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['ir_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['is_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['it_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['in_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrn_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vsn_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vtn_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrs_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vrt_k2']; ?></th>
                                    <th><?php echo $string['tabel']['header']['vst_k2']; ?></th>
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
<script type="text/javascript" src="/assets/js/layout/rekap/pengukuran/gardu/admin/rekap_pengukuran_gardu_admin_common_layout.min.js"></script>
</body>
</html>
