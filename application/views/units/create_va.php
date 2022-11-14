<div class="card card-block yellow-top">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-header">
        <h5 class="title"><?php echo $this->lang->line('Add') . " " ?><?php echo $this->lang->line('Variations') ?></h5>
    </div>
    <div class="card card-block ">


        <form method="post" id="data_form" class="card-body">

            <div class="form-group row">

                <label class="col-sm-1 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

                <div class="col-sm-4">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom required" name="name">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Atualizando...">
                    <input type="hidden" value="units/create_va" id="action-url">
                </div>
            </div>

            <input type="hidden" name="image" id="image" value="logo.png">
        </form>
    </div>
</div>