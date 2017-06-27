<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 20 June 2017, 3:12 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */ ?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="This is landing page">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php foreach ((isset($meta) ? $meta : array()) as $k => $v)
    {
        echo "<meta name=\"${k}\" content=\"${v}\">";
    }
    ?>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Landing Page</title>

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
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/nprogress/nprogress.min.css">

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
                    <a href="../../index2.html" class="navbar-brand">
                        <b><?php echo $string['title'] ?></b>
                    </a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <!-- Navbar Right Menu -->
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
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php
                                echo '<table id="table_report" class="table table-bordered table-hover">';
                                echo '<thead>';
                                echo '<tr>';
                                echo "<th>{$string['table_header_no']}</th>";
                                echo "<th>{$string['table_header_substation']}</th>";
                                echo "<th>{$string['table_header_current']}</th>";
                                echo "<th>{$string['table_header_voltage']}</th>";
                                echo "<th>{$string['table_header_location']}</th>";
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                echo '</tbody>';
                                echo '<tfoot>';
                                echo '<tr>';
                                echo "<th>{$string['table_header_no']}</th>";
                                echo "<th>{$string['table_header_substation']}</th>";
                                echo "<th>{$string['table_header_current']}</th>";
                                echo "<th>{$string['table_header_voltage']}</th>";
                                echo "<th>{$string['table_header_location']}</th>";
                                echo '</tr>';
                                echo '</tfoot>';
                                echo '</table>';
                                ?>
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
<!-- DataTables -->
<script type="text/javascript" src="/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/vendor/nprogress/nprogress.min.js"></script>

<script type="text/javascript" src="/assets/js/layout/landing/index/landing_index_client_common_layout.min.js"></script>
</body>
</html>
