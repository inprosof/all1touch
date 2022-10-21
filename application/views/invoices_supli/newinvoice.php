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
								
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Order') ?> <?php echo $this->lang->line('From') ?><a href='#'
                                                                                          class="btn btn-primary btn-sm round"
                                                                                          data-toggle="modal"
                                                                                          data-target="#addCustomer" <?php if ($order > 0) echo ' hidden' ?>>
                                                <?php echo $this->lang->line('Add Supplier') ?>
                                            </a>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst" class="caption" <?php if ($order > 0) echo ' hidden' ?>><?php echo $this->lang->line('Search Supplier') ?> </label>
                                        <input type="text" class="form-control" name="cst" id="supplier-box"
                                               placeholder="Enter Supplier Name or Mobile Number to search"
                                               autocomplete="off" <?php if ($order > 0) echo ' hidden' ?>/>

                                        <div id="supplier-box-result" <?php if ($order > 0) echo ' hidden' ?>></div>
                                    </div>
                                </div>
								
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Supplier Details'); ?>
                                        <hr>
										<input type="hidden" name="order_id" id="order_id" value="<?php echo $order?>" />
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
                                               class="caption">Fatura - Fornecedor Nº <strong><?php echo $lastinvoice + 1 ?> (numeração provisória)</strong></label>
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
                                                                 class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

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
                                                                 class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" autocomplete="false" data-toggle="datepicker" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea></div>
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
							
							if(!empty($products))
							{
								$cvalue = 0;
								$functionNum = "'".$cvalue."'";
								foreach ($products as $row) {
									$myArraytaxperc = explode(";", $row['taxaperc']);
									$myArraytaxvals = explode(";", $row['taxavals']);
									
									$valsumperc = "";
									foreach ($myArraytaxperc as $row1) {
										$valsumperc .= $row1."%";
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
                        if(is_array($custom_fields)){
                          echo'<div class="card">';
                                    foreach ($custom_fields as $row) {
                                        if ($row['f_type'] == 'text') { ?>
                                            <div class="row mt-1">

                                                <label class="col-sm-8"
                                                       for="docid"><?php echo $row['name'] ?></label>

                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="<?php echo $row['placeholder'] ?>"
                                                           class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
                                                           name="custom[<?php echo $row['id'] ?>]">
                                                </div>
                                            </div>


                                        <?php }
                                    }
                                    echo'</div>';
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
									<?php echo $this->lang->line('Payment Terms') ?> 
									<select name="pterms" class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select>
								</td>
								<td colspan="5">
                                    <div>
                                        <label><?php echo $this->lang->line('Update Stock') ?></label>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight1" value="yes">
                                                <label class="custom-control-label"
                                                       for="customRadioRight1"><?php echo $this->lang->line('Yes') ?></label>
                                            </div>
                                        </fieldset>
                                        <fieldset class="right-radio">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="update_stock"
                                                       id="customRadioRight2" value="no" checked="">
                                                <label class="custom-control-label"
                                                       for="customRadioRight2"><?php echo $this->lang->line('No') ?></label>
                                            </div>
                                        </fieldset>

                                    </div>
                                </td>
								<td>
									<input type="submit" class="btn btn-success sub-btn" value="Guardar Rascunho" id="submit-data3" data-loading-text="Creating...">
									<input type="submit" class="btn btn-success sub-btn btn-lg" value="Guardar e finalizar Documento" id="submit-data" data-loading-text="Creating...">
								</td>
                            </tr>
							</tbody>
						</table>
					</div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="invoices_supli/action" id="action-url">
					<input type="hidden" value="invoices_supli/action2" id="action-url2">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-success white">

                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Supplier') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">


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

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="email" placeholder="Email"
                                   class="form-control margin-bottom crequired" name="email" id="mcustomer_email">
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


                        <div class="col-sm-4">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom" name="city" id="mcustomer_city">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>
                        <div class="col-sm-4">
                            <select name="country" class="form-control b_input" id="mcustomer_country">
										<option value="">Escolha uma Opção</option>
										<?php
										echo $countrys;
										?>
									</select>
                        </div>

                    </div>

                    <div class="form-group row">


                        <div class="col-sm-6">
                            <input type="text" placeholder="PostBox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="TAX ID"
                                   class="form-control margin-bottom" name="taxid" id="tax_id">
                        </div>
                    </div>


                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="msupplier_add" class="btn btn-primary submitBtn"
                           value="<?php echo $this->lang->line('ADD') ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
	$("#invoi_serie").select2();
	
	$("#s_accounts").on('change', function () {
		var tips = $('#s_accounts').val();
		var accountaaa = $("#s_accounts option:selected").attr('data-serie');
		$("#account_set").val(accountaaa);
		$("#account_set_id").val(tips);
	});
</script>