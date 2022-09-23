<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form" class="form-horizontal">
                <h5><?php echo $this->lang->line('Add New assets Category') ?></h5>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="product_catname"><?php echo $this->lang->line('Category Name') ?></label>
						<div class="col-sm-6">
							<input type="text" placeholder="Assets Category Name" class="form-control margin-bottom  required" name="assets_catname">
						</div>
                </div>
				
				<div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="product_cat_name"><?php echo $this->lang->line('Category') ?></label>
                        <div class="col-sm-6">
							<select name="asset_cat_type" class="form-control required">
								<option value=""><?php echo $this->lang->line('Please Select Category') ?></option>
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
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom" value="<?php echo $this->lang->line('Add Category') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="assests/addcat" id="action-url">
                    </div>
                </div>
            </form>
        </div>
    </div>
</article>



