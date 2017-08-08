<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 10:46 PM.
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

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url('/') ?>" title="Sistem Pendataan Status Gardu Trafo"><?php echo @$string['title'] ?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                <?php echo @$data['profile']['username'] ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a style="color: red">
                        <i class="fa fa-user fa-fw"></i>
                        [ <?php echo @$data['profile']['group'] ?> ]
                    </a>
                </li>
                <li>
                    <a id="edit-user" data-toggle="modal" data-target="#update" data-email="<?php echo @$data['profile']['email'] ?>" data-username="<?php echo @$data['profile']['username'] ?>" data-role="<?php echo @$data['profile']['group'] ?>">
                        <i class="fa fa-gear fa-fw"></i>
                        <?php echo @$string['profile_edit'] ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo @site_url('/auth/logout') ?>">
                        <i class="fa fa-sign-out fa-fw"></i>
                        <?php echo @$string['auth_logout'] ?>
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
                    <a href="<?php echo site_url('/dashboard') ?>">
                        <i class="fa fa-home fa-fw"></i>
                        <?php echo @$string['sidebar_home'] ?>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-table fa-fw"></i>
                        <?php echo @$string['sidebar_recapitulation'] ?>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo site_url('/rekap/pengukuran/gardu') ?>"><?php echo @$string['sidebar_recapitulation_measurement'] ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/rekap/tegangan/ujung') ?>"><?php echo @$string['sidebar_recapitulation_voltage_end'] ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/rekap/beban/trafo') ?>"><?php echo @$string['sidebar_recapitulation_travo_load'] ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/rekap/beban/imbang') ?>"><?php echo @$string['sidebar_recapitulation_load_balance'] ?></a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-edit fa-fw"></i>
                        <?php echo @$string['sidebar_info_gardu'] ?>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo site_url('/gardu/induk') ?>"><?php echo @$string['sidebar_info_gardu_hq'] ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/gardu/penyulang') ?>"><?php echo @$string['sidebar_info_gardu_feeder'] ?></a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/gardu') ?>"><?php echo @$string['sidebar_info_gardu_data'] ?></a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="<?php echo site_url('/management/user') ?>">
                        <i class="fa fa-users fa-fw"></i>
                        <?php echo @$string['sidebar_info_user_management'] ?>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
