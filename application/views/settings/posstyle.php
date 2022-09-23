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

                    <label class="col-sm-5 col-form-label"
                           for="product_name">POS: Estilo Documentos</label>

                    <div class="col-sm-5"><select name="pstyle" class="form-control">
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
				<div class="form-group row">
					<label class="col-sm-5 col-form-label"
						   for="enable">POS: Listar Contas</label>

					<div class="col-sm-5">
						<select class="form-control" name="pos_list">
							<option value="<?php echo $online_pay['bank'] ?>">
								--<?php if (PAC) {
									echo $this->lang->line('Yes');
								} else {
									echo $this->lang->line('No');
								} ?>--
							</option>
							<option value="1"><?php echo $this->lang->line('Yes') ?></option>
							<option value="0"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-5 col-form-label"
						   for="typedoc">POS: Documento <?php echo $this->lang->line('Default') ?></label>
					<div class="col-sm-5">
						<select name="type_doc" class="selectpicker form-control round required">
								<option value="<?php echo $current['key1'] ?>">** <?php echo $current['typ_name'] ?> **</option>
							<?php
								echo $irs_typ;
							?>

						</select>
					</div>
				</div>
				<hr>
				
				<h5>Configurações Gerais</h5>
				<div class="form-group row">
                    <label class="col-sm-5 col-form-label"
                           for="product_name">Geral: <?php echo $this->lang->line('AllowAssignEmployee') ?></label>

                    <div class="col-sm-5"><select name="assign" class="form-control">

                            <?php switch ($current['key1']) {
                                case '1' :
                                    echo '<option value="1">** '.$this->lang->line('Yes') .' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**  '.$this->lang->line('No') .'**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>
				
				<h5>Loja por Defeito se não Definido na Localização</h5>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label"
						   for="tzone"><?php echo $this->lang->line('Warehouse').' '.$this->lang->line('Default')?></label>
					<div class="col-sm-6">
						<select name="wid" class="form-control">
							<?php
							echo '<option value="' . $ware['key1'] . '">*--';
							if($ware['key1'] == 0)
							{
								echo $this->lang->line('All');
							}else{
								echo $this->lang->line('Do not change');
							}
							
							echo '--*</option>';
							echo '<option value="0">' . $this->lang->line('All') . '</option>';
							foreach ($warehouses as $row) {
								echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
							}
							?>
						</select>
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
