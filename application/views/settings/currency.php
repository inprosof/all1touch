<article class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Currency Format') ?>
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
                           for="invoiceprefix"><?php echo $this->lang->line('Currency') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom" name="currency"
                               value="<?php echo $currency['currency'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Decimal Saparator') ?></label>

                    <div class="col-sm-6">
                        <select name="deci_sep" class="form-control">
                            <?php
                            echo '<option value="' . $currency['key1'] . '">' . $currency['key1'] . '</option>';

                            ?>
                            <option value=",">, (Comma)</option>
                            <option value=".">. (Dot)</option>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="thous_sep"><?php echo $this->lang->line('Thousand Saparator') ?></label>

                    <div class="col-sm-6">
                        <select name="thous_sep" class="form-control">
                            <?php
                            echo '<option value="' . $currency['key2'] . '">' . $currency['key2'] . '</option>'; ?>
                            <option value=",">, (Comma)</option>
                            <option value=".">. (Dot)</option>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Decimal Place') ?></label>

                    <div class="col-sm-6">
                        <select name="decimal" class="form-control">
                            <?php
                            echo '<option value="' . $currency['url'] . '">' . $currency['url'] . '</option>'; ?>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="spost"><?php echo $this->lang->line('Symbol Position') ?></label>

                    <div class="col-sm-6">
                        <select name="spos" class="form-control">
                            <?php
                            if ($currency['method'] == 'l') $method = '**Left**'; else $method = '**Right**';
                            echo '<option value="' . $currency['method'] . '">' . $method . '</option>'; ?>
                            <option value="l">Left</option>
                            <option value="r">Right</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="spost"><?php echo $this->lang->line('Invoice') ?><?php echo $this->lang->line('Round Off') ?></label>
                    <div class="col-sm-6">
                        <select name="roundoff" class="form-control">
                            <?php
                            if ($currency['other'] == 'PHP_ROUND_HALF_UP') {
                                $method = '**ROUND_HALF_UP**';
                            } elseif ($currency['other'] == 'PHP_ROUND_HALF_DOWN') {
                                $method = '**ROUND_HALF_DOWN**';
                            } else {
                                $method = '**Off**';
                            }
                            echo '<option value="' . $currency['other'] . '">' . $method . '</option>'; ?>
                            <option value="">Off</option>
                            <option value="PHP_ROUND_HALF_UP">ROUND_HALF_UP</option>
                            <option value="PHP_ROUND_HALF_DOWN">ROUND_HALF_DOWN</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="spost"><?php echo $this->lang->line('Round Off') ?> Precision</label>

                    <div class="col-sm-6">
                        <select name="r_precision" class="form-control">
                            <?php
                            echo '<option value="' . $currency['active'] . '">' . $currency['active'] . '</option>'; ?>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-6" id="paiCompanyUpdate">
                    <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                </div>
            </div>

    </div>
</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/currency';
        actionProduct(actionurl);
    });
</script>

