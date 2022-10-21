<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Edit Product Category</h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" name="catid" value="<?php echo $productcat['id'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="product_cat_name"><?php echo $this->lang->line('Category Name') ?></label>
                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom required" name="product_cat_name"
                                   value="<?php echo $productcat['title'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>
                        <div class="col-sm-6">
                            <input type="text" name="product_cat_desc" class="form-control required"
                                   aria-describedby="sizing-addon1" value="<?php echo $productcat['extra'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
						<label class="col-sm-2 col-form-label" for="product_cat"><?php echo $this->lang->line('Category') ?> Pai</label>
						<div class="col-sm-6">
							<select name="cat_rel" class="form-control" <?php if($productcat['delete1'] == 0) echo 'disabled' ?>>
								<?php
								echo "<option value='" . $productcat['rel_id'] . "'>--".$productcat['painame']."--</option>";
								echo $cat;
								?>
							</select>
						</div>
					</div>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="vis_pos" id="vis_pos" value="<?php echo $productcat['vis_pos'] ?>" <?php if ($productcat['vis_pos'] == 1) echo 'checked="checked"' ?>>
						<label class="custom-control-label" for="vis_pos"><?php echo "Visível no POS" ?></label>
					</div>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="fav_pos" id="fav_pos" value="<?php echo $productcat['fav_pos'] ?>" <?php if ($productcat['fav_pos'] == 1) echo 'checked="checked"' ?>>
						<label class="custom-control-label" for="fav_pos"><?php echo "Favorito no POS" ?></label>
					</div>
					<div class="form-group row"><label
                                class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                        <div class="col-sm-6">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <table id="files" class="files">
                                <tr>
                                    <td>
                                        <a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=<?php echo $productcat['image'] ?>"
                                           class="aj_delete"><i
                                                    class="btn-danger btn-sm icon-trash-a"></i><?php echo $productcat['image'] ?>
                                        </a><img style="max-height:200px;"
                                                 src="<?php echo base_url() ?>userfiles/product/<?php echo $productcat['image'] . '?c=' . rand(1, 999) ?>">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								<span>Select files...</span>
														<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload" type="file" name="files[]">
							</span>
                            <br>
                            <pre>Allowed: gif, jpeg, png</pre>
                            <br>
                            <!-- The global progress bar -->

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Update" data-loading-text="Updating...">
                            <input type="hidden" value="productcategory/editcat" id="action-url">
                        </div>
                    </div>
					<input type="hidden" name="image" id="image" value="<?php echo $productcat['image'] ?>">
                </form>
            </div>
        </div>
	</div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
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