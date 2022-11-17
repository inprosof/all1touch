<article class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('CRM') ?><?php echo $this->lang->line('Settings') ?>
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
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('SelfCustomerRegistration') ?> </label>

                    <div class="col-sm-6"><select name="register" class="form-control">

                            <?php switch ($current['key1']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Customer') ?> Registration With Email
                        Verification</label>

                    <div class="col-sm-6"><select name="email_conf" class="form-control">

                            <?php switch ($current['url']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="alert alert-info" id="alert-info-text">
                        <p><?php echo $this->lang->line('Send automatic email during customer registration by
                        employee. Please do not enable this feature unnecessarily, it may slow the customer registration
                        process as the application will connect to email server if your email is slow.') ?>
                        </p>
                    </div>
                    <label class="col-sm-2 col-form-label"
                           for="product_name">Auto Email Customer Details (Registration by Employee) </label>

                    <div class="col-sm-6"><select name="automail" class="form-control">

                            <?php switch ($current['other']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


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
        var actionurl = baseurl + 'settings/registration';
        actionProduct(actionurl);
    });
</script>
