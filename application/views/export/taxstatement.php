<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('TAX Report Export') ?>
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
            <div class="card-body">

                <div class="content">
                    <div class="card card-block">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>


                        <div class="row sameheight-container">
                            <div class="col-md-12">
                                <div class="card card-block sameheight-item">

                                    <form action="<?php echo base_url() ?>export/taxstatement_o" method="post"
                                          role="form">
                                        <input type="hidden"
                                               name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"
                                                   for="sdate"><?php echo $this->lang->line('From Date') ?></label>
                                            <div class="col-sm-6">
                                                <select name="ty" class="form-control">
                                                    <option value='Sales'>Vendas</option>
                                                    <option value='Purchase'>Notas de Encomendas</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"
                                                   for="sdate"><?php echo $this->lang->line('From Date') ?></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control required"
                                                       placeholder="Start Date" name="sdate"
                                                       data-toggle="datepicker" autocomplete="false" id="input-date">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label"
                                                   for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                            <div class="col-sm-2">
                                                <input type="text" class="form-control required"
                                                       placeholder="End Date" name="edate"
                                                       data-toggle="datepicker" autocomplete="false" id="input-date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="pay_cat"></label>

                                            <div class="col-sm-6" id="paiCompanyUpdate">
                                                <input type="submit" class="btn btn-primary btn-md"
                                                       value="<?php echo $this->lang->line('Export') ?>">


                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
