<div class="content-body">
    <div class="card card-block bg-white">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Edit supplier Details') ?></h4>

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
        <div class="row">
			<div class="col-md-4 ">
				<div class="card card-block card-body">
					<h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
					<hr>
					<div class="ibox-content no-padding border-left-right">
						<img alt="profile picture" id="dpic" class="img-responsive col"
							 src="<?php echo base_url('userfiles/suppliers/') . $supplier['picture'] ?>">
					</div>
					<hr>
					<p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
								id="fileupload" type="file"
								name="files[]"></p></div>

			</div>
			<div class="col-md-8">
				<div class="card card-block card-body">
					<form method="post" id="data_form" class="form-horizontal">
						<input type="hidden" name="id" value="<?php echo $supplier['id'] ?>">
						
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
												<label class="col-sm-2 col-form-label" for="taxid">Contribuinte</label>
												<div class="col-sm-6">
												<label class="col-sm-12" for="taxid">Deve ser um valor único</label>
													<input type="text" placeholder="<?php echo $this->lang->line('IRS Number') ?>"
														   class="form-control margin-bottom b_input" name="taxid" id="taxid" value="<?php echo $supplier['taxid'] ?>">
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
												<label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

												<div class="col-sm-6">
													<input type="text" placeholder="Name"
														   class="form-control margin-bottom required" name="name" value="<?php echo $supplier['name'] ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Company') ?></label>
												<div class="col-sm-6">
													<input type="text" placeholder="Company"
														   class="form-control margin-bottom" name="company_1" id="company_1" value="<?php echo $supplier['company'] ?>">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label"
													   for="address"><?php echo $this->lang->line('Address') ?></label>

												<div class="col-sm-6">
													<input type="text" placeholder="address"
														   class="form-control margin-bottom" name="address" id="address" value="<?php echo $supplier['address'] ?>">
												</div>
											</div>
											<div class="form-group row">
												
												<div class="col-sm-4">
													<label class="col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

													<div class="input-group">
														<input type="text" placeholder="city"
															   class="form-control margin-bottom" name="city" id="city" value="<?php echo $supplier['city'] ?>">
													</div>
												</div>
												<div class="col-sm-4">
													<label class="col-form-label"
														   for="region"><?php echo $this->lang->line('Region') ?></label>

													<div class="input-group">
														<input type="text" placeholder="Region"
															   class="form-control margin-bottom" name="region" id="region" value="<?php echo $supplier['region'] ?>">
													</div>
												</div>
												<div class="col-sm-4">
													<label class="col-form-label"
														   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

													<div class="input-group">
														<input type="text" placeholder="PostBox"
															   class="form-control margin-bottom" name="postbox" id="postbox" value="<?php echo $supplier['postbox'] ?>">
													</div>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="country"><?php echo $this->lang->line('Country') ?></label>
												<div class="col-sm-6">
													<select name="country" id="country" class="form-control b_input">
														<?php
														echo '<option value="' . $supplier['country'] . '">-' . ucfirst($supplier['namecountry']) . '-</option>';
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
														   class="form-control margin-bottom" name="phone" id="phone" value="<?php echo $supplier['phone'] ?>">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?></label>

												<div class="col-sm-6">
													<input type="text" placeholder="email"
														   class="form-control margin-bottom required" name="email" id="email" value="<?php echo $supplier['email'] ?>">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label" for="email">Website</label>

												<div class="col-sm-6">
													<input type="text" placeholder="website"
														   class="form-control margin-bottom" name="website" id="website" value="<?php echo $supplier['website'] ?>">
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="n_ative">Ativo</label>
												<div class="col-sm-6">
													<select name="n_ative" class="form-control b_input required">
														<?php switch ($supplier['active']) {
															case '0' :
																echo '<option value="0">** ' . $this->lang->line('Yes') . ' **</option>';
																break;
															case '1' :
																echo '<option value="1">**' . $this->lang->line('No') . '**</option>';
																break;

														} ?>
														<option value="0"><?php echo $this->lang->line('Yes') ?></option>
														<option value="1"><?php echo $this->lang->line('No') ?></option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="n_lang">Idioma</label>
												<div class="col-sm-6">
													<select name="n_lang" class="form-control b_input required" id="n_lang">
														<?php
														echo '<option value="' . $supplier['lang'] . '">-' . ucfirst($supplier['lang']) . '-</option>';
														echo $langs;
														?>
													</select>
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label" for="email">Desconto global</label>

												<div class="col-sm-6">
													<input type="text" placeholder="desc_glo"
														   class="form-control margin-bottom" onkeypress="return isNumber(event)" name="desc_glo" id="desc_glo" value="<?php echo $supplier['desc_glo'] ?>">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label" for="email">Limite de Crédito</label>

												<div class="col-sm-6">
													<input type="text" placeholder="limit_cre"
														   class="form-control margin-bottom" onkeypress="return isNumber(event)" name="limit_cre" id="limit_cre" value="<?php echo $supplier['limit_cre'] ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="n_praz_venc">Prazo de Vencimento</label>
												<div class="col-sm-6">
													<select name="n_praz_venc" class="form-control b_input required" id="n_praz_venc">
														<?php
														if($supplier['prazo_ve'] == null || $supplier['prazo_ve'] == "") 
															echo '<option value="">Escolha uma Opção</option>';
														else 
															echo '<option value="' . $supplier['prazo_ve'] . '" data-type="'.$supplier['prazo_ve_t'].'">-' . $supplier['prazo_ve_name'] . '-</option>'; 
														echo $prazos_vencimento;
														?>
													</select>
												</div>
											</div>
								
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"
													   for="n_copy">Nº Cópias</label>
												<div class="col-sm-6">
													<select name="n_copy" class="form-control b_input required" id="n_copy">
														<?php
														if($supplier['n_copy'] == null || $supplier['n_copy'] == "") echo '<option value="">Escolha uma Opção</option>'; else echo '<option value="' . $supplier['n_copy'] . '" data-type="'.$supplier['n_copy_t'].'">-' . $supplier['n_copy_name'] . '-</option>'; 
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
														<?php
														if($supplier['metod_pag'] == null || $supplier['metod_pag'] == "") echo '<option value="">Escolha uma Opção</option>'; else echo '<option value="' . $supplier['metod_pag'] . '" data-type="'.$supplier['metod_pag_t'].'">-' . $supplier['metod_pag_name'] . '-</option>'; 
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
														<?php
														if($supplier['metod_exp'] == null || $supplier['metod_exp'] == "") echo '<option value="">Escolha uma Opção</option>'; else echo '<option value="' . $supplier['metod_exp'] . '" data-type="'.$supplier['metod_exp_t'].'">-' . $supplier['metod_exp_name'] . '-</option>'; 
														echo $expeditions;
														?>
													</select>
												</div>
											</div>
											
											<div class="form-group row">

												<label class="col-sm-2 col-form-label" for="email">Observações</label>

												<div class="col-sm-6">
													<textarea rows="5" cols="1" placeholder="obs" placeholder="obs"
														   class="form-control margin-bottom" name="obs" id="obs" value="<?php echo $supplier['obs'] ?>"></textarea>
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
																   name="custom[<?php echo $row['id'] ?>]" value="<?php echo $row['data'] ?>">
														</div>
													</div>
												<?php }else if ($row['f_type'] == 'check') { ?>
													<div class="form-group row">
														<label class="col-sm-10 col-form-label"
															   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input <?php echo $row['other'] ?>" id="custom[<?php echo $row['id'] ?>]" name="custom[<?php echo $row['id'] ?>]" value="<?php echo $row['data'] ?>" <?php if ($row['data'] == 'on') echo 'checked="checked"' ?>>
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
																   name="custom[<?php echo $row['id'] ?>]" rows="1"><?php echo $row['data'] ?></textarea>
														</div>
													</div>
												<?php }
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label"></label>
							<div class="col-sm-4">
								<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
									   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
								<input type="hidden" value="supplier/editsupplier" id="action-url">
							</div>
						</div>
					</form>
				</div>
			</div>
            
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
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>supplier/displaypic?id=<?php echo $supplier['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/suppliers/' + data.result + '?' + new Date().getTime());

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
</script>
