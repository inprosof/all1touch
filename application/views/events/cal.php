<link rel="stylesheet" type="text/css"
      href="<?php echo assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?php echo APPVER ?>">
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrapValidator.min.css?v=<?php echo APPVER ?>" rel="stylesheet"/>
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css?v=<?php echo APPVER ?>"
      rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo assets_url(); ?>assets/c_portcss/custom.css?v=<?php echo APPVER ?>" rel="stylesheet"/>

<script src='<?php echo assets_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js?v=<?php echo APPVER ?>'></script>


<div class="content-body">
    <div class="card">

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <!-- Notification -->
                <div class="alert"></div>
                <form class="col-3">
                    <div class="form-group d-flex justify-content-between">
                        <label class="col-form-label pr-2"><?php echo $this->lang->line('Language:') ?></label>
                        <div class="full-calender-languages">
                            <select id='lang-selector' class="custom-select form-control"></select>
                        </div>
                    </div>
                </form>
                <div id="calendar" name="calendar" class="calendar"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only"><?php echo $this->lang->line('Close') ?></span></button>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="title"><?php echo $this->lang->line('Add Event') ?></label>

                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="title"><?php echo $this->lang->line('Title') ?></label>
                        <div class="col-md-8">
                            <input id="title" name="title" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="description"><?php echo $this->lang->line('Description') ?></label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo $this->lang->line('Event Type') ?></label>
                        <div class="col-md-8">
                            <select name="event_type" id="event_type" class="form-control">
                                <?php foreach ($eventTypes  as $eventType) {?>
                                <option value="<?php echo $eventType->id ?>"><?php echo $eventType->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
					<div class="form-group row">
						<label class="col-md-4 control-label"
							   for="color"><?php echo $this->lang->line('Repeat?') ?></label>
						<div class="col-md-8">
							<select name="event_repeat" id="event_repeat" class="form-control">
								<option value="0"><?php echo $this->lang->line('Not Repeat') ?></option>
								<option value="1"><?php echo $this->lang->line('Every Days') ?></option>
								<option value="2"><?php echo $this->lang->line('Every Weaks') ?></option>
								<option value="3"><?php echo $this->lang->line('Every Months') ?></option>
								<option value="4"><?php echo $this->lang->line('Every Years') ?></option>
							</select>
						</div>
					</div>
					<div class="form-group row" >
						<label class="col-md-4 control-label"
							   for="color"><?php echo $this->lang->line('Associated?') ?></label>
						<div class="col-md-8">
							<select name="event_associated" id="event_associated" class="form-control">
								<option value="0" data-type="0"><?php echo $this->lang->line('No') ?></option>
								<option value="1" data-type="1"><?php echo $this->lang->line('Yes') ?></option>
							</select>
						</div>
					</div>
					<div class="row associate">
						<label class="col-md-4 control-label"
							   for="color"><?php echo $this->lang->line('Employee') ?></label>
						<div class="col-md-8">
							<select name="employee_id" id="employee_id" class="form-control">
								<?php foreach ($employees as $employee): ?>
									<option value="<?php echo $employee['id'] ?>"><?php echo $employee['name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo $this->lang->line('Color') ?></label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly"/>
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo 'Start Date' ?></label>
                        <div class="col-md-8">
                            <input disabled type="text" id="start_date" name="start_date" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo 'End Date' ?></label>
                        <div class="col-md-8">
                            <input disabled type="text" id="end_date" name="end_date" class="form-control" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?php echo APPVER ?>"></script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?php echo APPVER ?>"></script>
<script src="<?php echo assets_url() ?>app-assets/vendors/js/extensions/locale-all.js?v=<?php echo APPVER ?>"></script>
<script src='<?php echo assets_url(); ?>assets/c_portjs/main.js?v=<?php echo APPVER ?>'></script>
<script>
	$(document).ready(function (){
        if($('select[name="event_associated"]').find('option:selected').data('type') !== 1){
            $('.associate').removeClass('hidden')
        }else{
            $('.associate').addClass('hidden')
			
		}
    })
    $('select[name="event_associated"]').change(function (){
        let selectedCategoryType = $(this).find('option:selected').data('type')
        $('.associate').addClass('hidden')
        if(selectedCategoryType == 1){
            $('.associate').removeClass('hidden')
        }
    })
</script>

