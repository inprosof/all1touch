<div class="content-body">
    <div class="card card-block bg-white">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add New supplier Details') ?></h5>

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
            <form method="post" id="data_form" class="form-horizontal">
				<div class="card">
                    <div class="card-content">
                        <div class="card-body">
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                       aria-controls="tab1" href="#tab1" role="tab"
                                       aria-selected="true">Informação</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#tab2" role="tab"
                                       aria-selected="false">Contatos</a>
                                </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false">Faturação</a>
                                </li>
								<li class="nav-item">
									<a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
									   href="#tab4" role="tab"
									   aria-selected="false"><?php echo $this->lang->line('CustomFields') ?></a>
								</li>
                            </ul>
							<div class="tab-content px-1 pt-1">
								<div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
									<hr>
									<div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="taxid">Contribuinte*</label>
                                        <div class="col-sm-6">
										<label class="col-sm-12" for="taxid">Deve ser um valor único</label>
                                            <input type="text" placeholder="<?php echo $this->lang->line('IRS Number') ?>"
                                                   class="form-control margin-bottom b_input required" name="taxid" id="taxid">
                                        </div>
                                    </div>
									
									<div class="form-group row">
                                        <label class="col-sm-12" for="taxid">Verificar contribuinte no sistema VIES</label>
                                        <div class="col-sm-12">
											<label class="col-sm-12" for="taxid">Nota: A verificação dos contribuintes no Sistema VIES só é possível para as empresas da União Europeia! Esta verificação é opcional!
Escolha o país de origem da empresa que deseja verificar e carregue em "Verificar Contribuinte".</label>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="msupplier_cont_vies"><?php echo $this->lang->line('Country') ?></label>

												<div class="col-sm-6">
													<select name="msupplier_cont_vies" class="form-control b_input" id="msupplier_cont_vies">
														<?php
														echo $countrys;
														?>

													</select>
												</div>
											</div>
											<input type="submit" class="btn btn-primary btn-md" id="calculate_due"
													   value="Verificar NIF VIES">
                                        </div>
                                    </div>
									<hr>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?>*</label>

										<div class="col-sm-6">
											<input type="text" placeholder="Name"
												   class="form-control margin-bottom required" name="name">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Company') ?></label>
										<div class="col-sm-6">
											<input type="text" placeholder="Company"
												   class="form-control margin-bottom" name="company_1" id="company_1">
										</div>
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label"
											   for="address"><?php echo $this->lang->line('Address') ?></label>

										<div class="col-sm-6">
											<input type="text" placeholder="address"
												   class="form-control margin-bottom" name="address" id="address">
										</div>
									</div>
									<div class="form-group row">
										
										<div class="col-sm-4">
											<label class="col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

											<div class="input-group">
												<input type="text" placeholder="city"
													   class="form-control margin-bottom" name="city" id="city">
											</div>
										</div>
										<div class="col-sm-4">
											<label class="col-form-label"
												   for="region"><?php echo $this->lang->line('Region') ?></label>

											<div class="input-group">
												<input type="text" placeholder="Region"
													   class="form-control margin-bottom" name="region" id="region">
											</div>
										</div>
										<div class="col-sm-4">
											<label class="col-form-label"
												   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

											<div class="input-group">
												<input type="text" placeholder="PostBox"
													   class="form-control margin-bottom" name="postbox" id="postbox">
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="country"><?php echo $this->lang->line('Country') ?></label>
										<div class="col-sm-6">
											<select name="country" class="form-control b_input" id="country">
												<option value="0">Escolha uma Opção</option>
												<?php
												echo $countrys;
												?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="phone"><?php echo $this->lang->line('Phone') ?></label>

										<div class="col-sm-6">
											<input type="text" placeholder="phone"
												   class="form-control margin-bottom" name="phone" id="phone">
										</div>
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?>*</label>

										<div class="col-sm-6">
											<input type="text" placeholder="email"
												   class="form-control margin-bottom required" name="email" id="email">
										</div>
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="email">Website</label>

										<div class="col-sm-6">
											<input type="text" placeholder="website"
												   class="form-control margin-bottom" name="website" id="website">
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_ative">Ativo*</label>
										<div class="col-sm-6">
											<select name="n_ative" class="form-control b_input required" id="n_ative">
												<option value="">Escolha uma Opção</option>
												<option value="0"><?php echo $this->lang->line('Yes') ?></option>
												<option value="1"><?php echo $this->lang->line('No') ?></option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_lang">Idioma*</label>
										<div class="col-sm-6">
											<select name="n_lang" class="form-control b_input required" id="n_lang">
												<option value="">Escolha uma Opção</option>
												<?php
												echo $langs;
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="email">Desconto global</label>

										<div class="col-sm-6">
											<input type="text" placeholder="desc_glo"
												   class="form-control margin-bottom" onkeypress="return isNumber(event)" name="desc_glo" id="desc_glo" value="0.00"/>
										</div>
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="email">Limite de Crédito</label>

										<div class="col-sm-6">
											<input type="text" placeholder="limit_cre"
												   class="form-control margin-bottom" onkeypress="return isNumber(event)" name="limit_cre" id="limit_cre" value="0.00"/>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_praz_venc">Prazo de Vencimento</label>
										<div class="col-sm-6">
											<select name="n_praz_venc" class="form-control b_input" id="n_praz_venc">
												<option value="">Escolha uma Opção</option>
												<?php
												echo $prazos_vencimento;
												?>
											</select>
										</div>
									</div>
						
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_copy">Nº Cópias</label>
										<div class="col-sm-6">
											<select name="n_copy" class="form-control b_input" id="n_copy">
												<option value="">Escolha uma Opção</option>
												<?php
												echo $nume_copys;
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_met_pag">Método Pagamento</label>
										<div class="col-sm-6">
											<select name="n_met_pag" class="form-control b_input" id="n_met_pag">
												<option value="">Escolha uma Opção</option>
												<?php
												echo $metodos_pagamentos;
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"
											   for="n_met_exp">Método de Expedição</label>
										<div class="col-sm-6">
											<select name="n_met_exp" class="form-control b_input" id="n_met_exp">
												<option value="">Escolha uma Opção</option>
												<?php
												echo $expeditions;
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">

										<label class="col-sm-2 col-form-label" for="email">Observações</label>

										<div class="col-sm-6">
											<textarea rows="5" cols="1" placeholder="obs" placeholder="obs"
												   class="form-control margin-bottom" name="obs" id="obs"></textarea>
										</div>
									</div>
								</div>
								<div class="tab-pane show" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                 <?php
									foreach ($custom_fields as $row) {
										if ($row['f_type'] == 'text') { ?>
											<div class="form-group row">
												<label class="col-sm-10 col-form-label"
													   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
												<div class="col-sm-8">
													<input type="text" placeholder="<?php echo $row['placeholder'] ?>"
														   class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
														   name="custom[<?php echo $row['id'] ?>]">
												</div>
											</div>
										<?php }else if ($row['f_type'] == 'check') { ?>
											<div class="form-group row">
												<label class="col-sm-10 col-form-label"
													   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input <?php echo $row['other'] ?>" id="custom[<?php echo $row['id'] ?>]" name="custom[<?php echo $row['id'] ?>]">
													<label class="custom-control-label"
													   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['placeholder'] ?></label>
												</div>
											</div>
										<?php }else if ($row['f_type'] == 'textarea') { ?>
											<div class="form-group row">
												<label class="col-sm-10 col-form-label"
													   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
												<div class="col-sm-8">
													<textarea placeholder="<?php echo $row['placeholder'] ?>"
														   class="summernote <?php echo $row['other'] ?>"
														   name="custom[<?php echo $row['id'] ?>]" rows="1"></textarea>
												</div>
											</div>
										<?php }
									}
									?>
                                </div>
							</div>
							
							
							
							<div class="form-group row">
								<label class="col-sm-2 col-form-label"></label>

								<div class="col-sm-4">
									<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
										   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
									<input type="hidden" value="supplier/addsupplier" id="action-url">
								</div>
							</div>
						</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
	$("#calculate_due").click(function (e) {
		e.preventDefault();
		var actionurl = baseurl + 'customers/searchVIES';
		t_actionCaculate(actionurl);
	});
	
	function t_actionCaculate(actionurl) {
		$.ajax({url: actionurl,
				type: 'POST',
				data: 'taxid=' + $('#taxid').val() + '&' + 'country=' + $('#msupplier_cont_vies').val() + '&' + crsf_token + '=' + crsf_hash,
				dataType: 'json',
				success: function (data) {
					if(!data['valid']) {
						$("#notify .message").html("<strong>Erro </strong>Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
						$("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
						$("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
					}else if(data['valid'])
					{
						$("#notify").hide();
						$('#company_1').html(data.name);
						$('#company_1').val(data.name);
						$Savename1 = "";
						$Saveadrr1 = "";
						$Saveadrr2 = "";
						$Saveadrr3 = "";
						$Saveadrr4 = "";
						$line = data.address.split('\n');
						if($line.length > 1)
						{
							$Saveadrr1 = $line[0];
							$Saveadrr2 = $line[1];
							$line2 = $line[2].split(' ');
							if($line2.length > 1)
							{
								$Saveadrr3 = $line2[0];
								//$Saveadrr4 = $line2[1];
							}
						}else{
							$Saveadrr1 = $data['address'];
						}
						var ee = $("#msupplier_cont_vies");
						var sel = document.getElementById('country');
						var opts = sel.options;
						for ( var i = 0; i < opts.length; i++ ) {
							if (opts[i]['value'] == ee.val()) {
							  sel.selectedIndex = i;
							  break;
							}
						}
						
						$('#address').val($Saveadrr1);
						$("#address").html($Saveadrr1);
						
						$('#city').val($Saveadrr2);
						$("#city").html($Saveadrr2);
						
						$('#postbox').val($Saveadrr3);
						$("#postbox").html($Saveadrr3);
						
						$('#region').val($Saveadrr2);
						$("#region").html($Saveadrr2);
					}else{
						$("#notify .message").html("<strong>Erro </strong>Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
						$("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
						$("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
					}
				},
				error: function (data) {
					$("#notify .message").html("<strong>" + data.status + "</strong>: Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
					$("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
					$("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
				}
			});
	}
</script>

