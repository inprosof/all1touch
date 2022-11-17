<article class="content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add New Product Warehouse') ?>
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
        <div class="card card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card card-block">


                <form method="post" id="data_form" class="card-body">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_catname"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Warehouse Name"
                                   class="form-control margin-bottom  required" name="product_catname">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_catname"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Warehouse Description"
                                   class="form-control margin-bottom required" name="product_catdesc">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

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

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-6" id="paiCompanyUpdate">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adicionando...">
                            <input type="hidden" value="productcategory/addwarehouse" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</article>

