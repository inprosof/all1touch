<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                Informações da Localização</h5>
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
                            <input type="hidden" value="<?php echo $id ?>" name="id">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param1 > 0) echo 'active show'; ?>" id="base-tab1"
                                           data-toggle="tab"
                                           aria-controls="tab1" href="#tab1" role="tab"
                                           aria-selected="<?php if ($param1 > 0) echo 'true'; else echo 'false'; ?>">Geral</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param2 > 0) echo 'active show'; ?>" id="base-tab2"
                                           data-toggle="tab" aria-controls="tab2"
                                           href="#tab2" role="tab"
                                           aria-selected="<?php if ($param2 > 0) echo 'true'; else 'false'; ?>">Financeiro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param3 > 0) echo 'active show'; ?>" id="base-tab3"
                                           data-toggle="tab" aria-controls="tab3"
                                           href="#tab3" role="tab"
                                           aria-selected="<?php if ($param3 > 0) echo 'true'; else 'false'; ?>">Faturação</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param4 > 0 || $param44 > 0) echo 'active show'; ?>"
                                           id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                           href="#tab4" role="tab"
                                           aria-selected="<?php if ($param4 > 0 || $param44 > 0) echo 'true'; else 'false'; ?>">Configuração
                                            AT</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param5 > 0) echo 'active show'; ?>" id="base-tab5"
                                           data-toggle="tab" aria-controls="tab5"
                                           href="#tab5" role="tab"
                                           aria-selected="<?php if ($param5 > 0) echo 'true'; else 'false'; ?>">Documentos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param6 > 0) echo 'active show'; ?>" id="base-tab6"
                                           data-toggle="tab" aria-controls="tab6"
                                           href="#tab6" role="tab"
                                           aria-selected="<?php if ($param6 > 0) echo 'true'; else 'false'; ?>">Emails</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if ($param7 > 0) echo 'active show'; ?>" id="base-tab7"
                                           data-toggle="tab" aria-controls="tab7"
                                           href="#tab7" role="tab"
                                           aria-selected="<?php if ($param7 > 0) echo 'true'; else 'false'; ?>">Preferências</a>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    <div class="tab-pane <?php if ($param1 > 0) echo 'active show'; ?>" id="tab1"
                                         role="tabpanel" aria-labelledby="base-tab1">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Name') ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Name"
                                                       class="form-control margin-bottom required" name="name"
                                                       value="<?php echo $cname ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Address"
                                                       class="form-control margin-bottom" name="address"
                                                       value="<?php echo $address ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="city"><?php echo $this->lang->line('City') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="City"
                                                       class="form-control margin-bottom" name="city"
                                                       value="<?php echo $city ?>">
                                            </div>
                                        </div>


                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label"
                                                   for=region"><?php echo $this->lang->line('Region') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Region"
                                                       class="form-control margin-bottom" name="region"
                                                       value="<?php echo $region ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="country"><?php echo $this->lang->line('Country') ?></label>
                                            <div class="col-sm-8">
                                                <select name="country" class="form-control b_input">
                                                    <?php
                                                    echo '<option value="' . $country . '">-' . ucfirst($country) . '-</option>';
                                                    echo $countrys;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label"
                                                   for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="postbox"
                                                       class="form-control margin-bottom" name="postbox"
                                                       value="<?php echo $postbox ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"
                                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Phone"
                                                       class="form-control margin-bottom" name="phone"
                                                       value="<?php echo $phone ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"
                                                   for="email"><?php echo $this->lang->line('Email') ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Email"
                                                       class="form-control margin-bottom required" name="email"
                                                       value="<?php echo $email ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data"
                                                       class="btn btn-success margin-bottom"
                                                       value="<?php echo $this->lang->line('Edit') ?>"
                                                       data-loading-text="Adding...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label"
                                                   for="taxid"><?php echo $this->lang->line('TAX ID') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="taxid"
                                                       class="form-control margin-bottom required" name="taxid"
                                                       value="<?php echo $taxid ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data1"
                                                       class="btn btn-success margin-bottom"
                                                       value="<?php echo $this->lang->line('Edit') ?>"
                                                       data-loading-text="Adding...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" name="rent_ab"
                                                   id="rent_ab"
                                                   value="<?php echo $rent_ab ?>" <?php if ($rent_ab == 1) echo 'checked="checked"' ?>>
                                            <label class="custom-control-label"
                                                   for="rent_ab"><?php echo "Retalhista ou vendedor ambulante" ?></label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label" for="zon_fis">Zona Fiscal</label>
                                            <div class="col-sm-8">
                                                <select name="zon_fis" class="selectpicker form-control required">
                                                    <?php echo '<option value="' . $zon_fis . '">--';
                                                    if ($zon_fis == 0)
                                                        echo $this->lang->line('Default');
                                                    else if ($zon_fis == 1)
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
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label"
                                                   for="cur_id"><?php echo $this->lang->line('Payment Currency client') ?></label>
                                            <div class="col-sm-8">
                                                <select name="cur_id" class="selectpicker form-control required">
                                                    <?php foreach ($currency as $row) {
                                                        if ($cur == $row['id']) echo '<option value="' . $row['id'] . '" selected>--' . $row['symbol'] . ' (' . $row['code'] . ')--</option>';
                                                        echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data2"
                                                       class="btn btn-success margin-bottom"
                                                       value="<?php echo $this->lang->line('Edit') ?>"
                                                       data-loading-text="Adding...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane <?php if ($param4 > 0 || $param44 > 0) echo 'active show'; ?>"
                                         id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                        <div id="accordionComunicatAtW" role="tablist" aria-multiselectable="false">
                                            <div id="headingr" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionComunicatAtW"
                                                   href="#accordioncomunicationat"
                                                   aria-expanded="false" aria-controls="accordioncomunicationat"
                                                   class="card-title lead <?php if ($param4 == 0) echo 'collapsed' ?>">
                                                    Comunicação AT
                                                </a>
                                            </div>
                                            <div id="accordioncomunicationat" role="tabpanel1"
                                                 aria-labelledby="headingr"
                                                 class="card-collapse <?php if ($param4 == 0) echo 'collapse' ?>"
                                                 aria-expanded="false">
                                                <div class="col-sm-12">
                                                    <h5><?php echo $this->lang->line('saft10') ?></h5>
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="billing_doc" id="billing_doc"
                                                               value="<?php echo $activation['docs'] ?>" <?php if ($activation['docs'] == 1) echo 'checked="checked"' ?>>
                                                        <label class="custom-control-label"
                                                               for="billing_doc"><?php echo $this->lang->line('saft11') ?></label>
                                                    </div>
                                                    <div class="form-group row div_date_docs">
                                                        <h6 style="text-align: justify"><?php echo $this->lang->line('saft14') ?></h6>
                                                        <label class="col-sm-3 control-label"
                                                               for="date_docs"><?php echo $this->lang->line('Date') ?></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control required"
                                                                   placeholder="Date" name="date_docs"
                                                                   data-toggle="datepicker" autocomplete="false"
                                                                   value="<?php echo $activation['docs_date'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="transport_doc" id="transport_doc"
                                                               value="<?php echo $activation['guides'] ?>" <?php if ($activation['guides'] == 1) echo 'checked="checked"' ?>>
                                                        <label class="custom-control-label"
                                                               for="transport_doc"><?php echo $this->lang->line('saft12') ?></label>
                                                    </div>
                                                    <div class="form-group row div_date_docs_guide">
                                                        <h6 style="text-align: justify"><?php echo $this->lang->line('saft14') ?></h6>
                                                        <label class="col-sm-3 control-label"
                                                               for="date_docs_guide"><?php echo $this->lang->line('Date') ?></label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control required"
                                                                   placeholder="Date" name="date_docs_guide"
                                                                   id="date_docs_guide" data-toggle="datepicker"
                                                                   autocomplete="false"
                                                                   value="<?php echo $activation['guides_date'] ?> ">
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <h5><?php echo $this->lang->line('saft13') ?></h5>

                                                        <div class="form-group row">
                                                            <div class="col-sm-10">
                                                                <label class="col-sm-12 col-form-label" for="username">ID
                                                                    Utilizador</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><?php echo $taxid; ?>/</span>
                                                                    <input type="text" name="username"
                                                                           class="form-control required"
                                                                           placeholder="0"
                                                                           aria-describedby="sizing-addon1"
                                                                           onkeypress="return isNumber(event)"
                                                                           value="<?php if ($activation['username'] == '') echo '0'; else echo $activation['username']; ?>">
                                                                    <div class="input-group-addon" id="info-text"
                                                                         data-container="body"
                                                                         data-toggle="popover" data-placement="top"
                                                                         data-content="<?php echo $this->lang->line('Must be an integer') ?>">
                                                                        <i class="bi bi-info-circle"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-8 col-form-label"
                                                                   for="email"><?php echo $this->lang->line('Your Password') ?></label>
                                                            <div class="input-group col-sm-10">
                                                                <input type="current-password" placeholder="Password"
                                                                       class="form-control margin-bottom crequired"
                                                                       name="password" id="password"
                                                                       value="<?php echo $activation['password'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-8" id="paiCompanyUpdate">
                                                        <input type="submit" id="location-data3"
                                                               class="btn btn-success margin-bottom"
                                                               value="<?php echo $this->lang->line('Edit') ?>"
                                                               data-loading-text="Adding...">
                                                        <input type="hidden" value="<?php echo $id ?>" name="idloc_at">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="accordionIvaCaixAtW" role="tablist"
                                             aria-multiselectable="<?php if ($param44 > 0) echo 'true'; else echo 'false'; ?>">
                                            <div id="headingriva" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionIvaCaixAtW"
                                                   href="#accordionIvaCaix"
                                                   aria-expanded="false" aria-controls="accordionIvaCaix"
                                                   class="card-title lead <?php if ($param44 == 0) echo 'collapsed' ?>">
                                                    Regime de IVA de Caixa
                                                </a>
                                            </div>
                                            <div id="accordionIvaCaix" role="tabpanel2" aria-labelledby="headingriva"
                                                 class="card-collapse <?php if ($param44 == 0) echo 'collapse' ?>"
                                                 aria-expanded="false">
                                                <div class="col-sm-12">
                                                    <h4 class="title"><?php echo $this->lang->line('saft17') ?></h4>
                                                    <h6 style="text-align: justify"><?php echo $this->lang->line('saft18') ?></h6>
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="caixa_1" id="caixa_1_t"
                                                               value="<?php echo $activation['caixa_vat1'] ?>" <?php if ($activation['caixa_vat1'] == 1) echo 'checked="checked"' ?>>
                                                        <label class="custom-control-label"
                                                               for="caixa_1_t"><?php echo $this->lang->line('saft23') ?></label>
                                                    </div>

                                                    <h4 class="title"><?php echo $this->lang->line('saft19') ?></h4>
                                                    <h6 style="text-align: justify"><?php echo $this->lang->line('saft20') ?></h6>
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="caixa_2" id="caixa_2_t"
                                                               value="<?php echo $activation['caixa_vat2'] ?>" <?php if ($activation['caixa_vat2'] == 1) echo 'checked="checked"' ?>>
                                                        <label class="custom-control-label"
                                                               for="caixa_2_t"><?php echo $this->lang->line('saft24') ?></label>
                                                    </div>

                                                    <h4 class="title"><?php echo $this->lang->line('saft21') ?></h4>
                                                    <h6 style="text-align: justify"><?php echo $this->lang->line('saft22') ?></h6>
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="caixa_3" id="caixa_3_t"
                                                               value="<?php echo $activation['caixa_vat3'] ?>" <?php if ($activation['caixa_vat3'] == 1) echo 'checked="checked"' ?>>
                                                        <label class="custom-control-label"
                                                               for="caixa_3_t"><?php echo $this->lang->line('saft24') ?></label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="hidden" name="caixa_doc_date" id="caixa_doc_date"
                                                               value="<?php echo $activation['caixa_date'] ?>">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="caixa_4" id="caixa_4_t"
                                                               value="<?php echo $activation['caixa_vat4'] ?>" <?php if ($activation['caixa_vat4'] == 1) echo 'checked="checked"' ?> <?php if ($activation['caixa_vat1'] == 0 || $activation_caixa['caixa_vat2'] == 0 || $activation_caixa['caixa_vat3'] == 0) echo 'disabled' ?>>
                                                        <label class="custom-control-label"
                                                               for="caixa_4_t"><?php echo $this->lang->line('saft25') ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label"></label>
                                                    <div class="col-sm-8" id="paiCompanyUpdate">
                                                        <input type="submit" id="location-data4"
                                                               class="btn btn-success margin-bottom"
                                                               value="<?php echo $this->lang->line('Edit') ?>"
                                                               data-loading-text="Adding...">
                                                        <input type="hidden" value="<?php echo $id ?>"
                                                               name="idloc_caixa">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane <?php if ($param5 > 0) echo 'active show'; ?>" id="tab5"
                                         role="tabpanel" aria-labelledby="base-tab5">
                                        <?php
                                        $cvalue = 0;
                                        foreach ($docs_copy_ini as $row) {
                                            echo '<div class="col-sm-12">
														<input type="hidden" class="pdIn" name="pid[]" id="pid-' . $cvalue . '" value="' . $row['id'] . '">
														<input type="hidden" class="pdIn" name="pcopyid[]" id="pcopyid-' . $cvalue . '" value="' . $row['copy'] . '">
														<label class="col-form-label" for="typ_doc_' . $cvalue . '">' . $row['typ_name'] . '</label><div class="col-sm-8">
														<input type="text" class="form-control text-center" onkeyup="rowCopys(' . $cvalue . ')"  name="serie_copy[]" id="serie_copy-' . $cvalue . '" value="' . $row['copyname'] . '">
														</div>
													</div>';
                                            $cvalue++;
                                        }
                                        ?>
                                        <div class="form-group row mt-2">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data5"
                                                       class="btn btn-success margin-bottom"
                                                       value="<?php echo $this->lang->line('Edit') ?>"
                                                       data-loading-text="Adding...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane <?php if ($param6 > 0 || $param7 > 0) echo 'active show'; ?>"
                                         id="tab6" role="tabpanel" aria-labelledby="base-tab6">
                                        <div id="accordionEMAILGG" role="tablist" aria-multiselectable="false">
                                            <div id="headingremails" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionEMAILGG"
                                                   href="#accordionEMAILGGW"
                                                   aria-expanded="false" aria-controls="accordionEMAILGGW"
                                                   class="card-title lead <?php if ($param6 == 0) echo 'collapsed' ?>">
                                                    1. Geral
                                                </a>
                                            </div>
                                            <div id="accordionEMAILGGW" role="tabpanel3"
                                                 aria-labelledby="headingremails"
                                                 class="card-collapse <?php if ($param6 == 0) echo 'collapse' ?>"
                                                 aria-expanded="false">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="emails_notifica">E-mail
                                                            notificações All1Touch</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" placeholder="abcd@abcd.pt"
                                                                   class="form-control margin-bottom"
                                                                   name="emails_notifica" id="emails_notifica"
                                                                   value="<?php echo $company_permiss['email_app'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="emailo_remet">Nome Remetente
                                                            nos Emails</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" placeholder="abcd@abcd.pt"
                                                                   class="form-control margin-bottom"
                                                                   name="emailo_remet" id="emailo_remet"
                                                                   value="<?php echo $company_permiss['emailo_remet'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="docs_email" id="docs_email"
                                                           value="<?php echo $company_permiss['docs_email'] ?>" <?php if ($company_permiss['docs_email'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="docs_email"><?php echo "Enviar após criação de um Documento?" ?></label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="docs_del_email" id="docs_del_email"
                                                           value="<?php echo $company_permiss['docs_del_email'] ?>" <?php if ($company_permiss['docs_del_email'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="docs_del_email"><?php echo "Enviar após anular um Documento?" ?></label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="trans_email" id="trans_email"
                                                           value="<?php echo $company_permiss['trans_email'] ?>" <?php if ($company_permiss['trans_email'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="trans_email"><?php echo "Enviar após uma Transação?" ?></label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="trans_del_email" id="trans_del_email"
                                                           value="<?php echo $company_permiss['trans_del_email'] ?>" <?php if ($company_permiss['trans_del_email'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="trans_del_email"><?php echo "Enviar após apagar uma Transação?" ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="accordionEMAILSTG" role="tablist" aria-multiselectable="false">
                                            <div id="headingrstocks" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionEMAILSTG"
                                                   href="#accordionEMAILSTGW"
                                                   aria-expanded="false" aria-controls="accordionEMAILSTGW"
                                                   class="card-title lead <?php if ($param7 == 0) echo 'collapsed' ?>">
                                                    2. Artigos e Stocks
                                                </a>
                                            </div>
                                            <div id="accordionEMAILSTGW" role="tabpanel"
                                                 aria-labelledby="headingrstocks"
                                                 class="card-collapse <?php if ($param7 == 0) echo 'collapse' ?>"
                                                 aria-expanded="false">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="email_stock">E-mail
                                                            notificações Stock</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" placeholder="abcd@abcd.pt"
                                                                   class="form-control margin-bottom" name="email_stock"
                                                                   id="email_stock"
                                                                   value="<?php echo $company_permiss['email_stock'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="stock_min"
                                                           id="stock_min"
                                                           value="<?php echo $company_permiss['stock_min'] ?>" <?php if ($company_permiss['stock_min'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="stock_min"><?php echo "Enviar alerta de stock mínimo por e-mail" ?></label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="stock_sem"
                                                           id="stock_sem"
                                                           value="<?php echo $company_permiss['stock_sem'] ?>" <?php if ($company_permiss['stock_min'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="stock_sem"><?php echo "Enviar alerta sem stock por e-mail" ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data7" class="btn btn-success sub-btn"
                                                       value="<?php echo $this->lang->line('Update') ?>"
                                                       data-loading-text="Updating...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane <?php if ($param77 > 0) echo 'active show'; ?>" id="tab7"
                                         role="tabpanel" aria-labelledby="base-tab7">
                                        <div id="accordionConfG" role="tablist" aria-multiselectable="false">
                                            <div id="headingrconf1" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionConfG"
                                                   href="#accordionConfGW"
                                                   aria-expanded="false" aria-controls="accordionConfGW"
                                                   class="card-title lead collapsed">
                                                    1 - Painel Principal
                                                </a>
                                            </div>
                                            <div id="accordionConfGW" role="tabpanel" aria-labelledby="headingrconf1"
                                                 class="card-collapse collapse" aria-expanded="false">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="grafic_show" id="grafic_show"
                                                           value="<?php echo $company_permiss['grafics'] ?>" <?php if ($company_permiss['grafics'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="grafic_show"><?php echo "Mostrar gráficos no Painel Principal" ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="accordionSearG" role="tablist" aria-multiselectable="false">
                                            <div id="headingrconf2" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionSearG"
                                                   href="#accordionSearGW"
                                                   aria-expanded="false" aria-controls="accordionSearGW"
                                                   class="card-title lead collapsed">
                                                    2 - Pesquisas
                                                </a>
                                            </div>
                                            <div id="accordionSearGW" role="tabpanel" aria-labelledby="headingrconf2"
                                                 class="card-collapse collapse" aria-expanded="false">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="products_show" id="products_show"
                                                           value="<?php echo $company_permiss['products_inactiv_show'] ?>" <?php if ($company_permiss['products_inactiv_show'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="products_show"><?php echo "Mostrar artigos inactivos nas pesquisas" ?></label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="clients_show" id="clients_show"
                                                           value="<?php echo $company_permiss['clients_inactiv_show'] ?>" <?php if ($company_permiss['clients_inactiv_show'] == 1) echo 'checked="checked"' ?>>
                                                    <label class="custom-control-label"
                                                           for="clients_show"><?php echo "Mostrar clientes inactivos nas pesquisas" ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="accordionGER" role="tablist" aria-multiselectable="false">
                                            <div id="headingr" class="card-header">
                                                <a data-toggle="collapse" data-parent="#accordionGER"
                                                   href="#accordionGERW"
                                                   aria-expanded="false" aria-controls="accordionGERW"
                                                   class="card-title lead <?php if ($param77 == 0) echo 'collapsed' ?>">
                                                    3 - Configurações por defeito (Se
                                                    não selecionada Localização)
                                                </a>
                                            </div>
                                            <div id="accordionGERW" role="tabpanel" aria-labelledby="headingr"
                                                 class="card-collapse <?php if ($param77 == 0) echo 'collapse' ?>"
                                                 aria-expanded="false">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="n_praz_venc"><?php echo 'Prazo de Vencimento ' ?><?php echo $this->lang->line('Default') ?></label>
                                                        <div class="input-group">
                                                            <select name="n_praz_venc" class="form-control">
                                                                <?php
                                                                if ($online_pay['prazo_ve'] == null || $online_pay['prazo_ve'] == "") echo '<option value="0">Escolha uma Opção</option>'; else echo '<option value="' . $online_pay['prazo_ve'] . '">-' . $online_pay['prazo_ve_name'] . '-</option>';
                                                                echo $prazos_vencimento;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="n_met_exp"><?php echo 'Método de Expedição ' ?><?php echo $this->lang->line('Default') ?></label>
                                                        <div class="input-group">
                                                            <select name="n_met_exp" class="form-control">
                                                                <?php
                                                                if ($online_pay['metod_exp'] == null || $online_pay['metod_exp'] == "") echo '<option value="0">Escolha uma Opção</option>'; else echo '<option value="' . $online_pay['metod_exp'] . '">-' . $online_pay['metod_exp_name'] . '-</option>';
                                                                echo $expeditions;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="n_met_pag"><?php echo 'Método Pagamento ' ?><?php echo $this->lang->line('Default') ?></label>
                                                        <div class="input-group">
                                                            <select name="n_met_pag" class="form-control">
                                                                <?php
                                                                if ($online_pay['metod_pag'] == null || $online_pay['metod_pag'] == "") echo '<option value="0">Escolha uma Opção</option>'; else echo '<option value="' . $online_pay['metod_pag'] . '">-' . $online_pay['metod_pag_name'] . '-</option>';
                                                                echo $metodos_pagamentos;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="wid"><?php echo $this->lang->line('Warehouse') ?><?php echo $this->lang->line('Default') ?></label>
                                                        <div class="input-group">
                                                            <select name="wid"
                                                                    class="selectpicker form-control round required">
                                                                <?php
                                                                echo '<option value="' . $ware . '" selected>--' . $namewar . '--</option>';
                                                                foreach ($warehouse as $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="assign"><?php echo $this->lang->line('AllowAssignEmployee') ?></label>
                                                        <div class="input-group">
                                                            <select name="assign" class="form-control">
                                                                <?php switch ($online_pay['emps']) {
                                                                    case '1' :
                                                                        echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                                                        break;
                                                                    case '0' :
                                                                        echo '<option value="0">**  ' . $this->lang->line('No') . '**</option>';
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
                                                        <label class="col-form-label" for="pstyle">Estilo
                                                            Documentos</label>
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
                                                        <label class="col-form-label" for="pos_list">Listar(Para
                                                            Escolha) <?php echo $this->lang->line('Account') ?> POS ou
                                                            Documentos</label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="pos_list">
                                                                <option value="<?php echo $online_pay['pac']; ?>">
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
                                                        <label class="col-form-label" for="pos_type_doc">Tipo
                                                            Documento <?php echo $this->lang->line('Default') ?>
                                                            POS</label>
                                                        <div class="input-group">
                                                            <select name="type_doc"
                                                                    class="selectpicker form-control round required">
                                                                <option value="<?php echo $online_pay['doc_default']; ?>"
                                                                        selected>
                                                                    --<?php echo $online_pay['nametipdoc']; ?>--
                                                                </option>
                                                                ';
                                                                <?php
                                                                echo $irs_typ;
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="account_o"><?php echo $this->lang->line('Account') ?>
                                                            Documentos <?php echo $this->lang->line('Default') ?> e
                                                            POS</label>
                                                        <div class="input-group">
                                                            <select name="account_d" class="form-control">
                                                                <?php
                                                                echo '<option value="' . $online_pay['acount_d'] . '" selected>--' . $online_pay['ac_name_d'] . '--</option>';
                                                                foreach ($accounts as $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="account_d"><?php echo $this->lang->line('Account') ?>
                                                            Vendas Online</label>
                                                        <div class="input-group">
                                                            <select name="account" class="form-control">
                                                                <?php
                                                                echo '<option value="' . $online_pay['acount_o'] . '" selected>--' . $online_pay['ac_name_o'] . '--</option>';
                                                                foreach ($accounts as $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="account_f"><?php echo $this->lang->line('Account') ?>
                                                            Fornecedores <?php echo $this->lang->line('Default') ?></label>
                                                        <div class="input-group">
                                                            <select name="account_f" class="form-control">
                                                                <?php
                                                                echo '<option value="' . $online_pay['acount_f'] . '" selected>--' . $online_pay['ac_name_f'] . '--</option>';
                                                                foreach ($accounts as $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label"
                                                               for="dual_entry"><?php echo $this->lang->line('Dual Entry') ?></label>
                                                        <div class="alert alert-info" id="alert-info-text">
                                                            <strong>Atenção:</strong>Por favor, não habilite este
                                                            recurso sem o devido entendimento sistema de contabilidade
                                                            de dupla entrada.
                                                        </div>
                                                        <div class="input-group">
                                                            <select name="dual_entry" class="form-control">
                                                                <option value="<?php echo $online_pay['dual_entry']; ?>">
                                                                    --<?php if ($online_pay['dual_entry'] == '0') {
                                                                        echo $this->lang->line('No');
                                                                    } else {
                                                                        echo $this->lang->line('Yes');
                                                                    } ?>--
                                                                </option>
                                                                <option value="0"><?php echo $this->lang->line('No') ?></option>
                                                                <option value="1"><?php echo $this->lang->line('Yes') ?> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-8" id="paiCompanyUpdate">
                                                <input type="submit" id="location-data8" class="btn btn-success sub-btn"
                                                       value="<?php echo $this->lang->line('Update') ?>"
                                                       data-loading-text="Updating...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="search_copys" id="bill_copys">
                            <input type="hidden" name="image" id="image" value="<?php echo $logo ?>">
                        </form>
                    </div>
                    <div class="col-6">
                        <div class="card card-block">
                            <h5>Logo da Localização</h5>
                            <div class="col-sm-6">
                                <table id="files" class="files">
                                    <tr>
                                        <td>
                                            <a data-url="<?php echo base_url() ?>locations/file_handling?op=delete&name=<?php echo $logo ?>"
                                               class="aj_delete"><i
                                                        class="btn-danger btn-sm icon-trash-a"></i> <?php echo $logo ?>
                                            </a><img
                                                    style="max-height:200px;"
                                                    src="<?php echo base_url() ?>userfiles/company/<?php echo $logo ?>">
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <p>
                                    <label for="fileupload"><?php echo $this->lang->line('Change Company Logo') ?></label><input
                                            id="fileupload" type="file" name="files[]"></p>
                                <pre>gif, jpeg, png (500x200px).</pre>
                                <!-- The global progress bar -->
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $("#location-data").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/edit';
        actionProduct(actionurl);
    });
    $("#location-data1").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/edit';
        actionProduct(actionurl);
    });
    $("#location-data2").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/edit';
        actionProduct(actionurl);
    });
    $("#location-data3").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/autority_pt';
        actionProduct(actionurl);
    });
    $("#location-data4").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/reg_iva';
        actionProduct(actionurl);
    });
    $("#location-data5").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/edit';
        actionProduct(actionurl);
    });
    $("#location-data6").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/edit';
        actionProduct(actionurl);
    });
    $("#location-data7").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/geral_emails';
        actionProduct(actionurl);
    });
    $("#location-data8").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'locations/geral_configs';
        actionProduct(actionurl);
    });
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>locations/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>locations/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/company/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
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

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });

    $('.editdate').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
</script>