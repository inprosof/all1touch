<article class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Product search settings') ?>
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
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">
                <div class="alert alert-info" id="alert-info-text">
                    <p><?php echo $this->lang->line('search_serial_with_not_available') ?></p>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('product_search_settings') ?></label>

                    <div class="col-sm-6"><select name="serial" class="form-control">

                            <?php switch ($billing_settings['key1']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('search_default') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('search_serial_with') . '**</option>';
                                    break;
                                case '2' :
                                    echo '<option value="2">**' . $this->lang->line('search_serial_only') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('search_default') ?></option>
                            <option value="1"><?php echo $this->lang->line('search_serial_with') ?></option>
                            <option value="2"><?php echo $this->lang->line('search_serial_only') ?></option>


                        </select>

                    </div>

                </div>


                <div class="alert alert-info" id="alert-info-text">
                    <p><?php echo $this->lang->line('Allow sales person to bill with 0 stock, helpful to use products as a service.') ?></p>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Zero Stock') ?></label>

                    <div class="col-sm-6"><select name="stock" class="form-control">

                            <?php switch ($zero_stock['key1']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="1"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><h5><?php echo $this->lang->line('disable_expired_products') ?> </h5>
                    </label>

                    <div class="col-sm-6"><select name="expired" class="form-control">

                            <?php switch ($billing_settings['key2']) {
                                case '0' :
                                    echo '<option value="0">** ' . $this->lang->line('No') . ' **</option>';
                                    break;
                                case '1' :
                                    echo '<option value="1">**' . $this->lang->line('Yes') . '**</option>';
                                    break;

                            } ?>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>


                        </select>

                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Atualizando...">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/billing_settings';
        actionProduct(actionurl);
    });
</script>
