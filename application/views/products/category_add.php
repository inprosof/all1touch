<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
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
        <div class="card card-block">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
     
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="product_catname"><?php echo $this->lang->line('Category Name') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Category Name"
                                   class="form-control margin-bottom  required" name="product_catname">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="product_catdesc"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Product Category Short Description"
                                   class="form-control margin-bottom  required" name="product_catdesc">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="product_cat"><?php echo $this->lang->line('Category') ?> Pai</label>
                        <div class="col-sm-6">
                            <select name="cat_rel" id="cat_rel" class="form-control required">
                                <?php
                                if ($catpai != null) {
                                    if ($catpai['id'] != null) {
                                        echo '<option value="' . $catpai['id'] . '">** ' . $catpai['title'] . ' **</option>';
                                    }
                                }
                                echo $cat;
                                ?>
                            </select>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="vis_pos" id="vis_pos">
                            <label class="custom-control-label" for="vis_pos"><?php echo "Visível no POS" ?></label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="fav_pos" id="fav_pos">
                            <label class="custom-control-label" for="fav_pos"><?php echo "Favorito no POS" ?></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                        <div class="col-sm-6">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Select files...</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files[]">
						    </span>
                            <br>
                            <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                            <br>
                            <!-- The global progress bar -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4" id="paiCompanyUpdate">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add Category') ?>"
                                   data-loading-text="Adicionando...">
                            <input type="hidden" value="productcategory/addcat" id="action-url">
                        </div>
                    </div>
                    <input type="hidden" name="image" id="image" value="default.png">
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?php echo $this->security->get_csrf_token_name(); ?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
                $('#image').html(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });

</script>