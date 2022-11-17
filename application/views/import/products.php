<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Import Products') ?>
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


                <?php echo form_open_multipart('import/products_upload'); ?><input type="hidden"
                                                                                   name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                                                   value="<?php echo $this->security->get_csrf_hash(); ?>">

                <p>Your products data file should as per this template <a
                            href="<?php echo base_url('userfiles/product/products_import.csv') ?>"><strong>Download
                            Template</strong></a>. Please download a database backup before importing the
                    geopos_products.
                </p>
                <div class="alert alert-info" id="alert-info-text">
                    <p>Column Order in CSV File Must be like this</p>
                    <pre>
1. (string)Product A, 2. (string)ProductCODE, 3.(number)Sales_Price, 4.(number)Factory_Price,

5.(number)TAX_Rate, 6.(number)Discount_Rate, 7.(integer)Quantity,

8.(string)Product_Description, 9.(integer)Low_Stock_Alert_Quantity
                </pre>
                </div>
                <hr>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">File
                    </label>

                    <div class="col-sm-6">
                        <input type="file" name="userfile" size="15"/>(csv format only)
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Product Category') ?></label>

                    <div class="col-sm-6">
                        <select name="product_cat" class="form-control">
                            <?php
                            echo $cat;
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>

                    <div class="col-sm-6">
                        <select name="product_warehouse" class="form-control">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Import Products') ?>" data-loading-text="Adding...">

                    </div>
                </div>

            </div>
        </div>

