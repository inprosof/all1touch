<article class="content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Edit Product warehouse') ?>
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

                <form method="post" id="data_form" class="form-horizontal">
                    <div class="card card-block">
                        <input type="hidden" name="catid" value="<?php echo $warehouse['id'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label" for="product_cat_name">Warehouse Name</label>

                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control margin-bottom  required" name="product_cat_name"
                                       value="<?php echo $warehouse['title'] ?>">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label">Description</label>

                            <div class="col-sm-6">


                                <input type="text" name="product_cat_desc" class="form-control required"
                                       aria-describedby="sizing-addon1" value="<?php echo $warehouse['extra'] ?>">

                            </div>

                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                            <div class="col-sm-6">
                                <select name="lid" class="form-control">
                                    <option value='<?php echo $warehouse['loc'] ?>'><?php echo $this->lang->line('Do not change') ?></option>
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

                            <div class="col-sm-4" id="paiCompanyUpdate">
                                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                       value="Update" data-loading-text="Atualizando...">
                                <input type="hidden" value="productcategory/editwarehouse" id="action-url">
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</article>

