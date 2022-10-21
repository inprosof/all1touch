<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="card card-block">
	<div id="notify" class="alert alert-success" style="display:none;">
		<a href="#" class="close" data-dismiss="alert">&times;</a>

		<div class="message"></div>
	</div>
	<div class="card card-block">


		<form method="post" id="data_form" class="card-body">

			<h5><?php echo $this->lang->line('Add') . ' Tipo de Documento Com Série'; ?></h5>
			<hr>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"
					   for="currency">Tipo de Documento</label>
				<div class="col-sm-2">
					<select name="typ_doc" class="form-control b_input">
						<?php foreach ($typ_docs as $row) {
							echo '<option value="' . $row['id'] . '">' . $row['type'] . " - ". $row['description'];  '</option>';
						} ?>
					</select>
				</div>
			</div>
			
			
			<div id="saman-row">
				<table class="table-responsive tfr my_stripe">
					<thead>
					<tr class="item_header bg-gradient-directional-blue white">
						<th width="31%" class="text-center">Serie</th>
						<th width="20%" class="text-center"><?php echo $this->lang->line('Preset') ?></th>
						<th width="10%" class="text-center"><?php echo $this->lang->line('Copys') ?></th>
						<th width="17%" class="text-center"><?php echo $this->lang->line('Class Ativ') ?>.</th>
						<th width="10%" class="text-center"><?php echo $this->lang->line('Warehouse') ?></th>
						<th width="17%" class="text-center"><?php echo $this->lang->line('Type Com') ?>.</th>
						<th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
					</tr>
					</thead>
					<tbody>
					<tr class="last-item-row sub_c">
						<td class="add-row">
							<button type="button" class="btn btn-success" aria-label="Left Align"
									id="addserie">
								<i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
							</button>
						</td>
						<td colspan="7"></td>
					</tr>
					<tr class="sub_c" style="display: table-row;">
						<td colspan="2"></td>
						<td class="reverse_align" colspan="6"><input type="submit"
															 class="btn btn-success sub-btn btn-lg"
															 value="<?php echo $this->lang->line('Add') ?> "
															 id="submit-data" data-loading-text="Creating...">
															 

						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<input type="hidden" value="settings/irs_typ" id="action-url">
			<input type="hidden" value="new_i" id="inv_page">
			<input type="hidden" value="0" name="counter" id="ganak">
			<input type="hidden" value="search_series" id="bill_serie">
			<input type="hidden" value="search_activi" id="bill_activ">
			<input type="hidden" value="search_copys" id="bill_copys">
			<input type="hidden" value="search_wareh" id="bill_wareh">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>