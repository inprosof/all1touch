<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Event Type') ?>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
        </div>
        <div class="card-body">

            <form method="pos   t" id="data_form" class="card-body">
                <input type="hidden"
                       name="did"
                       value="<?php echo $evtype['id'] ?>">

                <div class="row form-group">
                    <label class="col-sm-2 control-label"
                           for="name"><?php echo $this->lang->line('Name') ?></label>
                    <div class="col-sm-6">
                        <input id="name" name="name" type="text" class="form-control input-md"
                               value="<?php echo $evtype['name'] ?>"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Paid?') ?></label>
                    <div class="col-sm-6">
                        <select name="paid" class="form-control b_input">
                            <option value="0" <?php if ($evtype['paid'] == 0) echo "selected"; ?> ><?php echo $this->lang->line('No') ?></option>
                            <option value="1" <?php if ($evtype['paid'] == 1) echo "selected"; ?> ><?php echo $this->lang->line('Yes') ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Edit') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="events/editeventtype" id="action-url">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>