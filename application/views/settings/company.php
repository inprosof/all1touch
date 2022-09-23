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
										<a class="nav-link active show" id="base-tab1" data-toggle="tab"
										   aria-controls="tab1" href="#tab1" role="tab"
										   aria-selected="true">Geral</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
										   href="#tab2" role="tab"
										   aria-selected="false">Financeiro</a>
									</li>
									  <li class="nav-item">
										<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
										   href="#tab3" role="tab"
										   aria-selected="false">Faturação</a>
									</li>
								</ul>
								<div class="tab-content px-1 pt-1">
									<div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
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
												<label class=" col-form-label" for="data_share"><?php echo $this->lang->line('Foundation Day') ?> </label>
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
									</div>
									<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
										<div class="form-group row">
											<div class="col-sm-12">
												<label class="col-form-label"
													   for="email"><?php echo $this->lang->line('Tax') ?></label>

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


                        </form>

                    </div>
                    <div class="col-6">
                        <div class="card card-block">
                            <div id="notify" class="alert alert-success" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>

                                <div class="message"></div>
                            </div>
                            <form method="post" id="product_action" class="form-horizontal">
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
                                                id="fileupload" type="file"
                                                name="files[]"></p>
                                    <pre>Recommended logo size is 500x200px.</pre>
                                    <div id="progress" class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%"
                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                </div>
                            </form>
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