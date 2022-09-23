<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Add') . ' '.$this->lang->line('Withholding')?></h5>
                <hr>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="tcode">Cod.</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Cod"
                               class="form-control margin-bottom  required" name="tcode">
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="tcodesend">Cod. Send</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Cod Send"
                               class="form-control margin-bottom  required" name="tcodesend">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="tname"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Name"
                               class="form-control margin-bottom  required" name="tname">
                    </div>
                </div>
				
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="tdiscription"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Tax Description"
                               class="form-control margin-bottom  required" name="tdiscription">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="trate"><?php echo $this->lang->line('Rate') ?> (%)</label>

                    <div class="col-sm-6">
                        <input type="number" placeholder="Tax Rate"
                               class="form-control margin-bottom  required" name="trate">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="ttype"><?php echo $this->lang->line('Type') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control round" name="ttype">
                            <option value="yes" data-tformat="yes">Exclusive</option>
                            <option value="inclusive" data-tformat="incl"><?php echo $this->lang->line('Inclusive') ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/taxwithholdings_new" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

