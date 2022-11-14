<div class="content-body">
    <div class="card card-block bg-white yellow-top">
        <div class="card-header">


            <h5 class="title"><a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a><?php echo $this->lang->line('Edit Customer Details') ?></h5>

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
            <div class="col-md-3 ">
                <div class="card card-block card-body">
                    <h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
                    <hr>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="profile picture" id="dpic" class="img-responsive col"
                             src="<?php echo base_url('userfiles/customers/') . $customer['picture'] ?>">
                    </div>
                    <hr>
                    <p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
                                id="fileupload" type="file"
                                name="files[]"></p></div>

            </div>
            <div class="col-md-9">
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">

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
                                    <div class="tab-pane active show" id="tab1" role="tabpanel"
                                         aria-labelledby="base-tab1">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="taxid">Contribuinte</label>
                                            <div class="col-sm-6">
                                                <label class="col-sm-12" for="taxid">Deve ser um valor único</label>
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('IRS Number') ?>"
                                                       class="form-control margin-bottom b_input" name="taxid"
                                                       id="taxid"
                                                       value="<?php echo $customer['taxid'] ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row mt-1">
                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Name') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Name"
                                                       class="form-control margin-bottom b_input required" name="name"
                                                       id="mcustomer_name" value="<?php echo $customer['name'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Company') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Company"
                                                       class="form-control margin-bottom b_input" name="company"
                                                       id="company_1" value="<?php echo $customer['company'] ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="phone"
                                                       class="form-control margin-bottom required b_input" name="phone"
                                                       id="mcustomer_phone" value="<?php echo $customer['phone'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="email">Email</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="email"
                                                       class="form-control margin-bottom required b_input" name="email"
                                                       id="mcustomer_email" value="<?php echo $customer['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="address"
                                                       class="form-control margin-bottom b_input" name="address"
                                                       id="mcustomer_address1"
                                                       value="<?php echo $customer['address'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="city"><?php echo $this->lang->line('City') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="city"
                                                       class="form-control margin-bottom b_input" name="city"
                                                       id="mcustomer_city" value="<?php echo $customer['city'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="region"><?php echo $this->lang->line('Region') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Region"
                                                       class="form-control margin-bottom b_input" name="region"
                                                       id="region" value="<?php echo $customer['region'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                                            <div class="col-sm-6">
                                                <select name="country" class="form-control b_input"
                                                        id="mcustomer_country">
                                                    <?php
                                                    echo '<option value="' . $customer['country'] . '">-' . ucfirst($customer['namecountry']) . '-</option>';
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
                                                       id="postbox" value="<?php echo $customer['postbox'] ?>">
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
                                                       id="mcustomer_name_s" value="<?php echo $customer['name_s'] ?>">
                                            </div>
                                        </div>


                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="phone"
                                                       class="form-control margin-bottom b_input" name="phone_s"
                                                       id="mcustomer_phone_s"
                                                       value="<?php echo $customer['phone_s'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="email_s">Email</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="email"
                                                       class="form-control margin-bottom b_input" name="email_s"
                                                       id="mcustomer_email_s"
                                                       value="<?php echo $customer['email_s'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="address_s"
                                                       class="form-control margin-bottom b_input" name="address_s"
                                                       id="mcustomer_address1_s"
                                                       value="<?php echo $customer['address_s'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="city_s"><?php echo $this->lang->line('City') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="city"
                                                       class="form-control margin-bottom b_input" name="city_s"
                                                       id="mcustomer_city_s" value="<?php echo $customer['city_s'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="region_s"><?php echo $this->lang->line('Region') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Region"
                                                       class="form-control margin-bottom b_input" name="region_s"
                                                       id="region_s" value="<?php echo $customer['region_s'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="country_s"><?php echo $this->lang->line('Country') ?></label>

                                            <div class="col-sm-6">
                                                <select name="country_s" class="form-control b_input"
                                                        id="mcustomer_country_s">
                                                    <?php
                                                    echo '<option value="' . $customer['country_s'] . '">-' . ucfirst($customer['namecountry']) . '-</option>';
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
                                                       id="postbox_s" value="<?php echo $customer['postbox_s'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane show" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                        <?php
                                        foreach ($custom_fields as $row) {
                                            if ($row['f_type'] == 'text') { ?>
                                                <div class="form-group row">
                                                    <label class="col-sm-10 col-form-label"
                                                           for="custom[<?php echo $row['id'] ?>]"><?php echo $row['name'] ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="text"
                                                               placeholder="<?php echo $row['placeholder'] ?>"
                                                               class="form-control margin-bottom b_input <?php echo $row['other'] ?>"
                                                               name="custom[<?php echo $row['id'] ?>]"
                                                               value="<?php echo $row['data'] ?>">
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
                                                               name="custom[<?php echo $row['id'] ?>]"
                                                               value="<?php echo $row['data'] ?>" <?php if ($row['data'] == 'on') echo 'checked="checked"' ?>>
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
                                                              rows="1"><?php echo $row['data'] ?></textarea>
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
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Discount') ?>"
                                                       class="form-control margin-bottom b_input" name="discount"
                                                       value="<?php echo $customer['discount_c'] ?>">
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
                                            <label class="col-sm-2 col-form-label" for="c_field">Inactivar</label>
                                            <div class="col-sm-6">
                                                <select name="c_field"
                                                        class="form-control b_input" <?php if ($customer['delete1'] == 0) echo 'disabled' ?>>
                                                    <option value="<?php echo $customer['inactive'] ?>">--
                                                        <?php
                                                        if ($customer['inactive'] == '0') {
                                                            echo $this->lang->line('No');
                                                        } else {
                                                            echo $this->lang->line('Yes');
                                                        } ?>
                                                        --
                                                    </option>
                                                    <option value="0"><?php echo $this->lang->line('No') ?></option>
                                                    <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="customergroup"><?php echo $this->lang->line('Customer group') ?></label>

                                            <div class="col-sm-6">
                                                <select name="customergroup" class="form-control b_input">
                                                    <?php
                                                    echo '<option value="' . $customergroup['id'] . '">' . $customergroup['title'] . ' (S)</option>';
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
                                                    echo '<option value="' . $customer['lang'] . '">-' . ucfirst($customer['lang']) . '-</option>';
                                                    echo $langs;
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="paiCompanyUpdate">
                                        <input type="submit" id="submit-data"
                                               class="btn btn-primary margin-bottom float-xs-right mr-2"
                                               value="<?php echo $this->lang->line('Update') ?>"
                                               data-loading-text="Atualizando...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <input type="hidden" value="customers/editcustomer" id="action-url">
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>customers/displaypic?id=<?php echo $customer['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/customers/' + data.result + '?' + new Date().getTime());

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