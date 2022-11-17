<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Edit') . ' ( ' . $sms['name'] . ') ' . $this->lang->line('Template') ?>
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
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <input type="hidden" name="id" value="<?php echo $sms['id'] ?>">


            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('Body') ?></label>

                <div class="col-sm-6">
                        <textarea
                                class="form-control margin-bottom summernote" name="body"
                                rows="15"><?php echo $sms['other'] ?></textarea>
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-6" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Atualizando...">
                    <input type="hidden" value="templates/sms_update" id="action-url">
                </div>
            </div>

        </div>
    </form>
    <div class="box">
        <div class="col-sm-2">Variables are</div>
        <div class="col-sm-6">{BillNumber}, {URL},{DueDate},{Amount}</div>
    </div>

</div>