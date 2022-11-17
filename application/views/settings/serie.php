<script src="<?php echo assets_url(); ?>assets/portjs/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Add') . ' Serie' ?>
            </h5>
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


            <form method="post" id="data_form" class="card-body">


                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                           aria-controls="tab1" href="#tab1" role="tab"
                           aria-selected="true">Geral</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                           href="#tab2" role="tab"
                           aria-selected="false">Preferências</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                           href="#tab3" role="tab"
                           aria-selected="false">Números Iniciais</a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="Serie">Serie</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Serie"
                                       class="form-control margin-bottom b_input" name="serie">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="cae">C.A.E. (Classificação das Atividades
                                Económicas)</label>
                            <div class="col-sm-6">
                                <select name="cae" class="form-control b_input required" id="cae">
                                    <option value="">Escolha um CAE</option>
                                    <?php
                                    echo $caes;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label"
                                   for="from"><?php echo $this->lang->line('Start') ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control b_input required"
                                       placeholder="Start Date" name="startdate"
                                       data-toggle="datepicker" autocomplete="false" id="input-date">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="from"><?php echo $this->lang->line('End') ?></label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control b_input required"
                                       placeholder="End Date" name="enddate"
                                       data-toggle="datepicker" autocomplete="false" id="input-date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_iva_caixa">Regime de IVA de Caixa?</label>
                            <div class="col-sm-2">
                                <select name="serie_iva_caixa" class="form-control b_input">
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_iva_caixa">Regime de IVA de Caixa?</label>
                            <div class="col-sm-2">
                                <select name="serie_iva_caixa" class="form-control b_input">
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_pred">Predefinido?</label>
                            <div class="col-sm-2">
                                <select name="serie_pred" class="form-control b_input">
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="exclued">Inativar?</label>
                            <div class="col-sm-2">
                                <select name="exclued" class="form-control b_input">
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_class"><?php echo $this->lang->line('Class Ativ') ?>.</label>
                            <div class="col-sm-6">
                                <select name="serie_class" id="serie_class" class="form-control b_input">
                                    <option value="">Escolha uma Opção</option>
                                    <?php echo $classes ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_wareh">Localização</label>
                            <div class="col-sm-6">
                                <select name="serie_wareh" id="serie_wareh" class="form-control b_input">
                                    <option value="">Escolha uma Opção</option>
                                    <?php echo $localizacoes ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="serie_type_com"><?php echo $this->lang->line('Type Com') ?>.</label>
                            <div class="col-sm-6">
                                <select name="serie_type_com" id="serie_type_com" class="form-control b_input">
                                    <option value="">Escolha uma Opção</option>
                                    <option value="0">Web Service</option>
                                    <option value="1">SAFT</option>
                                    <option value="2">Sem Comunicação</option>
                                    <option value="3">Manual</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                        <?php
                        $cvalue = 0;
                        foreach ($docs_ini as $row) {
                            echo '<div class="row mb-2">
									<input type="hidden" class="pdIn" name="pid[]" id="pid-' . $cvalue . '" value="' . $row['id'] . '">
									<div class="col-sm-2"><label class="col-form-label" for="typ_doc_' . $cvalue . '">' . $row['typ_name'] . '</label></div><div class="col-sm-6">
									<input type="text"';

                            if ($row['ver'] == 0) {
                                echo ' readonly ';
                            }
                            echo '"placeholder="' . $row['typ_name'] . '" class="form-control margin-bottom b_input" name="start_doc[]" id="doc_' . $cvalue . '" value="' . $row['start'] . '">
									</div>
								</div>';

                            $cvalue++;
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6 mt-2" id="paiCompanyUpdate">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/serie" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select-box').select2();
</script>