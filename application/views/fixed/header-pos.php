<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>All1Touch POS</title >";
    }
    ?>
    <link rel="apple-touch-icon" href="<?php echo assets_url() ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url() ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/vendors.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/vendors/css/charts/morris.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/pages/chat-application.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>assets/css/style.css<?php echo APPVER ?>">
    <?php if (LTR == 'rtl') echo '<link rel="stylesheet" type="text/css" href="' . assets_url() . 'assets/css/style-rtl.css' . APPVER . '">'; ?>
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <!-- END Custom CSS-->
    <script src="<?php echo assets_url() ?>app-assets/vendors/js/vendors.min.js"></script>
    <script type="text/javascript" src="<?php echo assets_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script type="text/javascript"
            src="<?php echo assets_url() ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?php echo assets_url() ?>app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="<?php echo assets_url() ?>app-assets/vendors/js/charts/morris.min.js"></script>

    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?php echo $this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?php echo assets_url('assets/myjs/mousetrap.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/printThis.js" type="text/javascript"></script>
    <?php accounting() ?>
</head>
<body class="horizontal-layout horizontal-menu content-left-sidebar <?php if ($s_mode) echo 'chat-application'; ?>  menu-expanded"
      data-open="hover"
      data-menu="horizontal-menu"
      data-col="2-columns">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="navbar-brand" href="<?php echo base_url() ?>dashboard/"><img class="brand-logo" alt="logo"
                                                                                           src="<?php echo base_url(); ?>userfiles/theme/logo-header.png"></a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link nav-link-expand" data-toggle="modal" data-target="#shortFullScreen"><i
                                    class="ficon ft-maximize"></i></a>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link ">
                        <a href="<?php echo base_url() ?>dashboard" class="btn btn-amber btn-md t_tooltip"
                           title="Access POS"><i
                                    class="icon-speedometer"></i><?php echo $this->lang->line('Dashboard') ?> </a>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link ">
                        <a class="btn btn-blue btn-md t_tooltip" title="View Register" data-toggle="modal"
                           data-target="#register"><i
                                    class="icon-drawer"></i><?php echo $this->lang->line('Register') ?> </a>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link ">
                        <a data-toggle="modal" data-target="#close_register" class="btn btn-danger btn-md t_tooltip"
                           title="Close Register"> <i class="icon-close"></i></a>
                    </li>

                </ul>

                <ul class="nav navbar-nav float-right">
                    <li class=" nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#shortkeyboard"><i
                                    class="fa fa-keyboard-o"></i></a>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">0 New</span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist">
                            </li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center"
                                   href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i><span
                                    class="badge badge-pill badge-default badge-info badge-default badge-up"
                                    id="messagecount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span
                                            class="notification-tag badge badge-default badge-warning float-right m-0"
                                            id="messagecount2">0<?php echo $this->lang->line('new') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php
                                $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {
                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
									  <div class="media">
										<div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
										<div class="media-body">
										  <h6 class="media-heading">' . $row->name . '</h6>
										  <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
											<time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
										</div>
									  </div></a>';
                                } ?>    </li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center"
                                   href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">
                            <?php if ($this->aauth->clock()) {

                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-default badge-success badge-default badge-up">' . $this->lang->line('On') . '</span></a>';

                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-default badge-warning badge-default badge-up">' . $this->lang->line('Off') . '</span></a>';
                            }
                            ?>
                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <br><br>
                                <?php echo '<span class="p-1 text-bold-300">' . $this->lang->line('Attendance') . ':</span>';
                                if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-on" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('In') . ' <i
                                    class="ficon icon-clock spinner"></i></a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-off" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('Out') . ' </a>';
                                }
                                ?>

                                <br><br>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span><span
                                    class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>user/holiday"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a>
                            <a href="<?php echo base_url(); ?>user/vacation"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Vacations') ?></a>
                            <a href="<?php echo base_url(); ?>user/fault"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Faults') ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i
                                        class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->

<!-- Horizontal navigation-->
<div id="notify" class="alert" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <div class="message"></div>
</div>
<div id="thermal_a" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <div class="message"></div>
</div>
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">