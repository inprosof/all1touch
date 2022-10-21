<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">
                <h5>POS Configurações</h5>
                <hr>
                <div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label" for="name">Estilo Documentos</label>
						<div class="input-group">
							<select name="pstyle" class="form-control">
								<?php switch (POSV) {
									case '1' :
										echo '<option value="1">** Versão Standard **</option>';
										break;
									case '2' :
										echo '<option value="2">**Versão Completa**</option>';
										break;
								} ?>
								<option value="1">Versão Standard</option>
								<option value="2">Versão Completa</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label" for="name">Listar Contas</label>
						<div class="input-group">
							<select class="form-control" name="pos_list">
								<option value="<?php echo PAC ?>">
									--<?php if (PAC == 1 || PAC == "1") {
										echo $this->lang->line('Yes');
									} else {
										echo $this->lang->line('No');
									} ?>--
								</option>
								<option value="0"><?php echo $this->lang->line('No') ?></option>
								<option value="1"><?php echo $this->lang->line('Yes') ?></option>
							</select>
						</div>
					</div>
				</div>
				
				
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/pos_style';
        actionProduct(actionurl);
    });
</script>
