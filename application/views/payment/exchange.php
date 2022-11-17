<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Currency Exchange') ?>
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
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <p><?php echo $this->lang->line('Application has integrated currencylayer.com API. It offers a real-time currency conversion for your
                invoices. Accurate Exchange Rates for 168 World Currencies with data updates ranging from every 60
                minutes down to stunning 60 seconds. Please visit currencylayer.com to get API key.') ?>
            <p>
            <p> <?php echo $this->lang->line('Please do not forget set the CRON job for automatic base rate updates in background.') ?></p>
            <p> <?php echo $this->lang->line('API Integration and Cron Job are optionals, you can manually set exchange rates here: ') ?>
                <a href="<?php echo base_url() ?>paymentgateways/currencies"><?php echo base_url() ?>
                    paymentgateways/currencies</a></p>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="currency"><?php echo $this->lang->line('Base Currency Code') ?>
                    <small>(i.e. USD,AUD)</small>
                </label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="currency"
                           value="<?php echo $exchange['url'] ?>" maxlength="3">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="key1"><?php echo $this->lang->line('API Key') ?></label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="key1"
                           value="<?php echo $exchange['key1'] ?>">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="key2">API Endpoint</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="key2"
                           value="<?php echo $exchange['key2'] ?>">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="enable"><?php echo $this->lang->line('Enable Exchange') ?></label>

                <div class="col-sm-6">
                    <?php if ($exchange['active'] == 1) {
                        $env = 'Yes';
                    } else {
                        $env = 'No';
                    } ?>
                    <select class="form-control" name="enable">
                        <option value="<?php echo $exchange['active'] ?>">
                            --<?php echo $this->lang->line($env) ?>--
                        </option>
                        <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="0"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row"><label class="col-sm-2 col-form-label">Secondary Currency as
                    Currency </label>
                <div class="col-sm-6">
                    <div class="">
                        <label class="display-inline-block custom-control custom-radio ml-1">
                            <input type="radio" name="reverse"
                                   value="1" <?php if ($exchange['other']) echo 'checked=""' ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0"><?php echo $this->lang->line('Yes') ?></span>
                        </label>
                        <label class="display-inline-block custom-control custom-radio">
                            <input type="radio" name="reverse"
                                   value="0" <?php if (!$exchange['other']) echo 'checked=""' ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description ml-0"><?php echo $this->lang->line('No') ?></span>
                        </label>
                    </div>
                    <div class="alert alert-info mt-2" id="alert-info-text">
                        <p>
                            <?php echo $this->lang->line('Recommended : No | With this option input during bill creation will be considered as per selected currency.') ?>
                        </p>
                    </div>
                </div>

            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-2" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Atualizando...">
                    <input type="hidden" value="paymentgateways/exchange" id="action-url">
                </div>
            </div>

        </div>
    </form>

</div>