<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Edit Transaction Category') ?>
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
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card-body">
                <input type="hidden" name="catid" value="<?php echo $cat['id'] ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="catcod">Código</label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="catcod"
                               value="<?php echo $cat['cod'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="cat_name"><?php echo $this->lang->line('Category Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="cat_name"
                               value="<?php echo $cat['name'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Atualizando...">
                        <input type="hidden" value="transactions/editcatsave" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>