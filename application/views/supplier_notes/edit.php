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
                            <div id="customerpanel" class="inner-cmp-pnl">
								<input type="hidden" name="typeinvoice" value="<?php echo $typeinvoice ?>">
								<input type="hidden" name="iddoc" value="<?php echo $invoice['iddoc'] ?>">
								<input type="hidden" value="<?php echo $invoice['loc_adress']; ?>" name="compa_adr" id="compa_adr">
								<input type="hidden" value="<?php echo $invoice['loc_postbox']; ?>" name="compa_post" id="compa_post">
								<input type="hidden" value="<?php echo $invoice['loc_city']; ?>" name="compa_city" id="compa_city">
								<input type="hidden" value="<?php echo $invoice['loc_country']; ?>" name="compa_country" id="compa_country">
								<div class="form-group row">
									<div class="fcol-sm-12">
										<h3 class="title">
											<?php echo $this->lang->line('Bill To') ?> <a href='#'
																						  class="btn btn-primary btn-sm round"
																						  data-toggle="modal"
																						  data-target="#addCustomer">
												<?php echo $this->lang->line('Add Client') ?>
											</a>
									</div>
								</div>
								<div class="form-group row">
									<div class="frmSearch col-sm-12"><label for="cst" class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
										<input type="text" class="form-control round" name="cst" id="customer-box"
											   placeholder="Enter Customer Name or Mobile Number to search"
											   autocomplete="off"/>
										<div id="customer-box-result"></div>
									</div>
								</div>
								<div id="customer">
									<div class="clientinfo">
										<?php echo $this->lang->line('Client Details'); ?>
										<hr>
										<input type="hidden" name="quote_tid" id="quote_tid" value="<?php echo $quote?>" />
										<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $invoice['csd']; ?>">
										<div id="customer_name"><strong><?php echo $invoice['name']; ?></strong></div>
									</div>
									<div class="clientinfo">
										<input type="hidden" name="customer_adr_hi" id="customer_adr_hi" value="<?php echo $invoice['address']; ?>">
										<input type="hidden" name="customer_post_box_hi" id="customer_post_box_hi" value="<?php echo $invoice['postbox']; ?>">
										<input type="hidden" name="customer_city_hi" id="customer_city_hi" value="<?php echo $invoice['city']; ?>">
										<input type="hidden" name="customer_country_hi" id="customer_country_hi" value="<?php echo $invoice['country']; ?>">
										<div id="customer_address1"><strong><?php echo $invoice['address'] . '<br>' . $invoice['city'] . ',' . $invoice['postbox']. ',' . $invoice['country']; ?></strong></div>
									</div>
									<div class="clientinfo">
										<div type="text" id="customer_phone"><?php echo 'Telefone: <strong>' . $invoice['phone'] . '</strong><br>Email: <strong>' . $invoice['email']; ?></strong></div>
									</div>
									<div class="col-sm-6"><label class="caption"><?php echo $this->lang->line('TAX ID'); ?></label>
										<div class="input-group">
											<div class="input-group-addon"><span class="icon-calendar4"
																				 aria-hidden="true"></span></div>
											<input type="text" class="form-control round required editdate"
												   placeholder="contribuinte" id="customer_tax" name="customer_tax" value="<?php echo $invoice['tax_id']; ?>">
										</div>
									</div>
									<hr>
									<div id="customer_pass"></div><?php echo $this->lang->line('Warehouse') ?> <select
											name="s_warehouses" id="s_warehouses"
											class="form-control round">
										<?php 
											echo '<option value="' . $invoice['loc'] . '">--' . $invoice['loc_cname'] . '--</option>';
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
							<input type="hidden" class="form-control round" name="invocieno" value="<?php echo $invoice['tid']; ?>"> 
								<div class="form-group row">
									<div class="col-sm-8">
										<label for="invoi_type"
											   class="caption"><?php echo $this->lang->line('Edit').' '.$invoice['irs_type_s'].' nº (numeração provisória)' ?> <strong><?php echo $invoice['tid']; ?></strong></label>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6">
										<label for="invoi_type"
											   class="caption"><?php echo $this->lang->line('Types Tax') ?></label>
										<select class="form-control round required"
												id="invoi_type" name="invoi_type">
											<?php 
												echo '<option value="' . $invoice['irs_type'] . '">--' . $invoice['irs_type_s'] .' - '.$invoice['irs_type_n']. '--</option>';
											?>
										</select>
									</div>
									<div class="col-sm-6">

										<div class="form-group">
											<label for="invoi_serie"
												   class="caption">Serie</label>
											<select id="invoi_serie" name="invoi_serie" class="form-control required round select-box">
												<?php 
													echo '<option value="' . $invoice['serie'] . '">--' . $invoice['serie_name'] . '--</option>';
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
												   value="<?php echo $invoice['ref_enc_orc'] ?>">
											<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência no documento, use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
										</div>
									</div>
									<div class="col-sm-6"><label for="invocieno"
																 class="caption"><?php echo $this->lang->line('Reference') ?></label>
										<div class="input-group">
											<input type="text" class="form-control round" placeholder="Reference #" name="refer" value="<?php echo $invoice['refer'] ?>">
											<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência do seu cliente na nota de encomenda (Nº de Requisição ou Encomenda, por exemplo), use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-6"><label for="invoicedate"
																 class="caption"><?php echo 'Data de Emissão'; ?></label>

										<div class="input-group">
											<div class="input-group-addon"><span class="icon-calendar4"
																				 aria-hidden="true"></span></div>
											<input type="text" class="form-control round required"
												   placeholder="Billing Date" name="invoicedate"
												   data-toggle="datepicker"
												   autocomplete="false" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?> value="<?php echo dateformat($invoice['invoicedate']) ?>">
											<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: dd-mm-aaaa';?>"><i class="fa fa-info fa-2x"></i></span>
										</div>
									</div>
									<div class="col-sm-6"><label for="invoicedate"
																 class="caption"><?php echo 'Data de Emissão'; ?></label>

										<div class="input-group">
											<div class="input-group-addon"><span class="icon-calendar4"
																				 aria-hidden="true"></span></div>
											<input type="text" class="form-control round required"
												   placeholder="Billing Date" name="invoiceduedate"
												   data-toggle="datepicker"
												   autocomplete="false" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?> value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
											<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: dd-mm-aaaa';?>"><i class="fa fa-info fa-2x"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12">
										<label for="toAddInfo"
											   class="caption">Notas</label>
										<textarea class="form-control round" name="notes" rows="2"><?php echo $invoice['notes'] ?></textarea></div>
								</div>
                            </div>
                        </div>
                    </div>
                    <div id="saman-row-invoice">
						<table class="table-responsive tfr my_stripe">
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
								if($row['serial'] != '') 
									$row['product'].=' - '.$row['serial'];
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
								<input type="hidden" id="alert-' . $cvalue . '" name="alert[]" value="' .$row['alert']. '"> </td> <td>
								<input value="' . $row['price'] . '" type="text" class="form-control req prc" name="product_price[]" id="price-' . $cvalue . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $functionNum . ')" autocomplete="off" inputmode="numeric"></td><td>
								<input value="' . $row['discount'] . '" type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' . $cvalue . '" onkeyup="rowTotal(' . $functionNum . ')" autocomplete="off"></td> <td><div class="input-group">
								<input type="text" disabled class="col-form-label text-center" id="texttaxa-' . $cvalue . '" value="' . $valsumperc . '">
								<a title="Alterar" class="btn btn-blue btn-sm butedittax" name="butedittax[]" id="butedittax-'.$cvalue.'">
								<span class="fa fa-edit" aria-hidden="false"></span></a></div></td><td><span class="currenty">' .$this->config->item('currency') . '</span> <strong>
								<span class=\'ttlText\' id="result-' . $cvalue . '">' .$row['totaltax'].'</span></strong></td><td class="text-center">
								<button type="button" data-rowid="' . $cvalue . '" class="btn btn-danger removeProd" title="Remove" > 
								<i class="fa fa-minus-square"></i></button><input type="hidden" name="taxacomo[]" id="taxacomo-' . $cvalue . '" value="' .$row['taxacomo']. '">
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
								<input type="hidden" name="serial[]" id="serial-' . $cvalue . '" value="' . $row['serial'] . '"> </td>
								</tr>
								<tr>
									<td colspan="8">
									<textarea class="form-control pdIn" id="product_description-' . $cvalue . '" name="product_description[]" placeholder="Enter Product description" autocomplete="off">' . $row['product_des'] . '</textarea></td>
								</tr>';
								$cvalue++;
							} ?>
							<tr class="last-item-row sub_c">
								<td class="add-row">
									<button type="button" class="btn btn-success" id="addproduct">
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
									<input type="hidden" name="subttlform_val" id="subttlform_val" value="<?php echo $invoice['subtotal'] ?>">
									<?php echo $this->config->item('currency'); ?></span>
									<span id="subttlform_in" name="subttlform_in" class="lightMode"><?php echo $invoice['subtotal'] ?></span></td>
							</tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="6" class="reverse_align">
									<strong>Desconto comercial</strong></td>
								<td align="left" colspan="2"><span
											class="currenty lightMode"><?php echo $this->config->item('currency');
										if (isset($_GET['project'])) {
											echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
										} ?></span>
									<span id="discs" class="lightMode"><?php echo $invoice['discount']?></span></td>
									<input type="hidden" name="discs_come" id="discs_come" value="<?php echo $invoice['discount']?>">
							</tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="5" class="reverse_align"></td>
								<td align="left" colspan="3">
									<table id="last-item-row-taxs" class="table-responsive tfr my_stripe">
										<?php 
											echo '<thead><tr class="item_header bg-gradient-directional-blue white"><th width="70%" class="text-center">Impostos</th><th width="30%" class="text-center">Valor</th></tr></thead>';
											for($r = 0; $r < count($arrtudo); $r++)
											{
												echo '<tr><td><strong>'.$arrtudo[$r]['title'].'</strong></td><td><span class="currenty lightMode"> '.$this->config->item('currency').' </span>'
												.$arrtudo[$r]['val'].'<input type="hidden" name="tax_name[]" value="'.$arrtudo[$r]['title'].'" 
												id="tax_name-'.$r.'"/><input type="hidden" name="tax_val[]" value="'.$arrtudo[$r]['val'].'" 
												id="tax_val-'.$r.'"/><input type="hidden" name="tax_cod[]" value="'.$arrtudo[$r]['cod'].'" id="tax_cod-'.$r.'"/></td></tr>';
											}?>
									</table>
								</td>
							</tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="6" class="reverse_align">
									<strong>Total do documento</strong></td>
								<td align="left" colspan="2"><span class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
									<span id="discs_tot" class="lightMode"><?php echo $invoice['total_discount_tax'] ?></span>
									<input type="hidden" value="<?php echo $invoice['total_discount_tax'] ?>" name="discs_tot_val" id="discs_tot_val"></td>
							</tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="6" class="reverse_align">
									<strong><?php echo $this->lang->line('Shipping') ?> (%)</strong></td>
								<td align="left" colspan="2"><input type="text" class="form-control shipVal"
																	onkeypress="return isNumber(event)"
																	placeholder="Value"
																	name="shipping" id="shipping" autocomplete="off"
																	onkeyup="billUpyogInv()" value="<?php 
																	if($invoice['ship_tax_type'] == 'excl'){
																		$invoice['shipping'] = $invoice['shipping'] - $invoice['ship_tax'];
																	}
																	
																	if ($invoice['shipping'] != 0) 
																	{
																		echo $invoice['shipping'];
																	}else{
																		echo "0";
																	}
																	?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
									(<?php echo $this->config->item('currency'); ?>
									<span id="ship_final"><?php $invoice['ship_tax'] ?></span> )
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
																	name="disc_val" id="disc_val" autocomplete="off" value="<?php echo $invoice['discount_rate']; ?>"
																	onkeyup="billUpyogInv()" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
								</td>
							</tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="2"><?php if ($exchange['active'] == 1){
									echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
									<select name="mcurrency"
											class="selectpicker form-control">

										<?php
										echo '<option value="' . $invoice['multi'] . '">Do not change</option>';
										foreach ($currency as $row) {

											echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
										} ?>

									</select><?php } ?></td>
								<td colspan="4" class="reverse_align"><strong>Total a Pagar
									(<span
											class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
								</td>
								<td align="left" colspan="2"><input type="text" name="totalpay" class="form-control"
																	id="invoiceyoghtml" readonly="" value="<?php echo edit_amountExchange_s($invoice['total'], $invoice['multi'], $this->aauth->get_user()->loc); ?>">

								</td>
							</tr>
							</tbody>
						</table>
                        <?php
							if(is_array($custom_fields)){
							foreach ($custom_fields as $row) {
											if ($row['f_type'] == 'text') { ?>
												<div class="form-group row">

													<label class="col-sm-2 col-form-label"
														   for="docid"><?php echo $row['name'] ?></label>

													<div class="col-sm-8">
														<input type="text" placeholder="<?php echo $row['placeholder'] ?>"
															   class="form-control margin-bottom b_input"
															   name="custom[<?php echo $row['id'] ?>]"
															   value="<?php echo @$row['data'] ?>">
													</div>
												</div>


											<?php }


										}
							}
										?>
                    </div>
					<hr>
					<div id="saman-row-buts">
						<table id="myTablebuts" class="table-responsive tfr my_stripe">
							<thead>
							</thead>
							<tbody>
							<tr class="last-item-row-buts sub_c_buts">
								<td>
									<?php echo $invoice['type'].' Termos' ?> 
									<select name="pterms" class="selectpicker form-control">
									<option value="<?php echo $invoice['termid']; ?>"><?php echo '--'.$invoice['termtit'].'--'; ?></option>
									<?php foreach ($terms as $row) {
											echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
										} ?>

									</select>
								</td>
								<td colspan="4"></td>
								<td>
									<input type="submit" class="btn btn-success sub-btn" value="Atualizar Rascunho" id="submit-data3" data-loading-text="Creating...">
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar e finalizar Documento" id="submit-data" data-loading-text="Creating...">
								</td>
							</tr>
							</tbody>
						</table>
					</div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="supplier_notes/editaction" id="action-url">
					<input type="hidden" value="supplier_notes/editaction2" id="action-url2">
                    <input type="hidden" value="search" id="billtype">
					<input type="hidden" value="searchtax" id="billtypetax">
                    <input type="hidden" value="<?php echo $cvalue?>" name="counter" id="ganak">
					<input type="hidden" name="taxas_tota" id="taxas_tota" value="<?php echo $invoice['tax']?>">
					<input type="hidden" name="tota_items" id="tota_items" value="<?php echo $invoice['items']?>">
                    <input type="hidden" value="<?php echo currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?php echo $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?php echo $invoice['tax_status']?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?php echo $invoice['format_discount']?>" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?php echo $invoice['ship_tax']?>" name="ship_rate" id="ship_rate">
                    <input type="hidden" value="<?php echo $invoice['ship_tax_type']?>" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="<?php echo $invoice['ship_tax']?>" name="ship_tax" id="ship_tax">
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
				<div class="form-group row" style="visibility: hidden">
					<div class="col-sm-12">
						<label for="justisent"
							   class="caption">Justificação de Isenção</label>
						 <select
							name="justisent"
							id="justisent"
							class="form-control round">
							<?php foreach ($withholdings as $row) {
								echo '<option value="' . $row['val2'] . '">' . $row['val1'] . '</option>';
							} ?>
						</select>
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
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom crequired" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address" id="mcustomer_address1">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city" id="mcustomer_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region"
                                           class="form-control margin-bottom" name="region">
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
								   <select name="country" class="form-control b_input" id="mcustomer_country">
										<option value="">Escolha uma Opção</option>
										<?php
										echo $countrys;
										?>
									</select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox"
                                           class="form-control margin-bottom" name="postbox">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="mcustomer_tax">
                                </div>


                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label  col-form-label-sm"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control form-control-sm">
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


                        </div>

                        <!-- shipping -->
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                            <div class="form-group row">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="customer1s"
                                           id="copy_address">
                                    <label class="custom-control-label"
                                           for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                </div>


                                <div class="col-sm-10">
                                    <?php echo $this->lang->line("leave Shipping Address") ?>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name_s" name="name_s"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email_s"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email_s"
                                           id="mcustomer_email_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address_s"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address_s"
                                           id="mcustomer_address1_s">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region_s"
                                           class="form-control margin-bottom" name="region_s">
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <select name="country_s" class="form-control b_input" id="mcustomer_country_s">
										<option value="">Escolha uma Opção</option>
										<?php
										echo $countrys;
										?>
									</select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox_s"
                                           class="form-control margin-bottom" name="postbox_s">
                                </div>
                            </div>


                        </div>

                    </div>
                                   <?php
                                   if(is_array($custom_fields_c)){
                                    foreach ($custom_fields_c as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="form-group row">

                                                <label class="col-sm-2 col-form-label"
                                                       for="docid"><?php echo $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?php echo $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input"
                                                           name="custom[<?php echo $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                   }
                                    ?>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
	$("#invoi_serie").select2();
	$('select[name="exped_se"]').change(function (){
        let selectedCategoryType = $(this).find('option:selected').data('type');
		$('#autos_se').prop('selectedIndex', -1);
		$("#autos_se").val('');
		$("#autos_se").val('');
		$("#expedival").val(selectedCategoryType);
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
	
	$("#s_accounts").on('change', function () {
		var tips = $('#s_accounts').val();
		var accountaaa = $("#s_accounts option:selected").attr('data-serie');
		$("#account_set").val(accountaaa);
		$("#account_set_id").val(tips);
	});
	
    $("#invoi_type").on('change', function () {
        $("#invoi_serie").val('').trigger('change');
        var tips = $('#invoi_type').val();
		var el = $("#invoi_type option:selected").attr('data-serie');
		
		$("#invoi_type_val").val(el);
        $("#invoi_serie").select2({
            ajax: {
                url: baseurl + 'settings/sub_series?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.seriename,
                                value: item.serie_id,
								id: item.serie_id
                            }
                        })
                    };
                },
            }
        });
    });	
</script>