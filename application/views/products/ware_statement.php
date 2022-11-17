<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $product['title'] . ' ';
            echo $this->lang->line('Statements') ?>
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
    <div class="card card-body">

        <div class="row ">
            <div class="col-md-12 m-1">
                <form action="<?php echo base_url() ?>productcategory/warehouse_report" method="post"
                      role="form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input name="id" type="hidden" value="<?php echo $product['id'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                        <div class="col-md-4">
                            <select name="r_type" class="form-control">

                                <option value='1'><?php echo $this->lang->line('Sales') ?></option>
                                <option value='2'><?php echo $this->lang->line('Purchase Order') ?></option>
                                <option value='3'><?php echo $this->lang->line('Stock Transfer') ?></option>

                            </select>


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-md-2 control-label"
                               for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                        <div class="col-md-4">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="s_date" id="sdate"
                                   autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-md-2 control-label"
                               for="edate"><?php echo $this->lang->line('To Date') ?></label>

                        <div class="col-md-4">
                            <input type="text" class="form-control required"
                                   placeholder="End Date" name="e_date"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="pay_cat"></label>

                        <div class="col-md-4" id="paiCompanyUpdate">
                            <input type="submit" class="btn btn-primary btn-md"
                                   value=<?php echo $this->lang->line("View") ?>>


                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>