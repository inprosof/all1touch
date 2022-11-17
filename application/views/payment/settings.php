<div class="card-content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                Configurações de Pagamento Online e Duplicar Transações
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
                
                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"
                           for="enable"><?php echo $this->lang->line('Enable Online Payment for Invoices') ?></label>

                    <div class="col-sm-5">
                        <select class="form-control" name="enable">
                            <option value="<?php echo $online_pay['enable'] ?>">
                                --<?php if ($online_pay['enable'] == 1) {
                                    echo $this->lang->line('Yes');
                                } else {
                                    echo $this->lang->line('No');
                                } ?>--
                            </option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"
                           for="enable"><?php echo $this->lang->line('Enable Bank Payment Button') ?></label>

                    <div class="col-sm-5">
                        <select class="form-control" name="bank">
                            <option value="<?php echo $online_pay['bank'] ?>">
                                --<?php if ($online_pay['bank'] == 1) {
                                    echo $this->lang->line('Yes');
                                } else {
                                    echo $this->lang->line('No');
                                } ?>--
                            </option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"
                           for="account">Conta Bancária Vendas Online</label>

                    <div class="col-sm-5">
                        <select name="account" class="form-control">

                            <?php
                            echo '<option value="' . $online_pay['default_acid'] . '">--Alterar a sua conta--</option>';

                            foreach ($acclist as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"
                           for="enable">Online Transação de débito automático útil para gerar extratos de vencimento em
                        algumas regiões.</label>

                    <div class="col-sm-5">
                        <select class="form-control" name="auto_debit">
                            <option value="<?php echo $online_pay['bank'] ?>">
                                --<?php if ($current['key2'] == 1) {
                                    echo $this->lang->line('Yes');
                                } else {
                                    echo $this->lang->line('No');
                                } ?>--
                            </option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="paymentgateways/settings" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>