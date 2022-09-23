<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">
					<input type="hidden" name="id" value="<?php echo $guide['id'] ?>">
                    <div class="row">

                        <div class="col-sm-4">

                        </div>

                        <div class="col-sm-3"></div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-3">

                        </div>

                    </div>
						<div class="row">
							<div class="col-sm-6 cmp-pnl">
								<div id="customerpanel" class="inner-cmp-pnl">
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
										<div class="frmSearch col-sm-12"><label for="cst"
																				class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
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
											<?php echo '  <input type="hidden" name="customer_id" id="customer_id" value="' . $guide['csd'] . '">
									<div id="customer_name"><strong>' . $guide['name'] . '</strong></div>
								</div>
								<div class="clientinfo">

									<div id="customer_address1"><strong>' . $guide['address'] . '<br>' . $guide['city'] . ',' . $guide['country'] . '</strong></div>
								</div>

								<div class="clientinfo">

									<div type="text" id="customer_phone">NIF: <strong>' . $guide['tax_id'] . 'Phone: <strong>' . $guide['phone'] . '</strong><br>Email: <strong>' . $guide['email'] . '</strong></div>
								</div>'; ?>
											<hr>
											<div id="customer_pass"></div><?php echo $this->lang->line('Warehouse') ?>
											<select
													id="s_warehouses"
													class="selectpicker form-control round">
												<?php echo $this->common->default_warehouse();?>
												<?php foreach ($warehouse as $row) {
													echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
												} ?>

											</select>
										</div>


									</div>
								</div>
								<div class="col-sm-6 cmp-pnl">
									<div class="inner-cmp-pnl">


										<div class="form-group row">

											<div class="col-sm-12"><span
														class="red">Alterar <?php echo $guide['type']; ?></span>
												<h3
														class="title">Propriedades das <?php echo $guide['type']; ?></h3>
											</div>

										</div>
										<div class="form-group row">
											<div class="col-sm-6"><label for="invocieno"
																		 class="caption">Número <?php echo $guide['type']; ?></label>

												<div class="input-group">
													<div class="input-group-addon"><span class="icon-file-text-o"
																						 aria-hidden="true"></span></div>
													<input type="text" class="form-control round" placeholder="Invoice #"
														   name="invocieno"
														   value="<?php echo $guide['tid']; ?>" readonly> <input
															type="hidden"
															name="iid"
															value="<?php echo $guide['iid']; ?>">
												</div>
											</div>
											<div class="col-sm-6"><label for="invocieno"
																		 class="caption"><?php echo $this->lang->line('Reference') ?></label>

												<div class="input-group">
													<div class="input-group-addon"><span class="icon-bookmark-o"
																						 aria-hidden="true"></span></div>
													<input type="text" class="form-control round" placeholder="Reference #"
														   name="refer"
														   value="<?php echo $guide['refer'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">

											<div class="col-sm-6"><label for="invociedate"
																		 class="caption">Data <?php echo $guide['type']; ?></label>

												<div class="input-group">
													<div class="input-group-addon"><span class="icon-calendar4"
																						 aria-hidden="true"></span></div>
													<input type="text" class="form-control round required editdate"
														   placeholder="Billing Date" name="invoicedate"
														   autocomplete="false"
														   value="<?php echo dateformat($guide['invoicedate']) ?>">
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-6">
												<label for="taxformat"
													   class="caption"><?php echo $this->lang->line('Tax') ?></label>
												<select class="form-control round" onchange="changeTaxFormat(this.value)"
														id="taxformat">

													<?php echo $taxlist; ?>
												</select>
											</div>
											<div class="col-sm-6">

												<div class="form-group">
													<label for="discountFormat"
														   class="caption"><?php echo $this->lang->line('Discount') ?></label>
													<select class="form-control round"
															onchange="changeDiscountFormat(this.value)"
															id="discountFormat">
														<?php echo '<option value="' . $guide['format_discount'] . '">' . $this->lang->line('Do not change') . '</option>'; ?>
														<?php echo $this->common->disclist() ?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label for="toAddInfo"
													   class="caption">Nota Guia</label>
												<textarea class="form-control round" name="notes"
														  rows="2"><?php echo $guide['notes'] ?></textarea></div>
										</div>

									</div>
								</div>
                        </div>
                        <div id="saman-row">
                            <table class="table-responsive tfr my_stripe">
                                <thead>

                                <tr class="item_header bg-gradient-directional-blue white">
                                    <th width="30%"
                                        class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                    <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                    <th width="10%" class="text-center"><?php echo $this->lang->line('Tax') ?></th>
                                    <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                    <th width="10%"
                                        class="text-center"><?php echo $this->lang->line('Amount') . ' (' . $this->config->item('currency'); ?>
                                        )
                                    </th>
                                    <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                foreach ($products as $row) {
                                    echo '<tr >
                        <td><input type="text" class="form-control text-center" name="product_name[]"  value="' . $row['product'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . amountFormat_general($row['qty']) . '" ><input type="hidden" name="old_product_qty[]" value="' . amountFormat_general($row['qty']) . '" ></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . edit_amountExchange_s($row['price'], $guide['multi'], $this->aauth->get_user()->loc) . '"></td>
                        <td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' . $i . '"
                                    onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                    autocomplete="off"  value="' . amountFormat_general($row['tax']) . '"></td>
                        <td class="text-center" id="texttaxa-' . $i . '">' . edit_amountExchange_s($row['totaltax'], $guide['multi'], $this->aauth->get_user()->loc) . '</td>
                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-' . $i . '"
                                   onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . amountFormat_general($row['discount']) . '"></td>
                        <td><span class="currenty">' . $this->config->item('currency') . '</span>
                            <strong><span class="ttlText" id="result-' . $i . '">' . edit_amountExchange_s($row['subtotal'], $guide['multi'], $this->aauth->get_user()->loc) . '</span></strong></td>
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn-sm btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . edit_amountExchange_s($row['totaltax'], $guide['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . edit_amountExchange_s($row['totaldiscount'], $guide['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . edit_amountExchange_s($row['subtotal'], $guide['multi'], $this->aauth->get_user()->loc) . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                             <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">
                                   <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">  <input type="hidden" name="serial[]" id="serial-' . $i . '" value="' . $row['serial'] . '">';
                                   if(isset($row['alert'])) echo'<input type="hidden" id="alert-' . $i . '" value="'.$row['alert'].'"
                                                                               name="alert[]">';
                  echo'  </tr> <tr class="desc_p"><td colspan="8"><textarea id="dpid-' . $i . '" class="form-control" name="product_description[]" placeholder="' . $this->lang->line('Enter Product description') . '" autocomplete="off">' . $row['product_des'] . '</textarea><br></td></tr>';
                                    $i++;
                                } ?>
                                <tr class="last-item-row sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success"

                                                id="addproduct">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                        </button>
                                    </td>
                                    <td colspan="7"></td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" class="reverse_align"><input type="hidden"
                                                                         value="<?php echo edit_amountExchange_s($guide['subtotal'], $guide['multi'], $this->aauth->get_user()->loc) ?>"
                                                                         id="subttlform"
                                                                         name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                    </td>
                                    <td align="left" colspan="2"><span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                        <span id="taxr"
                                              class="lightMode"><?php echo edit_amountExchange_s($guide['tax'], $guide['multi'], $this->aauth->get_user()->loc) ?></span>
                                    </td>
                                </tr>
                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" class="reverse_align">
                                        <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                    <td align="left" colspan="2"><span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                        <span id="discs"
                                              class="lightMode"><?php echo edit_amountExchange_s($guide['discount'], $guide['multi'], $this->aauth->get_user()->loc) ?></span>
                                    </td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" class="reverse_align">
                                        <strong><?php echo $this->lang->line('Shipping') ?></strong>
                                    </td>
                                    <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                        onkeypress="return isNumber(event)"
                                                                        placeholder="Value"
                                                                        name="shipping" autocomplete="off"
                                                                        onkeyup="billUpyog()"
                                                                        value="<?php if ($guide['ship_tax_type'] == 'excl') {
                                                                            $guide['shipping'] = $guide['shipping'] - $guide['ship_tax'];
                                                                        }
                                                                        echo edit_amountExchange_s($guide['shipping'], $guide['multi'], $this->aauth->get_user()->loc); ?>">( <?= $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                        <span id="ship_final"><?= edit_amountExchange_s($guide['ship_tax'], $guide['multi'], $this->aauth->get_user()->loc) ?> </span>
                                        )
                                    </td>
                                </tr>

                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="2"><?php if ($exchange['active'] == 1){
                                        echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                        <select name="mcurrency"
                                                class="selectpicker form-control">

                                            <?php
                                            echo '<option value="' . $guide['multi'] . '">Do not change</option><option value="0">None</option>';
                                            foreach ($currency as $row) {

                                                echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                            } ?>

                                        </select><?php } ?></td>
                                    <td colspan="4" class="reverse_align"><strong><?php echo $this->lang->line('Grand Total') ?>
                                            (<span
                                                    class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                    </td>
                                    <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                        id="invoiceyoghtml"
                                                                        value="<?= edit_amountExchange_s($guide['total'], $guide['multi'], $this->aauth->get_user()->loc); ?>"
                                                                        readonly="">
                                    </td>
                                </tr>
                                <tr class="sub_c" style="display: table-row;">
                                    <td colspan="6" class="reverse_align">
                                        <strong> <?php echo $this->lang->line('Extra') . ' ' . $this->lang->line('Discount') ?></strong>
                                    </td>
                                    <td align="left" colspan="2"><input type="text"
                                                                        class="form-control form-control-sm discVal"
                                                                        onkeypress="return isNumber(event)"
                                                                        placeholder="Value"
                                                                        name="disc_val" autocomplete="off"
                                                                        onkeyup="billUpyog()"
                                                                        value="<?= amountExchange_s($guide['discount_rate'], $guide['multi'], $this->aauth->get_user()->loc); ?>">
                                        <input type="hidden"
                                               name="after_disc" id="after_disc">
                                        ( <?= $this->config->item('currency'); ?>
                                        <span id="disc_final"><?= amountExchange_s((($guide['discount'] / $guide['discount_rate']) * 100) - $guide['total'], $guide['multi'], $this->aauth->get_user()->loc); ?></span>
                                        )
                                    </td>
                                </tr>
                                </tbody>
                            </table>
							
							<hr>
							
							<table class="table-responsive">
								<tbody>
								<tr class="sub_c" style="display: table-row;">
										<td colspan="1">Transporte 
											<div class="col-sm-12">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input required" name="copy_date"
														   id="copy_date"/>
													<label class="custom-control-label"
														   for="copy_date">Preencher com a data e hora de agora</label>
												</div>
												<label for="guidedate" class="caption">Início do transporte</label>
												<div class="input-group">
													<input type="text" id="start_date_guide" name="start_date_guide" class="form-control round required" value="<?php echo $guide['exp_date'] ?>" placeholder="0000-00-00 00:00:00"/>
													<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: aaaa-mm-dd hh:mm';?>"><i class="fa fa-info fa-2x"></i></span>
												</div>
												<label type="text" id="zone_date" name="zone_date" value="" placeholder="timezone"></label>
												<label for="exped" class="caption">Expedição</label>
												<select name="exped_se" id="exped_se" class="form-control round">
													<?php 
														echo '<option value="' . $guide['expedition'] . '" data-type="'.$guide['expd_t'].'">-' . $guide['expd_name'] . '-</option>'; 
														echo $expeditions; 
													?>
												</select>
												<label for="autos_s" class="caption">Viatura</label>
												<div class="input-group">
													<select name="autos_se" id="autos_se" class="form-control round" <?php if($guide['autoid'] == 0) echo 'disabled';?>>
														<?php if($guide['autoid'] == 0) echo '<option value="">Escolha uma Opção</option>'; else echo '<option value="' . $guide['autoid'] . '">-' . $guide['autoid_name'] . '-</option>'; 
														echo $autos; ?>
													</select>
													<a class="btn btn-primary btn-sm rounded ajaddauto">+Veiculo</a>
												</div>
												
												
												<div class="col-sm-12 associate <?php if($guide['expd_t'] == 'exp1' || $guide['expd_t'] == 'exp2' || $guide['expd_t'] == 'exp3') echo 'hidden'; ?>">
													<label for="guidedate" class="caption">Matrícula</label>
													<input type="text" class="form-control round" placeholder="matricula" value="<?php echo $guide['exp_mat'] ?>" name="matricula_aut" id="matricula_aut"/>
													<label for="guidedate" class="caption">Designacao</label>
													<input type="text" class="form-control round" placeholder="designacao" value="<?php echo $guide['exp_des'] ?>" name="designacao_aut" id="designacao_aut"/>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="copy_autos"
															   id="copy_autos">
														<label class="custom-control-label"
															   for="copy_autos">Guardar nas minhas viaturas</label>
													</div>
												</div>
											</div>
										</td>
										<td colspan="2">Local de Carga 
											<div class="col-sm-32">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="copy_comp" id="copy_comp"/>
													<label class="custom-control-label" for="copy_comp">Preencher com os dados da empresa</label>
												</div>
												<label for="guideloc" class="caption">Morada</label>
												<div class="input-group">
													<input type="text" id="loc_guide_comp" name="loc_guide_comp" value="<?php echo $guide['charge_address'] ?>" class="form-control round required" placeholder=""/>
													<span class="input-group-addon" title="<?php echo 'Defina o local de carga dos artigos';?>"><i class="fa fa-info fa-2x"></i></span>
												</div>
												<div class="form-group row">
													<div class="col-sm-6">
														<label for="guideloc" class="caption">Cód. Postal</label>
														<input type="text" id="post_guide_comp" name="post_guide_comp" value="<?php echo $guide['charge_postbox'] ?>" class="form-control round required" placeholder=""/>
													</div>
													<div class="col-sm-12">
														<label for="guideloc" class="caption">Localidade</label>
														<input type="text" id="city_guide_comp" name="city_guide_comp" value="<?php echo $guide['charge_city'] ?>" class="form-control round required" placeholder=""/>
													</div>
												</div>
												<div class="col-sm-12">
													<label for="mcustomer_gui_comp"><?php echo $this->lang->line('Country') ?></label>
													<select name="mcustomer_gui_comp" class="form-control b_input required" id="mcustomer_gui_comp">
														<?php
														echo '<option value="' . $guide['charge_country'] . '">-' . $guide['charge_country_name'] . '-</option>';
														echo $countrys;
														?>

													</select>
												</div>
											</div>
										</td>
										<td colspan="3">Local de Descarga 
											<div class="col-sm-32">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="copy_cos" id="copy_cos"/>
													<label class="custom-control-label" for="copy_cos">Preencher com os dados do cliente</label>
												</div>
												<label for="guideloc" class="caption">Morada</label>
												<div class="input-group">
													<input type="text" id="loc_guide_cos" name="loc_guide_cos" value="<?php echo $guide['discharge_address'] ?>" class="form-control round required"" placeholder=""/>
													<span class="input-group-addon" title="<?php echo 'Defina o local de descarga dos artigos';?>"><i class="fa fa-info fa-2x"></i></span>
												</div>
												<div class="form-group row">
													<div class="col-sm-6">
														<label for="guideloc" class="caption">Cód. Postal</label>
														<input type="text" id="post_guide_cos" name="post_guide_cos" value="<?php echo $guide['discharge_postbox'] ?>" class="form-control round required" placeholder=""/>
													</div>
													<div class="col-sm-12">
														<label for="guideloc" class="caption">Localidade</label>
														<input type="text" id="city_guide_cos" name="city_guide_cos" value="<?php echo $guide['discharge_city'] ?>" class="form-control round required" placeholder=""/>
													</div>
												</div>
												<div class="col-sm-12">
													<label for="mcustomer_gui_cos"><?php echo $this->lang->line('Country') ?></label>
													<select name="mcustomer_gui_cos" class="form-control b_input" id="mcustomer_gui_cos">
														<?php
														echo '<option value="' . $guide['discharge_country'] . '">-' .$guide['discharge_country_name']. '-</option>';
														echo $countrys;
														?>

													</select>
												</div>
											</div>
										</td>
									</tr>
									<hr>
									<tr class="sub_c" style="display: table-row;">
										<td colspan="2">Termos das Guias<select name="pterms"
																												 class="selectpicker form-control"><?php foreach ($terms as $row) {
													echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
												} ?>

											</select></td>
										<td class="reverse_align" colspan="6"><input type="submit" class="btn btn-success sub-btn"
                                                                         value="<?php echo $this->lang->line('Update') ?>"
                                                                         id="submit-data"
                                                                         data-loading-text="Updating...">
										</td>
									</tr>
								</tbody>
							</table>
                        </div>
                        <input type="hidden" value="invoices/editaction" id="action-url">
                        <input type="hidden" value="search" id="billtype">
                        <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
                        <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                        <input type="hidden" value="<?= $this->common->taxhandle_edit($guide['taxstatus']) ?>"
                               name="taxformat" id="tax_format">
                        <input type="hidden" value="<?= $guide['format_discount']; ?>" name="discountFormat"
                               id="discount_format">
                        <input type="hidden" value="<?= $guide['taxstatus']; ?>" name="tax_handle" id="tax_status">
                        <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                        <input type="hidden" value="<?php
                        $tt = 0;
                        if ($guide['ship_tax_type'] == 'incl') $tt = @number_format(($guide['shipping'] - $guide['ship_tax']) / $guide['shipping'], 2, '.', '');
                        echo amountFormat_general(@number_format((($guide['ship_tax'] / $guide['shipping']) * 100) + $tt, 3, '.', '')); ?>"
                               name="shipRate" id="ship_rate">
                        <input type="hidden" value="<?= $guide['ship_tax_type']; ?>" name="ship_taxtype"
                               id="ship_taxtype">
                        <input type="hidden" value="<?= amountFormat_general($guide['ship_tax']); ?>" name="ship_tax"
                               id="ship_tax">
                </form>
            </div>

            <?php
            if(is_array($custom_fields)){
            foreach ($custom_fields as $row) {
                            if ($row['f_type'] == 'text') { ?>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="docid"><?= $row['name'] ?></label>

                                    <div class="col-sm-8">
                                        <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                               class="form-control margin-bottom b_input"
                                               name="custom[<?= $row['id'] ?>]"
                                               value="<?= @$row['data'] ?>">
                                    </div>
                                </div>


                            <?php }


                        }
            }
                        ?>
        </div>

        <div class="modal fade" id="addCustomer" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content ">
                    <form method="post" id="product_action" class="form-horizontal">
                        <!-- Modal Header -->
                        <div class="modal-header">

                            <h4 class="modal-title"
                                id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                            <div class="row">
                                <div class="col">
                                    <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom" id="mcustomer_name" name="name"
                                                   required>
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
                                                   class="form-control margin-bottom " name="address"
                                                   id="mcustomer_address1">
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
                                                   class="form-control margin-bottom" name="taxid" id="mcustomer_city">
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                        <div class="col-sm-10">
                                            <select name="customergroup" class="form-control">
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
                                <div class="col">
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
                                                   class="form-control margin-bottom" id="mcustomer_name_s"
                                                   name="name_s"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Phone"
                                                   class="form-control margin-bottom" name="phone_s"
                                                   id="mcustomer_phone_s">
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
                                                   class="form-control margin-bottom" name="city_s"
                                                   id="mcustomer_city_s">
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

                            </div>   <?php
                                   if(is_array($custom_fields_c)){
                                    foreach ($custom_fields_c as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="form-group row">

                                                <label class="col-sm-2 col-form-label"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                           name="custom[<?= $row['id'] ?>]">
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
<script>
	$("#guide_serie").select2();
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
		$("#mcustomer_gui_cos").val('0');
		if ($(this).prop("checked") == true) {
			var cosid = $('#customer_id').val();
			if (cosid == "0") {
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
    })
	
	
	
    $("#guide_type").on('change', function () {
        $("#guide_serie").val('').trigger('change');
        var tips = $('#guide_type').val();
		var el = $("#iguide_type option:selected").attr('data-serie');
		
		$("#guide_type_val").val(el);
        $("#guide_serie").select2({

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