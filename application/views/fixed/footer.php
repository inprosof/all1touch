</div>
</div>
</div>
<!-- BEGIN VENDOR JS-->
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', ".view_task", function (e) {
            e.preventDefault();
            var actionurl = 'tools/view_task';
            var id = $(this).attr('data-id');
            $('#task_model').modal({backdrop: 'static', keyboard: false});
            $.ajax({
                url: baseurl + actionurl,
                type: 'POST',
                data: {'tid': id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                dataType: 'json',
                success: function (data) {
                    $('#description').html(data.description);
                    $('#task_title').html(data.name);
                    $('#employee').html(data.employee);
                    $('#assign').html(data.assign);
                    $('#priority').html(data.priority);
                }
            });

        });
    });

    $(document).ready(function () {
        $(document).on('click', ".view_note", function (e) {
            e.preventDefault();
            var actionurl = 'tools/view_note';
            var id = $(this).attr('data-id');
            $('#task_note').modal({backdrop: 'static', keyboard: false});
            $.ajax({
                url: baseurl + actionurl,
                type: 'POST',
                data: {'tid': id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                dataType: 'json',
                success: function (data) {
                    $('#description').html(data.content);
                    $('#task_title').html(data.title);
                    $('#employee').html(data.employee);
                    $('#date_ini').html(data.date_ini);
                    $('#date_edit').html(data.date_last);
                }
            });

        });
    });


    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
    $('[data-toggle="datepicker"]').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');

	$('.date30_plus').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30_plus').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d'))))); ?>');
</script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="<?php echo assets_url() ?>app-assets/js/core/app-menu.js"></script>
<script src="<?php echo assets_url() ?>app-assets/js/core/app.js"></script>
<script type="text/javascript"
        src="<?php echo assets_url() ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="<?php echo assets_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo assets_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
<script src="<?php echo assets_url('assets/myjs/custom.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/basic.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/control.js') . APPVER; ?>"></script>
<script src="<?php echo assets_url('assets/myjs/components.js') ?>"></script>
<script type="text/javascript">
    $.ajax({
        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }
    });

    $.ajax({
        url: baseurl + 'manager/pmsverify',
        dataType: 'json',
        success: function (data) {
            $('#messagecount').html(data.tcount);
            $('#messagecount2').html(data.tcount);
        },
        error: function (data) {
            $('#response').html('Error')
        }
    });


</script>


</body>
</html>
