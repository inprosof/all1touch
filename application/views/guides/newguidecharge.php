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
								<input type="hidden" value="<?= $locations['address']; ?>" name="compa_adr" id="compa_adr">
								<input type="hidden" value="<?= $locations['postbox']; ?>" name="compa_post" id="compa_post">
								<input type="hidden" value="<?= $locations['city']; ?>" name="compa_city" id="compa_city">
								<input type="hidden" value="<?= $locations['country']; ?>" data-serie="<?= $locations['namecountry']; ?>" name="compa_country" id="compa_country">
								<input type="hidden" value="<?= $company['prefix']; ?>" name="pref_fac" id="pref_fac">
								<input type="hidden" value="<?= $prefix['ff']; ?>" name="pref_rc" id="pref_rc">
								<input type="hidden" value="<?= $prefix['year']; ?>" name="year" id="year">
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
                                        <input type="text" class="form-control round" name="cst" id="customer-box-guide"
                                               placeholder="Enter Customer Name or Mobile Number to search"
                                               autocomplete="off"/>
                                        <div id="customer-box-result"></div>
                                    </div>
                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Client Details') ?>
                                        <hr>
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name" id="customer_name"></div>
                                    </div>
                                    <div class="clientinfo">
										<input type="hidden" name="customer_adr_hi" id="customer_adr_hi" value="0">
										<input type="hidden" name="customer_post_box_hi" id="customer_post_box_hi" value="0">
										<input type="hidden" name="customer_city_hi" id="customer_city_hi" value="0">
										<input type="hidden" name="customer_country_hi" id="customer_country_hi" value="0">
                                        <div id="customer_address1" id="customer_address1"></div>
                                    </div>

                                    <div class="clientinfo">
                                        <div id="customer_phone" name="customer_phone"></div>
                                    </div>
									<div class="clientinfo">
										<input type="hidden" name="customer_tax" id="customer_tax" value="999999990">
                                        <div id="customer_tax_name" name="customer_tax_name" value="999999990"></div>
                                    </div>
                                    <hr><?php echo $this->lang->line('Warehouse') ?> <select id="s_warehouses"
                                                                                             class="selectpicker form-control">
                                        <?php echo $this->common->default_warehouse();
                                        echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">
                                    <div class="col-sm-12"><h3
                                                class="title">Guias de Remessa Propriedades</h3>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="guide_type"
                                               class="caption"><?php echo $this->lang->line('Types Tax') ?></label>
                                        <select class="form-control round required"
                                                id="guide_type" name="invoi_type">
											<option value="">Please Select <?php echo $this->lang->line('Type Tax') ?></option>
											<?php foreach ($typesguides as $row) {
												echo '<option value="' . $row['id'] . '" data-serie="' . $row['type'] . '">' .$row['type'].' - '. $row['description'] . '</option>';
											} ?>
                                        </select>
										<input type="hidden" id="guide_type_val" name="guide_type_val" value="0">
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="guide_serie"
                                                   class="caption">Serie</label>
											<select id="guide_serie" name="guide_serie" class="form-control required round select-box">
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="guideno"
                                                                 class="caption">Guia Número</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Guide #"
                                                   name="guideno"
                                                   value="<?php echo $lastguide + 1 ?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="guideno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Reference #"
                                                   name="refer">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
									<div class="col-sm-6">
                                        <label for="taxwithholdings"
                                               class="caption"><?php echo $this->lang->line('Withholding') ?></label>
                                         <select
											name="taxwithholdings"
                                            id="taxwithholdings"
											onchange="changeTaxWithholdingFormat(this.value)"
                                            class="form-control round">
                                        <?php foreach ($withholdings as $row) {
                                            echo '<option value="' . $row['val2'] . '">' . $row['val1'] . '</option>';
                                        } ?>
										</select>
                                    </div>
                                    <div class="col-sm-6"><label for="guidedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="guidedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="taxformat"
                                               class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                        <select class="form-control round"
                                                onchange="changeTaxFormat(this.value)"
                                                id="taxformat" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>

                                            <?php echo $taxlist; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <select class="form-control round"
                                                    onchange="changeDiscountFormat(this.value)"
                                                    id="discountFormat" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>

                                                <?php echo $this->common->disclist() ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption">Notas Guias</label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center">Qtd.</th>
                                <th width="10%" class="text-center">Value</th>
                                <th width="10%" class="text-center">Prod.(%)</th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?= currency($this->aauth->get_user()->loc); ?>)
                                </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>"
                                           id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value=""
                                                                               name="alert[]"></td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>></td>
                                <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>></td>
                                <td class="text-center" id="texttaxa-0">0</td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>></td>
                                <td><span class="currenty"><?= currency($this->aauth->get_user()->loc); ?></span>
                                    <strong><span class='ttlText' id="result-0">0</span></strong></td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0"/>
                                <input type="hidden" name="disca[]" id="disca-0" value="0"/>
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0"/>
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0"/>
                                <input type="hidden" name="unit[]" id="unit-0" value=""/>
                                <input type="hidden" name="hsn[]" id="hsn-0" value=""/>
                                <input type="hidden" name="serial[]" id="serial-0" value=""/>
                            </tr>
                            <tr>
                                <td colspan="8"><textarea id="dpid-0" class="form-control" name="product_description[]"
                                                          placeholder="<?php echo $this->lang->line('Enter Product description'); ?> (Optional)"
                                                          autocomplete="off"></textarea><br></td>
                            </tr>

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
                                <td colspan="6" class="reverse_align"><input type="hidden" value="0" id="subttlform"
                                                                     name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?= $this->config->item('currency'); ?></span>
                                    <span id="taxr" class="lightMode">0</span></td>
                            </tr>
							<tr class="sub_c" style="display: table-row;">
								<td colspan="6" class="reverse_align"><input type="hidden" value="0" id="subttlformwithholding"
                                                                     name="subtotalwithholding"><strong><?php echo $this->lang->line('Total').' '.$this->lang->line('Withholding') ?></strong>
                                </td>
								<td align="left" colspan="2"><span
                                            class="currenty lightMode"><?= $this->config->item('currency'); ?></span>
                                    <span id="subttlwithholding" class="lightMode">0</span></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <span id="discs" class="lightMode">0</span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="6" class="reverse_align">
                                    <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" autocomplete="off"
                                                                    onkeyup="billUpyog()" value="0">
                                    ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                    <span id="ship_final">0</span> )
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
                                                                    name="disc_val" autocomplete="off" value="0"
                                                                    onkeyup="billUpyog()">
                                    <input type="hidden"
                                           name="after_disc" id="after_disc" value="0">
                                    ( <?= $this->config->item('currency'); ?>
                                    <span id="disc_final">0</span> )
                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="2"><?php if (isset($employee)){
                                       echo $this->lang->line('Employee')
                                ?><br>
                                    <select name="employee"
                                            class=" mt-1 col form-control form-control-sm">

                                        <?php foreach ($employee as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['name'] . ')</option>';
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
                                <td colspan="4" class="reverse_align"><strong><?php echo $this->lang->line('Grand Total') ?>
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                    id="invoiceyoghtml" readonly="">

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
												<input type="text" id="start_date_guide" name="start_date_guide" class="form-control round required" value="" placeholder="0000-00-00 00:00:00"/>
												<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: aaaa-mm-dd hh:mm';?>"><i class="fa fa-info fa-2x"></i></span>
											</div>
											<label type="text" id="zone_date" name="zone_date" value="" placeholder="timezone"></label>
											<label for="exped" class="caption">Expedição</label>
											<select name="exped_se" class="form-control b_input required" id="exped_se">
												<option value="" data-type="exp0">Escolha uma Opção</option>
												<?php
													echo $expeditions;
												?>

											</select>
											<label for="autos_s" class="caption">Viatura</label>
											<div class="input-group">
												<select name="autos_se" id="autos_se" class="form-control round" disabled>
													<option value="">Escolha uma Opção</option>
													<?php echo $autos; ?>
												</select>
												<a class="btn btn-primary btn-sm rounded ajaddauto">+Veiculo</a>
											</div>
											
											
											<div class="col-sm-12 associate hidden">
												<label for="guidedate" class="caption">Matrícula</label>
												<input type="text" class="form-control round" placeholder="matricula" name="matricula_aut" id="matricula_aut"/>
												<label for="guidedate" class="caption">Designacao</label>
												<input type="text" class="form-control round" placeholder="designacao" name="designacao_aut" id="designacao_aut"/>
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
												<input type="text" id="loc_guide_comp" name="loc_guide_comp" class="form-control round required" placeholder=""/>
												<span class="input-group-addon" title="<?php echo 'Defina o local de carga dos artigos';?>"><i class="fa fa-info fa-2x"></i></span>
											</div>
											<div class="form-group row">
												<div class="col-sm-6">
													<label for="guideloc" class="caption">Cód. Postal</label>
													<input type="text" id="post_guide_comp" name="post_guide_comp" class="form-control round required" placeholder=""/>
												</div>
												<div class="col-sm-12">
													<label for="guideloc" class="caption">Localidade</label>
													<input type="text" id="city_guide_comp" name="city_guide_comp" class="form-control round required" placeholder=""/>
												</div>
											</div>
											<div class="col-sm-12">
												<label for="mcustomer_gui_comp"><?php echo $this->lang->line('Country') ?></label>
												<select name="mcustomer_gui_comp" class="form-control b_input required" id="mcustomer_gui_comp">
													<option value="0">Escolha uma Opção</option>
													<?php
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
												<input type="text" id="loc_guide_cos" name="loc_guide_cos" class="form-control round required"" placeholder=""/>
												<span class="input-group-addon" title="<?php echo 'Defina o local de descarga dos artigos';?>"><i class="fa fa-info fa-2x"></i></span>
											</div>
											<div class="form-group row">
												<div class="col-sm-6">
													<label for="guideloc" class="caption">Cód. Postal</label>
													<input type="text" id="post_guide_cos" name="post_guide_cos" class="form-control round required" placeholder=""/>
												</div>
												<div class="col-sm-12">
													<label for="guideloc" class="caption">Localidade</label>
													<input type="text" id="city_guide_cos" name="city_guide_cos" class="form-control round required" placeholder=""/>
												</div>
											</div>
											<div class="col-sm-12">
												<label for="mcustomer_gui_cos"><?php echo $this->lang->line('Country') ?></label>
												<select name="mcustomer_gui_cos" class="form-control b_input" id="mcustomer_gui_cos">
													<option value="">Escolha uma Opção</option>
													<?php
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
									<td class="reverse_align" colspan="6"><input type="submit"
																		 class="btn btn-success sub-btn btn-lg"
																		 value="Gerar Guia"
																		 id="submit-data" data-loading-text="Creating...">

									</td>
								</tr>
							</tbody>
                        </table>
						
						
                        <?php
                        if(is_array($custom_fields)){
                          echo'<div class="card">';
                                    foreach ($custom_fields as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="row mt-1">

                                                <label class="col-sm-8"
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                           name="custom[<?= $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                    echo'</div>';
                        }
                                    ?>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="guides/action_charge" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>"
                           name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>"
                           name="shipRate"
                           id="ship_rate">
                    <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                           id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">
					<input type="hidden" value="0" id="custom_withholding">
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
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
                                           class="form-control margin-bottom" name="taxid" id="mcustomer_city">
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
                                                       for="docid"><?= $row['name'] ?></label>

                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input"
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
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
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
</script>