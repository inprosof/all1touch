<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">
                    <div class="row">
                        <div class="col-sm-6 cmp-pnl">
							<input type="hidden" value="<?php echo $relationid ?>" name="relationid" id="relationid">
							<input type="hidden" value="<?php echo $locations['address']; ?>" name="compa_adr" id="compa_adr">
							<input type="hidden" value="<?php echo $locations['postbox']; ?>" name="compa_post" id="compa_post">
							<input type="hidden" value="<?php echo $locations['city']; ?>" name="compa_city" id="compa_city">
							<input type="hidden" value="<?php echo $locations['country']; ?>" data-serie="<?php echo $locations['namecountry']; ?>" name="compa_country" id="compa_country">
                                
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill To') ?> <a href='#'
                                                                                          class="btn btn-primary btn-sm round"
                                                                                          data-toggle="modal"
                                                                                          data-target="#addCustomer" <?php if ($relationid > 0) echo ' hidden' ?>>
                                                <?php echo $this->lang->line('Add Client') ?>
                                            </a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst" class="caption" <?php if ($relationid > 0) echo ' hidden'; ?>><?php echo $this->lang->line('Search Client'); ?></label>
                                        <input type="text" class="form-control round" name="cst" id="customer-box"
                                               placeholder="Enter Customer Name or Mobile Number to search"
                                               autocomplete="off" <?php if ($relationid > 0) echo ' hidden' ?>/>
                                        <div id="customer-box-result" <?php if ($relationid > 0) echo ' hidden' ?>></div>
                                    </div>
                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Client Details'); ?>
                                        <hr>
										<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $csd_id?>" />
										<div id="customer_name"><strong><?php echo $csd_name; ?></strong></div>
                                    </div>
                                    <div class="clientinfo">
                                        <div id="customer_address1"></div>
                                    </div>
									<div class="clientinfo">
                                        <div id="customer_phone"></div>
                                    </div>
									<div class="col-sm-6"><label class="caption"><?php echo $this->lang->line('TAX ID'); ?></label>
										<div class="input-group">
											<div class="input-group-addon"><span class="icon-calendar4"
																				 aria-hidden="true"></span></div>
											<input type="text" class="form-control round required editdate"
												   placeholder="contribuinte" id="customer_tax" name="customer_tax" value="<?php echo $csd_tax?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>/>
										</div>
									</div>
                                    <hr>
                                    <div id="customer_pass"></div><?php echo $this->lang->line('Warehouse') ?> <select
                                            name="s_warehouses" id="s_warehouses"
                                            class="form-control round">
										<?php 
											echo $this->common->default_warehouse();
											foreach ($warehouse as $row) {
												echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
											}
										?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">
							<input type="hidden" class="form-control round" placeholder="Invoice #" name="invocieno" value="<?php echo $lastinvoice + 1 ?>"> 
                                <div class="form-group row">
									<div class="col-sm-8">
										<label for="invoi_type"
											   class="caption"><?php echo 'Documento Nº' ?> <strong><?php echo $lastinvoice + 1 ?> (numeração provisória)</strong></label>
										<span class="input-group-addon" title="<?php echo "Esta numeração é atribuída com base na sequência dos documentos gerados dentro da série escolhida

Os documentos do mesmo tipo dentro da mesma série têm que ter uma numeração sequêncial, a qual é mostrada aqui.
No entanto, e como se trata de uma ferramenta On-line com vários utilizadores que podem administrar documentos na mesma empresa ao mesmo tempo, a numeração final poderá ser diferente da mostrada, caso alguém se antecipe e insira um documento do mesmo tipo e série.

A numeração final só é atribuída depois de escolher a opção 'Guardar e finalizar Documento'.";?>"><i class="fa fa-info fa-2x"></i></span>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="invoi_type"
                                               class="caption"><?php echo $this->lang->line('Types Tax') ?></label>
                                        <select class="form-control round required"
                                                id="invoi_type" name="invoi_type">
											<?php 
												echo $typesinvoicesdefault;
											?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="invoi_serie"
                                                   class="caption">Serie</label>
											<select id="invoi_serie" name="invoi_serie" class="form-control required round select-box">
												<?php 
													echo $seriesinvoiceselect;
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
									 <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption">Enc./Orç.</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Enc Orc #"
                                                   name="invocieencorc"
                                                   value="">
											<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência no documento, use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>
										<div class="input-group">
											<input type="text" class="form-control round" placeholder="Reference #" name="refer">
											<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência do seu cliente na fatura (Nº de Requisição ou Encomenda, por exemplo), use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
										</div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invoicedate"
                                                                 class="caption">Data de Emissão/Começo</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
											<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: dd-mm-aaaa';?>"><i class="fa fa-info fa-2x"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="reccur" class="caption"><?php echo $this->lang->line('Next Payment After') ?></label>
                                        <select name="reccur" class="form-control round required">
											<option value="0">Escolha uma Opção</option>
                                            <option value="7 day">7 <?php echo $this->lang->line('Days') ?></option>
                                            <option value="14 day">14 <?php echo $this->lang->line('Days') ?></option>
                                            <option value="28 day">28 <?php echo $this->lang->line('Days') ?></option>
                                            <option value="30 day">30 <?php echo $this->lang->line('Days') ?></option>
                                            <option value="45 day">45 <?php echo $this->lang->line('Days') ?></option>
                                            <option value="2 month">2 <?php echo $this->lang->line('Months') ?></option>
                                            <option value="3 month">3 <?php echo $this->lang->line('Months') ?></option>
                                            <option value="6 month">6 <?php echo $this->lang->line('Months') ?></option>
                                            <option value="9 month">9 <?php echo $this->lang->line('Months') ?></option>
                                            <option value="1 year">1 <?php echo $this->lang->line('Year') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="saman-row-invoice">
						<hr>
                        <table id="myTable" class="table-responsive tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="25%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="7%" class="text-center">Qtd.</th>
                                <th width="10%" class="text-center">Preço (€)</th>
								<th width="10%" class="text-center"><?php echo $this->lang->line('Discount') ?> (%)</th>
                                <th width="20%" class="text-center"><?php echo $this->lang->line('Tax') ?> (%)</th>
                                <th width="10%" class="text-center">Total Líquido(<?php echo currency($this->aauth->get_user()->loc); ?>)
                                </th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php 
								$cvalue = 0;
								if(!empty($products))
								{
									$functionNum = "'".$cvalue."'";
									$sub_t = 0;
									$valsumtax = 0;
									$valsumcisc = 0;
									$arrtudo = [];
									foreach ($products as $row) {
										$valsum = 0;
										$valsumperc = '';
										$myArraytaxid = explode(";", $row['taxaid']);
										$myArraytaxperc = explode(";", $row['taxaperc']);
										foreach ($myArraytaxid as $row1) {
											$valsum += $row1;
											$valsumtax += $row1;
										}
										
										foreach ($myArraytaxperc as $row2) {
											$valsumperc = $row2.'%';
										}
										
										$myArraytaxname = explode(";", $row['taxaname']);
										$myArraytaxcod = explode(";", $row['taxacod']);
										$myArraytaxvals = explode(";", $row['taxavals']);
										$myArraytaxcomo = explode(";", $row['taxacomo']);
										
										for($i = 0; $i < count($myArraytaxname); $i++)
										{
											$jatem = false;
											for($oo = 0; $oo < count($arrtudo); $oo++)
											{
												if($arrtudo[$oo]['title'] == $myArraytaxname[$i])
												{
													$arrtudo[$oo]['val'] = ($arrtudo[$oo]['val']+$myArraytaxvals[$i]);
													$arrtudo[$oo]['inci'] = ($arrtudo[$oo]['inci']+$row['subtotal']);
													$jatem = true;
													break;
												}
											}
											
											if(!$jatem)
											{
												$stack = array('title'=>$myArraytaxname[$i], 'val'=>$myArraytaxvals[$i], 'perc'=>$myArraytaxperc[$i].' %', 'inci'=>$row['subtotal'], 'cod'=>$myArraytaxcod[$i], 'como'=>$myArraytaxcomo[$i], 'id'=>$myArraytaxid[$i]);
												array_push($arrtudo, $stack);
											}
										}
										
										echo '<tr><td><input type="text" value="' . $row['product'] . '" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' . $cvalue . '"></td><td><div class="input-group">
										<input value="' . $row['qty'] . '" type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $cvalue . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $functionNum . ')" autocomplete="off" value="1"  inputmode="numeric">
										<span id="product_uni-' . $cvalue . '" name="product_uni[]" class="lightMode"></span></div></td>
										<input type="hidden" id="alert-' . $cvalue . '" name="alert[]" value="' .$row['alert']. '"><td>
										<input value="' . $row['price'] . '" type="text" class="form-control req prc" name="product_price[]" id="price-' . $cvalue . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $functionNum . ')" autocomplete="off" inputmode="numeric"></td><td>
										<input value="' . $row['discount'] . '" type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' . $cvalue . '" onkeyup="rowTotal(' . $functionNum . ')" autocomplete="off"></td> <td><div class="input-group">
										<input type="text" disabled class="col-form-label text-center" id="texttaxa-' . $cvalue . '" value="' . $valsumperc . '">
										<a title="Alterar" class="btn btn-blue btn-sm butedittax" name="butedittax[]" id="butedittax-'.$cvalue.'">
										<span class="fa fa-edit" aria-hidden="false"></span></a></div></td><td><span class="currenty">' .$this->config->item('currency') . '</span> <strong>
										<span class=\'ttlText\' id="result-' . $cvalue . '">' .$row['totaltax'].'</span></strong></td><td class="text-center">
										<button type="button" data-rowid="' . $cvalue . '" class="btn btn-danger removeProd" title="Remove" > 
										<i class="fa fa-minus-square"></i></button><input type="hidden" name="taxacomo[]" id="taxacomo-' . $cvalue . '" value="' .$row['taxacomo']. '"></td>
										<input type="hidden" name="taxavals[]" id="taxavals-' . $cvalue . '" value="' .$row['taxavals']. '">
										<input type="hidden" name="taxaname[]" id="taxaname-' . $cvalue . '" value="' .$row['taxaname']. '">
										<input type="hidden" name="taxaperc[]" id="taxaperc-' . $cvalue . '" value="' .$row['taxaperc']. '">
										<input type="hidden" name="taxacod[]" id="taxacod-' . $cvalue . '" value="' .$row['taxacod']. '">
										<input type="hidden" name="taxaid[]" id="taxaid-' . $cvalue . '" value="' .$row['taxaid']. '">
										<input type="hidden" name="taxa[]" id="taxa-' . $cvalue . '" value="' .$row['tax']. '">
										<input type="hidden" name="disca[]" id="disca-' . $cvalue . '" value="' . $row['totaldiscount'] . '">
										<input type="hidden" class="ttInputsub" name="subtotal[]" id="subtotal-' . $cvalue . '" value="' . $row['subtotal'] . '">
										<input type="hidden" class="ttInputtot2" name="product_tax[]" id="product_tax-' . $cvalue . '" value="' .$row['tax']. '">
										<input type="hidden" class="ttInputtot" name="total[]" id="total-' . $cvalue . '" value="' .$row['totaltax']. '">
										<input type="hidden" class="pdIn" name="pid[]" id="pid-' . $cvalue . '" value="' . $row['pid'] . '">
										<input type="hidden" name="unit[]" id="unit-' . $cvalue . '" value="' . $row['unit'] . '">
										<input type="hidden" name="hsn[]" id="hsn-' . $cvalue . '" value="' . $row['code'] . '">
										<input type="hidden" name="serial[]" id="serial-' . $cvalue . '" value="">
										<input type="hidden" name="verif_typ[]" id="verif_typ-' . $cvalue . '" value="' . $row['verify_typ'] . '">
										</tr>
										<tr>
											<td colspan="8">
											<textarea class="form-control pdIn" id="product_description-' . $cvalue . '" name="product_description[]" placeholder="Enter Product description" autocomplete="off">' . $row['product_des'] . '</textarea></td>
										</tr>';
										$cvalue++;
									}
								}
							?>
                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproduct">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>
							<tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
									<strong>Total Iliquido</strong>
                                </td>
                                <td align="left" colspan="2"><span class="currenty lightMode">
									<input type="hidden" name="subttlform_val" id="subttlform_val" value="0.00">
									<?php echo $this->config->item('currency'); ?></span>
                                    <span id="subttlform_in" name="subttlform_in" class="lightMode">0.00</span></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong>Desconto comercial</strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <span id="discs" class="lightMode">0.00</span></td>
									<input type="hidden" name="discs_come" id="discs_come" value="0.00">
                            </tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="5" class="reverse_align"></td>
								<td align="left" colspan="3">
									<table id="last-item-row-taxs">
										
									</table>
								</td>
                            </tr>
							<tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong>Total do documento</strong></td>
                                <td align="left" colspan="2"><span class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                    <span id="discs_tot" class="lightMode">0.00</span><input type="hidden" value="0.00" name="discs_tot_val" id="discs_tot_val"></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong><?php echo $this->lang->line('Shipping') ?> (%)</strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" id="shipping" autocomplete="off"
                                                                    onkeyup="billUpyogInv()" value="<?php echo amountFormat_general($this->common->disc_status()['ship_rate']); ?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                    (<?php echo $this->config->item('currency'); ?>
                                    <span id="ship_final">0.00</span> )
                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong>Desconto financeiro ( <?php echo $this->config->item('currency'); ?>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text"
                                                                    class="form-control form-control discVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="disc_val" id="disc_val" autocomplete="off" value="0.00"
                                                                    onkeyup="billUpyogInv()" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                </td>
                            </tr>


                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2"><?php if (isset($employee)){
                                       echo $this->lang->line('Employee')
                                ?><br>
                                    <select name="employee"
                                            class=" mt-1 col form-control form-control-sm">

                                        <?php foreach ($employee as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['username'] . ')</option>';
                                        } ?>

                                    </select><?php } ?><br><?php if ($exchange['active'] == 1){
                                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                        <option value="0">Default</option>
                                        <?php foreach ($currency as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                        } ?>

                                    </select><?php } ?></td>
                                <td colspan="4" class="reverse_align"><strong>Total a Pagar
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="totalpay" class="form-control"
                                                                    id="invoiceyoghtml" readonly="" value="0.00">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?php
							if(!empty($custom_fields)){
								foreach ($custom_fields as $row) {
									if ($row['f_type'] == 'text') { ?>
										<div class="form-group row">
											<label class="col-sm-10 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="col-sm-8">
												<input type="text" placeholder="<?php echo $row['placeholder'] ?>"
													   class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
													   name="custom[<?php echo $row['id'] ?>]">
											</div>
										</div>
									<?php }else if ($row['f_type'] == 'check') { ?>
										<div class="form-group row">
											<label class="col-sm-10 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input <?php echo $row['other'] ?>" id="custom[<?php echo $row['id'] ?>]" name="custom[<?php echo $row['id'] ?>]">
												<label class="custom-control-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['placeholder'] ?></label>
											</div>
										</div>
									<?php }else if ($row['f_type'] == 'textarea') { ?>
										<div class="form-group row">
											<label class="col-sm-10 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="col-sm-8">
												<textarea placeholder="<?php echo $row['placeholder'] ?>"
													   class="summernote <?php echo $row['other'] ?>"
													   name="custom[<?php echo $row['id'] ?>]" rows="1"></textarea>
											</div>
										</div>
									<?php }
								}
							}
						?>
                    </div>
					<hr>
					<div id="accordionWrapar" role="tablist" aria-multiselectable="true">
						<div id="headingr" class="card-header">
							<a data-toggle="collapse" data-parent="#accordionWrapar" href="#accordionr"
							   aria-expanded="false" aria-controls="accordionr"
							   class="card-title lead collapsed">
								<i class="fa fa-plus-circle"></i>Documentos relacionados
							</a>
						</div>
						<div id="accordionr" role="tabpanel" aria-labelledby="headingr"
							 class="card-collapse <?php if ($docs_origem == null) echo 'collapse'?>" aria-expanded="false">
							<div class="card-body">
								<table id="myTableAddRelations" class="table-responsive">
									<thead>
										<tr>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Relacionar este documento com outros</td>
											<td><button type="button" class="btn btn-default" id="choise_docs_related_but">Escolher Documentos</button></td>
										</tr>
									</tbody>
								</table>
								<hr>
								<table id="relationsdocs" name="relationsdocs" class="table-responsive <?php if ($docs_origem == null) echo 'hidden'?>">
									<thead>
										<tr>
											<th width="20%">Série</th>
											<th width="10%">Nº</th>
											<th width="15%">Data Emissão</th>
											<th width="15%">Cliente</th>
											<th width="20%">Total Liq.</th>
											<th width="20%">Valor Conciliado</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$valdocrela = 0;
											if(!empty($docs_origem))
											{
												foreach ($docs_origem as $row) {
													$tiiid = $row['iddoc'];
													$exte = $row['ext'];
													if($row['iddoc'] != null && $row['iddoc'] != '')
													{
														echo '<tr class="last-item-row-related sub_related">';
														echo '<input type="hidden" value="'.$row['iddoc'].'" name="idtyprelation[]" id="idtyprelation-'.$valdocrela.'">';
														echo '<input type="hidden" value="'.$row['type_related'].'" name="typrelation[]" id="typrelation-'.$valdocrela.'">';
														echo "<td><strong>".$row['serie_name']."</strong></td>";
														if($row['type_related'] == "0" || $row['type_related'] == "2"){
															if($row['draft'] == "0"){
																echo '<td><a href="'.base_url("invoices/view?id=$tiiid&draf=0&ext=$exte").'" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'.$row['type'].'/'.$row['tid'].'</a>
																		<a href="' . base_url("invoices/printinvoice?id=$tiiid&draf=0&ext=$exte") . '&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
															}else{
																echo '<td><a href="'.base_url("invoices/view?id=$tiiid&draf=1&ext=$exte").'" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'.$row['type'].'/'.$row['tid'].'</a>
																		<a href="' . base_url("invoices/printinvoice?id=$tiiid&draf=1&ext=$exte") . '&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
															}
														}else if($row['type_related'] == "1"){
															echo '<td><a href="'.base_url("invoices/view?id=$tiiid&draf=0&ext=$exte").'" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'.$row['type'].'/'.$row['tid'].'</a>
																		<a href="' . base_url("invoices/printinvoice?id=$tiiid&draf=0&ext=$exte") . '&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
														}else if($row['type_related'] == "3"){
															echo '<td><a href="'.base_url("quote/view?id=$tiiid&draf=0&ext=$exte").'" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'.$row['type'].'/'.$row['tid'].'</a>
																		<a href="' . base_url("quote/printquote?id=$tiiid&draf=0&ext=$exte") . '&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
														}
														echo "<td>".$row['invoicedate']."</td>";
														echo "<td>".$row['tax_id']."</td>";
														echo '<td><input type="text" disabled readonly value="'.$row['total_discount_tax'].'" name="val_tot_rel[]" id="val_tot_rel-'.$valdocrela.'"></td>';
														
														if($row['type_related'] != 3){
															echo '<td><input type="text" disabled readonly value="'.$row['pamnt'].'" name="val_tot_rel[]" id="val_tot_rel_con-'.$valdocrela.'"></td>';
														}else{
															echo '<td><input type="text" disabled readonly value="'.$row['total_discount_tax'].'" name="val_tot_rel[]" id="val_tot_rel_con-'.$valdocrela.'"></td>';
														}
														echo '</tr>';
													}
													
													$valdocrela++;
												}
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr>
					<div id="accordionWrapa3" role="tablist" aria-multiselectable="true">
						<div id="heading3" class="card-header">
							<a data-toggle="collapse" data-parent="#accordionWrapa3" href="#accordion3"
							   aria-expanded="false" aria-controls="accordion3"
							   class="card-title lead collapsed">
								<i class="fa fa-plus-circle"></i>Observações
							</a>
						</div>
						<div id="accordion3" role="tabpanel" aria-labelledby="heading3"
							 class="card-collapse collapse" aria-expanded="false">
							<div class="card-body">
								<textarea class="form-control round" name="notes" rows="2"></textarea>
							</div>
						</div>
					</div>
					<hr>
					<div id="saman-row-buts">
						<table id="myTablebuts" class="table-responsive tfr my_stripe">
                            <thead>
							</thead>
                            <tbody>
							<tr class="last-item-row-buts sub_c_buts">
								<td>
									Termos da Subscrição
									<select name="pterms" class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select>
								</td>
								<td colspan="5"></td>
								<td>
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar Rascunho" id="submit-data-draft" data-loading-text="Creating...">
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar e finalizar Documento" id="submit-data-save" data-loading-text="Creating...">
								</td>
                            </tr>
							</tbody>
						</table>
					</div>
					<input type="hidden" value="<?php echo $accountname; ?>" id="account_set" name="account_set">
					<input type="hidden" value="<?php echo $accountid; ?>" id="account_set_id" name="account_set_id">
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="subscriptions/action" id="action-url">
					<input type="hidden" value="subscriptions/action2" id="action-url2">
                    <input type="hidden" value="search" id="billtype">
					<input type="hidden" value="searchtax" id="billtypetax">
                    <input type="hidden" value="0" name="counter" id="ganak">
					<input type="hidden" value="0" name="counter" id="ganakpay">
					<input type="hidden" name="taxas_tota" id="taxas_tota" value="0.00">
					<input type="hidden" name="tota_items" id="tota_items" value="0.00">
                    <input type="hidden" value="<?php echo currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?php echo $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?php echo $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?php echo $this->common->disc_status()['disc_format']; ?>"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?php echo amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="ship_rate"
                           id="ship_rate">
                    <input type="hidden" value="<?php echo $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="newtaxs" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <form method="post" id="product_action_tax" class="form-horizontal">
				<input type="hidden" value="search_tax" id="bill_tax">
				<input type="hidden" id="numrow">
				<p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
				<div class="bg-gradient-directional-purple white col-sm-12">
                    <h5 class="modal-title" id="myModalLabel">Impostos</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>
				<h6>Use esta opção para remover uma taxa de IVA aplicada a um artigo ou definir uma isenção da aplicação da taxa de IVA, no caso de remover todas as taxas..</h6>
				<div id="saman-row-tax" class="col-sm-12">
					<table id="last-item-row-intax" name="last-item-row-intax">
						<tbody>
						</tbody>
					</table>
					<div class="col-sm-12">
						<select name="taxas" id="taxas" class="form-control form-control-xl">
							<option value="0">Escolha uma Opção</option>
							<?php
								echo $taxsiva;
							?>
						</select>
						<button type="button" class="btn btn-success" aria-label="Left Align"
								id="addtaxinvoice">
							<i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
						</button>
					</div>
				</div>
				<div class="modal-footer">
					<a id="closemodal" href="#" class="btn btn-primary">Cancelar</a>
					<a id="updatemodal" href="#" class="btn btn-secondary">Atualizar</a>
				</div>

			</form>
        </div>
    </div>
</div>
			
<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-purple white">
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
					<div id="notifyc" class="alert alert-success" style="display:none;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<div class="messagec"></div>
					</div>
					<input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active show" id="base-tab1" data-toggle="tab"
							   aria-controls="tab1" href="#tab1" role="tab"
							   aria-selected="true"><?php echo $this->lang->line('Billing Address') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
							   href="#tab2" role="tab"
							   aria-selected="false"><?php echo $this->lang->line('Shipping Address') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
							   href="#tab3" role="tab"
							   aria-selected="false"><?php echo $this->lang->line('CustomFields') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
							   href="#tab4" role="tab"
							   aria-selected="false"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Settings') ?></a>
						</li>

					</ul>
					<div class="tab-content px-1 pt-1">
						<div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">

							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="taxid">Contribuinte</label>
								<div class="col-sm-6">
									<label class="col-sm-12" for="taxid">Deve ser um valor único</label>
									<input type="text"
										   placeholder="<?php echo $this->lang->line('IRS Number') ?>"
										   class="form-control margin-bottom b_input" name="taxid" id="taxid" value="999999990">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12" for="taxid">Verificar contribuinte no sistema
									VIES</label>
								<div class="col-sm-12">
									<div class="alert alert-info" id="alert-info-text" for="taxid">
										<p>Nota: A verificação dos contribuintes
											no Sistema VIES só é possível para as empresas da União Europeia!
											Esta
											verificação é opcional!
											Escolha o país de origem da empresa que deseja verificar e carregue
											em
											"Verificar Contribuinte". </p>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="mcustomer_vies"><?php echo $this->lang->line('Country') ?></label>

										<div class="col-sm-6">
											<select name="country" class="form-control b_input"
													id="country">
												<?php
												echo $countrys;
												?>

											</select>
										</div>
									</div>
									<input type="submit" class="btn btn-primary btn-md" id="calculate_due"
										   value="Verificar Contribuinte">
								</div>
							</div>
							<hr>
							<div class="form-group row mt-1">
								<label class="col-sm-2 col-form-label"
									   for="name"><?php echo $this->lang->line('Name') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="Name"
										   class="form-control margin-bottom b_input crequired" name="name"
										   id="mcustomer_name">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="name"><?php echo $this->lang->line('Company') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="Company"
										   class="form-control margin-bottom b_input" name="company"
										   id="company_1">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="phone"><?php echo $this->lang->line('Phone') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="phone"
										   class="form-control margin-bottom crequired b_input" name="phone"
										   id="mcustomer_phone" value="+3519">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="email">Email</label>
								<div class="col-sm-8">
									<input type="text" placeholder="email"
										   class="form-control margin-bottom crequired b_input" name="email"
										   id="mcustomer_email">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="address"><?php echo $this->lang->line('Address') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="address"
										   class="form-control margin-bottom b_input" name="address"
										   id="mcustomer_address1" value="Desconhecido">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="city"><?php echo $this->lang->line('City') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="city"
										   class="form-control margin-bottom b_input" name="city"
										   id="mcustomer_city" value="Desconhecido">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="region"><?php echo $this->lang->line('Region') ?></label>
								<div class="col-sm-8">
									<input type="text" placeholder="Region"
										   class="form-control margin-bottom b_input" name="region"
										   id="region" value="Desconhecido">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"
									   for="mcustomer_country"><?php echo $this->lang->line('Country') ?></label>
								<div class="col-sm-6">
									<select name="mcustomer_country" class="form-control b_input" id="mcustomer_country">
										<?php
										echo $countrys;
										?>

									</select>
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

								<div class="col-sm-6">
									<input type="text" placeholder="PostBox"
										   class="form-control margin-bottom b_input" name="postbox"
										   id="postbox" value="0000-000">
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
							<div class="form-group row">

								<div class="input-group mt-1">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="customer1"
											   id="copy_address">
										<label class="custom-control-label"
											   for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
									</div>

								</div>

								<div class="col-sm-10 text-info">
									<?php echo $this->lang->line("leave Shipping Address") ?>
								</div>
							</div>

							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="name_s"><?php echo $this->lang->line('Name') ?></label>

								<div class="col-sm-8">
									<input type="text" placeholder="Name"
										   class="form-control margin-bottom b_input crequired" name="name_s"
										   id="mcustomer_name_s">
								</div>
							</div>


							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

								<div class="col-sm-8">
									<input type="text" placeholder="phone"
										   class="form-control margin-bottom b_input" name="phone_s"
										   id="mcustomer_phone_s">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label" for="email_s">Email</label>

								<div class="col-sm-8">
									<input type="text" placeholder="email"
										   class="form-control margin-bottom b_input" name="email_s"
										   id="mcustomer_email_s">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="address"><?php echo $this->lang->line('Address') ?></label>

								<div class="col-sm-8">
									<input type="text" placeholder="address_s"
										   class="form-control margin-bottom b_input" name="address_s"
										   id="mcustomer_address1_s">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="city_s"><?php echo $this->lang->line('City') ?></label>

								<div class="col-sm-8">
									<input type="text" placeholder="city"
										   class="form-control margin-bottom b_input" name="city_s"
										   id="mcustomer_city_s">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="region_s"><?php echo $this->lang->line('Region') ?></label>

								<div class="col-sm-8">
									<input type="text" placeholder="Region"
										   class="form-control margin-bottom b_input" name="region_s"
										   id="region_s">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="mcustomer_country_s"><?php echo $this->lang->line('Country') ?></label>

								<div class="col-sm-6">
									<select name="mcustomer_country_s" class="form-control b_input"
											id="mcustomer_country_s">
										<?php
										echo $countrys;
										?>

									</select>
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

								<div class="col-sm-6">
									<input type="text" placeholder="PostBox"
										   class="form-control margin-bottom b_input" name="postbox_s"
										   id="postbox_s">
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
							<?php
							foreach ($c_custom_fields as $row) {
								if ($row['f_type'] == 'text') { ?>
									<div class="form-group row">
										<label class="col-sm-10 col-form-label"
											   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
										<div class="col-sm-8">
											<input type="text" placeholder="<?php echo $row['placeholder'] ?>"
												   class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
												   name="custom[<?php echo $row['id'] ?>]">
										</div>
									</div>
								<?php } else if ($row['f_type'] == 'check') { ?>
									<div class="form-group row">
										<label class="col-sm-10 col-form-label"
											   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
										<div class="custom-control custom-checkbox">
											<input type="checkbox"
												   class="custom-control-input <?php echo $row['other'] ?>"
												   id="custom[<?php echo $row['id'] ?>]"
												   name="custom[<?php echo $row['id'] ?>]">
											<label class="custom-control-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['placeholder'] ?></label>
										</div>
									</div>
								<?php } else if ($row['f_type'] == 'textarea') { ?>
									<div class="form-group row">
										<label class="col-sm-10 col-form-label"
											   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
										<div class="col-sm-8">
											<textarea placeholder="<?php echo $row['placeholder'] ?>"
													  class="summernote <?php echo $row['other'] ?>"
													  name="custom[<?php echo $row['id'] ?>]"
													  rows="1"></textarea>
										</div>
									</div>
								<?php }
							}
							?>
						</div>
						<div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
							<div class="form-group row"><label class="col-sm-2 col-form-label"
															   for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
								<div class="col-sm-6">
									<input type="text" placeholder="<?php echo $this->lang->line('Discount') ?>"
										   class="form-control margin-bottom b_input" name="discount" value="0">
								</div>
							</div>

							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="docid"><?php echo $this->lang->line('Document') ?> ID</label>

								<div class="col-sm-6">
									<input type="text" placeholder="Document ID"
										   class="form-control margin-bottom b_input" name="docid">
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

								<div class="col-sm-6">
									<select name="customergroup" class="form-control b_input">
										<?php

										foreach ($customergrouplist as $row) {
											$cid = $row['id'];
											$title = $row['title'];
											echo "<option value='$cid'>$title</option>";
										}
										?>
									</select>


								</div>
							</div>

							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="currency"><?php echo $this->lang->line('Language') ?></label>

								<div class="col-sm-6">
									<select name="language" class="form-control b_input">
										<?php
										echo $langs;
										?>

									</select>
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="currency"><?php echo $this->lang->line('customer_login') ?></label>

								<div class="col-sm-6">
									<select name="c_login" class="form-control b_input">

										<option value="1"><?php echo $this->lang->line('Yes') ?></option>
										<option value="0"><?php echo $this->lang->line('No') ?></option>

									</select>
								</div>
							</div>
							<div class="form-group row">

								<label class="col-sm-2 col-form-label"
									   for="password_c"><?php echo $this->lang->line('New Password') ?></label>

								<div class="col-sm-6">
									<input type="text" placeholder="Leave blank for auto generation"
										   class="form-control margin-bottom b_input" name="password_c"
										   id="password_c">
								</div>
							</div>
						</div>
					</div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="<?php echo $this->lang->line('ADD') ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="choise_docs_related" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
				<div class="col-sm-12">
					<h4 class="modal-title">Relacionar com outros documentos</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div class="input-group">
						<h6>Relacione este documento com outros documentos do mesmo cliente</h6>
					</div>
				</div>
            </div>
			
			<div class="modal-body">
				<div class="input-group">
					<label class="col-form-label">Pesquisa</label>
					<input type="text" placeholder="Ref. Nº Série" id="searchdoc" class="form-control col-sm-2" name="searchdoc">
					<span class="input-group-addon" title="<?php echo 'A pesquisa nos documentos relacionados procura nos seguintes campos: Número, série, nossa referência e referência do cliente/fornecedor.

	Nota: A pesquisa não é feita em documentos em rascunho ou anulados e apenas considera os documentos disponíveis para serem relacionados respeitando os restantes filtros de pesquisa aplicados.';?>"><i class="fa fa-info fa-2x"></i></span>
					<label class="col-form-label" for="email_s">Tipo Doc.</label>
					<select name="choise-doc-type" class="form-control b_input crequired" id="choise-doc-type">
						<option value="-1"><?php echo $this->lang->line('Please Select') ?></option>
						<option value="3">Orçamento</option>
						<option value="15">Documento Interno</option>
					</select>
					<label class="col-form-label" for="email_s">Data Emissão:</label>
					<label class="col-form-label" for="email_s">Início:</label>
					<input type="date" style="width: 80px" class="form-control round crequired" placeholder="De" id="startdaterel" name="startdate" autocomplete="false">
					<label class="col-form-label" for="email_s">Fim:</label>
					<input type="date" style="width: 80px" class="form-control round crequired" placeholder="Até" id="enddaterel" name="enddate" autocomplete="false">
					<button id="searchdocbut" name="searchdocbut" type="button" class="btn btn-default searchdocbut">Pesquisar Filtros Aplicados</button>
				</div>
            </div>
            <div class="modal-footer">
				<table id="relationssearch" name="relationssearch" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%"></table>
			</div>
			<button id="pass_selected" name="pass_selected" type="button" class="btn btn-primary"><span class="fa fa-select"></span>Passa Selecionados</button>	
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
		 </div>
	 </div>
 </div>

<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
	$("#calculate_due").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'customers/searchVIES';
        t_actionCaculate(actionurl);
    });

    function t_actionCaculate(actionurl) {
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: 'taxid=' + $('#taxid').val() + '&' + 'country=' + $('#country').val() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
				$('#company_1').html('');
				$('#company_1').val('');
				$('#mcustomer_address1').html('Desconhecido');
				$('#mcustomer_address1').val('Desconhecido');
				$('#mcustomer_city').html('Desconhecido');
				$('#mcustomer_city').val('Desconhecido');
				$('#postbox').val('0000-000');
				$("#postbox").html('0000-000');
				$('#region').val('Desconhecido');
				$("#region").html('Desconhecido');
				$('#mcustomer_country').prop('selectedIndex', 0);
				$("#mcustomer_country").val('PT');
                if (data['valid'] == "false") {
                    $("#notifyc .messagec").html("<strong>Erro </strong>Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
                    $("#notifyc").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#notifyc').offset().top}, 1000);
                } else if (data['valid'] == "true") {
                    $("#notifyc").hide();
                    $('#company_1').html(data.name);
                    $('#company_1').val(data.name);
                    $Savename1 = "";
                    $Saveadrr1 = "";
                    $Saveadrr2 = "";
                    $Saveadrr3 = "";
                    $Saveadrr4 = "";
                    $line = data.address.split('\n');
                    if ($line.length > 1) {
                        $Saveadrr1 = $line[0];
                        $Saveadrr2 = $line[1];
                        $line2 = $line[2].split(' ');
                        if ($line2.length > 1) {
                            $Saveadrr3 = $line2[0];
                            //$Saveadrr4 = $line2[1];
                        }
                    } else {
                        $Saveadrr1 = data.address;
                    }
                    $('#mcustomer_address1').val($Saveadrr1);
                    $("#mcustomer_address1").html($Saveadrr1);

                    $('#mcustomer_city').val($Saveadrr2);
                    $("#mcustomer_city").html($Saveadrr2);

                    $('#postbox').val($Saveadrr3);
                    $("#postbox").html($Saveadrr3);

                    $('#region').val($Saveadrr2);
                    $("#region").html($Saveadrr2);
					
					var ee = $("#customer_country_hi");
					var sel = document.getElementById('mcustomer_country');
					var opts = sel.options;
					for ( var i = 0; i < opts.length; i++ ) {
						if (opts[i]['value'] == data.countryCode) {
						  sel.selectedIndex = i;
						  break;
						}
					}
                } else {
                    $("#notifyc .messagec").html("<strong>Erro </strong>Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
                    $("#notifyc").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#notifyc').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#notifyc .messagec").html("<strong>" + data.status + "</strong>: Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
                $("#notifyc").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notifyc').offset().top}, 1000);
            }
        });
    }
	$("#invoi_serie").select2();
	$('select[name="exped_se"]').change(function (){
        let selectedCategoryType = $(this).find('option:selected').data('type');
		$('#autos_se').prop('selectedIndex', -1);
		$("#autos_se").val('');
        if(selectedCategoryType == 'exp3'){
			$("#autos_se").attr({ disabled: false});
        }else{
			$("#autos_se").attr({ disabled: true});
		}
    });
	
	
	$("#copy_date").change(function () {
		if ($(this).prop("checked") == true) {
			
			var today = new Date();
			var date = today.getUTCFullYear()+'-'+(today.getUTCMonth()+1)+'-'+today.getUTCDate();
			var time = today.getUTCHours() + ":" + today.getUTCMinutes();
			var todat = date+' '+time;
			$('#start_date_guide').val(todat);
			
			var offset = today.getTimezoneOffset();
			
			var MyTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
			
			var zon1 = "Fuso horário: "+MyTimeZone+" | GMT";
			if(offset<0)
				zon1 = zon1+"+" + (offset/-60);
			else
				zon1 = zon1+"-" + (offset/60);
			
			$('#zone_date').val(zon1);
			$('#zone_date').text(zon1);
		} else {
			$('#start_date_guide').val('');
			$('#zone_date').val('');
			$('#zone_date').text('');
		}
	});
	
	$("#copy_cos").change(function () {
		$('#loc_guide_cos').val('');
		$('#city_guide_cos').val('');
		$('#post_guide_cos').val('');
		$('#mcustomer_gui_cos').prop('selectedIndex', -1);
		$("#mcustomer_gui_cos").val('');
		if ($(this).prop("checked") == true) {
			var cosid = $('#customer_id').val();
			if (cosid == "") {
				$("#notify .message").html("<strong>Cliente em Falta</strong>: Por favor selecione um Cliente primeiro.");
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
			}else{
				$('#loc_guide_cos').val($('#customer_adr_hi').val());
				$('#city_guide_cos').val($('#customer_city_hi').val());
				$('#post_guide_cos').val($('#customer_post_box_hi').val());
				var ee = $("#customer_country_hi");
				var sel = document.getElementById('mcustomer_gui_cos');
				var opts = sel.options;
				for ( var i = 0; i < opts.length; i++ ) {
					if (opts[i]['value'] == ee.val()) {
					  sel.selectedIndex = i;
					  break;
					}
				}
			}
		}
	});
	
	$("#copy_comp").change(function () {
		$('#loc_guide_comp').val('');
		$('#city_guide_comp').val('');
		$('#post_guide_comp').val('');
		$('#mcustomer_gui_comp').prop('selectedIndex', -1);
		$("#mcustomer_gui_comp").val('0');
		if ($(this).prop("checked") == true) {
			$('#loc_guide_comp').val($('#compa_adr').val());
			$('#city_guide_comp').val($('#compa_city').val());
			$('#post_guide_comp').val($('#compa_post').val());
			
			var ee = $("#compa_country");
			var sel = document.getElementById('mcustomer_gui_comp');
			var opts = sel.options;
			for ( var i = 0; i < opts.length; i++ ) {
				if (opts[i]['value'] == ee.val()) {
				  sel.selectedIndex = i;
				  break;
				}
			}
		}
	});

    $(document).on('click', ".ajaddauto", function (e) {
		e.preventDefault();
		$("#matricula_aut").val('');
		$("#designacao_aut").val('');
		$("#copy_autos").val('');
		$("#copy_autos").attr("checked", false);
		
		if($('.associate').hasClass('hidden'))
		{
			$('.associate').removeClass('hidden');
		}else{
			
			$('.associate').addClass('hidden');
		}
    });
	
	$("#n_praz_venc").on('change', function () {
		var el = $("#n_praz_venc option:selected").attr('data-type');
		var datatten = $('#datenowsave').val();
		if(datatten == ""){
			datatten = $("#invocieduedate").val();
			$('#datenowsave').val($("#invocieduedate").val());
		}
		if(el == 'praz1')
		{
			$("#invocieduedate").val(DateHelper.format(DateHelper.addDays(new Date(), 0)));
		}else if(el == 'praz2')
		{
			$("#invocieduedate").val(DateHelper.format(DateHelper.addDays(new Date(), 30)));
		}else if(el == 'praz3')
		{
			$("#invocieduedate").val(DateHelper.format(DateHelper.addDays(new Date(), 60)));
		}else if(el == 'praz4')
		{
			$("#invocieduedate").val(DateHelper.format(DateHelper.addDays(new Date(), 90)));
		}
	});
	
	var DateHelper = {
		addDays : function(aDate, numberOfDays) {
			aDate.setDate(aDate.getDate() + numberOfDays); // Add numberOfDays
			return aDate;                                  // Return the date
		},
		format : function format(date) {
			return [
			   ("0" + date.getDate()).slice(-2),           // Get day and pad it with zeroes
			   ("0" + (date.getMonth()+1)).slice(-2),      // Get month and pad it with zeroes
			   date.getFullYear()                          // Get full year
			].join('-');                                   // Glue the pieces together
		}
	};
</script>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
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