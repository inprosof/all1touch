<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Add') . ' '.$this->lang->line('Type Docs Tax'); ?></h5>
                <hr>
				<div class="form-group row">

                    <label class="col-sm-3 col-form-label" for="Type"><?php echo $this->lang->line('Type') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Type"
                               class="form-control margin-bottom b_input" name="type">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-3 col-form-label" for="Description"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Description"
                               class="form-control margin-bottom b_input" name="description">
                    </div>
                </div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label"
						   for="currency"><?php echo $this->lang->line('Used') ?></label>
					<div class="col-sm-2">
						<select name="used" class="form-control b_input">
							<option value="0">Financeiro</option>
							<option value="1">Stocks</option>
							<option value="2">Outros</option>
						</select>
					</div>
				</div>

                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/irs_typ_doc" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>