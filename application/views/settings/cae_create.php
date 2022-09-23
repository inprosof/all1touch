<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card card-block">
		<div class="card-header">
            <h5><?php echo $this->lang->line('Add') . ' C.A.E'?></h5>
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
			<hr>
			<div class="form-group row">

				<label class="col-sm-2 col-form-label"
					   for="tcod">Código</label>

				<div class="col-sm-6">
					<input type="text" placeholder="Cae Cod"
						   class="form-control margin-bottom  required" name="tcod">
				</div>
			</div>
			<div class="form-group row">

				<label class="col-sm-2 col-form-label"
					   for="tname">Designação</label>

				<div class="col-sm-6">
					<input type="text" placeholder="Cae Des"
						   class="form-control margin-bottom  required" name="tname">
				</div>
			</div>
			
			<div class="form-group row">

				<label class="col-sm-2 col-form-label"></label>

				<div class="col-sm-4">
					<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
						   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
					<input type="hidden" value="settings/caes_new" id="action-url">
				</div>
			</div>


		</form>
	</div>
</div>

