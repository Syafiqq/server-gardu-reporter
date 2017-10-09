<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 23 July 2017, 12:06 PM.
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
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- NProgress -->
    <link rel="stylesheet" href="/assets/vendor/nprogress/nprogress.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/assets/css/layout/common/common_layout.min.css">
    <link rel="stylesheet" href="/assets/css/layout/gardu/index/member/gardu_index_member_common_layout.min.css">

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

            <!--====================================================================================================-->
            <div id="create_item" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo @$string['item_creation_title'] ?></h4>
                        </div>
                        <div class="row margin-top-20">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div id="form-creation-message-container">
                                </div>
                            </div>
                        </div>
                        <?php echo @form_open('/api/gardu/index/register', 'id="create_gardu_index"'); ?>
                        <div class="modal-body" id="modal-add">
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_induk_id'] ?>"><?php echo @$string['item_creation_form_induk_id_label'] ?></label>
                                <select class="form-control" name="<?php echo @$string['item_creation_form_id_induk_id'] ?>" id="create_<?php echo @$string['item_creation_form_id_induk_id'] ?>" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_penyulang_id'] ?>"><?php echo @$string['item_creation_form_penyulang_id_label'] ?></label>
                                <select class="form-control" name="<?php echo @$string['item_creation_form_id_penyulang_id'] ?>" id="create_<?php echo @$string['item_creation_form_id_penyulang_id'] ?>" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_jenis'] ?>"><?php echo @$string['item_creation_form_jenis_label'] ?></label>
                                <select class="form-control" name="<?php echo @$string['item_creation_form_id_jenis'] ?>" id="create_<?php echo @$string['item_creation_form_id_jenis'] ?>" required>
                                    <option value="Portal">Portal</option>
                                    <option value="Cantol">Cantol</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_no'] ?>"><?php echo @$string['item_creation_form_no_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_no'] ?>" id="create_<?php echo @$string['item_creation_form_id_no'] ?>" placeholder="<?php echo @$string['item_creation_form_no_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_lokasi'] ?>"><?php echo @$string['item_creation_form_lokasi_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_lokasi'] ?>" id="create_<?php echo @$string['item_creation_form_id_lokasi'] ?>" placeholder="<?php echo @$string['item_creation_form_lokasi_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_merk'] ?>"><?php echo @$string['item_creation_form_merk_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_merk'] ?>" id="create_<?php echo @$string['item_creation_form_id_merk'] ?>" placeholder="<?php echo @$string['item_creation_form_merk_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_serial'] ?>"><?php echo @$string['item_creation_form_serial_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_serial'] ?>" id="create_<?php echo @$string['item_creation_form_id_serial'] ?>" placeholder="<?php echo @$string['item_creation_form_serial_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_daya'] ?>"><?php echo @$string['item_creation_form_daya_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_daya'] ?>" id="create_<?php echo @$string['item_creation_form_id_daya'] ?>" placeholder="<?php echo @$string['item_creation_form_daya_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_fasa'] ?>"><?php echo @$string['item_creation_form_fasa_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_fasa'] ?>" id="create_<?php echo @$string['item_creation_form_id_fasa'] ?>" placeholder="<?php echo @$string['item_creation_form_fasa_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_tap'] ?>"><?php echo @$string['item_creation_form_tap_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_tap'] ?>" id="create_<?php echo @$string['item_creation_form_id_tap'] ?>" placeholder="<?php echo @$string['item_creation_form_tap_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_jurusan'] ?>"><?php echo @$string['item_creation_form_jurusan_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_jurusan'] ?>" id="create_<?php echo @$string['item_creation_form_id_jurusan'] ?>" placeholder="<?php echo @$string['item_creation_form_jurusan_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_lat'] ?>"><?php echo @$string['item_creation_form_lat_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_lat'] ?>" id="create_<?php echo @$string['item_creation_form_id_lat'] ?>" placeholder="<?php echo @$string['item_creation_form_lat_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_long'] ?>"><?php echo @$string['item_creation_form_long_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_creation_form_id_long'] ?>" id="create_<?php echo @$string['item_creation_form_id_long'] ?>" placeholder="<?php echo @$string['item_creation_form_long_placeholder'] ?>">
                            </div>
                        </div>
                        <div class="modal-footer" id="modal-to">
                            <button type="reset" class="btn btn-danger"><?php echo @$string['item_creation_reset'] ?></button>
                            <input type="submit" class="btn btn-primary" value="<?php echo @$string['item_creation_register'] ?>">
                        </div>
                        <?php echo @form_close() ?>
                    </div>
                </div>
            </div>
            <div id="update_item" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo @$string['item_manipulation_title'] ?></h4>
                        </div>
                        <div class="row margin-top-20">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div id="form-update-message-container">
                                </div>
                            </div>
                        </div>
                        <?php echo @form_open('/api/gardu/index/update', 'id="update_gardu_index"'); ?>
                        <div class="modal-body" id="modal-add">
                            <input type="hidden" name="<?php echo @$string['item_manipulation_form_id_no'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_no'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_jenis'] ?>"><?php echo @$string['item_manipulation_form_jenis_label'] ?></label>
                                <select class="form-control" name="<?php echo @$string['item_manipulation_form_id_jenis'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_jenis'] ?>" required>
                                    <option value="Portal">Portal</option>
                                    <option value="Cantol">Cantol</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_lokasi'] ?>"><?php echo @$string['item_manipulation_form_lokasi_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_lokasi'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_lokasi'] ?>" placeholder="<?php echo @$string['item_manipulation_form_lokasi_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_merk'] ?>"><?php echo @$string['item_manipulation_form_merk_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_merk'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_merk'] ?>" placeholder="<?php echo @$string['item_manipulation_form_merk_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_serial'] ?>"><?php echo @$string['item_manipulation_form_serial_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_serial'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_serial'] ?>" placeholder="<?php echo @$string['item_manipulation_form_serial_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_fasa'] ?>"><?php echo @$string['item_manipulation_form_fasa_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_fasa'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_fasa'] ?>" placeholder="<?php echo @$string['item_manipulation_form_fasa_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_tap'] ?>"><?php echo @$string['item_manipulation_form_tap_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_tap'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_tap'] ?>" placeholder="<?php echo @$string['item_manipulation_form_tap_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_jurusan'] ?>"><?php echo @$string['item_manipulation_form_jurusan_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_jurusan'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_jurusan'] ?>" placeholder="<?php echo @$string['item_manipulation_form_jurusan_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_lat'] ?>"><?php echo @$string['item_manipulation_form_lat_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_lat'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_lat'] ?>" placeholder="<?php echo @$string['item_manipulation_form_lat_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_id_long'] ?>"><?php echo @$string['item_manipulation_form_long_label'] ?></label>
                                <input class="form-control" name="<?php echo @$string['item_manipulation_form_id_long'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_long'] ?>" placeholder="<?php echo @$string['item_manipulation_form_long_placeholder'] ?>">
                            </div>
                        </div>
                        <div class="modal-footer" id="modal-to">
                            <button type="reset" class="btn btn-danger"><?php echo @$string['item_manipulation_reset'] ?></button>
                            <input type="submit" class="btn btn-primary" value="<?php echo @$string['item_manipulation_update'] ?>">
                        </div>
                        <?php echo @form_close() ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo @$string['page_title'] ?>
                    </h1>
                </div>
            </div>
            <!-- mulai konten -->
            <div class="row">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="div#create_item">
                        <i class="fa fa-plus"></i>
                        <?php echo @$string['add_new_item'] ?>
                    </button>
                </div>
            </div>
            <div class="margin-top-20">

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table id="table_gardu_index" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th width="15%"><?php echo @$string['table_header_induk_id'] ?></th>
                                    <th width="15%"><?php echo @$string['table_header_penyulang_id'] ?></th>
                                    <th width="20%"><?php echo @$string['table_header_no'] ?></th>
                                    <th><?php echo @$string['table_header_location'] ?></th>
                                    <th width="15%"><?php echo @$string['table_header_option'] ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><?php echo @$string['table_header_induk_id'] ?></th>
                                    <th><?php echo @$string['table_header_penyulang_id'] ?></th>
                                    <th><?php echo @$string['table_header_no'] ?></th>
                                    <th><?php echo @$string['table_header_location'] ?></th>
                                    <th><?php echo @$string['table_header_option'] ?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--====================================================================================================-->
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
<!-- DataTables -->
<script type="text/javascript" src="/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Sprintf -->
<script type="text/javascript" src="/assets/vendor/sprintf/dist/sprintf.min.js"></script>
<!-- Custom -->
<script type="text/javascript">
    var sessionFlashdata = <?php echo @json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/common/common_function.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/common/profile/common_profile_edit_common_layout.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/gardu/index/member/gardu_index_member_common_layout.min.js"></script>
</body>
</html>
