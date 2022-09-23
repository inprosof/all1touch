<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Edit Asset') ?></h5>
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
        <?php
        // echo '<pre>';
        // print_r($assests);
        // echo '</pre>';
        ?>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form">
                <input type="hidden" name="aid" value="<?php echo $assests['id'] ?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label"  for="product_name"><?php echo $this->lang->line('Asset Name') ?>*</label>
                        <input type="text" placeholder="Asset Name" class="form-control margin-bottom required" name="product_name" value="<?php echo $assests['assest_name'] ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Assets Category') ?>*</label>
                        <select name="product_cat" id="product_cat" class="form-control required">
							<option value="<?php echo $assests['acat'] ?>" data-type="<?php echo $assests['acattype'] ?>"><?php echo $assests['cat_name'] ?></option>
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
							<option value="<?php echo $assests['warehouse'] ?>"><?php echo $assests['warehouse_name'] ?></option>
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
                               value="<?php echo $assests['qty'] ?>">
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
                                <option value="<?php echo $eid ?>" <?php echo $eid == $assests['employee_id'] ? 'selected' : '' ?> >
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
                               value="<?php echo $assests['insurance_date'] ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Inspection date') ?></label>
                        <input type="date" placeholder="<?php echo $this->lang->line('Inspection date') ?>"
                               class="form-control margin-bottom" name="inspection_date"
                               value="<?php echo $assests['inspection_date'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label class="col-form-label" for="product_cat"><?php echo $this->lang->line('Description') ?></label>
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ><?php echo $assests['product_des'] ?></textarea>
                    </div>
                </div>
                <div class="row pt-1">
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="assests/editasset" id="action-url">
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>

