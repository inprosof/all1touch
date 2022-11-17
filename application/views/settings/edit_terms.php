<div class="content-body">

    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Edit Term') ?>
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
        <div class="card-content">

            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">
                    <div class="grid_3 grid_4">


                        <input type="hidden" name="id" value="<?php echo $term['id'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="terms"><?php echo $this->lang->line('Name') ?></label>

                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control margin-bottom  required" name="title"
                                       value="<?php echo $term['title'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="terms"><?php echo $this->lang->line('Type') ?></label>

                            <div class="col-sm-6">
                                <select class="form-control margin-bottom" name="type">
                                    <option value="<?php echo $term['idterm'] ?>">--<?php echo $term['nameterm'] ?>--
                                    </option>
                                    <?php echo $terms; ?>
                                </select>


                                </select>
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                            <div class="col-sm-6">


                        <textarea name="terms" class="summernote"
                        ><?php echo $term['terms'] ?></textarea>
                            </div>

                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-6" id="paiCompanyUpdate">
                                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Atualizando...">
                                <input type="hidden" value="settings/edit_term" id="action-url">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']]

            ]
        });
    });
</script>


