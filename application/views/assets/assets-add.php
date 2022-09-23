<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Add New Asset') ?></h5>
            <hr>
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
            <form method="post" id="data_form">


                <input type="hidden" name="act" value="add_product">


                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label"  for="product_name"><?php echo $this->lang->line('Asset Name') ?>*</label>
                        <input type="text" placeholder="Product Name" class="form-control margin-bottom required" name="product_name">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Assets Category') ?>*</label>
                        <select name="product_cat" id="product_cat" class="form-control required">
							<option value=""><?php echo $this->lang->line('Please Select Category') ?></option>
								<?php
								foreach ($cats as $row) {
									$cid = $row['id'];
									$title = $row['title'];
									$type = $row['type'];
									echo "<option value='$cid' data-type='$type'>$title</option>";
								}
								?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>
                        <select name="product_warehouse" class="form-control required">
                            <option value=""><?php echo $this->lang->line('Close') ?></option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Stock Units') ?>*</label>
                        <input type="text" placeholder="<?php echo $this->lang->line('Stock Units') ?>*"
                               class="form-control margin-bottom required" name="product_qty"
                               onkeypress="return isNumber(event)">
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Assign to') ?>*</label>
                        <select name="employee_id" class="form-control required">
                            <option value="">--Please Select employee--</option>
                            <?php foreach ($employees as $employee) : ?>
                                <?php
                                $eid = $employee['id'];
                                $name = $employee['name'];
                                ?>
                                <option value="<?php echo $eid ?>" >
                                    <?php echo $name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row insuranceRow">
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Insurance date') ?></label>
                        <input type="date" placeholder="<?php echo $this->lang->line('Insurance date') ?>"
                               class="form-control margin-bottom" name="insurance_date"
                               value="">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Inspection date') ?></label>
                        <input type="date" placeholder="<?php echo $this->lang->line('Inspection date') ?>"
                               class="form-control margin-bottom" name="inspection_date"
                               value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Description') ?></label>
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ></textarea>
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                               value="<?php echo $this->lang->line('Add New Asset') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="assests/addasset" id="action-url">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    $(document).ready(function (){
        if($('select[name="product_cat"]').find('option:selected').data('type') !== 1){
            $('.insuranceRow').addClass('hidden')
        }
    })
    $('select[name="product_cat"]').change(function (){
        let selectedCategoryType = $(this).find('option:selected').data('type')
        $('.insuranceRow').addClass('hidden')
        if(selectedCategoryType == 1){
            $('.insuranceRow').removeClass('hidden')
        }
    })
</script>
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


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });


    $("#sub_cat").select2();
    $("#product_cat").on('change', function () {
        $("#sub_cat").val('').trigger('change');
        var tips = $('#product_cat').val();
        $("#sub_cat").select2({

            ajax: {
                url: baseurl + 'products/sub_cat?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });
    $(document).on('click', ".v_delete_serial", function (e) {
        e.preventDefault();
        $(this).closest('div .serial').remove();
    });
    $(document).on('click', ".add_serial", function (e) {
        e.preventDefault();

        $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label"><?php echo $this->lang->line('serial') ?></label><div class="col-lg-10"><input class="form-control box-size" placeholder="<?php echo $this->lang->line('serial') ?>" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

    });
</script>
