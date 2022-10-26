<?php 
	$loc = location(0);
?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Company Details') ?></h5>
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
                <div class="row">
                    <div class="col-6 border-right-blue">
                        <form method="post" id="product_action" class="form-horizontal">
                            <input type="hidden" name="id" value="<?php echo $company['id'] ?>">
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link <?php if($param1 > 0) echo 'active show'; ?>" id="base-tab1" data-toggle="tab"
										   aria-controls="tab1" href="#tab1" role="tab"
										   aria-selected="<?php if($param1 > 0) echo 'true'; else echo 'false'; ?>">Geral</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param2 > 0) echo 'active show'; ?>" id="base-tab2" data-toggle="tab" aria-controls="tab2"
										   href="#tab2" role="tab"
										   aria-selected="<?php if($param2 > 0) echo 'true'; else 'false'; ?>">Financeiro</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param3 > 0) echo 'active show'; ?>" id="base-tab3" data-toggle="tab" aria-controls="tab3"
										   href="#tab3" role="tab"
										   aria-selected="<?php if($param3 > 0) echo 'true'; else 'false'; ?>">Faturação</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param4 > 0 || $param44 > 0) echo 'active show'; ?>" id="base-tab4" data-toggle="tab" aria-controls="tab4"
										   href="#tab4" role="tab"
										   aria-selected="<?php if($param4 > 0 || $param44 > 0) echo 'true'; else 'false'; ?>">Configuração AT</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param5 > 0) echo 'active show'; ?>" id="base-tab5" data-toggle="tab" aria-controls="tab5"
										   href="#tab5" role="tab"
										   aria-selected="<?php if($param5 > 0) echo 'true'; else 'false'; ?>">Documentos</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param6 > 0) echo 'active show'; ?>" id="base-tab6" data-toggle="tab" aria-controls="tab6"
										   href="#tab6" role="tab"
										   aria-selected="<?php if($param6 > 0) echo 'true'; else 'false'; ?>">Emails</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php if($param7 > 0) echo 'active show'; ?>" id="base-tab7" data-toggle="tab" aria-controls="tab7"
										   href="#tab7" role="tab"
										   aria-selected="<?php if($param7 > 0) echo 'true'; else 'false'; ?>">Preferências</a>
									</li>
								</ul>
								<div class="tab-content px-1 pt-1">
									<div class="tab-pane <?php if($param1 > 0) echo 'active show'; ?>" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="name"><?php echo $this->lang->line('Company Name') ?></label>

												<div class="input-group">
													<input type="text" placeholder="Name"
														   class="form-control margin-bottom  required" name="name"
														   value="<?php echo $company['cname'] ?>">
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="address"><?php echo $this->lang->line('Address') ?></label>

												<div class="input-group">
													<input type="text" placeholder="address"
														   class="form-control margin-bottom  required" name="address"
														   value="<?php echo $company['address'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="city"><?php echo $this->lang->line('City') ?></label>

												<div class="input-group">
													<input type="text" placeholder="city"
														   class="form-control margin-bottom  required" name="city"
														   value="<?php echo $company['city'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="city"><?php echo $this->lang->line('Region') ?></label>

												<div class="input-group">
													<input type="text" placeholder="city"
														   class="form-control margin-bottom  required" name="region"
														   value="<?php echo $company['region'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="country"><?php echo $this->lang->line('Country') ?></label>

												<div class="input-group">
													<select name="country" class="form-control b_input required" id="country">
														<?php
														echo '<option value="' . $company['country'] . '">-' . $company['country_name'] . '-</option>';
														echo $countrys;
														?>

													</select>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

												<div class="input-group">
													<input type="text" placeholder="PostBox"
														   class="form-control margin-bottom  required" name="postbox"
														   value="<?php echo $company['postbox'] ?>">
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="phone"><?php echo $this->lang->line('Phone') ?></label>

												<div class="input-group">
													<input type="text" placeholder="phone"
														   class="form-control margin-bottom  required" name="phone"
														   value="<?php echo $company['phone'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Email') ?></label>

												<div class="input-group">
													<input type="text" placeholder="email"
														   class="form-control margin-bottom  required" name="email"
														   value="<?php echo $company['email'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('share_capital') ?></label>

												<div class="input-group">
													<input type="float" placeholder=""
														   class="form-control margin-bottom  required" name="share_capital"
														   value="<?php echo $company['share_capital'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('registration') ?></label>

												<div class="input-group">
													<input type="text" placeholder=""
														   class="form-control margin-bottom  required" name="registration"
														   value="<?php echo $company['registration'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('conservator') ?></label>

												<div class="input-group">
													<input type="text" placeholder=""
														   class="form-control margin-bottom  required" name="conservator"
														   value="<?php echo $company['conservator'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class=" col-form-label" for="foundation"><?php echo $this->lang->line('Foundation Day') ?> </label>
												<div class="input-group">
													<div class="input-group-addon">
													<span class="icon-calendar4" aria-hidden="true"></span></div>
													<input type="text" class="form-control round required editdate"
														   placeholder="Foundation Date" name="foundation"
														   autocomplete="false"
														   value="<?php echo dateformat($company['foundation']) ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"></label>
											<div class="col-sm-4">
												<input type="submit" id="company_update" class="btn btn-success margin-bottom"
													   value="<?php echo $this->lang->line('Update Company') ?>"
													   data-loading-text="Updating...">
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email">Contribuinte</label>

												<div class="col-sm-10">
													<input type="text" placeholder="<?php echo $this->lang->line('Tax') ?>"
														   class="form-control margin-bottom" name="taxid"
														   value="<?php echo $company['taxid'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Annual Vacation') ?></label>

												<div class="col-sm-10">
													<input type="number" placeholder=""
														   class="form-control margin-bottom" name="annual_vacation"
														   value="<?php echo $company['annual_vacation'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Social Security') ?></label>

												<div class="col-sm-10">
													<input type="text" placeholder=""
														   class="form-control margin-bottom" name="social_security"
														   value="<?php echo $company['social_security'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Number of days Work month') ?></label>

												<div class="col-sm-10">
													<input type="number" placeholder=""
														   class="form-control margin-bottom" name="number_day_work_month"
														   value="<?php echo $company['number_day_work_month'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Number of Hours Works Day') ?></label>

												<div class="col-sm-10">
													<input type="number" placeholder=""
														   class="form-control margin-bottom" name="number_hours_work"
														   value="<?php echo $company['number_hours_work'] ?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"></label>
											<div class="col-sm-4">
												<input type="submit" id="company_update1" class="btn btn-success margin-bottom"
													   value="<?php echo $this->lang->line('Update Company') ?>"
													   data-loading-text="Updating...">
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="passive_res" id="passive_res" value="<?php echo $company['passive_res'] ?>" <?php if ($company['passive_res'] == 1) echo 'checked="checked"' ?>>
											<label class="custom-control-label" for="passive_res"><?php echo "Sujeito passivo não residente em território nacional" ?></label>
										</div>
										<hr>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label" for="data_share"><?php echo $this->lang->line('Product Data Sharing with Other Locations') ?></label>
												
												<div class="col-sm-10">
													<select name="data_share" class="form-control">

														<?php switch (BDATA) {
															case '1' :
																echo '<option value="1">** '.$this->lang->line('Yes').' **</option>';
																break;
															case '0' :
																echo '<option value="0">** '.$this->lang->line('Yes').' **</option>';
																break;

														} ?>
														<option value="1"><?php echo $this->lang->line('Yes') ?></option>
														<option value="0"><?php echo $this->lang->line('No') ?></option>

													</select>
												</div>
											</div>
										</div>
										
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="rent_ab" id="rent_ab" value="<?php echo $company['rent_ab'] ?>" <?php if ($company['rent_ab'] == 1) echo 'checked="checked"' ?>>
											<label class="custom-control-label" for="rent_ab"><?php echo "Retalhista ou vendedor ambulante" ?></label>
										</div>
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label" for="taxid">Zona Fiscal</label>
												<div class="col-sm-10">
													<select name="zon_fis" class="selectpicker form-control required">
														<?php echo '<option value="' . $company['zon_fis'] . '">--';
														if($company['zon_fis'] == 0) 
															echo $this->lang->line('Default');
														else if($company['zon_fis'] == 1) 
															echo 'Açores';
														else 
															echo 'Madeira';
														echo '--</option>';
														?>
														<option value="0"><?php echo $this->lang->line('Default') ?></option>
														<option value="1">Açores</option>
														<option value="2">Madeira</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"></label>
											<div class="col-sm-4">
												<input type="submit" id="company_update2" class="btn btn-success margin-bottom"
													   value="<?php echo $this->lang->line('Update Company') ?>"
													   data-loading-text="Updating...">
											</div>
										</div>
									</div>
									
									<div class="tab-pane <?php if($param4 > 0 || $param44 > 0) echo 'active show'; ?>" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
										<div id="accordionComunicatAtW" role="tablist" aria-multiselectable="<?php if($param4 > 0) echo 'true'; else echo 'false'; ?>">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionComunicatAtW" href="#accordioncomunicationat"
												   aria-expanded="false" aria-controls="accordioncomunicationat"
												   class="card-title lead <?php if ($param4 == 0) echo 'collapsed'?>">
													<i class="fa fa-plus-circle"></i>Comunicação AT
												</a>
											</div>
											<div id="accordioncomunicationat" role="tabpanel" aria-labelledby="headingr" 
												class="card-collapse <?php if ($param4 == 0) echo 'collapse'?>" aria-expanded="false">
												<div class="col-sm-12">
													<h5><?php echo $this->lang->line('saft10') ?></h5>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="billing_doc" id="billing_doc" value="<?php echo $activation['docs'] ?>" <?php if ($activation['docs'] == 1) echo 'checked="checked"' ?>>
														<label class="custom-control-label" for="billing_doc"><?php echo $this->lang->line('saft11') ?></label>
													</div>
													<div class="form-group row div_date_docs">
														<h6><?php echo $this->lang->line('saft14') ?></h6>
														<label class="col-sm-3 control-label" for="date_docs"><?php echo $this->lang->line('Date') ?></label>
														<div class="col-sm-4">
															<input type="text" class="form-control required" placeholder="Date" name="date_docs" data-toggle="datepicker" autocomplete="false" value="<?php echo $activation['docs_date'] ?>">
														</div>
													</div>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="transport_doc" id="transport_doc" value="<?php echo $activation['guides'] ?>" <?php if ($activation['guides'] == 1) echo 'checked="checked"' ?>>
														<label class="custom-control-label" for="transport_doc"><?php echo $this->lang->line('saft12') ?></label>
													</div>
													<div class="form-group row div_date_docs_guide">
														<h6><?php echo $this->lang->line('saft14') ?></h6>
														<label class="col-sm-3 control-label" for="date_docs_guide"><?php echo $this->lang->line('Date') ?></label>
														<div class="col-sm-4">
															<input type="text" class="form-control required" placeholder="Date" name="date_docs_guide" id="date_docs_guide" data-toggle="datepicker" autocomplete="false" value="<?php echo $activation['guides_date'] ?>">
														</div>
													</div>
													<h5><?php echo $this->lang->line('saft13') ?></h5>
													<div class="form-group row">
														<div class="col-sm-10">
															<label class="col-sm-12 col-form-label" for="username">ID Utilizador</label>
															<div class="input-group">
																<span class="input-group-addon"><?php echo $loc['taxid'];?>/</span>
																<input type="text" name="username" class="form-control required"
																	   placeholder="0" aria-describedby="sizing-addon1"
																	   onkeypress="return isNumber(event)" value="<?php if($activation['username'] == '' || $activation['username'] == null) echo '0'; else echo $activation['username']; ?>">
																<span class="input-group-addon" title="<?php echo 'Deve ser um número inteiro';?>"><i class="fa fa-info fa-2x"></i></span>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-12 col-form-label" for="email"><?php echo $this->lang->line('Your Password') ?></label>
														<div class="input-group">
															<input type="current-password" placeholder="Password" class="form-control margin-bottom crequired" name="password" id="password" value="<?php if ($activation['password'] != null) echo $activation['password'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label"></label>
													<div class="col-sm-4">
														<input type="submit" id="company_update3" class="btn btn-success margin-bottom"
															   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
													</div>
												</div>
											</div>
										</div>
										
										<div id="accordionIvaCaixAtW" role="tablist" aria-multiselectable="<?php if($param44 > 0) echo 'true'; else echo 'false'; ?>">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionIvaCaixAtW" href="#accordionIvaCaix"
												   aria-expanded="false" aria-controls="accordionIvaCaix"
												   class="card-title lead <?php if ($param44 == 0) echo 'collapsed'?>">
													<i class="fa fa-plus-circle"></i>Regime de IVA de Caixa
												</a>
											</div>
											<div id="accordionIvaCaix" role="tabpanel" aria-labelledby="headingr"
												 class="card-collapse <?php if ($param44 == 0) echo 'collapse'?>" aria-expanded="false">
												<div class="col-sm-12">
													<h5><?php echo $this->lang->line('saft17') ?></h5>
													<h6><?php echo $this->lang->line('saft18') ?></h6>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="caixa_1" id="caixa_1_t" value="<?php echo $activation['caixa_vat1'] ?>" <?php if ($activation['caixa_vat1'] == 1) echo 'checked="checked"' ?>>
														<label class="custom-control-label" for="caixa_1_t"><?php echo $this->lang->line('saft23') ?></label>
													</div>
													
													<h5><?php echo $this->lang->line('saft19') ?></h5>
													<h6><?php echo $this->lang->line('saft20') ?></h6>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="caixa_2" id="caixa_2_t" value="<?php echo $activation['caixa_vat2'] ?>" <?php if ($activation['caixa_vat2'] == 1) echo 'checked="checked"' ?>>
														<label class="custom-control-label" for="caixa_2_t"><?php echo $this->lang->line('saft24') ?></label>
													</div>
													
													<h5><?php echo $this->lang->line('saft21') ?></h5>
													<h6><?php echo $this->lang->line('saft22') ?></h6>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="caixa_3" id="caixa_3_t" value="<?php echo $activation['caixa_vat3'] ?>" <?php if ($activation['caixa_vat3'] == 1) echo 'checked="checked"' ?>>
														<label class="custom-control-label" for="caixa_3_t"><?php echo $this->lang->line('saft24') ?></label>
													</div>

													<div class="custom-control custom-checkbox">
														<input type="hidden" name="caixa_doc_date" id="caixa_doc_date" value="<?php echo $activation['caixa_date'] ?>">
														<input type="checkbox" class="custom-control-input" name="caixa_4" id="caixa_4_t" value="<?php echo $activation['caixa_vat4'] ?>" <?php if ($activation['caixa_vat4'] == 1) echo 'checked="checked"' ?> <?php if ($activation['caixa_vat1'] == 0 || $activation['caixa_vat2'] == 0 || $activation['caixa_vat3'] == 0) echo 'disabled' ?>>
														<label class="custom-control-label" for="caixa_4_t"><?php echo $this->lang->line('saft25') ?></label>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label"></label>
													<div class="col-sm-4">
														<input type="submit" id="company_update4" class="btn btn-success margin-bottom"
															   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane <?php if($param5 > 0) echo 'active show'; ?>" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
										<?php
											$cvalue = 0;
											foreach ($docs_copy_ini as $row) {
												echo '<div class="col-sm-12">
														<input type="hidden" class="pdIn" name="pid[]" id="pid-' . $cvalue . '" value="' . $row['id'] . '">
														<input type="hidden" class="pdIn" name="pcopyid[]" id="pcopyid-' . $cvalue . '" value="' . $row['copy'] . '">
														<label class="col-form-label" for="typ_doc_'.$cvalue.'">'.$row['typ_name'].'</label><div class="col-sm-8">
														<input type="text" class="form-control text-center" onkeyup="rowCopys(' . $cvalue . ')"  name="serie_copy[]" id="serie_copy-' . $cvalue . '" value="' . $row['copyname'] . '">
														</div>
													</div>';
												$cvalue++;
											}
											?>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"></label>
											<div class="col-sm-4">
												<input type="submit" id="company_update5" class="btn btn-success margin-bottom"
													   value="<?php echo $this->lang->line('Update Company') ?>"
													   data-loading-text="Updating...">
											</div>
										</div>
									</div>
									<div class="tab-pane <?php if($param7 > 0 || $param6 > 0) echo 'active show'; ?>" id="tab6" role="tabpanel" aria-labelledby="base-tab6">
										<div id="accordionEMAILGG" role="tablist" aria-multiselectable="false">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionEMAILGG" href="#accordionEMAILGGW"
												   aria-expanded="false" aria-controls="accordionEMAILGGW"
												   class="card-title lead <?php if ($param6 == 0) echo 'collapsed'?>">
													<i class="fa fa-plus-circle"></i>1. Geral
												</a>
											</div>
											<div id="accordionEMAILGGW" role="tabpanel" aria-labelledby="headingr" 
												class="card-collapse <?php if ($param6 == 0) echo 'collapse'?>" aria-expanded="false">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="emails_notifica">E-mail notificações All1Touch</label>
														<div class="col-sm-10">
															<input type="text" placeholder="abcd@abcd.pt" class="form-control margin-bottom" name="emails_notifica" id="emails_notifica"
																   value="<?php echo $company_permiss['email_app'] ?>">
														</div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="emailo_remet">Nome Remetente nos Emails</label>
														<div class="col-sm-10">
															<input type="text" placeholder="abcd@abcd.pt" class="form-control margin-bottom" name="emailo_remet" id="emailo_remet"
																   value="<?php echo $company_permiss['emailo_remet'] ?>">
														</div>
													</div>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="docs_email" id="docs_email" value="<?php echo $company_permiss['docs_email'] ?>" <?php if ($company_permiss['docs_email'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="docs_email"><?php echo "Enviar após criação de um Documento?" ?></label>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="docs_del_email" id="docs_del_email" value="<?php echo $company_permiss['docs_del_email'] ?>" <?php if ($company_permiss['docs_del_email'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="docs_del_email"><?php echo "Enviar após anular um Documento?" ?></label>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="trans_email" id="trans_email" value="<?php echo $company_permiss['trans_email'] ?>" <?php if ($company_permiss['trans_email'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="trans_email"><?php echo "Enviar após uma Transação?" ?></label>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="trans_del_email" id="trans_del_email" value="<?php echo $company_permiss['trans_del_email'] ?>" <?php if ($company_permiss['trans_del_email'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="trans_del_email"><?php echo "Enviar após apagar uma Transação?" ?></label>
												</div>
											</div>
										</div>
										
										<div id="accordionEMAILSTG" role="tablist" aria-multiselectable="false">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionEMAILSTG" href="#accordionEMAILSTGW"
												   aria-expanded="false" aria-controls="accordionEMAILSTGW"
												   class="card-title lead <?php if ($param7 == 0) echo 'collapsed'?>">
													<i class="fa fa-plus-circle"></i>2. Artigos e Stocks
												</a>
											</div>
											<div id="accordionEMAILSTGW" role="tabpanel" aria-labelledby="headingr"
												 class="card-collapse <?php if ($param7 == 0) echo 'collapse'?>" aria-expanded="false">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="email_stock">E-mail notificações Stock</label>
														<div class="col-sm-10">
															<input type="text" placeholder="abcd@abcd.pt" class="form-control margin-bottom" name="email_stock" id="email_stock"
																   value="<?php echo $company_permiss['email_stock'] ?>">
														</div>
													</div>
												</div>	
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="stock_min" id="stock_min" value="<?php echo $company_permiss['stock_min'] ?>" <?php if ($company_permiss['stock_min'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="stock_min"><?php echo "Enviar alerta de stock mínimo por e-mail" ?></label>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="stock_sem" id="stock_sem" value="<?php echo $company_permiss['stock_sem'] ?>" <?php if ($company_permiss['stock_min'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="stock_sem"><?php echo "Enviar alerta sem stock por e-mail" ?></label>
												</div>
											</div>
											
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"></label>
											<div class="col-sm-4">
												<input type="submit" id="company_update7" class="btn btn-success sub-btn" value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
											</div>
										</div>
									</div>
									<div class="tab-pane <?php if($param77 > 0) echo 'active show'; ?>" id="tab7" role="tabpanel" aria-labelledby="base-tab7">
										<div id="accordionConfG" role="tablist" aria-multiselectable="false">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionConfG" href="#accordionConfGW"
												   aria-expanded="false" aria-controls="accordionConfGW"
												   class="card-title lead collapsed">
													<i class="fa fa-plus-circle"></i>1 - Painel Principal
												</a>
											</div>
											<div id="accordionConfGW" role="tabpanel" aria-labelledby="headingr"
												 class="card-collapse collapse" aria-expanded="false">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="grafic_show" id="grafic_show" value="<?php echo $company_permiss['grafics'] ?>" <?php if ($company_permiss['grafics'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="grafic_show"><?php echo "Mostrar gráficos no Painel Principal" ?></label>
												</div>
											</div>
										</div>
										<div id="accordionSearG" role="tablist" aria-multiselectable="false">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionSearG" href="#accordionSearGW"
												   aria-expanded="false" aria-controls="accordionSearGW"
												   class="card-title lead collapsed">
													<i class="fa fa-plus-circle"></i>2 - Pesquisas
												</a>
											</div>
											<div id="accordionSearGW" role="tabpanel" aria-labelledby="headingr"
												 class="card-collapse collapse" aria-expanded="false">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="products_show" id="products_show" value="<?php echo $company_permiss['products_inactiv_show'] ?>" <?php if ($company_permiss['products_inactiv_show'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="products_show"><?php echo "Mostrar artigos inactivos nas pesquisas" ?></label>
												</div>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="clients_show" id="clients_show" value="<?php echo $company_permiss['clients_inactiv_show'] ?>" <?php if ($company_permiss['clients_inactiv_show'] == 1) echo 'checked="checked"' ?>>
													<label class="custom-control-label" for="clients_show"><?php echo "Mostrar clientes inactivos nas pesquisas" ?></label>
												</div>
											</div>
										</div>
										<div id="accordionGER" role="tablist" aria-multiselectable="false">
											<div id="headingr" class="card-header">
												<a data-toggle="collapse" data-parent="#accordionGER" href="#accordionGERW"
												   aria-expanded="false" aria-controls="accordionGERW"
												   class="card-title lead <?php if ($param77 == 0) echo 'collapsed'?>">
													<i class="fa fa-plus-circle"></i>3 - Configurações por defeito (Se não selecionada Localização)
												</a>
											</div>
											<div id="accordionGERW" role="tabpanel" aria-labelledby="headingr"
												class="card-collapse <?php if ($param7 == 0) echo 'collapse'?>" aria-expanded="false">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="wid"><?php echo $this->lang->line('Warehouse') ?> <?php echo $this->lang->line('Default') ?></label>
														<div class="input-group">
															<select name="wid" class="form-control">
															<?php
																echo '<option value="'.$company['war']. '">*--';
																if($company['war'] == 0)
																{
																	echo $this->lang->line('All');
																}else{
																	echo $company['namewar'];
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
												</div>
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="assign"><?php echo $this->lang->line('AllowAssignEmployee') ?></label>
														<div class="input-group">
															<select name="assign" class="form-control">
																<?php switch ($online_pay['emps']) {
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
												</div>
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="pstyle">Estilo Documentos</label>
														<div class="input-group">
															<select name="pstyle" class="form-control">
																<?php switch ($online_pay['posv']) {
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
														<label class="col-form-label" for="pos_list">Listar(Para Escolha) <?php echo $this->lang->line('Account')?> POS ou Documentos</label>
														<div class="input-group">
															<select class="form-control" name="pos_list">
																<option value="<?php echo $online_pay['pac'] ?>">
																	--<?php if ($online_pay['pac'] == 1 || $online_pay['pac'] == "1") {
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
													<div class="col-sm-12">
														<label class="col-form-label" for="pos_type_doc">Tipo Documento <?php echo $this->lang->line('Default') ?> POS</label>
														<div class="input-group">
															<select name="pos_type_doc" class="selectpicker form-control round required">
																	<option value="<?php echo $online_pay['doc_default'] ?>">** <?php echo $online_pay['nametipdoc']; ?> **</option>
																<?php
																	echo $irs_typ;
																?>
															</select>
														</div>
													</div>
												</div>
												
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="account_o"><?php echo $this->lang->line('Account')?> Documentos <?php echo $this->lang->line('Default') ?> e POS</label>
														<div class="input-group">
															<select name="account_o" class="form-control">
																<?php 
																echo '<option value="' . $online_pay['ac_id_d'] . '" selected>--';
																if($online_pay['ac_id_d'] == 0)
																{
																	echo 'Sem conta definida';
																}else{
																	echo $online_pay['ac_name_d'];
																}
																echo '--</option>';
																foreach ($acclist as $row) {
																	echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
																}
																?>
															</select>
														</div>
													</div>
												</div>
												
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="account_d"><?php echo $this->lang->line('Account')?> Vendas Online</label>
														<div class="input-group">
															<select name="account_d" class="form-control">
																<?php 
																echo '<option value="' . $online_pay['ac_id_o'] . '" selected>--';
																if($online_pay['ac_id_o'] == 0)
																{
																	echo 'Sem conta definida';
																}else{
																	echo $online_pay['ac_name_o'];
																}
																echo '--</option>';
																foreach ($acclist as $row) {
																	echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
																}
																?>
															</select>
														</div>
													</div>
												</div>
												
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="account_f"><?php echo $this->lang->line('Account')?> Fornecedores <?php echo $this->lang->line('Default') ?></label>
														<div class="input-group">
															<select name="account_f" class="form-control">
																<?php 
																echo '<option value="' . $online_pay['ac_id_f'] . '" selected>--';
																if($online_pay['ac_id_f'] == 0)
																{
																	echo 'Sem conta definida';
																}else{
																	echo $online_pay['ac_name_f'];
																}
																echo '--</option>';
																foreach ($acclist as $row) {
																	echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
																}
																?>
															</select>
														</div>
													</div>
												</div>
												
												
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label" for="dual_entry"><?php echo $this->lang->line('Dual Entry') ?></label>
														<label class='btn-blue' style="display: block;"><span class='fa fa-plus-circle'></span>
															<strong>Atenção:</strong>Por favor, não habilite este recurso sem o devido entendimento sistema de contabilidade de dupla entrada.
														</label>
														<div class="input-group">
															<select name="dual_entry" class="form-control">
																<option value="<?php echo $online_pay['dual_entry']; ?>">--<?php if($online_pay['dual_entry'] == '0'){ echo $this->lang->line('No');} else {echo $this->lang->line('Yes');} ?>--</option>
																
																<option value="0"><?php echo $this->lang->line('No') ?></option>
																<option value="1"><?php echo $this->lang->line('Yes') ?> </option>

															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label"></label>
												<div class="col-sm-4">
													<input type="submit" id="company_update8" class="btn btn-success sub-btn" value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                        </form>
                    </div>
                    <div class="col-6">
                        <div class="card card-block">
                            <div class="grid_3 grid_4">
								<h5><?php echo $this->lang->line('Company Logo') ?></h5>
								<hr>
								<input type="hidden" name="id" value="<?php echo $company['id'] ?>">
								<div class="ibox-content no-padding border-left-right">
									<img alt="image" id="dpic" class="col"
										 src="<?php echo base_url('userfiles/company/') . $company['logo'] . '?t=' . rand(5, 99); ?>">
								</div>
								<hr>
								<p>
								<label for="fileupload"><?php echo $this->lang->line('Change Company Logo') ?></label><input
											id="fileupload" type="file" name="files[]"></p>
								<pre>gif, jpeg, png (500x200px).</pre>
								<div id="progress" class="progress progress-sm mt-1 mb-0">
									<div class="progress-bar bg-success" role="progressbar" style="width: 0%"
										 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<input type="hidden" value="search_copys" id="bill_copys">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$("#company_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
	$("#company_update1").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
	$("#company_update2").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
	$("#company_update3").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/autority_pt';
        actionProduct(actionurl);
    });
	$("#company_update4").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/reg_iva';
        actionProduct(actionurl);
    });
	$("#company_update5").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
	$("#company_update6").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/company';
        actionProduct(actionurl);
    });
	$("#company_update7").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/geral_emails';
        actionProduct(actionurl);
    });
	$("#company_update8").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/geral_configs';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {
        'use strict';
        var url = '<?php echo base_url() ?>settings/companylogo?id=<?php echo $company['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/company/' + data.result + '?' + new Date().getTime());


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
    $('.editdate').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
	
</script>