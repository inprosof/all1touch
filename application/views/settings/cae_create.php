<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Add') . ' C.A.E' ?>
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

        <div class="form-group row">

            <label class="col-sm-2 col-form-label"
                   for="tcod">Código</label>

            <div class="col-sm-6">
                <input type="text" placeholder="Cae Cod"
                       class="form-control margin-bottom  required" name="tcod">
            </div>
        </div>
        <div class="form-group row">

            <label class="col-sm-2 col-form-label"
                   for="tname">Designação</label>

            <div class="col-sm-6">
                <input type="text" placeholder="Cae Des"
                       class="form-control margin-bottom  required" name="tname">
            </div>
        </div>

        <div class="form-group row">

            <label class="col-sm-2 col-form-label"></label>

            <div class="col-sm-6" id="paiCompanyUpdate">
                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                       value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                <input type="hidden" value="settings/caes_new" id="action-url">
            </div>
        </div>


    </form>
</div>
<div class="fab">
    <button class="main">
        <i class="bi bi-info-circle"></i>
    </button>
    <ul>
        <li>
            <label for="opcao1">Opção 1</label>
            <div class="card" id="opcao1">
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                    with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                    publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>
            </div>
        </li>
    </ul>
</div>


