<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card-body">

                <h5>Woo Commerce Integration Using REST</h5>
                <hr>
                <p>Woo Commerce (WC) 2.6+ is fully integrated with the WordPress REST API. <br><span
                            class="text-primary">You can link your WooCommerce Store to Geo POS. To create or manage keys for a specific WordPress user, go to WooCommerce > Settings >Advanced > REST API.</span>
                </p>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Consumer Key</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key1"
                               value="<?php echo $universal['key1'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Consumer Secret</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $universal['key2'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Store Url</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="url"
                               value="<?php echo $universal['url'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Employee for store invoices</label>

                    <div class="col-sm-8">
                        <select name="emp" class="form-control">
                           <?php if($universal['method']) { ?><option value='<?php echo $universal['method'] ?>'>Do not change</option> <?php } ?>
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-sm-6" for="p_cat">Default Product Category to import</label>

                        <div class="col-sm-8">
                            <select name="p_cat" class="form-control">
                                <option value='<?php echo $config['category'] ?>'> (<?php echo $productcat['title'] ?>
                                    )
                                </option>
                                <?php
                                foreach ($cat as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">

                            <label class="col-sm-6 " for="p_warehouse">Default Product WareHouse to import</label>

                            <div class="col-sm-8">
                                <select name="p_warehouse" class="form-control">
                                    <option value='<?php echo $config['warehouse'] ?>'>
                                        (<?php echo $warehouse['title'] ?>)
                                    </option>
                                    <?php
                                    foreach ($warehouses as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
   <div class="col-sm-6">
                    <label class="col-sm-6" for="terms">Import Images</label>

                    <div class="col-sm-8">
                        <select name="images" class="form-control">
                            <option value='<?php echo $config['images'] ?>'>-<?php echo $config['images'] ?>-</option>
                            <option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="No"><?php echo $this->lang->line('No') ?></option>
                        </select>
                    </div>
                </div>
<div class="col-sm-6">
                <div class="form-group row">

                    <label class="col-sm-6" for="terms">Product Status</label>

                    <div class="col-sm-8">
                        <select name="p_status" class="form-control">
                            <option value='<?php echo $config['filter'] ?>'>-<?php echo $config['filter'] ?>-</option>
                            <option value='any'>Any</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                            <option value="pending">Pending</option>
                            <option value="pending">Private</option>
                        </select>
                    </div>
                </div>
</div>
</div>             <div class="form-group row">
   <div class="col-sm-6">
                    <label class="col-sm-6" for="terms">Default Discount</label>

                    <div class="col-sm-8">
                           <input type="number"
                               class="form-control margin-bottom  required" name="discount"
                               value="<?php echo $config['discount'] ?>">
                    </div>
                </div>
<div class="col-sm-6">
                <div class="form-group row">

                    <label class="col-sm-6" for="terms">Default Tax</label>

                    <div class="col-sm-8">
                        <input type="number"
                               class="form-control margin-bottom  required" name="tax"
                               value="<?php echo $config['tax'] ?>">
                    </div>
                </div>
</div>
</div>
                <hr>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="woocommerce" id="action-url">
                    </div>
                </div>

            </div>
        </form>

        <div class="card-body border-purple border-lighten-3">
            <div class="row">
                <div class="col-md-6"><h5>Import Woocommerce Products</h5>
                    <hr>


                    <p>You can import your woocommerce products to geo pos with one click.</p>
                    <a href="#" data-toggle="modal" data-target="#importProducts"
                       class="btn btn-blue-grey btn-lg margin-bottom"
                       data-loading-text="Importing..."><?php echo $this->lang->line('Import') ?></a>
                    <div class="card card-block p-1 text-bold-600 text-primary" id="products"></div>
                </div>
                <div class="col-md-6"><h5>Import Woocommerce Orders</h5>
                    <hr>


                    <p>You can import your woocommerce orders to geo pos with one click.</p>
                    <a href="#" data-toggle="modal" data-target="#importOrders"
                       class="btn btn-blue btn-lg margin-bottom"
                       data-loading-text="Importt..."><?php echo $this->lang->line('Import') ?></a>
                    <div class="card card-block p-1  text-bold-600 text-primary" id="orders"></div>
                </div>
            </div>

        </div>

        <div class="card-body border-success border-lighten-3">
            <h5 class="purple">Cron Jobs</h5>

            <hr>
            <p class="text-bold-500 blue">WooCommerce Auto Orders Import is</p>
            <pre class="card-block card">WGET <?php echo base_url('woocommerce/woo_orders?token=' . $cornkey) ?></pre>
            <pre class="card-block card">GET <?php echo base_url('woocommerce/woo_orders?token=' . $cornkey) ?></pre>
            <hr>
            <hr>
            <p class="text-bold-500 success">WooCommerce Auto Products Import is</p>
            <pre class="card-block card">WGET <?php echo base_url('woocommerce/woo_products?token=' . $cornkey) ?></pre>
            <pre class="card-block card">GET <?php echo base_url('woocommerce/woo_products?token=' . $cornkey) ?></pre>
            <hr>
            <p class="text-bold-500 purple">WooCommerce Auto Products Sync (After Import) is</p>
            <pre class="card-block card">WGET <?php echo base_url('woocommerce/woo_products_sync?token=' . $cornkey) ?></pre>
            <pre class="card-block card">GET <?php echo base_url('woocommerce/woo_products_sync?token=' . $cornkey) ?></pre>
            <hr>
        </div>
    </div>
    </div></div>

</article>
<div id="importProducts" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Import products</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Do you want to import products from WooCommerce Store ? <br> <br><small>It will be import max 100
                        product in each confirmation as limited by Woo Commerce API.<small></p>
            </div>
            <div class="modal-footer">


                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="wimport_products"><?php echo $this->lang->line('Yes') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="importOrders" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Import Orders</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Do you want to import Orders from WooCommerce Store ?</p>
            </div>
            <div class="modal-footer">


                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="wimport_orders"><?php echo $this->lang->line('Yes') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click', "#wimport_products", function (e) {
        e.preventDefault();
        var aurl = '<?=base_url() ?>woocommerce/woo_products?token=<?=$cornkey ?>&flag=json';
        var div_id = 'products';
        var message = 'Product Import Successful!';
        woo_action(aurl, div_id, message);
    });



    $(document).on('click', "#wimport_orders", function (e) {
        e.preventDefault();
        var aurl = '<?=base_url() ?>woocommerce/woo_orders?token=<?=$cornkey ?>';
        var div_id = 'orders';
        var message = 'Orders Import Successful!';

        woo_action(aurl, div_id, message);


    });

    function woo_action(aurl, div_id, message) {
        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#' + div_id).html(data.message);
                alert(data.status);
            }
        });
    }

</script>