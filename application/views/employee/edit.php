<div>
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
                         src="<?php echo base_url('userfiles/employee/') . $user['picture'] ?>">
                </div>
                <hr>
                <p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
                            id="fileupload" type="file"
                            name="files[]"></p></div>
            <!-- signature -->

            <div class="card card-block card-body"><h5><?php echo $this->lang->line('Update Your Signature') ?></h5>
                <hr>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="sign_pic" id="sign_pic" class="img-responsive col col"
                         src="<?php echo base_url('userfiles/employee_sign/') . $user['sign'] ?>">
                </div>
                <hr>
                <p>
                    <label for="sign_fileupload"><?php echo $this->lang->line('Change Your Signature') ?></label><input
                            id="sign_fileupload" type="file"
                            name="files[]"></p></div>


        </div>
        <div class="col-md-8">
            <div class="card card-block card-body">
                <form method="post" id="product_action" class="form-horizontal">
					<input type="hidden" name="eid" value="<?php echo $user['id'] ?>">
                    <div class="card">
						<div class="card-content">
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active show" id="base-tab1" data-toggle="tab"
										   aria-controls="tab1" href="#tab1" role="tab"
										   aria-selected="true"><?php echo $this->lang->line('Update Your Details') ?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
										   href="#tab2" role="tab"
										   aria-selected="false">Financeiro</a>
									</li>
									  <li class="nav-item">
										<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
										   href="#tab3" role="tab"
										   aria-selected="false">Contabilidade</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
										   href="#tab4" role="tab"
										   aria-selected="false"><?php echo $this->lang->line('CustomFields') ?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
										   href="#tab5" role="tab"
										   aria-selected="false">Permissões Extra</a>
									</li>
								</ul>
								<div class="tab-content px-1 pt-1">
									<div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Name') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="Name"
													   class="form-control margin-bottom  required" name="name"
													   value="<?php echo $user['name'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="address"><?php echo $this->lang->line('Address') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="address"
													   class="form-control margin-bottom" name="address"
													   value="<?php echo $user['address'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="city"><?php echo $this->lang->line('City') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="city"
													   class="form-control margin-bottom" name="city"
													   value="<?php echo $user['city'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="country"><?php echo $this->lang->line('Country') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="Country"
													   class="form-control margin-bottom" name="country"
													   value="<?php echo $user['country'] ?>">
											</div>
										</div>

										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="Postbox"
													   class="form-control margin-bottom" name="postbox"
													   value="<?php echo $user['postbox'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="phone"><?php echo $this->lang->line('Phone') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="phone"
													   class="form-control margin-bottom" name="phone"
													   value="<?php echo $user['phone'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="phone"><?php echo $this->lang->line('Phone') ?> (Alt)</label>

											<div class="col-sm-10">
												<input type="text" placeholder="altphone"
													   class="form-control margin-bottom" name="phonealt"
													   value="<?php echo $user['phonealt'] ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="email"><?php echo $this->lang->line('Email') ?></label>

											<div class="col-sm-10">
												<input type="text" placeholder="email"
													   class="form-control margin-bottom required" name="email"
													   value="<?php echo $user['email'] ?>" <?php if ($this->aauth->get_user()->roleid < 5) echo 'disabled' ?>>
											</div>
										</div>
										
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Productivity') ?></label>

											<div class="col-sm-5"><input type="number" placeholder="0.0"
																		 class="form-control margin-bottom" id="productivity"
																		 name="productivity"
																		 value="<?php echo amountFormat_general($user['productivity']) ?>">
											</div>
										</div>

										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('IBAN') ?></label>

											<div class="col-sm-5"><input type="text" placeholder=""
																		 class="form-control margin-bottom" id="account_bank"
																		 name="account_bank"
																		 value="<?php echo $user['account_bank'] ?>">
											</div>
										</div>
										
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												for="name"><?php echo $this->lang->line('NISS') ?></label>

											<div class="col-sm-5"><input type="text" placeholder=""
																		class="form-control margin-bottom" id="social_security_number"
																		name="social_security_number"
																		value="<?php echo numberClean($user['niss'] ?? 0) ?>">
											</div>
										</div>

										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												for="name"><?php echo $this->lang->line('IRS Number') ?></label>

											<div class="col-sm-5"><input type="text" placeholder=""
																		class="form-control margin-bottom" id="irs_number"
																		name="irs_number"
																		value="<?php echo numberClean($user['irs_number']) ?>">
											</div>
										</div>

										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												for="name"><?php echo $this->lang->line('Type Employee') ?></label>

											<div class="col-sm-5">
												<select id="type_employee" name="type_employee" class="form-control margin-bottom">
													<option value="<?php echo $user['type_employee'] ?>"><?php echo $this->lang->line('Do not change') ?></option>
													<option value="0"><?php echo $this->lang->line('Temporary') ?></option>
													<option value="1"><?php echo $this->lang->line('Full') ?></option>
													<option value="2">Vendedor</option>
												</select>
											</div>
										</div>
										<div class="form-group row 15"><label class="col-sm-2 col-form-label"
																  for="medical"><?php echo $this->lang->line('Medical Allowance') ?></label>
											<div class="col-sm-5"><input type="text" class="form-control" id="medical" name="medical" 
																		 value="<?php echo $user['medical_allowance'] ?>">
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Business Location') ?></label>

											<div class="col-sm-5">
												<select name="location" class="form-control margin-bottom">
													<option value="<?php echo $user['loc'] ?>">--<?php if ($user['loc'] == 0){echo "Por Defeito";} else echo $user['locname']; ?>--</option>
													<option value="0"><?php echo $this->lang->line('Default') ?></option>
													<?php $loc = locations();

													foreach ($loc as $row) {
														echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
													}

													?>
												</select>
											</div>
										</div>
										<?php if ($this->aauth->get_user()->roleid >= 4) { ?>
											<div class="form-group row">

												<label class="col-sm-2 col-form-label"
													   for="roleid"><?php echo $this->lang->line('UserRole') ?></label>

												<div class="col-sm-5">
													<select name="roleid" class="form-control margin-bottom" <? if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) echo 'disabled' ?>>
														<option value="<?php echo $user['roleid'] ?>">--<?php echo user_role($user['roleid']) ?>--</option>
														<?php 
														if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7)
														{
														  echo '<option value="5">'.$this->lang->line('Business Owner').'</option>';
														}
														?>
														<option value="4"><?php echo $this->lang->line('Business Manager') ?></option>
														<option value="8">Vendedor Externo</option>
														<option value="6"><?php echo $this->lang->line('Project Manager') ?></option>
														<option value="3"><?php echo $this->lang->line('Sales Manager') ?></option>
														<option value="2"><?php echo $this->lang->line('Sales Person') ?></option>
														<option value="1"><?php echo $this->lang->line('Inventory Manager') ?></option>
													</select>
												</div>
											</div>


										<?php } ?>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Department') ?></label>
											<div class="col-sm-5">
												<select name="department" class="form-control margin-bottom">
													<option value="<?php echo $user['dept'] ?>">--<?php echo $user['departament'] ?>--</option>
													<?php

													foreach ($dept as $row) {
														echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
													}

													?>
												</select>
											</div>
										</div>
									
										<div class="form-group row 15"><label class="col-sm-2 col-form-label"
																  for="basic_salary"><?php echo $this->lang->line('Basic Salary') ?></label>
											<div class="col-sm-5"><input type="number" placeholder="0.0"
																		 class="form-control margin-bottom" id="basic_salary"
																		 name="basic_salary"
																		 value="<?php echo amountFormat_general($user['basic_salary']) ?>">
											</div>
										</div>
										<div class="form-group row 15"><label class="col-sm-2 col-form-label"
																			  for="subsidy_meal"><?php echo $this->lang->line('Subsidy Meal') ?></label>
											<div class="col-sm-5"><input type="number" class="form-control" id="subsidy_meal" name="subsidy_meal"
																		 placeholder="0.0"
																		 value="<?php echo amountFormat_general($user['subsidy_meal']) ?>">
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="city"><?php echo $this->lang->line('Commission') ?>%</label>

											<div class="col-sm-2">
												<input type="number" placeholder="Commission %"
													   class="form-control margin-bottom" name="commission"
													   value="<?php echo $user['c_rate'] ?>">
											</div>
											<small class="col">It will based on each invoice amount - inclusive all
												taxes,shipping,discounts
											</small>

										</div>
									</div>
									<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Type IRS') ?></label>

											<div class="col-sm-5">
												<select name="type_irs" class="form-control margin-bottom">
													<option value="<?php echo $user['type_irs'] ?>">--<?php echo $user['type_irsname'] ?>--</option>
													<?php
														foreach ($typeIRS as $row) {
															echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('Married ?') ?></label>

											<div class="col-sm-5">
												<select name="married" class="form-control margin-bottom">
													<option value=""><?php echo $this->lang->line('Do not change') ?></option>
													<option value="0" <?php if ($user['number_children'] == 0) echo "selected";?> ><?php echo $this->lang->line('Unmarried') ?></option>
													<option value="1" <?php if ($user['number_children'] == 1) echo "selected";?> ><?php echo $this->lang->line('Married') ?></option>
												</select>
											</div>
										</div>

										<div class="form-group row">

											<label class="col-sm-2 col-form-label"
												   for="name"><?php echo $this->lang->line('N.Children') ?></label>

											<div class="col-sm-5"><input type="number" placeholder="0"
																		 class="form-control margin-bottom" id="number_children"
																		 name="number_children"
																		 value="<?php echo numberClean($user['number_children']) ?>">
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
												<div class="input-group mt-1">
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
									<div class="tab-pane show" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="mess_ativos" id="mess_ativos" value="<?php echo $user['mess_ativos'] ?>" <?php if ($user['mess_ativos'] == 1) echo 'checked="checked"' ?>>
											<label class="custom-control-label" for="mess_ativos"><?php echo "Mensagens Ativos" ?></label>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label"></label>
										<div class="col-sm-4">
											<input type="submit" id="profile_update" class="btn btn-success margin-bottom"
												   value="<?php echo $this->lang->line('Update') ?>"
												   data-loading-text="Updating...">
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var bsalary, total, totalsal, house, medical, special, other_allowance, tax, provident, other_deduction;
        $('#basic_salary').keyup(function () {
            total = $('#total_salary').val('');
            medical = $('#medical').val();
            house = $('#house').val();
            special = $('#special').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            other_allowance = $('#other_allowance').val();
            bsalary = parseFloat(this.value);
            if (isNaN(bsalary)) {
                bsalary = 0;
                $('#basic_salary').val(bsalary);
            }
            totalsal = parseFloat(bsalary) + parseFloat(medical) + parseFloat(house) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#house').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            medical = $('#medical').val();
            special = $('#special').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            other_allowance = $('#other_allowance').val();
            house = parseFloat(this.value);
            if (isNaN(house)) {
                house = 0;
                $('#house').val(house);
            }
            totalsal = parseFloat(bsalary) + parseFloat(medical) + parseFloat(house) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#special').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            other_allowance = $('#other_allowance').val();
            other_deduction = $('#other_deduction').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            special = parseFloat(this.value);
            if (isNaN(special)) {
                special = 0;
                $('#special').val(special);
            }
            totalsal = parseFloat(bsalary) + parseFloat(house) + parseFloat(medical) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#other_allowance').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = parseFloat($('#basic_salary').val());
            house = parseFloat($('#house').val());
            medical = parseFloat($('#medical').val());
            special = parseFloat($('#special').val());
            other_allowance = parseFloat(this.value);
            if (isNaN(other_allowance)) {
                other_allowance = 0;
                $('#other_allowance').val(other_allowance);
            }
            tax = parseFloat($('#tax').val());
            provident = parseFloat($('#provident').val());
            other_deduction = parseFloat($('#other_deduction').val());
            totalsal = parseFloat(bsalary) + parseFloat(house) + parseFloat(medical) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
        //$('#tax').keyup(function() {
        $(document).on("keyup", "#tax", function (e) {
            total = $('#total_salary').val('');
            bsalary = parseFloat($('#basic_salary').val());
            house = parseFloat($('#house').val());
            medical = parseFloat($('#medical').val());
            special = parseFloat($('#special').val());
            other_allowance = parseFloat($('#other_allowance').val());
            tax = parseFloat(this.value);
            if (isNaN(tax)) {
                tax = 0;
                $('#tax').val(tax);
            }
            provident = parseFloat($('#provident').val());
            other_deduction = parseFloat($('#other_deduction').val());
            totalsal = (bsalary + house + medical + special + other_allowance) - (tax + provident + other_deduction);
            $('#total_salary').val(totalsal);
        });
        $('#provident').keyup(function () {
            total = $('#total_salary').val();
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            special = $('#special').val();
            other_allowance = $('#other_allowance').val();
            provident = parseFloat(this.value);
            if (isNaN(provident)) {
                provident = 0;
                $('#provident').val(provident);
            }
            other_deduction = $('#other_deduction').val();
            tax = $('#tax').val();

            totalsal = parseFloat(bsalary) + parseFloat(house) + parseFloat(medical) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#other_deduction').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            special = $('#special').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = parseFloat(this.value);
            if (isNaN(other_deduction)) {
                other_deduction = 0;
                $('#other_deduction').val(other_deduction);
            }
            totalsal = parseFloat(bsalary) + parseFloat(house) + parseFloat(medical) + parseFloat(special) + parseFloat(other_allowance) - (parseFloat(tax) + parseFloat(provident) + parseFloat(other_deduction));
            $('#total_salary').val(totalsal);
        });
    });
</script>
<script type="text/javascript">
    $("#profile_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'employee/update';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/displaypic?id=<?php echo $user['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result + '?' + new Date().getTime());

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


        // Sign
        var sign_url = '<?php echo base_url() ?>employee/user_sign?id=<?php echo $user['id'] ?>';
        $('#sign_fileupload').fileupload({
            url: sign_url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#sign_pic").attr('src', '<?php echo base_url() ?>userfiles/employee_sign/' + data.result + '?' + new Date().getTime());


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