<div class="content-body">
    <div class="card yellow-top">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <div class="card-header">
            <h5 class="title"><?php echo $this->lang->line('Discount') . ' & ' . $this->lang->line('Shipping') ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="card card-block">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="discstatus"><?php echo $this->lang->line('Discount') ?> nos Produtos ou
                                Serviços</label>

                            <div class="col-sm-6">
                                <select name="discstatus" class="form-control">
                                    <option value="<?php echo $discship['key1'] ?>">
                                        -<?php if ($discship['key1'] == '%') echo 'Após o IVA'; else echo 'Antes do IVA'; ?>
                                        -
                                    </option>
                                    <option value="%">Após o IVA</option>
                                    <option value="b_p">Antes do IVA</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="shiptax_type"><?php echo $this->lang->line('Tax') ?>
                                no <?php echo $this->lang->line('Shipping') ?>?</label>

                            <div class="col-sm-6">
                                <select name="shiptax_type" class="form-control">
                                    <option value="<?php echo $discship['url'] ?>">
                                        -<?php if ($discship['url'] == 'incl') echo 'Ligado'; else echo 'Desligado'; ?>-
                                    </option>
                                    <option value="incl">Ligado</option>
                                    <option value="off">Desligado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="shiptax_rate"><?php echo $this->lang->line('Shipping') ?> (%) a cobrar</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Iva de envio"
                                       class="form-control margin-bottom" name="shiptax_rate"
                                       value="<?php echo $discship['key2'] ?>">
                            </div>

                        </div>
                        <div class="alert alert-info" id="alert-info-text">
                            <p> <?php echo $this->lang->line('This % will be added to all invoices. In the Shipping field.') ?></p>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4" id="paiCompanyUpdate">
                                <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Atualizando...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/discship';
        actionProduct(actionurl);
    });
</script>

