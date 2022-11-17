<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add Printer') ?>
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

        <div class="card-body">
            <form method="post" id="data_form" class="card-body">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_name">Printer Name</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Printer Name"
                               class="form-control margin-bottom  required" name="p_name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_type">Printer Type</label>

                    <div class="col-sm-6">
                        <select class="form-control" name="p_type">
                            <option value="file">File Printer</option>
                            <option value="network">Network Printer</option>
                            <option value="windows">Windows Printer (USB)</option>
                            <option value="test">Test Dummy Printer</option>
                            <option value="server">Easy REST Based Print Server</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="p_connect">Printer Connector</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Printer Connector"
                               class="form-control margin-bottom required" name="p_connect">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                    <div class="col-sm-6">
                        <select name="lid" class="form-control">
                            <?php
                            if (!$this->aauth->get_user()->loc) echo "<option value='0'>" . $this->lang->line('Default') . "</option>";
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

                    <label class="col-sm-2 col-form-label"
                           for="lid">Printing Mode</label>

                    <div class="col-sm-6">
                        <select name="pmode" class="form-control">
                            <option value='0'>Basic</option>
                            <option value='1'>Advanced</option>
                        </select>
                        <small>Basic: Text only (very fast) | Advanced Mode: Logo</small>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adicionando...">
                        <input type="hidden" value="printer/add" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>

