<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Manage POS Invoices') ?> <a
                        href="<?php echo base_url('pos_invoices/create') ?>"
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
                <table id="invoices" class="table table-striped table-bordered  dataex-res-constructor">
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
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
					<tfoot>
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
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					</tfoot>
                </table>
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
                <div class="alert alert-info" id="alert-info-text">
                    <strong>Atenção:</strong> Esta ferramenta permite-lhe colocar um documento em estado anulado, caso
                    cumpra as condições impostas pela Autoridade Tributária.<strong>Ao efetuar esta operação, irá ficar
                        associado e responsabilizado pela operação perante as autoridades competentes.</strong>
                </div>
                <p>Caso já tenha comunicado à Autoridade Tributária o ficheiro SAF-T(PT) referente ao mês do documento
                    que estiver a anular, terá que o voltar a exportar e submeter no eFatura.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="object-tid" value="">
                <input type="hidden" id="object-tdraft" value="1">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <textarea class="summernote" name="justification_cancel" id="justification_cancel" rows="1"></textarea>
            </div>
            <div class="row" id="centerButton">
                <div class="col-sm-12">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Anular
                    </button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
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
                    <strong>Atenção:</strong> Esta ferramenta permite-lhe remover este documento por estar ainda em
                    estado Rascunho.</strong>
                </label>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id2" value="">
                <input type="hidden" id="object-tid2" value="">
                <input type="hidden" id="object-tdraft2" value="0">
                <input type="hidden" id="action-url2" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm2"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 50,
            tooltip: false,
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
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('pos_invoices/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date
                    }
                },
				'rowCallback': function (row, data, cell) {
					if (data.status == 'canceled') {
						$(row).css('background-color', ' rgba(255, 0, 39, 0.22)');
					} else if (data.status == 'draft') {
						$(row).css('background-color', ' rgba(250, 255, 70, 0.8)');
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
                            columns: [2, 3, 4, 5, 6, 7]
                        }
                    }
                ],
            });
        }

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });
</script>