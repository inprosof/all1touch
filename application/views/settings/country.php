<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Country') ?>
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

                    <label class="col-sm-2 col-form-label" for="Name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Name"
                               class="form-control margin-bottom b_input" name="name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="Prefix"><?php echo $this->lang->line('Prefix') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Prefix"
                               class="form-control margin-bottom b_input" name="prefix">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="currency">Culturs</label>
                    <div class="col-sm-2">
                        <select name="culturs" class="form-control b_input">
                            <?php foreach ($culturs as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['prefix'] . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="Indicativ"><?php echo $this->lang->line('Indicativ') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Indicativ"
                               class="form-control margin-bottom b_input" name="indicat">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="currency"><?php echo $this->lang->line('Member UE') ?></label>
                    <div class="col-sm-2">
                        <select name="memberue" class="form-control b_input">
                            <option value="0"><?php echo $this->lang->line('No') ?></option>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/country" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>