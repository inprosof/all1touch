<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Print Invoice') ?> Style
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

    <form method="post" id="product_action" class="card-body">
        <div class="card card-block">

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="product_name"><?php echo $this->lang->line('Print Invoice') ?></label>

                <div class="col-sm-6"><select name="pstyle" class="form-control">

                        <?php switch (INVV) {
                            case '1' :
                                echo '<option value="1">** Standard Version **</option>';
                                break;
                            case '2' :
                                echo '<option value="2">** Compact Version**</option>';
                                break;

                        } ?>
                        <option value="1">Standard Version</option>
                        <option value="2">Compact Version</option>


                    </select>

                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card-group">
                    <div class="card">
                        <div class="card-header">
                            <h5>1. Standard Version</h5>
                        </div>
                        <div class="card-body">
                            <img alt="image" id="dpic"
                                 class="img-responsive img-md img-md"
                                 src="<?php echo assets_url() ?>assets/images/v1.png">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5> 2. Compact Version</h5>
                        </div>
                        <div class="card-body">
                            <img alt="image" id="dpic" class="img-md"
                                 src="<?php echo assets_url() ?>assets/images/v2.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/print_invoice';
        actionProduct(actionurl);
    });
</script>
