<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Assets Category') ?></h5>
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
                    <input type="hidden" name="catid" value="<?php echo $assetcat['id'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="product_cat_name"><?php echo $this->lang->line('Category Name') ?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control margin-bottom  required" name="product_cat_name" value="<?php echo $assetcat['title'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="product_cat_name"><?php echo $this->lang->line('Category') ?></label>
                        <div class="col-sm-6">
							<select name="asset_cat_type" class="form-control required">
								<option value="<?php echo $assetcat['type'] ?>"><?php echo $assetcat['type_name'] ?></option>
								<?php
								foreach ($catTypes as $row) {
									$cid = $row['id'];
									$title = $row['name'];
									echo "<option value='$cid'>$title</option>";
								}
								?>
							</select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom" value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                            <input type="hidden" value="assests/editcat" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
	 </div>
</div>


