<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('ProductSales') ?>
            </h5>
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
				<form method="post" id="product_action" action="<?php echo base_url('pos_invoices/exportpdf?typ=Extrato Vendas'); ?>" class="form-horizontal">
					<input type="submit" class="btn btn-primary btn-sm" value="Exportar PDF" data-loading-text="Calculating...">
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
				</form>
                <hr>
                <table id="invoices_rp" class="table table-striped table-bordered dataex-res-constructor">
                    <thead>
                    <tr>
                        <th>Série</th>
                        <th>Nº</th>
                        <th>Data Emissão</th>
                        <th>Cliente</th>
                        <th>Contribuinte</th>
                        <th>Qtd</th>
                        <th>Ilíquido</th>
                        <th>Impostos</th>
                        <th>Total Liq.</th>
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
						<th id="grand_total_1"></th>
						<th id="grand_total_2"></th>
						<th id="grand_total_3"></th>
						<th id="grand_total_4"></th>
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

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="pos_invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$("#export_pdf").click(function (e) {
		$.ajax({
            url: "<?php echo site_url('pos_invoices/exportpdf')?>",
            type: 'POST',
            data: 'start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val()+'&typ='+$('#typ_export').val() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'html'
            /*success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            }*/
        });
    });
	
	$(document).ready(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        draw_data(start_date, end_date);
    });
	
	$('#search').click(function () {
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		if (start_date != '' && end_date != '') {
			$('#invoices_rp').DataTable().destroy();
			draw_data(start_date, end_date);
		} else {
			alert("Date range is Required");
		}
	});
	
    function draw_data(start_date = '', end_date = '') {
		var valmulti = 0;
		var valloc = 0;
		var valqtd = 0;
		var valsubtotal = 0;
		var valtaxs = 0;
		var valtotals = 0;
		$('#invoices_rp').DataTable({
			'processing': true,
			'serverSide': true,
			'stateSave': true,
			responsive: true,
			<?php datatable_lang();?>
		
			'order': [],
			'ajax': {
				'url': "<?php echo site_url('pos_invoices/extended_ajax_list')?>",
				'type': 'POST',
				'data': {
					'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
					start_date: start_date,
					end_date: end_date
				}
			},
			'rowCallback': function (row, data, cell) {
				valmulti = data.multi;
				valloc = data.loc;
				valqtd += parseFloat(data.qty);
				valsubtotal += parseFloat(data.subtotal);
				valtaxs += parseFloat(data.tax);
				valtotals += parseFloat(data.total);
				//var subtot = amountExchange(valsubtotal, valmulti, valloc);
				//var subtax = amountExchange(valtaxs, valmulti, valloc);
				//var subtots = amountExchange(valtotals, valmulti, valloc);
				$("#grand_total_1").html(valqtd);
				$("#grand_total_2").html(valsubtotal.toFixed(2)+'€');
				$("#grand_total_3").html(valtaxs.toFixed(2)+'€');
				$("#grand_total_4").html(valtotals.toFixed(2)+'€');
			},
			'columnDefs': [
				{
					'targets': [0],
					'orderable': false,
				},
			],
			dom: 'Blfrtip',
			pageLength: 10,
			lengthMenu: [10, 20, 50, 100, 200, 500],
			buttons: [
				{
					extend: 'excelHtml5',
					footer: true,
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					}
				},
				{
					extend: 'csvHtml5',
					title: 'CSV',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					}
				},
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'pdfHtml5',
					title: 'Extrato de Vendas',
					footer: true,
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
					}
				},
				{ 
					extend: 'colvis', 
					text: '+ Colunas' ,
					exportOptions: {
						columns: ':visible'
					}
				}
			],
		});
	}
</script>