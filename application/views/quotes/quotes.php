<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Gestão de <?php echo $this->lang->line('Quotes') ?> <a
                        href="<?php echo base_url('quote/create_typ?typ=3') ?>"
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

                    <div class="col-md-2"><?php echo $this->lang->line('Quote Date') ?></div>
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
                <table id="quotes" class="table table-striped table-bordered zero-configuration">
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
						<th>Conciliado</th>
                        <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
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
						<th>Conciliado</th>
                        <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
</div>
<div id="delete_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apagar Documento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                <input type="hidden" id="action-url2" value="quote/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm2"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
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
                <input type="hidden" id="action-url" value="quote/delete_i">
				<textarea class="summernote" name="justification_cancel" id="justification_cancel" rows="1"></textarea></div>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="choise_type_convert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Converter documento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
				<input type="hidden" id="convert-id" name="convert-id" value="">
				<input type="hidden" id="convert-type" name="convert-type" value="">
				<input type="hidden" id="convert-ext" name="convert-ext" value="0">
				<select class="form-control b_input required" id="object-id-doc-convert-type" name="object-id-doc-convert-type">
					<option data-url="customers_notes/convert">Nota de Débito</option>
					<option data-url="customers_notes/convert">Nota de Crédito</option>
					<option data-url="receipts/convert">Recibo</option>
				</select>
            </div>
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
            <div class="modal-header">
                <h4 class="modal-title">Documentos relacionados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
			
			<div class="modal-body">
                <h6>O documento <?php echo $invoice['irs_type_n'].' '.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid'] ?> teve origem nos documentos abaixo (Está conciliado com)</h6>
				<div class="row">
					<table class="table table-striped">
						<?php if(is_array($docs_origem)) {
							$reicoun = count($docs_origem);
							if($reicoun > 0){
								echo "<thead>
									<tr>
										<th>Documento</th>
										<th>Série/Nº</th>
										<th>Data Emissão</th>
										<th>NIF/NIC</th>
										<th>Ilíquido</th>
										<th>Impostos</th>
										<th>Total Liq.</th>
										<th>".$this->lang->line('Settings')."</th>
									</tr>
								</thead>
								<tbody id='activity'>";
								foreach ($docs_origem as $row) {
									$tiiid = $row['id'];
									echo '<tr>';
									echo "<td><strong>".$row['tipo']."</strong></td>";
									echo "<td>".$row['serie_name'].'/'.$row['tid']."</td>";
									echo "<td>".$row['invoicedate']."</td>";
									echo "<td>".$row['tax_id']."</td>";
									echo "<td>".amountExchange($row['subtotal'], 0, $this->aauth->get_user()->loc)."</td>";
									echo "<td>".amountExchange($row['tax'], 0, $this->aauth->get_user()->loc)."</td>";
									echo "<td>".amountExchange($row['total'], 0, $this->aauth->get_user()->loc)."</td>";
									if($row['type_related'] == "0" || $row['type_related'] == "2"){
										if($row['draft'] == "0"){
											echo '<td><a href="'.base_url("invoices/view?id=$tiiid&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiid&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
										}else{
											echo '<td><a href="'.base_url("invoices/view?id=$tiiid&ty=1").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiid&ty=1") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
										}
									}else if($row['type_related'] == "1"){
										echo '<td><a href="'.base_url("invoices/view?id=$tiiid&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiid&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
									}else if($row['type_related'] == "3"){
										echo '<td><a href="'.base_url("quote/view?id=$tiiid&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("quote/printquote?id=$tiiid&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
									}
									echo '</tr>';
								}
								echo "</tbody>";
							}else
							{
								echo '<thead></thead><tbody id="activity"><tr><td>Não existe nenhum documento que tivesse origem neste documento!</td><tr></tbody>';
							}
							
						}else {
							echo '<thead></thead><tbody id="activity"><tr><td>Não existe nenhum documento que tivesse origem neste documento!</td><tr></tbody>';
						}?>
					</table>
				</div>
				<h6>O documento <?php echo $invoice['irs_type_n'].' '.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid'] ?> deu origem aos documentos abaixo (Foi conciliado com)</h6>
				<div class="row">
					<table class="table table-striped">
						<?php if(is_array($docs_deu_origem)) {
							$reicoun2 = count($docs_deu_origem);
							if($reicoun2 > 0){
								echo "<thead>
									<tr>
										<th>Documento</th>
										<th>Série/Nº</th>
										<th>Data Emissão</th>
										<th>NIF/NIC</th>
										<th>Ilíquido</th>
										<th>Impostos</th>
										<th>Total Liq.</th>
										<th>".$this->lang->line('Settings')."</th>
									</tr>
								</thead>
								<tbody>";
								foreach ($docs_deu_origem as $row) {
									$tiiide = $row['id'];
									echo '<tr>';
									echo "<td><strong>".$row['tipo']."</strong></td>";
									echo "<td>".$row['serie_name'].'/'.$row['tid']."</td>";
									echo "<td>".$row['invoicedate']."</td>";
									echo "<td>".$row['tax_id']."</td>";
									echo "<td>".amountExchange($row['subtotal'], 0, $this->aauth->get_user()->loc)."</td>";
									echo "<td>".amountExchange($row['tax'], 0, $this->aauth->get_user()->loc)."</td>";
									echo "<td>".amountExchange($row['total'], 0, $this->aauth->get_user()->loc)."</td>";
									if($row['type_related'] == "0" || $row['type_related'] == "2"){
										if($row['draft'] == "0"){
											echo '<td><a href="'.base_url("invoices/view?id=$tiiide&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiide&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
										}else{
											echo '<td><a href="'.base_url("invoices/view?id=$tiiide&ty=1").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiide&ty=1") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
										}
									}else if($row['type_related'] == "1"){
										echo '<td><a href="'.base_url("invoices/view?id=$tiiide&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("invoices/printinvoice?id=$tiiide&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
									}else if($row['type_related'] == "3"){
										echo '<td><a href="'.base_url("quote/view?id=$tiiide&ty=0").'" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
													<a href="' . base_url("quote/printquote?id=$tiiide&ty=0") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
									}
									
									echo '</tr>';
								}
								echo "</tbody>";
							}else{
								echo '<thead></thead><tbody id="activity"><tr><td>Não existe nenhum documento que desse origem a este documento!</td><tr></tbody>';
							}
						}else {
							echo '<thead></thead><tbody id="activity"><tr><td>Não existe nenhum documento que desse origem a este documento!</td><tr></tbody>';
						}?>
					</table>
				</div>
            </div>
            <div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 50,
            tooltip:false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#quotes').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('quote/ajax_list?ty=0')?>",
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
                $('#quotes').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>