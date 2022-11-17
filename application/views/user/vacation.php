<link rel="stylesheet" type="text/css"
      href="<?php echo assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?php echo APPVER ?>">
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrapValidator.min.css?v=<?php echo APPVER ?>"
      rel="stylesheet"/>
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css?v=<?php echo APPVER ?>"
      rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo assets_url(); ?>assets/c_portcss/custom.css?v=<?php echo APPVER ?>" rel="stylesheet"/>

<script src='<?php echo assets_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js?v=<?php echo APPVER ?>'></script>


<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Vacations'); ?>
                <form>
                    <div class="form-group d-flex justify-content-end">

                        <div class="full-calender-languages">
                            <select id='lang-selector' class="custom-select form-control"></select>
                        </div>
                    </div>
                </form>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </h5>
            <!-- Notification -->
            <div class="alert"></div>
        </div>
        <div class="card-body">


            <div id='vacations' class="calendar"></div>
        </div>
    </div>
</div>

<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?php echo APPVER ?>"></script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?php echo APPVER ?>"></script>
<script src='<?php echo assets_url(); ?>assets/c_portjs/main.js?v=<?php echo APPVER ?>'></script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/locale-all.js?v=<?php echo APPVER ?>"></script>