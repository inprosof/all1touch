<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Tax') ?></h5>
                <hr>

				<input type="hidden" name="id" value="<?php echo $slabs['id'] ?>">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="tname"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Name"
                               class="form-control margin-bottom  required" value="<?php echo $slabs['val1'] ?>" name="tname">
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxcountryregion">Tax Country Region</label>
                    <div class="col-sm-6">
						<select name="taxcountryregion" class="form-control b_input required" id="taxcountryregion">
							<?php
							echo '<option value="' . $slabs['taxregion'] . '">-' . $slabs['country_name'] . '-</option>';
							echo $countrys;
							?>

						</select>
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxcode">Tax Code</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Code"
                               class="form-control margin-bottom required" value="<?php echo $slabs['taxcode'] ?>" name="taxcode">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxdescription">Tax Description</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Description"
                               class="form-control margin-bottom" value="<?php echo $slabs['taxdescription'] ?>" name="taxdescription">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="trate"><?php echo $this->lang->line('Rate') ?> (%)</label>

                    <div class="col-sm-6">
                        <input type="number" placeholder="Tax Rate"
                               class="form-control margin-bottom  required" value="<?php echo $slabs['val2'] ?>" name="trate">
                    </div>
                </div>

                <!--<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="ttype">Type</label>

                    <div class="col-sm-6">
                        <select class="form-control round" name="ttype">
                            <option value="yes" data-tformat="yes">Exclusive</option>
                            <option value="inclusive" data-tformat="incl">Inclusive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           name="ttype2">Type 2</label>

                    <div class="col-sm-6">
                        <select class="form-control round" name="ttype2">
                            <option value="yes" data-tformat="yes">Exclusive</option>
                            <option value="inclusive"
                                    data-tformat="incl">Inclusive</option>
                        </select>
                    </div>
                </div>-->


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/taxslabs_edit" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

