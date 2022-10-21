<?php //extended open  version  ?>
<form method="post" id="data_form">
    <div class="row ">
        <div class="col-md-6 card p-mobile">
            <!--<div class="input-group mt-1">
                <a href='#'
                   class="btn btn-primary  round "
                   data-toggle="modal"
                   data-target="#Pos_addCustomer">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <input type="text" class="form-control round mousetrap" name="cst"
                       id="pos-customer-box"
                       placeholder=""
                       autocomplete="off"/>
            </div>-->
			
			
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1"><i class="ft-search"></i></span>
				</div>
				<input type="text" class="form-control" id="pos-customer-box"
					   placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?>"
					   aria-describedby="button-addon2">
				<div class="input-group-append" id="button-addon2">
					<button class="btn btn-primary" type="button" data-toggle="modal"
							data-target="#Pos_addCustomer"> <?php echo $this->lang->line('Add') ?></button>
				</div>
			</div>

            <div class="row ml-5">
                <div id="customer-box-result" class="col-md-12"></div>
                <div id="customer" class="col-md-12 ml-3">
                    <div class="clientinfo">
                        <input type="hidden" name="customer_id" id="customer_id" value="99999999">
                        <div id="customer_name"><?php echo $this->lang->line('Default'); ?>: <strong>Consumidor Final</strong></div>
                    </div>
					<div class="col-sm-6"><label for="invociedate" class="caption"><?php echo $this->lang->line('TAX ID'); ?></label>
						<div class="input-group">
							<div class="input-group-addon"><span class="icon-calendar4"
																 aria-hidden="true"></span></div>
							<input type="text" class="form-control round editdate"
								   placeholder="contribuinte" id="customer_tax" name="customer_tax" value="999999990">
						</div>
					</div>
                </div>
            </div>
            <div id="saman-row-pos" class="rqw mt-1">
                <div class="col p-mobile">
                    <table id="pos_list" class="table-responsive tfr pos_stripe">
                        <thead>
                        <tr class="item_header bg-gradient-directional-purple white">
							<th width="7%" class="text-center">Qtd.</th>
							<th width="10%" class="text-center">Preço (€)</th>
							<th width="10%" class="text-center"><?php echo $this->lang->line('Discount') ?> (%)</th>
							<th width="20%" class="text-center"><?php echo $this->lang->line('Tax') ?> (%)</th>
							<th width="10%" class="text-center">Total Líquido(<?php echo currency($this->aauth->get_user()->loc); ?>)</th>
							<th width="10%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                        </thead>
                        <tbody id="pos_items">
                        </tbody>
                    </table>
                    <br>
                    <hr>

                   <div class="row mt-1">
                        <div class="col-3"<strong><?php echo $this->lang->line('Products') ?> </strong>
                        </div>
						<div class="col-6">
						<input type="hidden" name="tota_items" id="tota_items" value="0.00">
						<span id="total_items_count" class="currenty lightMode danger  font-weight-bold">0</span>
						</div>
                   </div>
					
					
                    <div class="row mt-1">
                        <div class="col-3">
							<input type="hidden" name="subttlform_val" id="subttlform_val" value="0.00">
							<strong>Total Iliquido</strong>
                        </div>
                        <div class="col-6"><span  class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                        <span id="subttlform_in" class="lightMode">0</span></div>
                    </div>
					<div class="row mt-1">
                        <div class="col-3">
							<input type="hidden" name="discs_come" id="discs_come" value="0.00">
                            <strong>Desconto comercial</strong></div>
                        <div class="col-6"><span
                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                if (isset($_GET['project'])) {
                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                } ?></span>
                            <span id="discs" class="lightMode">0</span></div>
                    </div>
					<div class="row mt-1">
						<table id="last-item-row-taxs" class="table-responsive tfr my_stripe">
							
						</table>
					</div>
					<div class="row mt-1">
                        <div class="col-3">
							<input type="hidden" value="0.00" name="discs_tot_val" id="discs_tot_val">
							<strong>Total do documento</strong>
                        </div>
                        <div class="col-6"><span  class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                        <span id="discs_tot" class="lightMode">0.00</span></div>
                    </div>
					
					<div class="row mt-1">
                        <div class="col-3">
                            <strong><?php echo $this->lang->line('Shipping') ?> (%)</strong></div>
                        <div class="col-6"><input type="text" class="form-control shipVal"
                                                  onkeypress="return isNumber(event)"
                                                  placeholder="Value"
                                                  name="shipping" id="shipping" autocomplete="off"
                                                  onkeyup="billUpyogInv()" value="<?php echo amountFormat_general($this->common->disc_status()['ship_rate']); ?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                            (<?php echo $this->config->item('currency'); ?>
                            <span id="ship_final">0.00</span> )
                        </div>
                    </div>
					
					
					<div class="row mt-1">
						<div class="col-3">
							<input type="hidden" name="discs_come" id="discs_come" value="0.00">
							<strong>Desconto financeiro ( <?php echo $this->config->item('currency'); ?>)</strong>
						</div>
						<div class="col-6"><input type="text" class="form-control form-control discVal"
													onkeypress="return isNumber(event)"
													placeholder="Value"
													name="disc_val" id="disc_val" autocomplete="off" value="0.00"
													onkeyup="billUpyogInv()" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
						</div>
					</div>
					<div class="row mt-1">
						<div class="col-3"><strong><?php echo $this->lang->line('Grand Total') ?>
								(<span
										class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
						</div>
						<div class="col-6"><input type="text" name="totalpay" class="form-control"
												  id="invoiceyoghtml" readonly="" value="0.00"></div>


					</div>
				</div>
                <hr>
                <?php if ($configs['emps'] == 1) { ?>
                    <div class="col">
                        <div class="form-group form-group-sm text-g">
                            <label for="employee"><?php echo $this->lang->line('Employee') ?></label>
                            <select id="employee" name="employee" class="form-control form-control-sm">
                                <?php
                                foreach ($employee as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select></div>
                    </div>
                <?php } ?>
                <div class="row mt-1">
                    <div class="col-md-12 text-center">
                        <a href="#" class="possubmit btn btn-lg btn-cyan sub-btn" data-type="6"
                        ><i class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?></a>
                        <a href="#" class="possubmit3 btn btn-lg btn-success sub-btn" data-type="6"
                           data-toggle="modal"
                           data-target="#basicPay"><i
                                    class="fa fa-money"></i> <?php echo $this->lang->line('Payment') ?>
                        </a>
                        <?php if ($enable_card['url']) { ?>
                            <a href="#"
                               class="possubmit2 btn btn-lg btn-blue-grey sub-btn"
                               data-type="4" data-toggle="modal"
                               data-target="#cardPay"><i
                                        class="fa fa-credit-card"></i> <?php echo $this->lang->line('Card') ?>
                            </a>
                        <?php } ?>
						<a href="<?= base_url('stockreturn/create?ty=0') ?>" class="red float-right"><i class="fa fa-reply-all"></i></a>
                    </div>
                </div>

                <hr>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary  mr-1 mb-1" id="base-tab1" data-toggle="tab"
                           aria-controls="tab1" href="#tab1" role="tab" aria-selected="false"><i
                                    class="fa fa-trophy"></i>
                            <?php echo $this->lang->line('Coupon') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary mr-1 mb-1" id="base-tab2" data-toggle="tab"
                           aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i
                                    class="icon-handbag"></i>
                            <?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Settings') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger  mr-1 mb-1" id="base-tab3" data-toggle="tab"
                           aria-controls="tab3" href="#tab3" role="tab" aria-selected="false"><i
                                    class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?>(s)</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                           href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
                            <?php echo $this->lang->line('Invoice Properties') ?></a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                        <div class="input-group">

                            <input type="text" class="form-control"
                                   id="coupon" name="coupon"><input type="hidden"
                                                                    name="coupon_amount"
                                                                    id="coupon_amount"
                                                                    value="0"><span
                                    class="input-group-addon round"> <button
                                        class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


                        </div>
                        <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                               value="">
                        <span class="text-primary text-bold-600" id="r_coupon"></span>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
						<div class="form-group row">
							<div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
								<select id="s_warehouses"
										name="s_warehouses"
										class="selectpicker form-control round teal">
									<?php 
										echo $this->common->default_warehouse();
										foreach ($warehouse as $row) {
											echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
										}
									?>

								</select>
							</div>
							<div class="col-4 blue text-xs-center">
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
							<div class="col-4 blue text-xs-center">
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
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                        <?php foreach ($draft_list as $rowd) {
                            echo '<li class="indigo p-1"><a href="' . base_url() . 'pos_invoices/draft?id=' . $rowd['id'] . '"> #' . $rowd['tid'] . ' (' . $rowd['invoicedate'] . ')</a>';
							echo '<a href="#" data-object-id="' . $rowd['id'] . '" data-object-tid="' . $rowd['tid'] . '" data-object-draft="0" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a></li>';
                        } ?>
                    </div>
                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                        <div class="form-group row">
                            <div class="col-sm-3"><label for="invoi_type"
                                               class="caption"><?php echo $this->lang->line('Invoice Number') ?> <strong><?php echo $lastinvoice + 1 ?> (numeração provisória)</strong></label>
									<span class="input-group-addon" title="<?php echo "Esta numeração é atribuída com base na sequência dos documentos gerados dentro da série escolhida

Os documentos do mesmo tipo dentro da mesma série têm que ter uma numeração sequêncial, a qual é mostrada aqui.
No entanto, e como se trata de uma ferramenta On-line com vários utilizadores que podem administrar documentos na mesma empresa ao mesmo tempo, a numeração final poderá ser diferente da mostrada, caso alguém se antecipe e insira um documento do mesmo tipo e série.

A numeração final só é atribuída depois de escolher a opção 'Guardar e finalizar Documento'.";?>"><i class="fa fa-info fa-2x"></i></span>
                            </div>
                            <div class="col-sm-3"><label for="invocieno"
                                                         class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control"
                                           placeholder="Reference #"
                                           name="refer">
									<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência do seu cliente na fatura (Nº de Requisição ou Encomenda, por exemplo), use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
                                </div>
                            </div>
							<div class="col-sm-3"><label for="invocieno" class="caption">Enc./Orç.</label>

								<div class="input-group">
									<div class="input-group-addon"><span class="icon-file-text-o"
																		 aria-hidden="true"></span></div>
									<input type="text" class="form-control round" placeholder="Enc Orc #"
										   name="invocieencorc"
										   value="">
									<span class="input-group-addon" title="<?php echo 'Caso tenha que inserir alguma referência no documento, use este campo';?>"><i class="fa fa-info fa-2x"></i></span>
								</div>
							</div>
                            <div class="col-sm-3"><label for="invociedate"
                                                         class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar4"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control required"
                                           placeholder="Billing Date" name="invoicedate"
                                           data-toggle="datepicker"
                                           autocomplete="false">
									<span class="input-group-addon" title="<?php echo 'A data inserida tem que ser no formato: dd-mm-aaaa';?>"><i class="fa fa-info fa-2x"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-6"><label for="invocieduedate"
                                                         class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    <input type="text" class="form-control required" id="tsn_due"
                                           name="invocieduedate"
                                           placeholder="Due Date" data-toggle="datepicker"
                                           autocomplete="false" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-7">
                                <?php echo $this->lang->line('Payment Terms') ?> <select
                                        name="pterms"
                                        class="selectpicker form-control"><?php foreach ($terms as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>

                                </select>
                                <?php if ($exchange['active'] == 1) {
                                    echo $this->lang->line('Payment Currency client') ?>
                                <?php } ?>
                                <?php if ($exchange['active'] == 1) {
                                    ?>
                                    <select name="mcurrency" class="selectpicker form-control">
                                    <option value="0">Default</option>
                                    <?php foreach ($currency as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                    } ?>

                                    </select><?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <label for="toAddInfo"
                                       class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                <textarea class="form-control" name="notes" rows="2"></textarea>
                            </div>
                        </div>


                    </div>
                </div>


            </div>

        </div>
        <div class="col-md-6 card  order-sm-first  order-md-2 border-amber bg-lighten-1 bg-faded round pt-1">
            <div class="row border-bottom-grey-blue  border-bottom-lighten-4">
                <div class="col-sm-9">
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<i class="fa fa-barcode p-0"></i>&nbsp;<input type="checkbox"
																			  aria-label="Enable BarCode"
																			  value="1" id="bar_only">
							</div>
						</div>
						<input type="text" class="form-control text-center round mousetrap"
							   name="product_barcode"
							   placeholder="Enter Product name, code or scan barcode" id="search_bar"
							   autocomplete="off" autofocus="autofocus">
					</div>


				</div>
                <div class="col-md-3  grey text-xs-center">
					<select id="categories" class="form-control round teal">
						<option value="0"><?php echo $this->lang->line('All') ?></option>
						<?php
							echo $cat;
                        ?>
                    </select></div>


            </div>
			<hr class="white">
			<div class="row m-0">
				<div class="col-md-12 pt-0 " id="pos_item">
					<!-- pos items -->
				</div>
			</div>
        </div>
    </div>
    </div>
	<input type="hidden" value="<?php echo $accountname; ?>" id="account_set" name="account_set">
	<input type="hidden" value="<?php echo $accountid; ?>" id="account_set_id" name="account_set_id">
    <input type="hidden" value="pos_invoices/action" id="action-url">
    <input type="hidden" value="search" id="billtype">
	<input type="hidden" value="searchtax" id="billtypetax">
	<input type="hidden" value="0" name="counter" id="ganak">
	<input type="hidden" value="0" name="counter" id="ganakpay">
	<input type="hidden" name="taxas_tota" id="taxas_tota" value="0.00">
    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
    <input type="hidden" value="<?php echo  $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
    <input type="hidden" value="<?php echo  $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
    <input type="hidden" value="<?php echo  $this->common->disc_status()['disc_format']; ?>" name="discountFormat"
           id="discount_format">
    <input type="hidden" value="<?php echo  amountFormat_general($this->common->disc_status()['ship_rate']); ?>" name="shipRate"
           id="ship_rate">
    <input type="hidden" value="<?php echo  $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
           id="ship_taxtype">
    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
</form>
<audio id="beep" src="<?php echo  assets_url() ?>assets/js/beep.wav" autoplay="false"></audio>

<div id="shortFullScreen" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ecrâ Total</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Click Por favor na tecla F11 do seu Teclado. Para Sair Click de novo na tecla F11 do seu Teclado.</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="shortkeyboard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Comandos Rápidos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Alt+X</td>
                        <td>Foco na pesquisa de produtos</td>
                    </tr>
                    <tr>
                        <td>Alt+C</td>
                        <td>Foco na busca de clientes</td>
                    </tr>

                    <tr>
                        <td>Alt+S (twice)</td>
                        <td>Pague agora + impressão térmica</td>
                    </tr>
                    <tr>
                        <td>Alt+Z</td>
                        <td>Fazer pagamento com cartão</td>
                    </tr>
                    <tr>
                        <td>Alt+Q</td>
                        <td>Selecione o primeiro produto</td>
                    </tr>
                    <tr>
                        <td>Alt+N</td>
                        <td>Criar Novo Documento</td>
                    </tr>


                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="Pos_addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-info white">

                    <h4 class="modal-title" id="myModalLabel"><i
                                class="icon-user-plus"></i> <?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name">
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
                                           class="form-control margin-bottom" name="email"
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
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="mcustomer_tax">
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
							<?php
							if (is_array($custom_fields_c)) {
								foreach ($custom_fields_c as $row) {
									if ($row['f_type'] == 'text') { ?>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="col-sm-8">
												<input type="text" placeholder="<?php echo $row['placeholder'] ?>"
													   class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
													   name="custom[<?php echo $row['id'] ?>]">
											</div>
										</div>
									<?php }else if ($row['f_type'] == 'check') { ?>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input <?php echo $row['other'] ?>" id="custom[<?php echo $row['id'] ?>]" name="custom[<?php echo $row['id'] ?>]">
												<label class="custom-control-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['placeholder'] ?></label>
											</div>
										</div>
									<?php }else if ($row['f_type'] == 'textarea') { ?>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"
												   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
											<div class="col-sm-8">
												<textarea placeholder="<?php echo $row['placeholder'] ?>"
													   class="summernote <?php echo $row['other'] ?>"
													   name="custom[<?php echo $row['id'] ?>]" rows="1"></textarea>
											</div>
										</div>
									<?php }
								}
							}?>
                        </div>

                        <!-- shipping -->


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/ >
                </div>
            </form>
        </div>
    </div>
</div>
<!--card-->
<div class="modal fade" id="cardPay" role="dialog">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p id="statusMsg"></p>

                <form role="form" id="card_data">


                    <div class="row">
                        <div class="col-6">
                            <div class="card-title mb-3">
                                <label for="cardNumber"><?php echo $this->lang->line('Payment Gateways') ?></label>
                                <select class="form-control" name="gateway"><?php


                                    $surcharge_t = false;
                                    foreach ($gateway as $row) {
                                        $cid = $row['id'];
                                        $title = $row['name'];
                                        if ($row['surcharge'] > 0) {
                                            $surcharge_t = true;
                                            $fee = '(<span class="gate_total"></span>+' . amountFormat_s($row['surcharge']) . ' %)';
                                        } else {
                                            $fee = '';
                                        }
                                        echo "<option value='$cid'>$title $fee</option>";
                                    }
                                    ?>
                                </select></div>
                        </div>
                        <div class="col-6"><br><img class="img-responsive pull-right"
                                                    src="<?php echo assets_url('assets/images/accepted_c22e0.png') ?>">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-success btn-lg btn-block"
                                    type="submit"
                                    id="pos_card_pay"
                                    data-type="2"><?php echo $this->lang->line('Paynow') ?></button>
                        </div>
                    </div>
                    <div class="form-group">

                        <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                    </div>
                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>

                    <input type="hidden" value="pos_invoices/action" id="pos_action-url">
                </form>


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="basicPay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="basicpay_data" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p>
                    <div class="text-center"><h1 id="b_total"></h1></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                <div class="input-group">
                                    <input type="text"
                                            class="form-control  text-bold-600 blue-grey"
                                            name="p_amount"
                                            placeholder="Amount" onkeypress="return isNumber(event)"
                                            id="p_amount" onkeyup="update_pay_pos()" inputmode="numeric"
                                    />
                                    <span class="input-group-addon"><i class="icon icon-cash"></i></span>
								</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
								<select class="form-control" name="p_method" id="p_method">
									<?php
									echo $metodos_pagamentos;
									?>
								</select>
							</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group  text-bold-600 red">
                                <label for="amount">Valor em falta
                                </label>
                                <input disabled type="text" class="form-control red" name="amount" id="balance1"
                                       onkeypress="return isNumber(event)"
                                       value="0.00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group text-bold-600 text-g">
                                <label for="b_change">Troco</label>
                                <input disabled type="text"
                                        class="form-control green"
                                        name="b_change" id="change_p" value="0.00">
                            </div>
                        </div>
                    </div>
                    <?php if (PAC) { ?>
                        <div class="col">
                            <div class="form-group text-bold-600 text-g">
                                <label for="account_p"><?php echo $this->lang->line('Account') ?></label>
								<!--p_account-->
                                <select name="s_accounts" id="s_accounts" class="form-control">
                                    <?php 
									foreach ($accounts as $rowa) {
										echo '<option value="' . $rowa['id'] . '" data-serie="' . $rowa['holder'] . '">' . $rowa['holder'] . ' / ' . $rowa['acn'] . '</option>';
									}
                                    ?>
                                </select>
							</div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-success btn-lg btn-block mb-1"
                                    type="submit"
                                    id="pos_basic_pay" data-type="4"><i
                                        class="fa fa-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?>
                            </button>
                            <button class="btn btn-info btn-lg btn-block"
                                    type="submit"
                                    id="pos_basic_print" data-type="4"><i
                                        class="fa fa-print"></i> <?php echo $this->lang->line('Paynow') ?>
                                + <?php echo $this->lang->line('Print') ?></button>
                        </div>
                    </div>

                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>


                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Movimentos de Caixa</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>
			<h6>Indicação do estado da caixa deste terminal.</h6>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="text-center m-1"><?php echo $this->lang->line('Active') ?> - <span id="r_date"></span></div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 blue">
                            <label for="amount blue"><?php echo $this->lang->line('Cash') ?>
                                (<?php echo  $this->config->item('currency'); ?>)
                            </label>
                            <input type="number" class="form-control blue" id="r_cash"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="r_card blue"><?php echo $this->lang->line('Card') ?></label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_card" value="0" readonly>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 blue">
                            <label for="r_bank blue"><?php echo $this->lang->line('Bank') ?></label>
							(<?php echo  $this->config->item('currency'); ?>)
                            </label>
                            <input type="number" class="form-control blue" id="r_bank"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="r_cheque blue">Cheque</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_cheque" value="0" readonly>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 blue">
                            <label for="r_balanco blue">Balanço Cliente</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input type="number" class="form-control blue" id="r_balanco"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="r_mbway blue">MBWay</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_mbway" value="0" readonly>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 blue">
                            <label for="r_paypal blue">Paypal</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input type="number" class="form-control blue" id="r_paypal"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="r_cupoes blue">Cupões Cliente</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_cupoes" value="0" readonly>
                        </div>
                    </div>
                </div>
				
				
				
                <div class="row">
					<div class="col-6">
                        <div class="form-group  text-bold-600 blue">
                            <label for="r_outros blue">Outros</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input type="number" class="form-control blue" id="r_outros"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 red">
                            <label for="r_change">Diferença(+)</label>
							(<?php echo  $this->config->item('currency'); ?>)
                            <input type="number"
                                    class="form-control red"
                                    id="r_change" value="0" readonly>
                        </div>
                    </div>
                </div>


                <div class="row" style="display:none;">
                    <div class="col-xs-12">
                        <p class="payment-errors"></p>
                    </div>
                </div>


                <!-- shipping -->


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="close_register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Close') ?><?php echo $this->lang->line('Your Register') ?></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?php echo  base_url() ?>/register/close" class="btn btn-danger btn-lg btn-block"
                           type="submit"
                        ><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Yes') ?></a>
                    </div>
                    <div class="col-4"></div>
                </div>

            </div>
            <!-- Modal Footer -->
        </div>
    </div>
</div>
<div class="modal fade" id="stock_alert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Stock Alert') ?> !</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row p-1">
                    <div class="alert alert-danger mb-2" role="alert">
                        <strong>Oh Não!</strong> <?php echo $this->lang->line('order or edit the stock') ?>
                    </div>
                </div>

            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Remover Rascunho</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Pretende Remover o Rascunho? Esta função é irreversível.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
				<input type="hidden" id="object-tid" value="">
				<input type="hidden" id="object-tdraft" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm">Remover</button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="pos_print" class="modal fade" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Legacy Print Mode</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body border_no_print" id="print_section">
                <embed src="<?php echo  base_url('assets/images/ssl-seal.png') ?>"
                       type="application/pdf" height="600px" width="470" id="loader_pdf"
                ">
                <input id="loader_file" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
	$("#s_accounts").on('change', function () {
		var tips = $('#s_accounts').val();
		var accountaaa = $("#s_accounts option:selected").attr('data-serie');
		$("#account_set").val(accountaaa);
		$("#account_set_id").val(tips);
	});
	
    var wait = true;
    $.ajax({
        url: baseurl + 'search_products/pos_search',
        dataType: 'html',
        method: 'POST',
        data: 'cid=' + $('#categories').val() + '&wid=' + $('#s_warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash + '&bar=' + $('#bar_only').prop('checked'),
        success: function (data) {
            $('#pos_item').html(data);

        }
    });

    function update_register() {
        $.ajax({
            url: baseurl + 'register/status',
            dataType: 'json',
            data: crsf_token + '=' + crsf_hash,
            success: function (data) {
                $('#r_cash').val(data.cash);
                $('#r_card').val(data.card);
                $('#r_bank').val(data.bank);
				$('#r_cheque').val(data.cheque);
				$('#r_balanco').val(data.balanco);
				$('#r_mbway').val(data.mbway);
				$('#r_paypal').val(data.paypal);
                $('#r_cupoes').val(data.cupoes);
				$('#r_outros').val(data.outros);
				$('#r_change').val(data.change);
                $('#r_date').html('Os movimentos de caixa neste terminal estão abertos. A caixa foi aberta pelo operador <strong>'+data.operator+'</strong> em <strong>'+data.date+'</strong> com o valor de <strong>'+data.tot_start+'</strong> €');
            }
        });
    }

    update_register();
    $(".possubmit").on("click", function (e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });

    $(".possubmit2").on("click", function (e) {
        e.preventDefault();
        $('#card_total').val(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal));
    });

    $(".possubmit3").on("click", function (e) {
        e.preventDefault();
        var roundoff = parseFloat(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal)).toFixed(two_fixed);

        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' roundoff=Math.ceil(roundoff);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' roundoff=Math.floor(roundoff);';
        }
        ?>
        $('#b_total').html(' <?php echo  $this->config->item('currency'); ?> ' + accounting.formatNumber(roundoff));
        $('#p_amount').val(accounting.formatNumber(roundoff));

    });

    function update_pay_pos() {
        var am_pos = accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal);
        var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' ttl_pos=Math.ceil(ttl_pos);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' ttl_pos=Math.floor(ttl_pos);';
        }
        ?>

        var due = parseFloat(ttl_pos - am_pos).toFixed(two_fixed);

        if (due >= 0) {
            $('#balance1').val(accounting.formatNumber(due));
            $('#change_p').val(0);
        } else {
            due = due * (-1)
            $('#balance1').val(0);
            $('#change_p').val(accounting.formatNumber(due));
        }
    }

    $('#pos_card_pay').on("click", function (e) {
        e.preventDefault();
        $('#cardPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&' + $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        update_register();
    });
    $('#pos_basic_pay').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&account=' + $("#p_account option:selected").val() + '&employee=' + $("#employee option:selected").val();
        var action_url = $('#action-url').val();
		console.log('Entreiaaaa');
        addObject(o_data, action_url);
        setTimeout(
            function () {
                update_register();
            }, 3000);
    });
	
    $('#pos_basic_print').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&printnow=1' + '&account=' + $("#p_account option:selected").val() + '&employee=' + $("#employee option:selected").val();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        setTimeout(
            function () {
                update_register();
            }, 3000);
    });
    var file_id;
    $(document.body).on('click', '.print_image', function (e) {

        e.preventDefault();

        var inv_id = $(this).attr('data-inid');

        jQuery.ajax({
            url: '<?php echo base_url('pos_invoices/invoice_legacy') ?>',
            type: 'POST',
            data: 'inv=' + inv_id + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                file_id= data.file_name;
                $("#loader_pdf").attr('src','<?php echo  base_url() ?>userfiles/pos_temp/'+data.file_name+'.pdf');
                $("#loader_file").val(data.file_name);
            },
        });

        $('#pos_print').modal('toggle');
        $("#print_section").printThis({
            //  beforePrint: function (e) {$('#pos_print').modal('hide');},

            printDelay: 500,
            afterPrint: clean_data()
        });
    });


    function clean_data() {
        setTimeout(function(){
        var file_id= $("#loader_file").val();
        jQuery.ajax({
            url: '<?php echo base_url('pos_invoices/invoice_clean') ?>',
            type: 'POST',
            data: 'file_id=' + file_id + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

            },
        });
}, 2500);

    }



</script>

<!-- Vendor libraries -->
<script type="text/javascript">
    var $form = $('#payment-form');
    $form.on('submit', payWithCard);

    /* If you're using Stripe for payments */
    function payWithCard(e) {
        e.preventDefault();

        /* Visual feedback */
        $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
            .prop('disabled', true);

        jQuery.ajax({
            url: '<?php echo base_url('billing/process_card') ?>',
            type: 'POST',
            data: $('#payment-form').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            },
            error: function () {
                $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                /* Show Stripe errors on the form */
                $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                $form.find('.payment-errors').closest('.row').show();
                $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                    .prop('disabled', true);
                $("#notify .message").html("<strong>Error</strong>: Please try again!");
            }
        });
    }


    $('#categories').change(function () {
        var whr = $('#s_warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });
    $('#s_warehouses').change(function () {
        var whr = $('#s_warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    })
    $(document).ready(function () {

        if (localStorage.bar_only && localStorage.bar_only != '') {
            $('#bar_only').attr('checked', 'checked');

        } else {
            $('#bar_only').removeAttr('checked');
        }

        $('#bar_only').click(function () {

            if ($('#bar_only').is(':checked')) {

                localStorage.bar_only = $('#bar_only').val();
            } else {
                localStorage.bar_only = '';
            }
            $('#search_bar').attr('readonly', false);
        });

        Mousetrap.bind('alt+x', function () {
            $('#search_bar').focus();
        });
        Mousetrap.bind('alt+c', function () {
            $('#pos-customer-box').focus();
        });

        Mousetrap.bind('alt+z', function () {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function () {
            window.location.href = "<?php echo base_url('pos_invoices/create') ?>";
        });
        Mousetrap.bind('alt+q', function () {
            $('#posp0').click();
            $('#search_bar').val('');
        });
        Mousetrap.bind('alt+s', function () {
            if ($('#basicPay').hasClass('show')) {
                $('#pos_basic_print').click();
            } else {
                $('.possubmit3').click();
            }

        });

        $('#search_bar').keyup(function (event) {
            if (!$(this).attr('readonly')) {
                //$('#search_bar').keyup(function () {
                var whr = $('#s_warehouses option:selected').val();
                var cat = $('#categories option:selected').val();
                if (this.value.length > 2) {
                    $.ajax({
                        type: "POST",
                        url: baseurl + 'search_products/pos_search',
                        data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash + '&bar=' + $('#bar_only').prop('checked'),
                        beforeSend: function () {
                            $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#pos_item").html(data);

                        }
                    });

                }
            }

            if (event.keyCode == 13 && !$('#search_bar').attr('readonly')) {
                $('#search_bar').attr('readonly', true);
                wait = false;
                def_timeout(1000).then(function () {
                    $('#posp0').click();
                    def_timeout(1800).then(function () {
                        var whr = $('#s_warehouses option:selected').val();
                        var cat = $('#categories option:selected').val();
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'search_products/pos_search',
                            data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash + '&bar=' + $('#bar_only').prop('checked'),
                            beforeSend: function () {
                                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                            },
                            success: function (data) {
                                $("#pos_item").html(data);
                                $('#search_bar').attr('readonly', false);
                                $('#search_bar').val('');
                            }

                        });
                    });


                });


            }
        });
    });
</script>