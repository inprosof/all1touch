<div class="content-body yellow-top">
    <div class="card card-block bg-white">
        <div class="card-header">
            <h5 class="title"><a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a><?php echo $this->lang->line('Add New Customer') ?></h5>

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
                                       aria-selected="true"><?php echo $this->lang->line('Billing Address') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                       href="#tab2" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Shipping Address') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                       href="#tab3" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('CustomFields') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                       href="#tab4" role="tab"
                                       aria-selected="false"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Settings') ?></a>
                                </li>

                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="taxid">Contribuinte</label>
                                        <div class="col-sm-6">
                                            <label class="col-sm-12" for="taxid">Deve ser um valor único</label>
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('IRS Number') ?>"
                                                   class="form-control margin-bottom b_input" name="taxid" id="taxid">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12" for="taxid">Verificar contribuinte no sistema
                                            VIES</label>
                                        <div class="col-sm-12">
                                            <div class="alert alert-info" id="alert-info-text" for="taxid">
                                                <p>Nota: A verificação dos contribuintes
                                                    no Sistema VIES só é possível para as empresas da União Europeia!
                                                    Esta
                                                    verificação é opcional!
                                                    Escolha o país de origem da empresa que deseja verificar e carregue
                                                    em
                                                    "Verificar Contribuinte". </p>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"
                                                       for="mcustomer_vies"><?php echo $this->lang->line('Country') ?></label>

                                                <div class="col-sm-6">
                                                    <select name="mcustomer_vies" class="form-control b_input"
                                                            id="mcustomer_cont_vies">
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
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom b_input required" name="name"
                                                   id="mcustomer_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Company') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Company"
                                                   class="form-control margin-bottom b_input" name="company"
                                                   id="company_1">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="phone"
                                                   class="form-control margin-bottom required b_input" name="phone"
                                                   id="mcustomer_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="email"
                                                   class="form-control margin-bottom required b_input" name="email"
                                                   id="mcustomer_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="address"
                                                   class="form-control margin-bottom b_input" name="address"
                                                   id="mcustomer_address1">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="city"
                                                   class="form-control margin-bottom b_input" name="city"
                                                   id="mcustomer_city">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Region"
                                                   class="form-control margin-bottom b_input" name="region"
                                                   id="region">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country"><?php echo $this->lang->line('Country') ?></label>

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
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox"
                                                   id="postbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="form-group row">

                                        <div class="input-group mt-1">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="customer1"
                                                       id="copy_address">
                                                <label class="custom-control-label"
                                                       for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                            </div>

                                        </div>

                                        <div class="col-sm-10 text-info">
                                            <?php echo $this->lang->line("leave Shipping Address") ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Name"
                                                   class="form-control margin-bottom b_input" name="name_s"
                                                   id="mcustomer_name_s">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="phone"
                                                   class="form-control margin-bottom b_input" name="phone_s"
                                                   id="mcustomer_phone_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email_s">Email</label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="email"
                                                   class="form-control margin-bottom b_input" name="email_s"
                                                   id="mcustomer_email_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="address_s"
                                                   class="form-control margin-bottom b_input" name="address_s"
                                                   id="mcustomer_address1_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city_s"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="city"
                                                   class="form-control margin-bottom b_input" name="city_s"
                                                   id="mcustomer_city_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region_s"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Region"
                                                   class="form-control margin-bottom b_input" name="region_s"
                                                   id="region_s">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country_s"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-6">
                                            <select name="country_s" class="form-control b_input"
                                                    id="mcustomer_country_s">
                                                <?php
                                                echo $countrys;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="PostBox"
                                                   class="form-control margin-bottom b_input" name="postbox_s"
                                                   id="postbox_s">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
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
                                        <?php } else if ($row['f_type'] == 'check') { ?>
                                            <div class="form-group row">
                                                <label class="col-sm-10 col-form-label"
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
                                                <label class="col-sm-10 col-form-label"
                                                       for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
                                                <div class="col-sm-8">
													<textarea placeholder="<?php echo $row['placeholder'] ?>"
                                                              class="summernote <?php echo $row['other'] ?>"
                                                              name="custom[<?php echo $row['id'] ?>]"
                                                              rows="1"></textarea>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                                       for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="<?php echo $this->lang->line('Discount') ?>"
                                                   class="form-control margin-bottom b_input" name="discount">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="docid"><?php echo $this->lang->line('Document') ?> ID</label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Document ID"
                                                   class="form-control margin-bottom b_input" name="docid">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

                                        <div class="col-sm-6">
                                            <select name="customergroup" class="form-control b_input">
                                                <?php

                                                foreach ($customergrouplist as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency"><?php echo $this->lang->line('Language') ?></label>

                                        <div class="col-sm-6">
                                            <select name="language" class="form-control b_input">
                                                <?php
                                                echo $langs;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency"><?php echo $this->lang->line('customer_login') ?></label>

                                        <div class="col-sm-6">
                                            <select name="c_login" class="form-control b_input">

                                                <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                                <option value="0"><?php echo $this->lang->line('No') ?></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="password_c"><?php echo $this->lang->line('New Password') ?></label>

                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Leave blank for auto generation"
                                                   class="form-control margin-bottom b_input" name="password_c"
                                                   id="password_c">
                                        </div>
                                    </div>


                                </div>

                                <div class="col-sm-10 " id="paiCompanyUpdate">
                                    <input type="submit" id="submit-data"
                                           class="btn btn-primary margin-bottom float-xs-right mr-2"
                                           value="<?php echo $this->lang->line('Add customer') ?>"
                                           data-loading-text="Adicionando...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <input type="hidden" value="customers/addcustomer" id="action-url">
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
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: 'taxid=' + $('#taxid').val() + '&' + 'country=' + $('#mcustomer_cont_vies').val() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (!data['valid']) {
                    $("#notify .message").html("<strong>Erro </strong>Não encontramos o contribuinte no sistema VIES.<br><br>Isto pode ter ocorrido porque:<br>- O contribuinte é de um particular;<br>- Ainda não está inserido no sistema VIES;<br>- Não é de uma empresa europeia.");
                    $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else if (data['valid']) {
                    $("#notify").hide();
                    $('#company_1').html(data.name);
                    $('#company_1').val(data.name);
                    $Savename1 = "";
                    $Saveadrr1 = "";
                    $Saveadrr2 = "";
                    $Saveadrr3 = "";
                    $Saveadrr4 = "";
                    $line = data.address.split('\n');
                    if ($line.length > 1) {
                        $Saveadrr1 = $line[0];
                        $Saveadrr2 = $line[1];
                        $line2 = $line[2].split(' ');
                        if ($line2.length > 1) {
                            $Saveadrr3 = $line2[0];
                            //$Saveadrr4 = $line2[1];
                        }
                    } else {
                        $Saveadrr1 = $data['address'];
                    }


                    $('#mcustomer_address1').val($Saveadrr1);
                    $("#mcustomer_address1").html($Saveadrr1);

                    $('#mcustomer_city').val($Saveadrr2);
                    $("#mcustomer_city").html($Saveadrr2);

                    $('#postbox').val($Saveadrr3);
                    $("#postbox").html($Saveadrr3);

                    $('#region').val($Saveadrr2);
                    $("#region").html($Saveadrr2);
                } else {
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