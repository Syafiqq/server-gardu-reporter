<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 01 August 2017, 8:48 AM.
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
    <!-- NProgress -->
    <link rel="stylesheet" href="/assets/vendor/nprogress/nprogress.min.css">
    <!-- Jquery Confirm -->
    <link rel="stylesheet" href="/assets/vendor/jquery-confirm2/dist/jquery-confirm.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="/assets/css/layout/common/common_layout.min.css">
    <link rel="stylesheet" href="/assets/css/layout/gardu/pengukuran/index/admin/gardu_pengukuran_index_admin_common_layout.min.css">

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
                    <?php echo @form_open('/api/gardu/pengukuran/index/register', 'id="create_index_measurement"'); ?>
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="common_<?php echo @$string['form']['no_gardu']['id'] ?>"><?php echo @$string['form']['no_gardu']['label'] ?></label>
                                    <span><a data-toggle="tooltip" data-placement="bottom" title="<?php echo @$string['form']['create_gardu_index']['description'] ?>" style="float: right" href="<?php echo @$string['form']['create_gardu_index']['link'] ?>"><?php echo @$string['form']['create_gardu_index']['label'] ?></a></span>
                                    <select class="form-control" name="<?php echo @$string['form']['no_gardu']['id'] ?>" id="common_<?php echo @$string['form']['no_gardu']['id'] ?>">
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="common_<?php echo @$string['form']['date']['id'] ?>"><?php echo @$string['form']['date']['label'] ?></label>
                                    <input class="form-control" id="common_<?php echo @$string['form']['date']['id'] ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="common_<?php echo @$string['form']['time']['id'] ?>"><?php echo @$string['form']['time']['label'] ?></label>
                                    <input class="form-control" id="common_<?php echo @$string['form']['time']['id'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <?php foreach ((@isset($string['form']['worker']) ? $string['form']['worker'] : []) as $v)
                                {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label" for="common_<?php echo @$v['id'] ?>"><?php echo @$v['label'] ?></label>
                                        <input name="<?php echo @$v['id'] ?>" class="form-control" id="common_<?php echo @$v['id'] ?>" placeholder="<?php echo @$v['placeholder'] ?>">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?php foreach ((@isset($string['form']['arus'][0]) ? $string['form']['arus'][0] : []) as $v)
                                            {
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="common_<?php echo @$v['id'] ?>"><?php echo @$v['label'] ?></label>
                                                    <input name="<?php echo @$v['id'] ?>" class="form-control" id="common_<?php echo @$v['id'] ?>" placeholder="<?php echo @$v['placeholder'] ?>">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?php foreach ((@isset($string['form']['arus'][1]) ? $string['form']['arus'][1] : []) as $v)
                                            {
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="common_<?php echo @$v['id'] ?>"><?php echo @$v['label'] ?></label>
                                                    <input name="<?php echo @$v['id'] ?>" class="form-control" id="common_<?php echo @$v['id'] ?>" placeholder="<?php echo @$v['placeholder'] ?>">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?php foreach ((@isset($string['form']['tegangan'][0]) ? $string['form']['tegangan'][0] : []) as $v)
                                            {
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="common_<?php echo @$v['id'] ?>"><?php echo @$v['label'] ?></label>
                                                    <input name="<?php echo @$v['id'] ?>" class="form-control" id="common_<?php echo @$v['id'] ?>" placeholder="<?php echo @$v['placeholder'] ?>">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?php foreach ((@isset($string['form']['tegangan'][1]) ? $string['form']['tegangan'][1] : []) as $v)
                                            {
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label" for="common_<?php echo @$v['id'] ?>"><?php echo @$v['label'] ?></label>
                                                    <input name="<?php echo @$v['id'] ?>" class="form-control" id="common_<?php echo @$v['id'] ?>" placeholder="<?php echo @$v['placeholder'] ?>">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <h4 class="panel-title">
                                                        <b><?php echo @$string['form']['jurusan']['umum']['title'] ?></b>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <!-- Nav tabs -->
                                                    <ul class="nav nav-tabs nav-pills">
                                                        <?php
                                                        foreach (@isset($string['form']['jurusan']['umum']['content']) ? $string['form']['jurusan']['umum']['content'] : [] as $k => $v)
                                                        {
                                                            ?>
                                                            <li <?php echo @($k == 0 ? 'class="active"' : '') ?>>
                                                                <a href="#umum_<?php echo @$v['id'] ?>" data-toggle="tab"><?php echo @$v['title'] ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <?php
                                                        foreach (@isset($string['form']['jurusan']['umum']['content']) ? $string['form']['jurusan']['umum']['content'] : [] as $k => $v)
                                                        {
                                                            ?>
                                                            <div class="tab-pane fade<?php echo @($k == 0 ? 'in active' : '') ?>" id="umum_<?php echo @$v['id'] ?>">
                                                                <!-- isi jurusan1 -->
                                                                <br>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group form-inline">
                                                                        <label class="control-label" for="umum_<?php echo @$v['jurusan']['id'] ?>"><?php echo @$v['jurusan']['label'] ?></label>
                                                                        <input name="<?php echo @$v['jurusan']['id'] ?>" class="form-control" id="umum_<?php echo @$v['jurusan']['id'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['arus'][0]) ? $v['arus'][0] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="umum_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="umum_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['arus'][1]) ? $v['arus'][1] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="umum_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="umum_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['tegangan'][0]) ? $v['tegangan'][0] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="umum_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="umum_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['tegangan'][1]) ? $v['tegangan'][1] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="umum_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="umum_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <!-- /.isi jurusan1 -->
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- /.panel-body -->
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <h4 class="panel-title">
                                                        <b><?php echo @$string['form']['jurusan']['khusus']['title'] ?></b>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <!-- Nav tabs -->
                                                    <ul class="nav nav-tabs nav-pills">
                                                        <?php
                                                        foreach (@isset($string['form']['jurusan']['khusus']['content']) ? $string['form']['jurusan']['khusus']['content'] : [] as $k => $v)
                                                        {
                                                            ?>
                                                            <li <?php echo @($k == 0 ? 'class="active"' : '') ?>>
                                                                <a href="#khusus_<?php echo @$v['id'] ?>" data-toggle="tab"><?php echo @$v['title'] ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <?php
                                                        foreach (@isset($string['form']['jurusan']['khusus']['content']) ? $string['form']['jurusan']['khusus']['content'] : [] as $k => $v)
                                                        {
                                                            ?>
                                                            <div class="tab-pane fade<?php echo @($k == 0 ? 'in active' : '') ?>" id="khusus_<?php echo @$v['id'] ?>">
                                                                <!-- isi jurusan1 -->
                                                                <br>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group form-inline">
                                                                        <label class="control-label" for="khusus_<?php echo @$v['jurusan']['id'] ?>"><?php echo @$v['jurusan']['label'] ?></label>
                                                                        <input name="<?php echo @$v['jurusan']['id'] ?>" class="form-control" id="khusus_<?php echo @$v['jurusan']['id'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['arus'][0]) ? $v['arus'][0] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="khusus_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="khusus_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['arus'][1]) ? $v['arus'][1] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="khusus_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="khusus_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['tegangan'][0]) ? $v['tegangan'][0] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="khusus_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="khusus_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <?php foreach ((@$v['tegangan'][1]) ? $v['tegangan'][1] : [] as $vv)
                                                                        {
                                                                            ?>
                                                                            <div class="form-group">
                                                                                <label class="control-label" for="khusus_<?php echo @$vv['id'] ?>"><?php echo @$vv['label'] ?></label>
                                                                                <input name="<?php echo @$vv['id'] ?>" class="form-control" id="khusus_<?php echo @$vv['id'] ?>" placeholder="<?php echo @$vv['placeholder'] ?>">
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <!-- /.isi jurusan1 -->
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- /.panel-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="float: right;margin-bottom: 15px">
                        <a href="<?php echo @site_url('/dashboard') ?>" class="btn btn-default"><?php echo @$string['form']['button']['go_back'] ?></a>
                        <button type="reset" class="btn btn-danger"><?php echo @$string['form']['button']['reset'] ?></button>
                        <input type="submit" class="btn btn-primary" value="<?php echo @$string['form']['button']['submit'] ?>">
                    </div>
                    <?php echo @form_close() ?>
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
<script type="text/javascript" src="/assets/js/common/serializer/common_serializer.min.js"></script>
<script type="text/javascript" src="/assets/vendor/jquery-serialize-object/dist/jquery.serialize-object.min.js"></script>
<!-- Notify -->
<script type="text/javascript" src="/assets/vendor/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
<!-- Jquery Confirm -->
<script type="text/javascript" src="/assets/vendor/jquery-confirm2/dist/jquery-confirm.min.js"></script>
<!-- Moment -->
<script type="text/javascript" src="/assets/vendor/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/assets/vendor/moment/min/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/assets/vendor/moment-timezone/builds/moment-timezone-with-data.min.js"></script>
<!-- Custom -->
<script type="text/javascript">
    var sessionFlashdata = <?php echo @json_encode($data['session']['flashdata'])?>;
</script>
<script type="text/javascript" src="/assets/js/layout/common/common_function.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/common/profile/common_profile_edit_common_layout.min.js"></script>
<script type="text/javascript" src="/assets/js/layout/gardu/pengukuran/index/admin/gardu_pengukuran_index_admin_common_layout.min.js"></script>
</body>
</html>

