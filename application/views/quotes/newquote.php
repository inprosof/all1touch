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
										<input type="hidden" name="customer_id" id="customer_id" value="99999999">
										<div id="customer_name"><?php echo $this->lang->line('Default'); ?>: <strong>Consumidor Final</strong></div>
                                    </div>
                                    <div class="clientinfo">
										<input type="hidden" name="customer_adr_hi" id="customer_adr_hi" value="Desconhecido">
										<input type="hidden" name="customer_post_box_hi" id="customer_post_box_hi" value="0000-000">
										<input type="hidden" name="customer_city_hi" id="customer_city_hi" value="Desconhecido">
										<input type="hidden" name="customer_country_hi" id="customer_country_hi" value="PT">
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
												   placeholder="contribuinte" id="customer_tax" name="customer_tax" value="999999990">
										</div>
									</div>
                                    <hr>
                                    <div id="customer_pass">
										<?php echo $this->lang->line('Warehouse') ?>
										<select name="s_warehouses" id="s_warehouses" class="form-control round">
										<?php 
											echo $this->common->default_warehouse();
											foreach ($warehouse as $row) {
												echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
											}
										?>
										</select>
									</div>
                                </div>
								<div id="customer_pass">
									Prazo de vencimento
									<select name="n_praz_venc" id="n_praz_venc" class="form-control round">
										<?php 
											echo '<option value="">Escolha uma Opção</option>';
											echo $prazos_vencimento;
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
                                               class="caption"><?php echo $this->lang->line('Quote Number') ?> <strong><?php echo $lastinvoice + 1 ?> (numeração provisória)</strong></label>
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
												
												foreach ($typesinvoices as $row) {
													echo '<option value="' . $row['id'] . '" data-serie="' . $row['type'] . '">' .$row['description'] . '</option>';
												}
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
                                                                 class="caption"><?php echo $this->lang->line('Quote Date'); ?></label>

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
									
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption"><?php echo $this->lang->line('Quote Validity') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
											<input type="hidden" id="datenowsave" name="datenowsave"/>
                                            <input type="text" class="form-control round required"
                                                   name="invocieduedate" id="invocieduedate" placeholder="Due Date" autocomplete="false" data-toggle="datepicker" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
											<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: dd-mm-aaaa';?>"><i class="fa fa-info fa-2x"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Quote Note') ?></label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea></div>
                                </div>

                            </div>
                        </div>

                    </div>

					<div class="row">
                        <div class="col">
                            <label for="toAddInfo"
                                   class="caption"><?php echo $this->lang->line('Proposal Message') ?></label>
                            <textarea class="summernote" name="propos" id="contents" rows="1"></textarea></div>
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
									<div class="input-group mt-1">
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
							?>
                    </div>
					<hr>
					<div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
						<div id="heading2" class="card-header">
							<a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion2"
							   aria-expanded="false" aria-controls="accordion2"
							   class="card-title lead collapsed">
								<i class="fa fa-plus-circle"></i>Entrega e Transporte
							</a>
						</div>
						<div id="accordion2" role="tabpanel" aria-labelledby="heading2"
							 class="card-collapse collapse" aria-expanded="false">
							<div class="card-body">
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
								</tbody>
							</table>
							
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
									<?php echo $this->lang->line('Quote Terms') ?> 
									<select name="pterms" class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select>
								</td>
								<td colspan="5"></td>
								<td>
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar Rascunho" id="submit-data3" data-loading-text="Creating...">
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar e finalizar Documento" id="submit-data" data-loading-text="Creating...">
								</td>
                            </tr>
							</tbody>
						</table>
					</div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="quote/action" id="action-url">
					<input type="hidden" value="quote/action2" id="action-url2">
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
                                           class="form-control margin-bottom " name="address" id="address">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city" id="city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region"
                                           class="form-control margin-bottom" name="region">
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
								   <select name="country" class="form-control b_input" id="country">
										<option value="">Escolha uma Opção</option>
										<?php
										echo $countrys;
										?>
									</select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox"
                                           class="form-control margin-bottom" name="postbox" id="mcostumer_postbox">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company" id="mcostumer_company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Contribuinte"
                                           class="form-control margin-bottom" name="taxid" id="mcostumer_taxid">
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
                                           class="form-control margin-bottom" name="mcustomer_region_s">
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
	}
	
	
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