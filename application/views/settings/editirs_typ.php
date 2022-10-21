<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="card card-block">
	<div class="card-header">
		<h5><?php echo $this->lang->line('Edit') ?> Tipo de Documento Com Série</h5>
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
		<input type="hidden" name="did" value="<?php echo $irs_typ['id']; ?>">
		<div class="form-group row">
			<label class="col-sm-3 col-form-label"
				   for="currency">Tipo de Documento</label>
			<div class="col-sm-8">
				<select name="typ_doc" id="typ_doc" class="form-control margin-bottom b_input">
					<option value="<?php echo $irs_typ['typ_doc'] ?>">--<?php echo $irs_typ['nameused'] ?>--</option>
					<?php foreach ($typ_docs as $row) {
						echo '<option value="' . $row['id'] . '">' . $row['type'] . " - ". $row['description'];  '</option>';
					} ?>
				</select>
			</div>
		</div>

		<div id="saman-row">
			<table id="last-item-row" class="table-responsive tfr my_stripe">
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
				<?php $i = 0;
				foreach ($series as $row) {
					echo '<tr >
						<td><input type="text" class="form-control text-center" name="serie_n[]" id="serie_n-' . $i . '" value="' . $row['seriename'] . '">
						</td>
						<td><select name="serie_pred[]" id="serie_pred-' . $i . '" class="form-control b_input">
								<option value="' . $row['predf'] . '">--' . $row['predfname'] . '--</option>
								<option value="0">'.$this->lang->line('No').'</option>
								<option value="1">'.$this->lang->line('Yes').'</option>
							</select>
						</td>
						<td><input type="text" class="form-control text-center" name="serie_copy[]" id="serie_copy-' . $i . '" value="' . $row['copyname'] . '">
						</td>
						<td><input type="text" class="form-control text-center" name="serie_class[]" id="serie_class-' . $i . '" value="' . $row['claname'] . '">
						</td>
						<td><input type="text" class="form-control text-center" name="serie_wareh[]" id="serie_wareh-' . $i . '" value="' . $row['warehousename'] . '">
						</td>
						<td><select name="serie_type_com[]" id="serie_type_com-' . $i . '" class="form-control b_input">
								<option value="' . $row['type_com'] . '">--' . $row['type_comname'] . '--</option>
								<option value="0">Web Service</option>
								<option value="1">SAFT</option>
								<option value="2">Sem Comunicação</option>
								<option value="3">Manual</option>
							</select>
						</td>
						<td class="text-center"><button type="button" data-rowid="'.$i.'" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
						<input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['serie'] . '">
						<input type="hidden" class="pdIn" name="pactid[]" id="pactid-' . $i . '" value="' . $row['cla'] . '">
						<input type="hidden" class="pdIn" name="pcopyid[]" id="pcopyid-' . $i . '" value="' . $row['copy'] . '">
						<input type="hidden" class="pdIn" name="pwareid[]" id="pwareid-' . $i . '" value="' . $row['warehouse'] . '">
						'; 
						$i++;
					} ?>
					
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
															 value="<?php echo $this->lang->line('Update') ?> "
															 id="submit-data" data-loading-text="Creating...">
															 

						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<input type="hidden" value="settings/edirs_typ" id="action-url">
		<input type="hidden" value="new_i" id="inv_page">
		<input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
		<input type="hidden" value="search_series" id="bill_serie">
		<input type="hidden" value="search_activi" id="bill_activ">
		<input type="hidden" value="search_copys" id="bill_copys">
		<input type="hidden" value="search_wareh" id="bill_wareh">
	</form>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>

<script type="text/javascript"> $('.editdate').datepicker({
		autoHide: true,
		format: '<?php echo $this->config->item('dformat2'); ?>'
	});

	window.onload = function () {
		//billUpyog();
	};
</script>