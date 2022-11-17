<div class="row">
    <div class="col-xl-3 col-md-12">
        <div class="card overflow-hidden">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="bg-primary p-2 media-middle">
                        <i class="bi bi-briefcase font-large-2 white"></i>
                    </div>
                    <div class="media-body p-1">
                        <h4><?php echo $this->lang->line('Sales') ?></h4>
                        <span><?php echo $this->lang->line('Total') ?></span>
                    </div>
                    <div class="media-right p-2 media-middle">
                        <h4 class="success" id="p3" class="font-large-x1 red float-xs-right">
                            <span id="p3" class="font-large-x1 red float-xs-right"><i
                                        class=" icon-refresh spinner"></i></span>
                        </h4>
                        <!--                            <h1 class="success"><span-->
                        <!--                                        id="dash_0"></span></h1>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="bg-warning p-2 media-middle">
                        <i class="bi bi-card-list font-large-2  white"></i>
                    </div>
                    <div class="media-body p-1">
                        <h4><?php echo $this->lang->line('Products') ?>
                        </h4>
                        <span><?php echo $this->lang->line('Qty') ?></span>
                    </div>
                    <div class="media-right p-2 media-middle">
                        <!--                            <h1 class="cyan" id="dash_1">0</h1>-->
                        <h4 class="cyan" id="p1" class="font-large-x1 blue float-xs-right">
                            <span id="p1" class="font-large-x1 blue float-xs-right"><i
                                        class=" icon-refresh spinner"></i></span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12">
        <div class="card overflow-hidden">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="bg-primary p-2 media-middle">
                        <i class="bi bi-calendar3 font-large-2 white"></i>
                    </div>
                    <div class="media-body p-1">
                        <h4><?php echo $this->lang->line('Month') ?></h4>
                        <span><?php echo $this->lang->line('Total') ?></span>
                    </div>
                    <div class="media-right p-2 media-middle">
                        <h4 class="success" id="p4" class="font-large-x1 red float-xs-right">
                            <span id="p4" class="font-large-x1 orange float-xs-right"><i
                                        class=" icon-refresh spinner"></i></span>
                        </h4>
                        <!--                            <h1 class="success"><span-->
                        <!--                                        id="dash_0"></span></h1>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="bg-warning p-2 media-middle">
                        <i class="bi bi-card-list font-large-2  white"></i>
                    </div>
                    <div class="media-body p-1">
                        <h4><?php echo $this->lang->line('Month') . ' ' . $this->lang->line('Products') ?>
                        </h4>
                        <span><?php echo $this->lang->line('Qty') ?></span>
                    </div>
                    <div class="media-right p-2 media-middle">
                        <!--                            <h1 class="cyan" id="dash_1">0</h1>-->
                        <h4 class="cyan" id="p2" class="font-large-x1 blue float-xs-right">
                            <span id="p2" class="font-large-x1 green float-xs-right"><i
                                        class=" icon-refresh spinner"></i></span></li>
                          
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">


    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Report') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Products') ?>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 ">
                <ul class="list-unstyled">
                    <!--                            <li class="font-large-x1 blue ">--><?php //echo $this->lang->line('Total') . ' ' . $this->lang->line('Sales') ?>
                    <!--                                <span id="p3" class="font-large-x1 red float-xs-right"><i-->
                    <!--                                            class=" icon-refresh spinner"></i></span>-->
                    <!--                            </li>-->
                    <!--                            <hr>-->
                    <!--                            <li class="font-large-x1 green">--><?php //echo $this->lang->line('Total') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Qty') ?>
                    <!--                                <span id="p1" class="font-large-x1 blue float-xs-right"><i-->
                    <!--                                            class=" icon-refresh spinner"></i></span></li>-->
                    <!--                            <hr>-->
                    <!--                            <li class="font-large-x1 indigo">--><?php //echo $this->lang->line('Month') ?>
                    <!--                                <span id="p4" class="font-large-x1 orange float-xs-right"><i-->
                    <!--                                            class=" icon-refresh spinner"></i></span></li>-->
                    <!--                            <hr>-->
                    <!--                            <li class="font-large-x1 blue-light">--><?php //echo $this->lang->line('Month') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Qty') ?>
                    <!--                                <span id="p2" class="font-large-x1 green float-xs-right"><i-->
                    <!--                                            class=" icon-refresh spinner"></i></span></li>-->
                    <li class="font-large-x1 orange" id="param1"></li>

                </ul>
            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <form method="post" id="product_action" class="form-horizontal">
                            <div class="grid_3 grid_4">
                                <h4><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Custom Range') ?></h4>
                                <hr>


                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"
                                           for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

                                    <div class="col-sm-6">
                                        <select name="pay_acc" class="form-control">
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

                                    <label class="col-sm-4 control-label"
                                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="Start Date" name="sdate" id="sdate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-4 control-label"
                                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="End Date" name="edate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"></label>

                                    <div class="col-sm-6" id="paiCompanyUpdate">
                                        <input type="hidden" name="check" value="ok">
                                        <input type="submit" id="calculate_p" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Calculate') ?>"
                                               data-loading-text="Calculating...">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <form method="post" id="product_action2" class="form-horizontal">
                            <div class="grid_3 grid_4">
                                <h4><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Custom Range') ?></h4>
                                <hr>


                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"
                                           for="pay_cat"><?php echo $this->lang->line('Product Category') ?></label>

                                    <div class="col-sm-6">
                                        <select name="pay_acc" class="form-control">
                                            <option value='0'><?php echo $this->lang->line('All') ?></option>
                                            <?php
                                            echo $cat;
                                            ?>
                                        </select>


                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label class="col-sm-4 control-label"
                                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control date30 required"
                                               placeholder="Start Date" name="sdate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-4 control-label"
                                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="End Date" name="edate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"></label>

                                    <div class="col-sm-6" id="paiCompanyUpdate">
                                        <input type="hidden" name="check" value="ok">
                                        <input type="submit" id="calculate_p_pc" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Calculate') ?>"
                                               data-loading-text="Calculating...">
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $("#calculate_p").click(function (e) {
            e.preventDefault();
            var actionurl = baseurl + 'reports/customproducts';
            actionCaculate(actionurl);
        });

        $("#calculate_p_pc").click(function (e) {
            e.preventDefault();
            var actionurl = baseurl + 'reports/customproducts_cat';
            actionCaculate(actionurl, '#product_action2');
        });

        setTimeout(function () {
            $.ajax({
                url: baseurl + 'reports/fetch_data?p=products',
                dataType: 'json',
                success: function (data) {
                    $('#p1').html(data.p1);
                    $('#p2').html(data.p2);
                    $('#p3').html(data.p3);
                    $('#p4').html(data.p4);
                },
                error: function (data) {
                    $('#response').html('Error')
                }

            });
        }, 2000);
    </script>