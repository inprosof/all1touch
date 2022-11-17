<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Currency') ?>
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
    <form method="post" id="data_form" class="card-body">
        <div class="grid_3 grid_4">
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="name">ISO <?php echo $this->lang->line('Code') ?></label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="code"
                           maxlength="3">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="acn">Symbol</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="symbol" maxlength="3"
                    >
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="spost"><?php echo $this->lang->line('Symbol Position') ?></label>

                <div class="col-sm-6">
                    <select name="spos" class="form-control">

                        <option value="0">Left</option>
                        <option value="1">Right</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="rate">Exchange Rate</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="rate">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="currency"><?php echo $this->lang->line('Decimal Place') ?></label>

                <div class="col-sm-6">
                    <select name="decimal" class="form-control">

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
                       for="thous_sep"><?php echo $this->lang->line('Thousand Saparator') ?></label>

                <div class="col-sm-6">
                    <select name="thous_sep" class="form-control">

                        <option value=",">, (Comma)</option>
                        <option value=".">. (Dot)</option>
                        <option value="">None</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="currency"><?php echo $this->lang->line('Decimal Saparator') ?></label>

                <div class="col-sm-6">
                    <select name="deci_sep" class="form-control">
                        <option value=".">. (Dot)</option>
                        <option value=",">, (Comma)</option>
                        <option value="">None</option>
                    </select>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-6" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="paymentgateways/add_currency" id="action-url">
                </div>
            </div>

        </div>
    </form>

</div>