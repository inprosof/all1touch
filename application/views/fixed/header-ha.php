<link rel="stylesheet" type="text/css"
      href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/menu/menu-types/vertical-menu.css">
</head>
<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="click" data-menu="horizontal-menu"
      data-col="2-columns">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item"><a class="navbar-brand" href="<?php echo base_url() ?>dashboard/"><img
                                class="brand-logo" alt="logo"
                                src="<?php echo base_url(); ?>userfiles/theme/logo-header.png">
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>


                    <li class="dropdown  nav-item"><a class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                    class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><i
                                                class="ficon ft-map-pin success"></i><?php echo $this->lang->line('business_location') ?></span>
                                </h6>
                            </li>
                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > <?php 
									$loc = location($this->aauth->get_user()->loc);
                                    echo $loc['cname']; ?></span>
                            </li>
                        </ul>
                    </li>
					
					<li class="nav-item d-none d-md-block nav-link" style="<?php if (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) echo 'display:none' ?> !important;">
						<select class="form-control" onchange="javascript:location.href = baseurl+'settings/switch_location?id='+this.value;"> 
						<?php
							$company = location(0);
							$loc = location($this->aauth->get_user()->loc);
							echo ' <option value="' . $loc['id'] . '">*' . $loc['cname'] . '*</option>';
							$loc = locations();
							foreach ($loc as $row) {
								echo ' <option value="' . $row['id'] . '">' . $row['cname'] . '</option>';
							}
							if($this->aauth->get_user()->loc > 0)
							{
								echo ' <option value="0">**' . $company['cname'] . '**</option>';
							}
						?></select>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link" style="<?php if (!$this->aauth->premission(5)) echo 'display:none' ?> !important;"><a href="<?php echo base_url() ?>pos_invoices/create"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Access POS"><i class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li>
					<li class="nav-item d-none d-md-block">
						<a class="nav-link" href="#"><?php echo $this->session->userdata('license_t'); ?></a>
					</li>
                    <li class="nav-item nav-search" style="<?php if (!$this->aauth->premission(120)) echo 'display:none' ?> !important;"><a class="nav-link nav-link-search" href="#" aria-haspopup="true"
                                                       aria-expanded="false" id="search-input"><i
                                    class="ficon ft-search"></i></a>
                        <div class="search-input">
                            <input class="input" type="text"
                                   placeholder="<?php echo $this->lang->line('Search Customer') ?>"
                                   id="head-customerbox">
                        </div>
                        <div id="head-customerbox-result" class="dropdown-menu ml-5"
                             aria-labelledby="search-input"></div>
                    </li>
                </ul>

                <ul class="nav navbar-nav float-right"><?php if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) { ?>
                        <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link " href="#"
                                                                       data-toggle="dropdown"> <?php echo $this->lang->line('admin_settings') ?> </a>
                            <ul class="mega-dropdown-menu dropdown-menu row">
                                <li class="col-md-3">

                                    <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading1" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion1"
                                                   aria-controls="accordion1"><i
                                                            class="fa fa-leaf"></i> <?php echo $this->lang->line('business_settings')  ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion1" role="tabpanel"
                                                 aria-labelledby="heading1" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/company"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('company_settings') ?>
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/caes"><i
                                                                        class="ft-chevron-right"></i> C.A.E.s da Empresa
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>locations"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Business Locations') ?>
                                                            </a></li><li>
															<select class="dropdown-item" onchange="javascript:location.href = baseurl+'settings/switch_location?id='+this.value;">
															<?php
																$company = location(0);
																$loc = location($this->aauth->get_user()->loc);
																echo ' <option value="' . $loc['id'] . '">*' . $loc['cname'] . '*</option>';
																$loc = locations();
																foreach ($loc as $row) {
																	echo ' <option value="' . $row['id'] . '">' . $row['cname'] . '</option>';
																}
																if($this->aauth->get_user()->loc > 0)
																{
																	echo ' <option value="0">**' . $company['cname'] . '**</option>';
																}
																?></select></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>tools/setgoals"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Set Goals') ?>
                                                            </a></li>
														<?php if ($this->aauth->get_user()->roleid == 7) {?><li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/culturs"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Culturs') ?>
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/countrys"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Countrys') ?>
                                                            </a></li>
														<?php }?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion2"
                                                   aria-controls="accordion2"> <i
                                                            class="fa fa-calendar"></i><?php echo $this->lang->line('Localisation') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion2" role="tabpanel"
                                                 aria-labelledby="heading2" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/currency"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/language"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Languages'); ?></a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/dtformat"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Date & Time Format') ?>
                                                            </a></li>
														<?php }?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/theme"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Theme') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading3" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion3"
                                                   aria-controls="accordion3"> <i
                                                            class="fa fa-lightbulb-o"></i><?php echo $this->lang->line('miscellaneous_settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion3" role="tabpanel"
                                                 aria-labelledby="heading3" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>activate/activate"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Software Activation'); ?></a></li>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>webupdate"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Software Update'); ?></a></li>
														<?php }?>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email Config') ?>
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/automail"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Auto Email SMS') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/misc_automail"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('EmailAlert') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/about"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('About') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading4" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion4"
                                                   aria-controls="accordion4"><i
                                                            class="fa fa-fire"></i><?php echo $this->lang->line('AdvancedSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion4" role="tabpanel"
                                                 aria-labelledby="heading4" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>restapi"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('REST API') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>cronjob"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Automatic Corn Job') ?>
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/debug"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Debug Mode'); ?> </a>
                                                        </li>
														<?php }?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/custom_fields"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('CustomFields') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/logdata"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Application Activity Log'); ?></a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion5"
                                                   aria-controls="accordion5"> <i
                                                            class="fa fa-shopping-cart"></i><?php echo $this->lang->line('BillingSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion5" role="tabpanel"
                                                 aria-labelledby="heading5" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>              
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/billing_settings"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('billing_settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/discship"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('DiscountShipping') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/billing_terms"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Billing Terms') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading6" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion6"
                                                   aria-controls="accordion6"><i
                                                            class="fa fa-scissors"></i><?php echo $this->lang->line('TaxSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion6" role="tabpanel"
                                                 aria-labelledby="heading6" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/series"><i
                                                                        class="ft-chevron-right"></i> Séries
                                                            </a></li>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/Clients Trans"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Withholding') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/taxslabs"><i
                                                                        class="ft-chevron-right"></i> Taxas de Iva
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/irs_typ_docs"><i
                                                                        class="ft-chevron-right"></i> Tipos de Documentos
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/reasons_notes"><i
                                                                        class="ft-chevron-right"></i> Razões Notas
                                                            </a></li>
														<?php }?>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap2" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading7" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion7"
                                                   aria-controls="accordion7"><i
                                                            class="fa fa-flask"></i><?php echo $this->lang->line('ProductsSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion7" role="tabpanel"
                                                 aria-labelledby="heading7" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Measurement Unit') ?>
                                                            </a></li>
														<?php }?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variations"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('ProductsVariations') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variables"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('VariationsVariables') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading8" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion8"
                                                   aria-controls="accordion8"> <i
                                                            class="fa fa-money"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion8" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
														<?php if ($this->aauth->get_user()->roleid == 7) {?>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/method_expeditions"><i
                                                                        class="ft-chevron-right"></i>Métodos de Expedição
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/method_payments"><i
                                                                        class="ft-chevron-right"></i>Métodos de Pagamentos
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/praz_vencs"><i
                                                                        class="ft-chevron-right"></i>Prazos de Vencimento
                                                            </a></li>
														<li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/numb_copys"><i
                                                                        class="ft-chevron-right"></i>Número de Cópias
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/settings"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                            </a></li>
														<?php }?>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Gateways') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/currencies"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Currencies') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency Exchange') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading9" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion9"
                                                   aria-controls="accordion9"><i
                                                            class="fa fa-umbrella"></i><?php echo $this->lang->line('CRMHRMSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion9" role="tabpanel"
                                                 aria-labelledby="heading9" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>employee/auto_attendance"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('SelfAttendance')  ?>
                                                            </a></li>

                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/registration"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('CRMSettings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/tickets"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Support Tickets') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                                <li class="col-md-3">

                                    <div id="accordionWrap3" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
											<?php if ($this->aauth->get_user()->roleid == 7) {?>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading10" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion10"
                                                   aria-controls="accordion10"><i
                                                            class="fa fa-magic"></i><?php echo $this->lang->line('PluginsSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion10" role="tabpanel"
                                                 aria-labelledby="heading10" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/recaptcha"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('reCaptcha Security'); ?></a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/shortner"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('URL Shortener'); ?></a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/twilio"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('SMS Configuration'); ?></a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Currency Exchange API'); ?></a></li>
                                                        <?php plugins_checker(); ?>
                                                    </ul>
                                                </div>
                                            </div>
											<?php }?>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading11" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion11"
                                                   aria-controls="accordion11"> <i
                                                            class="fa fa-eye"></i><?php echo $this->lang->line('TemplatesSettings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion11" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/sms"><i
                                                                        class="ft-chevron-right"></i> SMS</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/print_invoice"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Print Invoice') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading12" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion12"
                                                   aria-controls="accordion12"><i
                                                            class="fa fa-print"></i><?php echo $this->lang->line('POS Printers'); ?></a>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion12" role="tabpanel"
                                                 aria-labelledby="heading12" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer/add"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Add Printer'); ?></a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('List Printers'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </li>       
					<?php } ?>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2">Tarefas em Estado Vencidas</span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0"><?=$this->lang->line('New') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i><span
                                    class="badge badge-pill badge-default badge-info badge-default badge-up" id="messagecount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span
                                            class="notification-tag badge badge-default badge-warning float-right m-0" id="messagecount2">0<?php echo $this->lang->line('new') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>    </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">


                            <?php if ($this->aauth->clock()) {

                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-default badge-success badge-default badge-up">' . $this->lang->line('On') . '</span></a>';

                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-default badge-warning badge-default badge-up">' . $this->lang->line('Off') . '</span></a>';
                            }
                            ?>

                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <br><br>
                                <?php echo '<span class="p-1 text-bold-300">' . $this->lang->line('Attendance') . ':</span>';
                                if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-on" aria-hidden="true"></span> ' . $this->lang->line('ClockIn') . ' <i
                                    class="ficon icon-clock spinner"></i></a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-off" aria-hidden="true"></span> ' . $this->lang->line('ClockOut'). ' </a>';
                                }
                                ?>

                                <br><br>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span><span
                                    class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>user/holiday"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a>
							<a href="<?php echo base_url(); ?>user/vacation"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Vacations') ?></a>
							<a href="<?php echo base_url(); ?>user/fault"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Fault') ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i
                                        class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border"
     role="navigation" data-menu="menu-wrapper">
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">

        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>dashboard/"><i
                            class="icon-speedometer"></i><span><?php echo $this->lang->line('Dashboard') ?></span></a>
            </li>
            <?php
            if ($this->aauth->premission(1) || $this->aauth->premission(4) || $this->aauth->premission(7) || $this->aauth->premission(10) || $this->aauth->premission(13) || $this->aauth->premission(16) || $this->aauth->premission(19) || $this->aauth->premission(42) || $this->aauth->premission(125) || $this->aauth->premission(130) || $this->aauth->premission(136)) { ?>
                <li class="dropdown nav-item" data-menu="dropdown">
					<a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-basket-loaded"></i><span>Documentos</span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(1) || $this->aauth->premission(4) || $this->aauth->premission(125) || $this->aauth->premission(130)) {?>
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-handbag"></i>Vendas</a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(1)) {?>
                                <li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>invoices" data-toggle="dropdown"><i class="icon-basket"></i>Faturas</a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(13)) {?>
									<li data-menu="">
										<a class="dropdown-item" href="<?php echo base_url(); ?>pos_invoices" data-toggle="dropdown"><i class="icon-paper-plane"></i>POS</a>
									</li>
								<?php }?>
								
								<?php if ($this->aauth->premission(125)) {?>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>customers_notes/index?ty=0"><i class="icon-screen-tablet"></i>Notas de Débito</a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(130)) {?>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>receipts/index?ty=0"><i class="icon-puzzle"></i>Recibos</a>
								</li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(7) || $this->aauth->premission(10) || $this->aauth->premission(42) || $this->aauth->premission(136)){?>
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-list"></i>Outros Documentos</a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(7)) {?>
                                <li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>quote/index?ty=0" data-toggle="dropdown"><i class="icon-call-out"></i><?php echo $this->lang->line('Quotes') ?></a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(10)) {?>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>subscriptions" data-toggle="dropdown"><i class="ft-radio"></i>Avenças</a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(42)) {?>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>purchase/index?ty=0" data-toggle="dropdown"><i class="icon-handbag"></i>Notas de Encomenda</a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(136)) {?>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>quote/index?ty=1"><i class="icon-paper-plane"></i>Faturas pró-Forma</a>
								</li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(13) || $this->aauth->premission(16)) {?>
							<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
										class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
											class="fa fa-barcode"></i>Transporte</a>
								<ul class="dropdown-menu">
									<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>guides/index?ty=1"
														data-toggle="dropdown">Guias de Remessa</a></li>
									  <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>guides/index?ty=2"
														data-toggle="dropdown">Guias de Transporte</a></li>
								</ul>
							</li>
						<?php }?>
						<?php if ($this->aauth->premission(19)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>promo" data-toggle="dropdown"><i
                                        class="icon-trophy"></i><?php echo $this->lang->line('Coupons') ?></a>
                        </li>
						<?php }?>
					</ul>
				</li>
            <?php }
             if ($this->aauth->premission(22) || $this->aauth->premission(25) || $this->aauth->premission(28) || $this->aauth->premission(31) || $this->aauth->premission(32) || $this->aauth->premission(35)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="ft-layers"></i><span><?php echo $this->lang->line('Stock') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(22)) {?>
                        <li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>products" data-toggle="dropdown"><i
                                        class="ft-list"></i> <?php echo $this->lang->line('Items Manager') ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(25)) {?>
                        <li data-menu="">
							<a class="dropdown-item"
                                            href="<?php echo base_url(); ?>productcategory"
                                            data-toggle="dropdown"><i
                                        class="ft-umbrella"></i><?php echo $this->lang->line('Product Categories'); ?>
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(28)) {?>
                        <li data-menu="">
							<a class="dropdown-item"
                                            href="<?php echo base_url(); ?>productcategory/warehouse"
                                            data-toggle="dropdown"><i
                                        class="ft-sliders"></i><?php echo $this->lang->line('Warehouses'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(31)) {?>
                        <li data-menu="">
							<a class="dropdown-item"
                                            href="<?php echo base_url(); ?>products/stock_transfer"
                                            data-toggle="dropdown"><i
                                        class="ft-wind"></i><?php echo $this->lang->line('Stock Transfer'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(32)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>products/classes" data-toggle="dropdown"><i
                                        class="icon-puzzle"></i> <?php echo $this->lang->line('Product Classes') ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(35)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="fa fa-barcode"></i><?php echo $this->lang->line('ProductsLabel'); ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>products/custom_label"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('custom_label'); ?></a></li>
                                  <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>products/standard_label"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('standard_label'); ?></a></li>
                            </ul>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php } 
			if ($this->aauth->premission(36) || $this->aauth->premission(39) || $this->aauth->premission(45) || $this->aauth->premission(48) || $this->aauth->premission(49) || $this->aauth->premission(139)) { ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-diamond"></i><span><?php echo $this->lang->line('CRM') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(36)) {?>
                        <li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>customers" data-toggle="dropdown"><i
                                        class="ft-users"></i><?php echo $this->lang->line('Clients') ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(39)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>clientgroup"><i
                                        class="icon-grid"></i><?php echo $this->lang->line('Client Groups'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(45)) {?>
						<li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>customers_notes/index?ty=1"><i
                                        class="icon-screen-tablet"></i>Notas de Crédito
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(48)) {?>
						<li data-menu="">
							<a class="dropdown-item"
								href="<?php echo base_url(); ?>stockreturn/index?ty=0"
								data-toggle="dropdown"><i class="icon-puzzle"></i> Notas de Devolução</a>
						</li>
						<?php }?>
						<?php if ($this->aauth->premission(139)) {?>
						<li data-menu="">
							<a class="dropdown-item"
								href="<?php echo base_url(); ?>docs_intern/index?ty=0"
								data-toggle="dropdown"><i class="ft-sliders"></i> Documentos Internos</a>
						</li>
						<?php }?>
						<?php if ($this->aauth->premission(49)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="fa fa-ticket"></i><?php echo $this->lang->line('Support Tickets') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>tickets/?filter=unsolved"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('UnSolved') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>tickets"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Manage Tickets'); ?></a>
                                </li>
                            </ul>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php }
			if ($this->aauth->premission(50) || $this->aauth->premission(51) || $this->aauth->premission(54) || $this->aauth->premission(57) || $this->aauth->premission(60) || $this->aauth->premission(122) || $this->aauth->premission(133) || $this->aauth->premission(142)) {?>
				<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-briefcase"></i><span><?php echo $this->lang->line('Suppliers') ?></span></a>
					<ul class="dropdown-menu">
						<?php if ($this->aauth->premission(50)) {?>
                        <li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>supplier" data-toggle="dropdown"><i
                                        class="ft-target"></i><?php echo $this->lang->line('Manage Suppliers') ?></a>
						</li>
						<?php }?>
						<?php if ($this->aauth->premission(51)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>invoices_supli" data-toggle="dropdown"><i
                                        class="icon-basket"></i> <?php echo $this->lang->line('Invoices') ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(54)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>purchase/index?ty=1" data-toggle="dropdown"><i
                                        class="icon-handbag"></i> Notas de Encomenda</a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(57)) {?>
						<li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>supplier_notes/index?ty=c"><i
                                        class="icon-screen-tablet"></i> Notas de Crédito
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(122)) {?>
						<li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>supplier_notes/index?ty=d"><i
                                        class="fa fa-ticket"></i> Notas de Débito
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(60)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>stockreturn/index?ty=1" data-toggle="dropdown"><i
                                        class="icon-puzzle"></i> Notas de Devolução</a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(133)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>receipts/index?ty=1"><i class="icon-grid"></i> Recibos</a>
						</li>
						<?php }?>
						<?php if ($this->aauth->premission(142)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>docs_intern/index?ty=1"><i class="ft-sliders"></i> Documentos Internos</a>
						</li>
						<?php }?>
					</ul>
                </li>
			<?php }
			$runprojead = false;
            if ($this->aauth->premission(61) && $this->aauth->premission(62) || $this->aauth->premission(65)) {
				$runprojead = true;
				?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-briefcase"></i><span><?php echo $this->lang->line('Project') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(61) && $this->aauth->premission(62)) {?>
						<li data-menu="">
							<a class="dropdown-item" href="<?php echo base_url(); ?>projects" data-toggle="dropdown"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Project Management') ?>
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(65)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/todo"><i
                                        class="icon-list"></i><?php echo $this->lang->line('To Do List'); ?></a>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php }
            if ((!$this->aauth->premission(62) && $this->aauth->premission(117)) && !$runprojead || !$runprojead && $this->aauth->premission(61)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-briefcase"></i><span><?php echo $this->lang->line('Project') ?></span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>manager/projects"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Manage Projects'); ?>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>manager/todo"><i
                                        class="icon-list"></i><?php echo $this->lang->line('To Do List'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(68) || $this->aauth->premission(71) || $this->aauth->premission(73) || $this->aauth->premission(76) || $this->aauth->premission(79)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-calculator"></i><span><?php echo $this->lang->line('Accounts') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(68) || $this->aauth->premission(71)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-book-open"></i><?php echo $this->lang->line('Accounts') ?></a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(68) || $this->aauth->premission(71)) {?>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>accounts"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Manage Accounts') ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(71)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>accounts/balancesheet"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Balance Sheet'); ?></a>
                                </li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(73) || $this->aauth->premission(76) || $this->aauth->premission(79)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-wallet"></i><?php echo $this->lang->line('Transactions') ?></a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(76)) {?>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions/categories"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Transaction Categories') ?></a>
                                </li>
								<?php }?>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('View Transactions') ?></a>
                                </li>
								<?php if ($this->aauth->premission(79)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/transfers"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('View Transfers'); ?></a>
                                </li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php }
			if ($this->aauth->premission(80) || $this->aauth->premission(83) || $this->aauth->premission(86) || $this->aauth->premission(89) || $this->aauth->premission(92) || $this->aauth->premission(95)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-note"></i><span><?php echo $this->lang->line('Miscellaneous') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(80)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/notes"><i
                                        class="icon-note"></i><?php echo $this->lang->line('Notes'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(83)) {?>
						<li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>events/events_type"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Events Type'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(86)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>events"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Calendar'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(89)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/documents"><i
                                        class="icon-doc"></i><?php echo $this->lang->line('Documents'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(92) || $this->aauth->premission(95)) { ?>
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
									class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
										class="ft-list"></i> <?php echo $this->lang->line('Assets Manager') ?></a>
							<ul class="dropdown-menu">
								<?php if ($this->aauth->premission(92)) {?>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>assests"
													data-toggle="dropdown"><?php echo $this->lang->line('Manage Assets'); ?></a>
								</li>
								<?php }?>
								<?php if ($this->aauth->premission(95)) {?>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>assests/cats"
													data-toggle="dropdown"><?php echo $this->lang->line('Assets Categories'); ?></a>
								</li>
								<?php }?>
							</ul>
						</li>
						<?php }?>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(98) || $this->aauth->premission(101) || $this->aauth->premission(102) || $this->aauth->premission(103) || $this->aauth->premission(106) || $this->aauth->premission(108) || $this->aauth->premission(109) || $this->aauth->premission(112)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="ft-file-text"></i><span><?php echo $this->lang->line('HRM') ?></span></a>
                    <ul class="dropdown-menu">
						<?php if ($this->aauth->premission(98) || $this->aauth->premission(101) || $this->aauth->premission(102) || $this->aauth->premission(103) || $this->aauth->premission(106) || $this->aauth->premission(108)) {?>
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="ft-users"></i><?php echo $this->lang->line('Employees') ?></a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(98)) {?>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Employees') ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(101)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/permissions"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Permissions'); ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(102)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/salaries"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Salaries'); ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(103)) {?>
								<li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/faults"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Faults'); ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(106)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/attendances"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Attendance'); ?></a>
                                </li>
								<?php }?>
								<?php if ($this->aauth->premission(108)) {?>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/vacations"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Vacations'); ?></a>
                                </li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(109)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/departments"><i
                                        class="icon-folder"></i><?php echo $this->lang->line('Departments'); ?></a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(112)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/payroll"><i
                                        class="icon-notebook"></i><?php echo $this->lang->line('Payroll'); ?></a>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(114)|| $this->aauth->premission(115) || $this->aauth->premission(116) || $this->aauth->premission(117) || $this->aauth->premission(72)) {?>
				<li class="dropdown mega-dropdown nav-item" data-menu="megamenu"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i
                                class="ft-bar-chart-2"></i><span><?php echo $this->lang->line('Data & Reports') ?></span></a>
                    <ul class="mega-dropdown-menu dropdown-menu row">
						<?php if ($this->aauth->premission(114)) {?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>register"><i
                                        class="icon-eyeglasses"></i> Caixa POS
                            </a>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(115) || $this->aauth->premission(72)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-doc"></i><?php echo $this->lang->line('Statements') ?></a>
                            <ul class="dropdown-menu">
								<?php if ($this->aauth->premission(72)) {?>
									<li data-menu=""><a class="dropdown-item"
														href="<?php echo base_url(); ?>reports/accountstatement"
														data-toggle="dropdown"><?php echo $this->lang->line('Account Statements'); ?></a>
									</li>
									<li data-menu=""><a class="dropdown-item"
														href="<?php echo base_url(); ?>reports/customerstatement"
														data-toggle="dropdown"><?php echo $this->lang->line('Customer_Account_Statements')  ?></a>
									</li>
									<li data-menu=""><a class="dropdown-item"
														href="<?php echo base_url(); ?>reports/supplierstatement"
														data-toggle="dropdown"><?php echo $this->lang->line('Supplier_Account_Statements') ?></a>
									</li>
									<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>pos_invoices/extended"
                                                          data-toggle="dropdown"><?php echo $this->lang->line('ProductSales'); ?></a></li>
								<?php }?>
                                <?php if ($this->aauth->premission(115)) {?>
									<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reports/taxstatement"
														data-toggle="dropdown"><?php echo $this->lang->line('TAX_Statements'); ?></a>
									</li>
								<?php }?>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(116)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-bar-chart"></i><?php echo $this->lang->line('Graphical Reports') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/product_cat"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Product Categories'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/trending_products"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Trending Products'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/profit"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Profit'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/topcustomers"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Top_Customers') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/incvsexp"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('income_vs_expenses') ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/income"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/expenses"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Expenses'); ?></a>

								</li>
                            </ul>
                        </li>
						<?php }?>
						<?php if ($this->aauth->premission(117)) {?>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-bulb"></i><?php echo $this->lang->line('Summary_Report') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/statistics"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Statistics') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/profitstatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Profit'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/incomestatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Calculate Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/expensestatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reports/sales"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Sales') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/products"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Products') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/commission"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Employee_Commission'); ?></a>
                                </li>

                            </ul>
                        </li>
						<?php }?>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(118)) {?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i
                                class="icon-pie-chart"></i><span><?php echo $this->lang->line('Export_Import') ?></span></a>
                    <ul class="mega-dropdown-menu dropdown-menu row">
                       <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
							<a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-bulb"></i><?php echo $this->lang->line('Export') ?></a>
                            <ul class="dropdown-menu">
                               <li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>export/crm"><i class="fa fa-caret-right"></i><?php echo $this->lang->line('Export People Data'); ?></a>
								</li>
								<li data-menu=""><a class="dropdown-item"
									   href="<?php echo base_url(); ?>export/transactions"><i
												class="fa fa-caret-right"></i><?php echo $this->lang->line('Export Transactions'); ?>
								</a></li>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>export/products"><i
												class="fa fa-caret-right"></i><?php echo $this->lang->line('Export Products'); ?>
								</a></li>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>export/account"><i
												class="fa fa-caret-right"></i><?php echo $this->lang->line('Account Statements'); ?>
								</a></li>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>export/people_products"><i 
											class="fa fa-caret-right"></i> <?php echo $this->lang->line('ProductsAccount Statements'); ?>
								</a></li>
								<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>export/taxstatement"><i 
											class="fa fa-caret-right"></i> <?php echo $this->lang->line('Tax_Export') ?>
								</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-bulb"></i><?php echo $this->lang->line('Import') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>import/products"><i class="fa fa-caret-right"></i></i><?php echo $this->lang->line('Import Products'); ?></a>
								</li>
								<li data-menu="">
									<a class="dropdown-item" href="<?php echo base_url(); ?>import/customers"><i class="fa fa-caret-right"></i><?php echo $this->lang->line('Import Customers'); ?></a>
								</li>
                            </ul>
                        </li>

                    </ul>
                </li>
			<?php }
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(119)) {?>
                <li class="dropdown mega-dropdown nav-item" data-menu="megamenu"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i
                                class="icon-pie-chart"></i><span><?php echo $this->lang->line('Other Options') ?></span></a>
                    <ul class="mega-dropdown-menu dropdown-menu row">
						<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
								class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
									class="fa fa-caret-right"></i><?php echo $this->lang->line('Saft Export') ?></a>
							<ul class="dropdown-menu">
								<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
										class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
											class="fa fa-caret-right"></i>Comunicação automática</a>
									<ul class="dropdown-menu">
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>settings/company?id=4" data-toggle="dropdown">Configuração da Ligação</a>
										</li>
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>saft/pendentes" data-toggle="dropdown">Listagem de pendentes</a>
										</li>
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>saft/sucesso" data-toggle="dropdown">Listagem de Envios com Sucesso</a>
										</li>
									</ul>
								</li>
								<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
										class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
											class="fa fa-caret-right"></i>Outras Configurações</a>
									<ul class="dropdown-menu">
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>settings/company?id=5" data-toggle="dropdown">Configuração do IVA de Caixa</a>
										</li>
									</ul>
								</li>
								<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
										class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
											class="fa fa-caret-right"></i>Exportações</a>
									<ul class="dropdown-menu">
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>saft/atconfigs?id=1" data-toggle="dropdown">Ficheiro SAF-T(PT)</a>
										</li>
										<li data-menu="">
											<a class="dropdown-item" href="<?php echo base_url(); ?>saft/atconfigs?id=2" data-toggle="dropdown">Inventário de existências</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>export/dbexport" data-toggle="dropdown"><?php echo $this->lang->line('Database Backup') ?></a></li>
					</ul>
                </li>
			<?php }?>
        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>

<!-- Horizontal navigation-->
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">