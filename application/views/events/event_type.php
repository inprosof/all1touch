<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Event Type') ?></h5>
                <hr>

                <div class="row form-group">
                        <label class="col-md-3 control-label"
                               for="name"><?php echo $this->lang->line('Name') ?></label>
                        <div class="col-md-8">
                            <input id="name" name="name" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                <div class="form-group row">
					<label class="col-sm-3 col-form-label"
						   for="currency"><?php echo $this->lang->line('Paid?') ?></label>
					<div class="col-sm-2">
						<select name="paid" class="form-control b_input">
							<option value="1"><?php echo $this->lang->line('Yes') ?></option>
							<option value="0"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="events/addeventstype" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>