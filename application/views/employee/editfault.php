<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Fault') ?>
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
        <form method="post" id="data_form" class="card-body">
            <input type="hidden" name="did" value="<?php echo $fault['id']; ?>">
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="pay_cat"><?php echo $this->lang->line('Employees') ?></label>

                <div class="col-sm-6">
                    <select name="employee" class="form-control required select-box">
                        <option value="<?php echo $fault['emp'] ?>">--<?php echo $fault['emp_nome'] ?>--</option>
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
            <div class="form-group row">

                <label class="col-sm-2 control-label"
                       for="from"><?php echo $this->lang->line('Start') ?></label>

                <div class="col-sm-2 input-group">
                    <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                    <input type="text" class="form-control required editdate"
                           placeholder="Start Date" name="adate"
                           autocomplete="false"
                           value="<?php echo dateformat($fault['adate']) ?>">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 control-label"
                       for="from"><?php echo $this->lang->line('End') ?></label>

                <div class="col-sm-2 input-group">
                    <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span></div>
                    <input type="text" class="form-control  required editdate"
                           placeholder="End Date" name="edate"
                           autocomplete="false"
                           value="<?php echo dateformat($fault['edate']) ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"
                       for="currency"><?php echo $this->lang->line('Justificated Fault?') ?></label>
                <div class="col-sm-2">
                    <select name="justified" class="form-control b_input">
                        <option value="<?php echo $fault['justified'] ?>">--<?php echo $fault['justifiedname'] ?>--
                        </option>
                        <option value="0"><?php echo $this->lang->line('No') ?></option>
                        <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                    </select>
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>

                <div class="col-sm-6">
                    <input type="text" placeholder="Note"
                           class="form-control margin-bottom b_input" name="note" value="<?php echo $fault['note'] ?>">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-6" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adicionando...">
                    <input type="hidden" value="employee/edfault" id="action-url">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>

<script>
    $('.editdate').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
</script>