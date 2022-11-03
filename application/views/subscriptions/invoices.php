<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Subscriptions') ?> <a
                        href="<?php echo base_url('subscriptions/create') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a></h4>
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
            <div class="card-body">
                <div class="row">

                    <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
                    </div>

                </div>
                <hr>
                <table id="subs" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
						<th>Série</th>
                        <th>Nº</th>
						<th>Data Emissão</th>
                        <th>Cliente</th>
                        <th>Contribuinte</th>
						<th>Ilíquido</th>
						<th>Impostos</th>
						<th>Total Liq.</th>
						<th class="no-sort">Pago</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Subscription') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Série</th>
                        <th>Nº</th>
						<th>Data Emissão</th>
                        <th>Cliente</th>
                        <th>Contribuinte</th>
						<th>Ilíquido</th>
						<th>Impostos</th>
						<th>Total Liq.</th>
						<th class="no-sort">Pago</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Subscription') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="choise_type_convert" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Converter documento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<input type="hidden" id="convert-id" name="convert-id" value="">
				<input type="hidden" id="convert-type" name="convert-type" value="">
				<input type="hidden" id="convert-ext" name="convert-ext" value="0">
				<select class="form-control b_input required" id="doc-convert-type" name="doc-convert-type">
					<option value="0" data-url="customers_notes/convert"><i class='fa fa-pencil'></i>Nota de Débito</option>
					<option value="1" data-url="customers_notes/convert"><i class='fa fa-pencil'></i>Nota de Crédito</option>
					<option value="0" data-url="receipts/convert"><i class='fa fa-pencil'></i>Recibo</option>
				</select>
            </div>
			<h6 id="titulo_converters" name="titulo_converters"></h6>
			<table id="convertersview" name="convertersview" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%"></table>
            <div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-primary" id="convert-confirm">Converter Agora</button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="choise_docs_related" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
			<input type="hidden" id="relations-id" name="relations-id" value="">
			<input type="hidden" id="relations-type" name="relations-type" value="">
			<input type="hidden" id="relations-type_n" name="relations-type_n" value="">
			<input type="hidden" id="relations-ext" name="relations-ext" value="0">
            <div class="modal-header">
                <h4 class="modal-title">Documentos relacionados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
			<div class="modal-body">
                <h6 id="titulo_relationt" name="titulo_relationt"></h6>
				<table id="relationstview" name="relationsview" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%"></table>
				<h6 id="titulo_relationd" name="titulo_relationd"></h6>
				<table id="relationsdview" name="relationsview" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%"></table>
            </div>
            <div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
			</div>
		</div>
    </div>
</div>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Anular Documento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<label class='btn-blue' style="display: block;"><span class='fa fa-plus-circle'></span>
					<strong>Atenção:</strong> Esta ferramenta permite-lhe colocar um documento em estado anulado, caso cumpra as condições impostas pela Autoridade Tributária.<strong>Ao efetuar esta operação, irá ficar associado e responsabilizado pela operação perante as autoridades competentes.</strong>
				</label>
                <p>Caso já tenha comunicado à Autoridade Tributária o ficheiro SAF-T(PT) referente ao mês do documento que estiver a anular, terá que o voltar a exportar e submeter no eFatura.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
				<input type="hidden" id="object-tid" value="">
				<input type="hidden" id="object-tdraft" value="1">
                <input type="hidden" id="action-url" value="subscriptions/delete_i">
				<textarea class="summernote" name="justification_cancel" id="justification_cancel" rows="1"></textarea></div>
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Anular</button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="delete_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Apagar Documento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<label class='btn-blue' style="display: block;"><span class='fa fa-plus-circle'></span>
					<strong>Atenção:</strong> Esta ferramenta permite-lhe remover este documento por estar ainda em estado Rascunho.</strong>
				</label>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id2" value="">
				<input type="hidden" id="object-tid2" value="">
				<input type="hidden" id="object-tdraft2" value="0">
                <input type="hidden" id="action-url2" value="subscriptions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm2"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
        draw_data(start_date, end_date);
    });
	
	function draw_data(start_date = '', end_date = '') {
		$('#subs').DataTable({
			'processing': true,
			'serverSide': true,
			'stateSave': true,
			responsive: true,
			<?php datatable_lang();?>
			'order': [],
			'ajax': {
				'url': "<?php echo site_url('subscriptions/ajax_list')?>",
				'type': 'POST',
				'data': {
					'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
					start_date: start_date,
					end_date: end_date
				}
			},
			'rowCallback': function ( row, data, cell) {
				if(data.status == 'canceled'){
					$(row).css('background-color', ' rgba(255, 0, 39, 0.22)');
				}
			},
			'columnDefs': [
				{
					'targets': [0],
					'orderable': false,
				},
			],
			dom: 'Blfrtip',
			buttons: [
				{
					extend: 'excelHtml5',
					footer: true,
					exportOptions: {
						columns: [1, 2, 3, 4, 5]
					}
				}
			],
		});
	};

	$('#search').click(function () {
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		if (start_date != '' && end_date != '') {
			$('#subs').DataTable().destroy();
			draw_data(start_date, end_date);
		} else {
			alert("Date range is Required");
		}
	});
</script>