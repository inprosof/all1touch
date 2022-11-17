<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Employee Details') ?> </h5>
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
        <form method="post" id="data_form" class="card-body">
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
                                    <label class="col-sm-3  col-form-label"
                                           for="name"> <?php echo $this->lang->line('UserName') ?> <small class="error">(Use
                                            Only a-z0-9)</small>
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control margin-bottom required" name="username"
                                               placeholder="username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="email">Email</label>
                                    <div class="col-sm-5">
                                        <input type="email" placeholder="email"
                                               class="form-control margin-bottom required" name="email"
                                               placeholder="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"
                                           for="password"> <?php echo $this->lang->line('Password') ?> <small>(min
                                            length 6 | max length 20 | a-zA-Z 0-9 @ $)</small>
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" placeholder="Password"
                                               class="form-control margin-bottom required" name="password"
                                               placeholder="password">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"> <?php echo $this->lang->line('Name') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Name"
                                               class="form-control margin-bottom required" name="name"
                                               placeholder="Full name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="address"> <?php echo $this->lang->line('Address') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="address"
                                               class="form-control margin-bottom required" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="city"> <?php echo $this->lang->line('City') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="City"
                                               class="form-control margin-bottom required" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="city"> <?php echo $this->lang->line('Region') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Region" class="form-control margin-bottom"
                                               name="region">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="country"> <?php echo $this->lang->line('Country') ?> </label>
                                    <div class="col-sm-6">
                                        <select name="country" class="form-control b_input" id="mcustomer_country">
                                            <?php
                                            echo $countrys;
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="postbox"> <?php echo $this->lang->line('Postbox') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Postbox" class="form-control margin-bottom"
                                               name="postbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="phone"> <?php echo $this->lang->line('Phone') ?> </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="phone" class="form-control margin-bottom"
                                               name="phone">
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Department') ?></label>
                                    <div class="col-sm-6">
                                        <select name="department" class="form-control margin-bottom required">
                                            <option value="0"><?php echo $this->lang->line('Default') . ' - ' . $this->lang->line('No') ?></option>
                                            <?php
                                            foreach ($dept as $row) {
                                                echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Productivity') ?></label>
                                    <div class="col-sm-6"><input type="number" placeholder="0.0"
                                                                 class="form-control margin-bottom required"
                                                                 id="productivity"
                                                                 name="productivity" value="0.0">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('IBAN') ?></label>

                                    <div class="col-sm-6"><input type="text" placeholder=""
                                                                 class="form-control margin-bottom" id="account_bank"
                                                                 name="account_bank">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('NISS') ?></label>

                                    <div class="col-sm-6"><input type="text" placeholder=""
                                                                 class="form-control margin-bottom required"
                                                                 id="social_security_number"
                                                                 name="social_security_number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('IRS Number') ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="" class="form-control margin-bottom required"
                                               id="irs_number" name="irs_number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Type Employee') ?></label>
                                    <div class="col-sm-6">
                                        <select name="type_employee" class="form-control margin-bottom required">
                                            <option value="1"><?php echo $this->lang->line('Full') ?></option>
                                            <option value="0"><?php echo $this->lang->line('Temporary') ?></option>
                                            <option value="2">Vendedor</option>
                                        </select>
                                    </div>
                                </div>
                                <hr/>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="exampleFormControlInput1">
                                        <?php echo $this->lang->line('Medical Allowance') ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="medical" name="medical"
                                               value="Sem Companhia">
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="name"> <?php echo $this->lang->line('UserRole') ?> </label>
                                        <div class="col-sm-6">
                                            <select name="roleid" class="form-control margin-bottom required">
                                                <?php
                                                if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                                                    echo '<option value="5">' . $this->lang->line('Business Owner') . '</option>';
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
                                    </div> <?php } ?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"> <?php echo $this->lang->line('Business Location') ?> </label>
                                    <div class="col-sm-6">
                                        <select name="location" class="form-control margin-bottom required">
                                            <option value="0"><?php echo $this->lang->line('Default') ?></option>
                                            <?php
                                            foreach ($locations as $row) {
                                                echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="basic_salary"><?php echo $this->lang->line('Basic Salary') ?></label>
                                    <div class="col-sm-6"><input type="number" placeholder="0.0"
                                                                 class="form-control margin-bottom" id="basic_salary"
                                                                 name="basic_salary"
                                                                 value="0.0">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-sm-2 col-form-label"
                                           for="subsidy_meal"><?php echo $this->lang->line('Subsidy Meal') ?></label>
                                    <div class="col-sm-6"><input type="number" class="form-control" id="subsidy_meal"
                                                                 name="subsidy_meal"
                                                                 placeholder="0.0"
                                                                 value="0.0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="city"> <?php echo $this->lang->line('Commission') ?> % </label>
                                    <div class="col-sm-2">
                                        <input type="number" placeholder="Commission %" value="0"
                                               class="form-control margin-bottom" name="commission">
                                    </div>
                                    <div class="alert alert-info" id="alert-info-text">
                                        <small><?php echo $this->lang->line('It will based on each invoice amount - inclusive all taxes, shipping, discounts') ?> </small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Type IRS') ?></label>

                                    <div class="col-sm-6">
                                        <select name="type_irs" class="form-control margin-bottom required">
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

                                    <div class="col-sm-6">
                                        <select name="married" class="form-control margin-bottom required">
                                            <option value="0"><?php echo $this->lang->line('Unmarried') ?></option>
                                            <option value="1"><?php echo $this->lang->line('Married') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('N.Children') ?></label>
                                    <div class="col-sm-6"><input type="number" placeholder="0"
                                                                 class="form-control margin-bottom" id="number_children"
                                                                 name="number_children" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                <?php
                                foreach ($custom_fields as $row) {
                                    if ($row['f_type'] == 'text') { ?>
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label"
                                                   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $row['placeholder'] ?>"
                                                       class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
                                                       name="custom[<?php echo $row['id'] ?>]">
                                            </div>
                                        </div>
                                    <?php } else if ($row['f_type'] == 'check') { ?>
                                        <div class="input-group mt-1">
                                            <label class="col-sm-6 col-form-label"
                                                   for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       class="custom-control-input <?php echo $row['other'] ?>"
                                                       id="custom[<?php echo $row['id'] ?>]"
                                                       name="custom[<?php echo $row['id'] ?>]">
                                                <label class="custom-control-label"
                                                       for="custom[<?php echo $row['id'] ?>]"><?php echo $row['placeholder'] ?></label>
                                            </div>
                                        </div>
                                    <?php } else if ($row['f_type'] == 'textarea') { ?>
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label"
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
                            <div class="tab-pane show" id="tab5" role="tabpanel" aria-labelledby="base-tab5">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mess_ativos"
                                           id="mess_ativos"/>
                                    <label class="custom-control-label"
                                           for="mess_ativos"><?php echo "Mensagens Ativos" ?></label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-6" id="paiCompanyUpdate">
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Add') ?>"
                                           data-loading-text="Atualizando...">
                                    <input type="hidden" value="employee/submit_user" id="action-url">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
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
            bsalary = this.value;
            totalsal = Number(bsalary) + Number(medical) + Number(house) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
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
            house = this.value;
            totalsal = Number(bsalary) + Number(medical) + Number(house) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#medical').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            special = $('#special').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            other_allowance = $('#other_allowance').val();
            medical = this.value;
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#special').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            other_allowance = $('#other_allowance').val();
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            special = this.value;
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#other_allowance').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            special = $('#special').val();
            other_allowance = this.value;
            tax = $('#tax').val();
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#tax').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            special = $('#special').val();
            tax = this.value;
            provident = $('#provident').val();
            other_deduction = $('#other_deduction').val();
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });
        $('#provident').keyup(function () {
            total = $('#total_salary').val('');
            bsalary = $('#basic_salary').val();
            house = $('#house').val();
            medical = $('#medical').val();
            special = $('#special').val();
            provident = this.value;
            other_deduction = $('#other_deduction').val();
            tax = $('#tax').val();
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
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
            other_deduction = this.value;
            totalsal = Number(bsalary) + Number(house) + Number(medical) + Number(special) + Number(other_allowance) - (Number(tax) + Number(provident) + Number(other_deduction));
            $('#total_salary').val(totalsal);
        });


    });
</script>
<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>
<script>
    function actionProduct1(actionurl) {
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html(" < strong > " + data.status + " < /strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({
                    scrollTop: $('html, body').offset().top
                }, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html(" < strong > " + data.status + " < /strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({
                    scrollTop: $('#notify').offset().top
                }, 1000);
            }
        });
    }
</script>