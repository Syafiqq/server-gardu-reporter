<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 19 July 2017, 6:14 PM.
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
    <link rel="stylesheet" href="/assets/css/layout/gardu/penyulang/admin/gardu_penyulang_admin_common_layout.min.css">

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
                        <?php echo @form_open('/api/gardu/penyulang/register', 'id="create_gardu_penyulang"'); ?>
                        <div class="modal-body" id="modal-add">
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_id_id'] ?>"><?php echo @$string['item_creation_form_id_label'] ?></label>
                                <input type="text" name="<?php echo @$string['item_creation_form_id_id'] ?>" class="form-control" id="create_<?php echo @$string['item_creation_form_id_id'] ?>" placeholder="<?php echo @$string['item_creation_form_id_placeholder'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="create_<?php echo @$string['item_creation_form_name_id'] ?>"><?php echo @$string['item_creation_form_name_label'] ?></label>
                                <input type="text" name="<?php echo @$string['item_creation_form_name_id'] ?>" class="form-control" id="create_<?php echo @$string['item_creation_form_name_id'] ?>" placeholder="<?php echo @$string['item_creation_form_name_placeholder'] ?>">
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
                        <?php echo @form_open('/api/gardu/penyulang/update', 'id="update_gardu_penyulang"'); ?>
                        <div class="modal-body" id="modal-add">
                            <input type="hidden" name="<?php echo @$string['item_manipulation_form_id_id'] ?>" id="update_<?php echo @$string['item_manipulation_form_id_id'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="update_<?php echo @$string['item_manipulation_form_name_id'] ?>"><?php echo @$string['item_manipulation_form_name_label'] ?></label>
                                <input type="text" name="<?php echo @$string['item_manipulation_form_name_id'] ?>" class="form-control" id="update_<?php echo @$string['item_manipulation_form_name_id'] ?>" placeholder="<?php echo @$string['item_manipulation_form_name_placeholder'] ?>">
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
                            <table id="table_gardu_penyulang" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th><?php echo @$string['table_header_code'] ?></th>
                                    <th><?php echo @$string['table_header_name'] ?></th>
                                    <th><?php echo @$string['table_header_option'] ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th><?php echo @$string['table_header_code'] ?></th>
                                    <th><?php echo @$string['table_header_name'] ?></th>
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
<!-- Custom -->
<script type="text/javascript">
    var sessionFlashdata = <?php echo @json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/common/common_function.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/common/profile/common_profile_edit_common_layout.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/gardu/penyulang/admin/gardu_penyulang_admin_common_layout.min.js"></script>
</body>
</html>
