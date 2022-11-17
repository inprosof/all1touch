<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('TAX') . ' Statement' ?>
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
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">

                        <form action="<?php echo base_url() ?>reports/taxviewstatement" method="post" role="form"><input
                                    type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="ty"><?php echo $this->lang->line('Type') ?></label>

                                <div class="col-sm-6">
                                    <select name="ty" class="form-control">
                                        <option value='Sales'>Vendas Clientes IVA Report</option>
                                        <option value='Sales2'>Vendas Fornecedores IVA Report</option>
                                        <option value='Purchase'>Nota de Encomenda Clientes IVA Report</option>
                                        <option value='Purchase2'>Nota de Encomenda Fornecedores IVA Report</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="edate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                                <div class="col-sm-6">
                                    <select name="lid" class="form-control">

                                        <option value='0'><?php echo $this->lang->line('All') ?></option>
                                        <?php
                                        foreach ($locations as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['cname'];
                                            $holder = $row['address'];
                                            echo "<option value='$cid'>$acn - $holder</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="pay_cat"></label>
                                <div class="col-sm-6" id="paiCompanyUpdate">
                                    <input type="submit" class="btn btn-primary btn-md"
                                           value=<?php echo $this->lang->line("View") ?>>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
