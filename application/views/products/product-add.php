<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header pb-0">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add New Product') ?>
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

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form">
                <input type="hidden" name="act" value="add_product">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                           aria-controls="tab1" href="#tab1" role="tab"
                           aria-selected="true">Informação Geral</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                           href="#tab2" role="tab"
                           aria-selected="false">Impostos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                           href="#tab3" role="tab"
                           aria-selected="false">Fornecedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                           href="#tab4" role="tab"
                           aria-selected="false"><?php echo $this->lang->line('CustomFields') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
                           href="#tab5" role="tab"
                           aria-selected="false">Imagem</a>
                    </li>
                </ul>
                <div class="tab-content pt-1">
                    <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                        <div class="form-group row">
                            <div class="col-sm-4"><label class="col-form-label"
                                                         for="product_name"><?php echo $this->lang->line('Product Name') ?>
                                    *</label>
                                <input type="text" placeholder="Product Name"
                                       class="form-control margin-bottom required" name="product_name">
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label"
                                       for="product_code">Referência<?php echo ' (Último Código: ' . $ultimaref . ')'; ?></label>
                                <input type="text" placeholder="Product Code"
                                       class="form-control required" name="product_code"
                                       value="<?php echo $nextcod; ?>">
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label"
                                       for="product_cat"><?php echo $this->lang->line('Product Category') ?>*</label>
                                <select name="product_cat" id="product_cat" class="form-control required">
                                    <option value=""><?php echo $this->lang->line('Please Select') ?></option>
                                    <?php
                                    echo $cat;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label class="col-form-label"
                                       for="product_warehouse"><?php echo $this->lang->line('Warehouse') ?>*</label>
                                <select name="product_warehouse" id="product_warehouse" class="form-control required">
                                    <option value=""><?php echo $this->lang->line('Please Select warehouse') ?></option>
                                    <?php
                                    foreach ($warehouse as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4"><label class="col-form-label"
                                                         for="product_typ">Tipo*</label>
                                <select name="product_typ" id="product_typ" class="form-control required">
                                    <option value=""><?php echo $this->lang->line('Please Select') ?></option>
                                    <?php
                                    foreach ($typ as $row) {
                                        $cid = $row['id'];
                                        $ccod = $row['cod'];
                                        $title = $row['title'];
                                        echo "<option value='$cid' data-serie='$ccod'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label"><?php echo $this->lang->line('Measurement Unit') ?>
                                    *</label>
                                <select name="unit" id="unit" class="form-control required">
                                    <option value=""><?php echo $this->lang->line('Please Select') ?></option>
                                    <?php
                                    foreach ($units as $row) {
                                        $cid = $row['code'];
                                        $title = $row['name'];
                                        echo "<option value='$cid'>$title - $cid</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label class="col-form-label"><?php echo $this->lang->line('Price'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?php echo $this->config->item('currency') ?></span>

                                    <input type="text" name="product_price" id="product_price"
                                           class="form-control required"
                                           placeholder="0.00" aria-describedby="sizing-addon1"
                                           onkeypress="return isNumber(event)"
                                           onkeyup="rowTotalTax('0') rowTotalSupl('0')" value="0.00"
                                           style="border-right: none">
                                    <div class="input-group-addon" id="info-text" data-container="body"
                                         data-toggle="popover" data-placement="top"
                                         data-content="<?php echo $this->lang->line('Price without taxes & fees') ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label"><?php echo $this->lang->line('Discount rate during') ?></label>
                                <div class="input-group">
                                    <input type="text" name="product_disc" id="product_disc"
                                           class="form-control required"
                                           placeholder="<?php echo $this->lang->line('Default Discount Rate') ?>"
                                           aria-describedby="sizing-addon1"
                                           onkeypress="return isNumber(event)"
                                           onkeyup="rowTotalTax('0'), rowTotalSupl('0')" value="0.00">
                                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-4"><label class="col-form-label"
                                                         for="product_class"><?php echo $this->lang->line('Product Classes') ?>
                                    *</label>
                                <select name="product_class" id="product_class" class="form-control required">
                                    <option value=""><?php echo $this->lang->line('Please Select') ?></option>
                                    <?php
                                    foreach ($p_cla as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="product_fav_pos"
                                       id="product_fav_pos">
                                <label class="custom-control-label" for="product_fav_pos">Favorito no POS</label>
                            </div>
                            <div class="custom-control custom-checkbox stockyes hidden">
                                <input type="checkbox" class="custom-control-input" name="product_tem_stock"
                                       id="product_tem_stock">
                                <label class="custom-control-label" for="product_tem_stock">Tem stock</label>


                            </div>
                        </div>

                        <div class="form-group row stockutility hidden">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="sub_classif">Tipo de Produto (Inventário stocks
                                    AT)</label>
                                <select id="sub_classif" name="sub_classif" class="form-control required select-box"
                                        disabled="true">
                                    <option value="0">Sem Classificação</option>
                                    <?php
                                    foreach ($classifica as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label class="col-form-label"><?php echo $this->lang->line('Stock Units') ?></label>
                                <input type="text" placeholder=""
                                       class="form-control margin-bottom required" name="product_qty"
                                       onkeypress="return isNumber(event)" value="0"></div>
                            <div class="col-sm-2">
                                <label class="col-form-label">Custo unitário</label>
                                <input type="text" placeholder=""
                                       class="form-control margin-bottom required" name="product_coust_unit"
                                       onkeypress="return isNumber(event)" value="0"></div>

                            <div class="col-sm-2">
                                <label class="col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>
                                <input type="text" placeholder=""
                                       class="form-control margin-bottom" name="product_qty_alert"
                                       onkeypress="return isNumber(event)" value="0">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>
                            <div class="col-sm-2">
                                <select class="form-control" name="code_type">
                                    <option value="EAN13">EAN13 - Default</option>
                                    <option value="UPCA">UPC</option>
                                    <option value="EAN8">EAN8</option>
                                    <option value="ISSN">ISSN</option>
                                    <option value="ISBN">ISBN</option>
                                    <option value="C128A">C128A</option>
                                    <option value="C39">C39</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" placeholder="BarCode Numeric Digit 123112345671"
                                       class="form-control margin-bottom" name="barcode"
                                       onkeypress="return isNumber(event)">
                                <div class="alert alert-info">
                                    <small>Se deixar em Branco o sistema cria uma Referência automática em
                                        EAN13.</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>
                            <div class="col-sm-12">
								<textarea maxlength="250" placeholder="Descrição - Máximo 250 Caracteres"
                                          class="form-control margin-bottom required" name="product_desc"
                                ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?>
                                )</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control required"
                                       placeholder="Expiry Date" name="wdate"
                                       data-toggle="datepicker" autocomplete="false" id="input-date">

                                <div class="alert alert-info" id="alert-info-text">
                                    <small>Não altere se não é aplicável</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-outline-danger add_serial btn-sm m-1">   <?php echo $this->lang->line('add_serial') ?></button>
                        <div id="added_product"></div>
                        <hr>
                        <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                            <div id="coupon4" class="card-header">
                                <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                                   aria-expanded="true" aria-controls="accordion41"
                                   class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                                    <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                </a>

                            </div>
                            <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                                 class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="row p-1">
                                    <div class="col">
                                        <button class="btn btn-success tr_clone_add" style="
                                                    margin-bottom: 15px;">
                                            <i class="fa fa-plus-square"></i>
                                            <?php echo $this->lang->line('add_row') ?>
                                        </button>
                                        <table class=" table" id="v_var">
                                            <tr>
                                                <td><select name="v_type[]" class="form-control">
                                                        <?php
                                                        foreach ($variables as $row) {
                                                            $cid = $row['id'];
                                                            $title = $row['name'];
                                                            $title = $row['name'];
                                                            $variation = $row['variation'];
                                                            echo "<option value='$cid'>$variation - $title </option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td><input value="" class="form-control" name="v_stock[]"
                                                           placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                                </td>
                                                <td><input value="" class="form-control" name="v_alert[]"
                                                           placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger tr_delete">
                                                        <i class="fa fa-minus-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="accordionWrapa2" role="tablist" aria-multiselectable="true">

                            <div id="coupon5" class="card-header">
                                <a data-toggle="collapse" data-parent="#accordionWrapa2" href="#accordion42"
                                   aria-expanded="true" aria-controls="accordion41"
                                   class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                                    <?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Warehouse') ?>
                                </a>
                            </div>
                            <div id="accordion42" role="tabpanel" aria-labelledby="coupon5"
                                 class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="row p-1">
                                    <div class="col">
                                        <button class="btn btn-success tr_clone_add_w" style="
                                                    margin-bottom: 15px;">
                                            <i class="fa fa-plus-square"></i>
                                            <?php echo $this->lang->line('add_row') ?>
                                        </button>
                                        <table class="table" id="w_var">
                                            <tr>
                                                <td>
                                                    <select name="w_type[]" class="form-control">
                                                        <?php
                                                        foreach ($warehouse as $row) {
                                                            $cid = $row['id'];
                                                            $title = $row['title'];
                                                            echo "<option value='$cid'>$title</option>";
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td><input value="" class="form-control" name="w_stock[]"
                                                           placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                                </td>
                                                <td><input value="" class="form-control" name="w_alert[]"
                                                           placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger tr_delete">
                                                        <i class="fa fa-minus-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                        <div id="saman-row">
                            <small><?php echo $this->lang->line('Tax rate during') ?></small>
                            <table class="table-responsive tfr my_stripe" id="table-block">
                                <thead>
                                <tr class="item_header bg-gradient-directional-blue white">
                                    <th width="60%"
                                        class="text-center"><?php echo $this->lang->line('Default TAX Rate') ?></th>
                                    <th width="15%" class="text-center">Valor</th>
                                    <th width="20%" class="text-center">Cumulativo</th>
                                    <th width="5%"
                                        class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control required" name="tax_n[]"
                                               placeholder="Please select One Tax"
                                               id='tax_n-0'>
                                    </td>
                                    <td><input type="text" readonly class="form-control text-center amnt"
                                               id="tax_val-0"
                                               name="tax_val[]" value="0.00"></td>
                                    <td id="tax_como_td"><input type="checkbox" class="form-control text-center"
                                                                id="tax_como-0" name="tax_como[]">
                                        <select hidden
                                                name="tax_ise[]"
                                                id="tax_ise-0"
                                                class="form-control round">
                                            <option value="0"><?php echo $this->lang->line('Please Select') ?></option>
                                            <?php foreach ($withholdings as $row) {
                                                echo '<option value="' . $row['id'] . '">' . $row['val1'] . '</option>';
                                            } ?>
                                        </select></td>
                                    <input type="hidden" class="pdIn" name="pidt[]" id="pidt-0" value="0">
                                    <input type="hidden" class="pdIn2" name="pcodid[]" id="pcodid-0" value="0">
                                    <input type="hidden" class="pdIn3" name="pperid[]" id="pperid-0" value="0">
                                </tr>
                                <tr class="last-item-row sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success" aria-label="Left Align"
                                                id="addtax">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                        </button>
                                    </td>
                                    <td colspan="7"></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="col-sm-4">
                                <label class="col-form-label">Total de Taxas</label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control text-center" id="ftotal_tax"
                                           name="ftotal_tax" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                        <div id="saman-row-supplier">
                            <table class="table-responsive tfr my_stripe" id="table-block">
                                <thead>
                                <tr class=" item_header bg-gradient-directional-blue white">
                                    <th width="20%" class="text-center">Fornecedor</th>
                                    <th width="15%" class="text-center">Referência</th>
                                    <th width="10%" class="text-center">Preço de Custo</th>
                                    <th width="10%" class="text-center">Desconto C.</th>
                                    <th width="10%" class="text-center">Desconto global</th>
                                    <th width="10%" class="text-center">Preço de C. c/ Desc.</th>
                                    <th width="10%" class="text-center">Margem (€)</th>
                                    <th width="10%" class="text-center">Margem (%)</th>
                                    <th width="5%"
                                        class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="supli_n[]"
                                               placeholder="Please select One Supplier"
                                               id='supli_n-0'>
                                    </td>
                                    </td>
                                    <td><input type="text" class="form-control text-center" id="supli_ref-0"
                                               name="supli_ref[]"></td>
                                    <td><input type="text" onkeyup="rowTotalSupl('0')"
                                               class="form-control text-center suppa" id="supli_pr_c-0"
                                               name="supli_pr_c[]"></td>
                                    <td><input type="text" readonly class="form-control text-center"
                                               id="supli_des_c-0"
                                               name="supli_des_c[]" value="0.00"></td>
                                    <td><input type="text" readonly class="form-control text-center"
                                               id="supli_des_g-0"
                                               name="supli_des_g[]" value="0.00"></td>
                                    <td><input type="text" readonly class="form-control text-center"
                                               id="supli_pr_c_d-0"
                                               name="supli_pr_c_d[]" value="0.00"></td>
                                    <td><input type="text" readonly class="form-control text-center"
                                               id="supli_marg_e-0"
                                               name="supli_marg_e[]" value="0.00"></td>
                                    <td><input type="text" readonly class="form-control text-center"
                                               id="supli_marg_p-0"
                                               name="supli_marg_p[]" value="0.00"></td>
                                    <input type="hidden" class="pdIn4" name="supliid[]" id="supliid-0" value="0">
                                </tr>
                                <tr class="last-item-row-s sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success" aria-label="Left Align"
                                                id="addsupplier">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                        </button>
                                    </td>
                                    <td colspan="7"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
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
                            <?php } else if ($row['f_type'] == 'check') { ?>
                                <div class="input-group mt-1">
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
                                                      name="custom[<?php echo $row['id'] ?>]" rows="1"></textarea>
                                    </div>
                                </div>
                            <?php }
                        }
                        ?>
                    </div>
                    <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
                        <input type="hidden" name="image" id="image" value="default.png">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                            <div class="col-sm-6">
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <!-- The container for the uploaded files -->
                                <table id="files" class="files"></table>
                                <br>
                                <span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Select files...</span>
                                    <!-- The file input field used as target for the file upload widget -->
									<input id="fileupload" type="file" name="files[]">
								</span>
                                <br>
                                <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                                <br>
                                <!-- The global progress bar -->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-primary margin-bottom"
                               value="<?php echo $this->lang->line('Add product') ?>"
                               data-loading-text="Adicionando..." style="margin-top: 1rem;">
                        <input type="hidden" value="products/addproduct" id="action-url">
                    </div>
                </div>
                <input type="hidden" value="search_tax" id="bill_tax">
                <input type="hidden" value="search_supplier" id="bill_supplier">
            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?php echo $this->security->get_csrf_token_name(); ?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
                $('#image').html(img);
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


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    $("#product_typ").on('change', function () {
        var tips = $("#product_typ option:selected").attr('data-serie');
        $('#sub_classif').prop('selectedIndex', 0);
        $("#sub_classif").val('0');
        if (tips == 'P') {
            $("#sub_classif").attr({disabled: false});
            $('.stockyes').removeClass('hidden');
        } else {
            $("#sub_classif").attr({disabled: true});
            $('.stockyes').addClass('hidden');
            $('.stockutility').addClass('hidden');
        }
        $("#product_qty").val('0');
        $("#product_coust_unit").val('0');
        $("#product_qty_alert").val('0');
    });

    $("#product_tem_stock").on('change', function (event) {
        if (event.currentTarget.checked) {
            $('.stockutility').removeClass('hidden');
        } else {
            $('.stockutility').addClass('hidden');
        }
        $("#product_qty").val('0');
        $("#product_coust_unit").val('0');
        $("#product_qty_alert").val('0');
    });

    $(document).on('click', ".v_delete_serial", function (e) {
        e.preventDefault();
        $(this).closest('div .serial').remove();
    });
    $(document).on('click', ".add_serial", function (e) {
        e.preventDefault();

        $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?php echo $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?php echo $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

    });

</script>
