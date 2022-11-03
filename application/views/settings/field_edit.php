<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Edit') ?><?php echo $this->lang->line('Custom') ?><?php echo $this->lang->line('Field') ?> </h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Custom Field Name"
                               class="form-control margin-bottom  required" name="f_name"
                               value="<?php echo $customfields['name'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_type"><?php echo $this->lang->line('Type') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_type">
							<option value="<?php echo $customfields['f_type']?>">**<?php echo $customfields['f_type']?>**</option>
                            <option value="text">Text</option>
							<option value="check">Check</option>
							<option value="textarea">Textarea</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_module"><?php echo $this->lang->line('Module') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_module">
							<option value="<?php echo $customfields['f_module']?>">**<?php echo $customfields['f_module_name']?>**</option>
                            <option value="1">Clientes</option>
                            <option value="2">Faturas</option>
							<option value="3">Orçamentos</option>
							<option value="4">Fornecedores</option>
                            <option value="5">Produtos</option>
							<option value="6">Funcionários</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_view"><?php echo $this->lang->line('Public View') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_view">
                            <?php if ($customfields['f_view']) echo ' <option value="1">**Sim**</option>'; ?>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                        <small>Qualquer pessoa pode ver do lado de fora do aplicativo.</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_required">Required</label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_required">
                            <?php if ($customfields['other']) echo ' <option value="required">**Sim**</option>'; ?>
                            <option value="">Não</option>
                            <option value="required">Sim</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_placeholder">Por Defeito</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Field PlaceHolder "
                               class="form-control margin-bottom required" name="f_placeholder"
                               value="<?php echo $customfields['placeholder'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_placeholder"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Field Description "
                               class="form-control margin-bottom" name="f_description"
                               value="<?php echo $customfields['value_data'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/edit_custom_field" id="action-url">
                        <input type="hidden" value="<?php echo $customfields['id'] ?>" name="fid">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

