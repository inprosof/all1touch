<article class="content">
    <div class="card card-block">
		<div class="card-header">
            <h5><?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Holiday') ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
			<input type="hidden"
				   name="did"
				   value="<?php echo $hday['id'] ?>">

			<div class="form-group row">

				<label class="col-sm-3 control-label"
					   for="from"><?php echo $this->lang->line('From Date') ?></label>

				<div class="col-sm-4">
					<input type="text" class="form-control b_input required"
						   placeholder="Start Date" name="from"
						   data-toggle="datepicker" autocomplete="false">
				</div>
			</div>
			<div class="form-group row">

				<label class="col-sm-3 control-label"
					   for="todate"><?php echo $this->lang->line('To Date') ?></label>

				<div class="col-sm-4">
					<input type="text" class="form-control b_input required"
						   placeholder="End Date" name="todate"
						   data-toggle="datepicker" autocomplete="false">
				</div>
			</div>

			<div class="form-group row">

				<label class="col-sm-3 col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>

				<div class="col-sm-8">
					<input type="text" placeholder="Note Title"
						   class="form-control margin-bottom b_input required" name="note"
						   value="<?php echo $hday['val3'] ?>">
				</div>
			</div>


			<div class="form-group row">

				<label class="col-sm-3 col-form-label"></label>

				<div class="col-sm-4">
					<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
						   value="<?php echo $this->lang->line('Edit') ?>" data-loading-text="Adding...">
					<input type="hidden" value="employee/editholiday" id="action-url">
				</div>
			</div>


		</form>
    </div>
</article>