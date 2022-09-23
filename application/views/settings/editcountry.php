<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card card-block">
		<div class="card-header">
            <h5><?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Country') ?></h5>
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
        <form method="post" id="data_form" class="card-body">
			<input type="hidden" name="did" value="<?php echo $country['id']; ?>">
			<div class="form-group row">

				<label class="col-sm-3 col-form-label" for="Name"><?php echo $this->lang->line('Name') ?></label>

				<div class="col-sm-8">
					<input type="text" placeholder="Name"
						   class="form-control margin-bottom b_input" name="name" value="<?php echo $country['name'] ?>">
				</div>
			</div>
			<div class="form-group row">

				<label class="col-sm-3 col-form-label" for="Prefix"><?php echo $this->lang->line('Prefix') ?></label>

				<div class="col-sm-8">
					<input type="text" placeholder="Prefix"
						   class="form-control margin-bottom b_input" name="prefix" value="<?php echo $country['prefix'] ?>">
				</div>
			</div>
			<div class="form-group row">
					<label class="col-sm-3 col-form-label"
						   for="currency"><?php echo $this->lang->line('Culturs') ?></label>
					<div class="col-sm-2">
						<select name="culturs" class="form-control b_input">
							<option value="<?php echo $country['cultur'] ?>">--<?php echo $country['culturname'] ?>--</option>
							<?php foreach ($culturs as $row) {
								echo '<option value="' . $row['id'] . '">' . $row['prefix'] . '</option>';
							} ?>
						</select>
					</div>
				</div>
			<div class="form-group row">

				<label class="col-sm-3 col-form-label" for="Inicial"><?php echo $this->lang->line('Indicativ') ?></label>

				<div class="col-sm-8">
					<input type="text" placeholder="Indicativ"
						   class="form-control margin-bottom b_input" name="indicat" value="<?php echo $country['indicat'] ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"
					   for="currency"><?php echo $this->lang->line('Member UE') ?></label>
				<div class="col-sm-2">
					<select name="memberue" class="form-control b_input">
						<option value="<?php echo $country['memberue'] ?>">--<?php echo $country['memberuename'] ?>--</option>
						<option value="0"><?php echo $this->lang->line('No') ?></option>
						<option value="1"><?php echo $this->lang->line('Yes') ?></option>
					</select>
				</div>
			</div>


			<div class="form-group row">

				<label class="col-sm-3 col-form-label"></label>

				<div class="col-sm-4">
					<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
						   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
					<input type="hidden" value="settings/edcountry" id="action-url">
				</div>
			</div>


		</form>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>

<script type="text/javascript"> $('.editdate').datepicker({
		autoHide: true,
		format: '<?php echo $this->config->item('dformat2'); ?>'
	});

	window.onload = function () {
		billUpyog();
	};
</script>