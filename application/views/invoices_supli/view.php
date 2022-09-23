<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="invoice-template" class="card-body">
                <div class="row">
					
                    <div class="">
						<?php
                        $validtoken = hash_hmac('ripemd160', $invoice['iid'], $this->config->item('encryption_key'));
                        if ($invoice['status'] != 'canceled') { ?>
							<div class="title-action">
							<img src="<?php $loc = location($invoice['loc']); echo base_url('userfiles/company/' . $loc['logo']) ?>"
									 class="img-responsive" style="max-height: 80px;">
							
							<?php if ($invoice['status'] != 'paid') {
							echo '<a href="edit?id=' . $invoice['iid'].'" class="btn btn-warning mb-1" ';
							if($this->aauth->get_user()->roleid == 5 || $this->aauth->premission(53) || $this->aauth->get_user()->roleid == 7) 
								echo 'disabled';
							echo '><i class="fa fa-pencil" ></i>'.$this->lang->line('Edit Invoice').'</a>';
							}?>
							
							<a href="<?php echo base_url('billing/viewsupli?id=' . $invoice['iid'] . '&token=' . $validtoken); ?>" class="btn btn-blue-grey mb-1"><i
										class="fa fa-globe"></i><?php echo $this->lang->line('Preview')?></a>
										
							<!--<a href="#pop_model" data-toggle="modal" data-remote="false"
							   class="btn btn-large btn-cyan mb-1" title="Change Status"
							<?php /*if ($this->aauth->get_user()->roleid < 5 && ($invoice['status'] == 'paid' || $invoice['status'] == 'canceled')) echo 'disabled' ?>><span class="fa fa-retweet"></span> <?php echo $this->lang->line('Change Status') ?></a>
							<a href="#cancel-bill" class="btn btn-danger mb-1" id="cancel-bill" <?php if ($this->aauth->get_user()->roleid < 5 || $invoice['status'] == 'paid' || $invoice['status'] == 'canceled') echo 'hidden' ?>><i
										class="fa fa-minus-circle"> </i> <?php echo $this->lang->line('Cancel')*/ ?>
							</a>-->
							<div class="btn-group ">
								<button type="button" class="btn btn-primary mb-1 btn-min-width dropdown-toggle"
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
											class="icon-anchor"></i> <?php echo $this->lang->line('Extra') ?>
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item"
									   href="<?php echo base_url() . 'invoices_supli/delivery?id=' . $invoice['iid']; ?>"><?php echo $this->lang->line('Delivery Note') ?></a>
									<div class="dropdown-divider"></div>
								</div>
							</div>
							<?php 
								/*if ($invoice['multi'] > 0) {
									echo '<div class="badge bg-blue text-xs-center mt-2 white">' . $this->lang->line('Payment currency is different') . '</div>';
								}*/
								} else {
									echo '<h2 class="btn btn-oval btn-danger">ANULADA</h2>';
								}?>
								<div class="btn-group ">
									<button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
											data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
												class="fa fa-print"></i> <?php echo $this->lang->line('Print') ?>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item"
										   href="<?php echo base_url('invoices_supli/printinvoice?id=' . $invoice['iid'] . '&ty=0&token=' . $validtoken); ?>"><?php echo $this->lang->line('Print') ?></a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item"
										   href="<?php echo base_url('invoices_supli/printinvoice?id=' . $invoice['iid'] . '&ty=0&token=' . $validtoken); ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

									</div>
								</div>
							</div>
                    </div>
                </div>

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active show" id="base-tab1" data-toggle="tab"
						   aria-controls="tab1" href="#tab1" role="tab"
						   aria-selected="true">Detalhes <?php echo $invoice['irs_type_n'] ?> <strong class="pb-1"> Nº<?php echo $invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid']; ?></strong></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
						   href="#tab2" role="tab"
						   aria-selected="false">Documentos relacionados</a>
					</li>
					  <li class="nav-item">
						<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
						   href="#tab3" role="tab"
						   aria-selected="false">Histórico do Documento</a>
					</li>
				</ul>
				
				<div class="tab-content px-1 pt-1">
                    <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
						<!--/ Invoice Company Details -->
						<div class="table-responsive col-sm-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Enc./Orç.</th>
										<th>Refª Cliente</th>
										<th>Moeda</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td><?php echo $invoice['ref_enc_orc']; ?></td>
										<td><?php echo $invoice['refer']; ?></td>
										<td><?php echo $invoice['multiname']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Invoice Customer Details -->
						<div id="invoice-customer-details" class="row pt-2">
							<div class="col-md-6 col-sm-12 text-xs-center text-md-left">
								<ul class="px-0 list-unstyled">
									<li class="text-bold-800"><li>Código: <?php echo $invoice['csd']?></li><a href="<?php echo base_url('customers/view?id=' . $invoice['cid']) ?>"><strong
											   class="invoice_a"><?php echo $invoice['name'] . '</strong></a></li><li>' . $invoice['company'] . '</li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' . $invoice['country'] . '</li><li>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '</li><li>' . $this->lang->line('Email') . ': ' . $invoice['email'] . '</li>';
										if (CUSTOM) {
											$c_custom_fields = $this->custom->view_fields_data($invoice['cid'], 1, 1);
											foreach ($c_custom_fields as $row) {
											if ($row['f_type'] == 'text') {
												echo '  <li>' . $row['name'] . ': ' . $row['data'].'</li>';
											}else if ($row['f_type'] == 'check') {
												if($row['data'] == 'on')
													echo '  <li>' . $row['name'] . ': Sim' .'</li>';
												else{
													echo '  <li>' . $row['name'] . ': Não' .'</li>';
												}
											}else if ($row['f_type'] == 'textarea') {
													echo '  <li>' . $row['name'] . ': ' . $row['data'].'</li>';
												}
											}
										}?>
								</ul>

							</div>
							<div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
								<?php echo '<p><span class="text-muted">' . $this->lang->line('Invoice Date') . '  :</span> ' . dateformat($invoice['invoicedate']) . '</p> <p><span class="text-muted">' . $this->lang->line('Due Date') . ' :</span> ' . dateformat($invoice['invoiceduedate']) . '</p>  <p><span class="text-muted">' . $this->lang->line('Terms') . ' :</span> ' . $invoice['termtit'] . '</p><p><span class="text-muted">Série :</span> ' . $invoice['serie_name'] . '</p>';
								?>
							</div>
						</div>
						<!--/ Invoice Customer Details -->

						<!-- Invoice Items Details -->
						<div id="invoice-items-details" class="pt-2">
							<div class="row">
								<div class="table-responsive col-sm-12">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th><?php echo $this->lang->line('Description') ?></th>
												<th class="text-xs-left">Preço</th>
												<th class="text-xs-left">Qtd.</th>
												<th class="text-xs-left"><?php echo $this->lang->line('Discount') ?> %</th>
												<th class="text-xs-left">Imposto</th>
												<th class="text-xs-left">Total Líquido</th>
											</tr>
											</thead>
											<tbody>
											<?php 
												$c = 1;
												$sub_t = 0;

												foreach ($products as $row) {
													$sub_t += $row['subtotal']+$row['totaldiscount'];
													$myArraytaxid = explode(";", $row['taxavals']);
													$valsum = 0;
													foreach ($myArraytaxid as $row1) {
														$valsum += $row1;
													}
													echo '<tr>
														<th scope="row">' . $c . '</th>
															<td><a href="'.base_url('products/edit?id='. $row['pid']).'"><strong class="invoice_a">'.$row['product'].'</strong></a></td>											
															<td>' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
															 <td>' . amountFormat_general($row['qty']) .' '. $row['unit'] . '</td>
															 <td>' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . ' (' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']) . ')</td>
															<td>' . amountExchange($valsum, $invoice['multi'], $invoice['loc']) . ' (' . $row['taxaperc'] . '%)</td>
															<td>' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . '</td>
														</tr>';
													echo '<tr><td colspan=8>' . $row['product_des'] . '</td></tr>';
													if (CUSTOM) {
														$p_custom_fields = $this->custom->view_fields_data($row['pid'], 5, 1);
														$z_custom_fields = '';
														foreach ($p_custom_fields as $row) {
														if ($row['f_type'] == 'text') {
															$z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
														}else if ($row['f_type'] == 'check') {
															if($row['data'] == 'on')
																$z_custom_fields .= $row['name'] . ': Sim<br>';
															else{
																$z_custom_fields .= $row['name'] . ': Não<br>';
															}
														}else if ($row['f_type'] == 'textarea') {
																$z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
															}
														}
														echo '<tr><td colspan="7">' . $z_custom_fields . '&nbsp;</td></tr>';
													}
													$c++;
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<p></p>
							<div class="row">
								<div class="col-md-7 col-sm-12 text-xs-center text-md-left">


									<div class="row">
										<div class="col-md-8">
											<p class="lead mt-1"><br><?php echo $this->lang->line('Note') ?>:</p>
											<code>
												<?php echo $invoice['notes'] ?>
											</code>
										</div>
										<div class="text-xs-center">
											<p><?php echo $this->lang->line('Authorized person') ?></p>
											<?php echo '<img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" alt="signature" class="height-100"/>
												<h6>(' . $employee['name'] . ')</h6>
												<p class="text-muted">' . user_role($employee['roleid']) . '</p>'; ?>
										</div>
										
										
									</div>
								</div>
								<div class="col-md-5 col-sm-12">
									<p class="lead"><?php echo $this->lang->line('Summary') ?></p>
									<div class="table-responsive">
										<table class="table">
											<tbody>
											<tr>
												<td><?php echo $this->lang->line('Sub Total') ?></td>
												<td class="text-xs-right"> <?php echo amountExchange($sub_t, 0, $this->aauth->get_user()->loc) ?></td>
											</tr>
											<tr>
												<td><?php echo $this->lang->line('Discount') ?> Comercial</td>
												<td class="text-xs-right"><?php echo amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) ?></td>
											</tr>
											
											<?php
												$arrtudo = [];
												foreach ($products as $row) {
													$myArraytaxname = explode(";", $row['taxaname']);
													$myArraytaxcod = explode(";", $row['taxacod']);
													$myArraytaxvals = explode(";", $row['taxavals']);
													for($i = 0; $i < count($myArraytaxname); $i++)
													{
														$jatem = false;
														for($oo = 0; $oo < count($arrtudo); $oo++)
														{
															if($arrtudo[$oo]['title'] == $myArraytaxname[$i])
															{
																$arrtudo[$oo]['val'] = ($arrtudo[$oo]['val']+$myArraytaxvals[$i]);
																$jatem = true;
																break;
															}
														}
														
														if(!$jatem)
														{
															$stack = array('title'=>$myArraytaxname[$i], 'val'=>$myArraytaxvals[$i]);
															array_push($arrtudo, $stack);
														}
													}
												}
												
												for($r = 0; $r < count($arrtudo); $r++)
												{
													echo "<tr>";
													echo "<td>".$arrtudo[$r]['title']."</td>";
													echo '<td class="text-xs-right">'.amountExchange($arrtudo[$r]['val'], 0, $this->aauth->get_user()->loc).'</td>';
													echo "</tr>";
												}
											?>
											<tr>
												<td><?php echo $this->lang->line('Shipping') ?></td>
												<td class="text-xs-right"><?php echo amountExchange($invoice['shipping'], 0, $this->aauth->get_user()->loc) ?></td>
											</tr>
											<tr>
												<td><?php echo $this->lang->line('Discount') ?> Financeiro</td>
												<td class="text-xs-right"><?php echo amountExchange($invoice['discount_rate'], $invoice['multi'], $invoice['loc']) ?></td>
											</tr>
											<tr>
												<td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
												<td class="text-bold-800 text-xs-right"> <?php echo amountExchange($invoice['total'], 0, $this->aauth->get_user()->loc) ?></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<!-- Invoice Footer -->
							<?php if(is_array($custom_fields)) {
								echo '<hr><div class="card">';
									foreach ($custom_fields as $row) {
										if ($row['f_type'] == 'text') { ?>
											<div class="row m-t-lg">
												<div class="col-md-10">
													<strong><?php echo $row['name'] ?></strong>
												</div>
												<div class="col-md-10">
													<?php echo $row['data'] ?>
												</div>
											</div>
										<?php }else if ($row['f_type'] == 'check') { ?>
											<div class="row m-t-lg">
												<div class="col-md-10">
													<strong><?php echo $row['name'] ?></strong>
												</div>
												<div class="col-md-10">
													<?php if($row['data'] == 'on') echo 'Sim'; else 'Não' ?>
												</div>
											</div>
										<?php }else if ($row['f_type'] == 'textarea') { ?>
											<div class="row m-t-lg">
												<div class="col-md-10">
													<strong><?php echo $row['name'] ?></strong>
												</div>
												<div class="col-md-10">
													<?php echo $row['data'] ?>
												</div>
											</div>
										<?php }
										} echo '</div>';
									}?>
					</div>
					
					<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
						<h4>Documentos relacionados</h4>
						<h6>O documento <?php echo $invoice['irs_type_n'].' '.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid'] ?> teve origem nos documentos abaixo (Está conciliado com)</h6>
						<div class="row">
							<table class="table table-striped">
								<thead>
								</thead>
								<tbody id="activity">
								<?php if(is_array($docs_origem)) {
									//echo '<tr><td></td></tr>';
								}else {
									echo '<tr><td>Não existe nenhum documento que desse origem a este documento!</td><tr>';
								}?>
								</tbody>
							</table>
						</div>
						<h6>O documento <?php echo $invoice['irs_type_n'].' '.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid'] ?> deu origem aos documentos abaixo (Foi conciliado com)</h6>
						<div class="row">
							<table class="table table-striped">
								<thead>
								</thead>
								<tbody id="activity">
								<?php if(is_array($docs_origem)) {
									//echo '<tr><td></td></tr>';
								}else {
									echo '<tr><td>Não existe nenhum documento que desse origem a este documento!</td><tr>';
								}?>
								</tbody>
							</table>
						</div>
						<hr>
						<h6>Outros Anexos</h6>
						<div class="row">
							<table class="table table-striped">
								<thead>
								</thead>
								<tbody id="activity">
								<?php foreach ($attach as $row) {

									echo '<tr><td><a data-url="' . base_url() . 'invoices_supli/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['iid'] . '" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
								} ?>

								</tbody>
							</table>
						</div>
						<div class="card">
							<pre>Allowed: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
							<br>
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="btn btn-success fileinput-button display-block">
								<i class="glyphicon glyphicon-plus"></i>
								<span>Select files...</span>
								<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload" type="file" name="files[]" multiple>
							</div>
						</div>

						<!-- The global progress bar -->
						<div id="progress" class="progress progress-sm mt-1 mb-0">
							<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0"
								 aria-valuemin="0" aria-valuemax="100"></div>
						</div>

						<!-- The container for the uploaded files -->
						<table id="files" class="files table table-striped"></table>
						<br>
					</div>
					<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
						<div class="row">
							<table class="table table-striped">
								<thead>
								<tr>
									<th>Histórico do documento</th>
									<th>Data</th>

								</tr>
								</thead>
								<tbody id="activity">
								<?php foreach ($history as $row) {

									echo '<tr><td>'.$row['note'].'</td><td>'.$row['created'].'</td></tr>';
								} ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>invoices_supli/file_handling?id=<?php echo $invoice['iid'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?php echo$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>invoices_supli/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['iid'] ?>" class="aj_delete red"><i class="btn-sm fa fa-trash"></i></a> ' + file.name + ' </td></tr>');
                });

            },
            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );

            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>

<!-- cancel -->
<div id="cancel_bill" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Invoice'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="cancelbill">
                    <?php echo $this->lang->line('You can not revert'); ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control"
                       name="tid" value="<?php echo $invoice['iid'] ?>">
				<input type="hidden" class="form-control"
                       name="tid" value="<?php echo $invoice['iid'] ?>">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-danger"
                        id="send"><?php echo $this->lang->line('Cancel Invoice'); ?></button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 150,
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

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });


    });


</script>
