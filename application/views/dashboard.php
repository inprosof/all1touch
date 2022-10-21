<script type="text/javascript">
    var dataVisits = [
        <?php $tt_inc = 0;foreach ($incomechart as $row) {
        $tt_inc += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>
    ];
    var dataVisits2 = [
        <?php $tt_exp = 0; foreach ($expensechart as $row) {
        $tt_exp += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . "},";
    }
        ?>];

</script>

<style type="text/css">
	
	#items td.description div, #items td.item-name div {
		width: 100%;
	}
	
	#items {
		clear: both;
		width: 100%;
		margin: 0px 0 0 0;
		border:none;
	}
	
	#table2 {
		border-collapse: collapse;
	}

	#table2 td, #table2 th {
		border: 1px solid griz;
		padding: 1px;
	}
	
	#items td.total-inov {
		border-right: 0;
		border-left: 0;
		border-top: 0;
		padding: 10px;
		text-align: left;
		font-size: 16px;
	}

	#items th {
		background: #eee;
	}

	#items tr.item-row td {
		border: #ccc 1px solid;
		vertical-align: top;
	}
</style>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-primary white media-body">
                        <h5><?php echo $this->lang->line('today_invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> <?php echo $todayin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-notebook font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                        <h5><?php echo $this->lang->line('this_month_invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?php echo $monthin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                        <h5><?php echo $this->lang->line('today_sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i><?php echo amountExchange($todaysales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-success white media-body">
                        <h5><?php echo $this->lang->line('this_month_sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i> <?php echo amountExchange($monthsales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height" <?php if(count($recent_buy) == 0 || $get_all_info_done['n_grafics'] == 0) echo 'style="display:none"'?>>
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('in_last _30') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="products-sales" class="height-300"></div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="primary"><?php echo amountExchange($todayinexp['credit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today_income') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="danger"><?php echo amountExchange($todayinexp['debit'], 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today_expenses') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="success"><?php echo amountExchange($todayprofit, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('today_profit') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="warning"><?php echo amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) ?></h3>
                                            <span><?php echo $this->lang->line('revenue') ?></span>
                                        </div>

                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 35%"
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="header-block">
                    <h4 class="title">
                        <?php echo $this->lang->line('income_vs_expenses') ?>
                    </h4></div>
            </div>
            <div class="card-body">
                <div id="salesbreakdown" class="card mt-2"
                     data-exclude="xs,sm,lg">
                    <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart"></div>

                </div>
                <br>
            </div>
        </div>
    </div>
</div>


<div class="row match-height">
    <div class="col-xl-4 col-lg-12">
        <div class="card match-height" role="tablist" aria-multiselectable="true">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-arrow-right deep-orange"></i> Configuração</h4><h3 class="primary">
            </div>
            <div class="card-content" role="tab" data-parent="#accordionWrap" href="#accordion1" aria-controls="accordion1">
				<div class="card-header p-0 pb-1 border-0 mt-1" id="heading1" role="tab">
					<?php 
						$erros="";
						$percenta = 100;
						
						if($get_all_info_done['n_cae'] == '0')
						{
							$percenta -= 20;
							$erros .= ' - Adicione pelo menos 1 C.A.E da sua Empresa! <a class="match-width match-height"
								   href="'.base_url().'settings/caes"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						if($get_all_info_done['n_series'] == '0')
						{
							$percenta -= 10;
							$erros .= ' - Adicione pelos menos uma série! Para usar nos seus documentos! <a class="match-width match-height"
								   href="'.base_url().'settings/series"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						if($get_all_info_done['n_accounts'] == '0')
						{
							$percenta -= 20;
							$erros .= ' - Adicione pelo menos uma conta ao seu negócio! <a class="match-width match-height" 
										href="'.base_url().'accounts"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer.
										</a><br>';
						}
						
						if($get_all_info_done['n_warehouse'] == '0')
						{
							$percenta -= 10;
							$erros .= ' - Adicione pelo menos 1 Armazém! <a class="match-width match-height"
								   href="'.base_url().'productcategory/warehouse"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						if($this->aauth->get_user()->loc == 0){
							if($get_all_info_done['n_emp_email'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Email nas informações da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_nif'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo NIF nas informações da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_logo'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Logótipo nas informações da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_phone'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Telefone nas informações da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emailo_remet'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um Nome do Remetente para Notificações da Aplicação aos Clientes! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=6"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_email_app'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um email para Notificações da Aplicação aos Clientes! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=6"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_email_stock'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um email para Notificações da Aplicação Relativo ao Stock! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=7"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_armazem'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Armazém por Defeito da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_conta_d'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para os Documentos da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_conta_o'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para as Vendas Online da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_conta_f'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para os Documentos de Fornecedores da Empresa! <a class="match-width match-height"
									   href="'.base_url().'settings/company?id=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
						}else{
							if($get_all_info_done['n_emp_email'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Email da sua localização para as informações correspondentes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_nif'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo NIF da sua localização para as informações correspondentes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_logo'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Logótipo da sua localização para as informações correspondentes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_phone'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Telefone da sua localização para as informações correspondentes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=1"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emailo_remet'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um Nome do Remetente para Notificações da Aplicação aos Clientes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=6"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_email_app'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um email para Notificações da Aplicação aos Clientes! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=6"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_email_stock'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Adicione um email para Notificações da Aplicação Relativo ao Stock! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=7"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_armazem'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Altere o Campo Armazém por Defeito na localização! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							if($get_all_info_done['n_emp_conta_d'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para os Documentos na localização! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_conta_o'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para as Vendas Online na localização! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
							if($get_all_info_done['n_emp_conta_f'] == '0')
							{
								$percenta -= 2;
								$erros .= ' - Insira uma Conta para os Documentos de Fornecedores na localização! <a class="match-width match-height"
									   href="'.base_url().'locations?id='.$this->aauth->get_user()->loc.'&param=77"><i
												class="ft-chevron-right">Click aqui para o Fazer.</i> 
									</a><br>';
							}
							
						}
						
						if($get_all_info_done['n_emp_registration'] == '0')
						{
							$percenta -= 5;
							$erros .= ' - Altere o Campo Matrícula Comercial nas informações do negócio! <a class="match-width match-height"
								   href="'.base_url().'settings/company"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						if($get_all_info_done['n_emp_conservator'] == '0')
						{
							$percenta -= 5;
							$erros .= ' - Altere o Campo Registo da Conservatórtia nas informações do negócio! <a class="match-width match-height"
								   href="'.base_url().'settings/company"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						if($get_all_info_done['n_email_host'] == '0')
						{
							$percenta -= 4;
							$erros .= ' - Altere o Campo Host para Configurar o Servidor de Email! <a class="match-width match-height"
								   href="'.base_url().'settings/email"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						if($get_all_info_done['n_email_username'] == '0')
						{
							$percenta -= 2;
							$erros .= ' - Altere o Campo Utilizador para Configurar o Servidor de Email! <a class="match-width match-height"
								   href="'.base_url().'settings/email"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						if($get_all_info_done['n_email_password'] == '0')
						{
							$percenta -= 2;
							$erros .= ' - Altere o Campo Senha para Configurar o Servidor de Email! <a class="match-width match-height"
								   href="'.base_url().'settings/email"><i
											class="ft-chevron-right">Click aqui para o Fazer.</i> 
								</a><br>';
						}
						
						
						if($erros != "")
						{
							echo '<div id="notify" class="alert alert-warning">
									<a href="#" class="close" data-dismiss="alert"></a>
									<div class="message"><strong>Dados em Falta</strong>: <br>'.$erros.'</div>
								</div>';
						}
					?>
					<h6 class="blue">A sua conta está <?php $ipt = sprintf("%0.0f", ($percenta * 100) / 100); ?><?php echo ' ' . $ipt . '%' ?> preenchida com a informação necessária e obrigatória.
										<?php if($percenta != 100)
										{
											echo 'Para a sua conta ficar perfeita e pronta a trabalhar, Por favor remova todos os erros anteriores.';
											
										}?>
					</h6>
                </div>
            </div>
        </div>
    </div>		
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-arrow-right deep-orange"></i> Uso da Conta</h4>
            </div>
            <div class="card-content">
				<table id="items" class="table2">
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-top: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>pos_invoices"><i
											class="ft-chevron-right"></i>POS Faturas
								</a></td>
						<td style="border-right: 0; border-top: 0; border-left: 0;"><?php echo $tot_pos_invoice?></td>
					</tr>
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-top: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>invoices"><i
											class="ft-chevron-right"></i>Faturas
								</a></td>
						<td style="border-right: 0; border-top: 0; border-left: 0;"><?php echo $tot_invoice?></td>
					</tr>
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-bottom: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>products"><i
											class="ft-chevron-right"></i>Artigos
								</a></td>
						<td style="border-right: 0; border-bottom: 0; border-left: 0;"><?php echo $tot_artigos?></td>
					</tr>
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-bottom: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>supplier"><i
											class="ft-chevron-right"></i>Fornecedores
								</a></td>
						<td style="border-right: 0; border-bottom: 0; border-left: 0;"><?php echo $tot_supliers?></td>
					</tr>
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-bottom: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>employee"><i
											class="ft-chevron-right"></i>Funcionários
								</a></td>
						<td style="border-right: 0; border-bottom: 0; border-left: 0;"><?php echo $tot_employees?></td>
					</tr>
					<tr class="item-row">
						<td class="total-inov" style="border-right: 0; border-left: 0; border-bottom: 0;"><a class="match-width match-height"
								   href="<?php echo base_url(); ?>projects"><i
											class="ft-chevron-right"></i>Projectos
								</a></td>
						<td style="border-right: 0; border-bottom: 0; border-left: 0;"><?php echo $tot_projects?></td>
					</tr>
				</table>
            </div>
        </div>
    </div>
	<div class="col-xl-4 col-lg-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title"><i class="icon-arrow-right deep-orange"></i> Ligação AT</h4>
            </div>
            <div class="card-content">
				<ul>
					<h5><strong>Documentos de Venda</strong></h5>
					<?php 
					if($get_ativ_saft['data_saft_docs'] == '0' || $get_ativ_saft['data_saft_docs'] == 0)
					{
						if($this->aauth->get_user()->loc == 0){
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'settings/company?id=4"><i class="ft-chevron-right"></i>Ativar </a>';
						}else{
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=4"><i class="ft-chevron-right"></i>Ativar </a>';
						}
					}else{
						echo "<li>Ligação ativa: Sim (Desde ".$get_ativ_saft['data_saft_docs'].")";
					}
					?></li>
					<h5><strong>Documentos de Transporte</strong></h5>
					<?php 
					
					if($get_ativ_saft['data_saft_transporte'] == '0' || $get_ativ_saft['data_saft_transporte'] == 0)
					{
						if($this->aauth->get_user()->loc == 0){
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'settings/company?id=4"><i class="ft-chevron-right"></i>Ativar </a>';
						}else{
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=4"><i class="ft-chevron-right"></i>Ativar </a>';
						}
					}else{
						echo "<li>Ligação ativa: Sim (Desde ".$get_ativ_saft['data_saft_transporte'].")";
					}
					?></li>
					<h5><strong>Iva Caixa</strong></h5>
					<?php 
					if($get_caixa_activ['data_activ_caixa_iva'] == '0' || $get_caixa_activ['data_activ_caixa_iva'] == 0)
					{
						if($this->aauth->get_user()->loc == 0){
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'settings/company?id=44"><i class="ft-chevron-right"></i>Ativar </a>';
						}else{
							echo '<li>Ligação ativa: Não <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=44"><i class="ft-chevron-right"></i>Ativar </a>';
						}
						
					}else{
						echo "<li>Ligação ativa: Sim (Desde ".$get_caixa_activ['data_activ_caixa_iva'].")";
					}
					?></li>
					<h5><strong>Ligações de Interesse</strong></h5>
					<li><a class="match-width match-height" href="<?php echo base_url(); ?>saft/atconfigs?id=1">
						<i class="ft-chevron-right"></i>Exportar SAF-T(PT)
					</a></li>
					<li><a class="match-width match-height" href="<?php echo base_url(); ?>saft/atconfigs?id=2">
						<i class="ft-chevron-right"></i>Exportar Inventário Existências
					</a></li>
					<li><a class="match-width match-height" href="<?php echo base_url(); ?>reports/accountstatement">
						<i class="ft-chevron-right"></i>Extratos de Contas
					</a></li>
					<li><a class="match-width match-height" href="<?php echo base_url(); ?>reports/statistics">
						<i class="ft-chevron-right"></i>Estatísticas
					</a></li>
					<li><a class="match-width match-height" href="<?php echo base_url(); ?>reports/commission">
						<i class="ft-chevron-right"></i>Comissões de Vendas
					</a></li>
				</ul>
            </div>
        </div>
    </div>
</div>

<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent_invoices') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <p><span class="float-right"> <a
                                    href="<?php echo base_url() ?>invoices/create"
                                    class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Add Sale') ?></a>
                                <a
                                        href="<?php echo base_url() ?>invoices"
                                        class="btn btn-success btn-sm rounded"><?php echo $this->lang->line('Manage Invoices') ?></a>
                                <a
                                        href="<?php echo base_url() ?>pos_invoices"
                                        class="btn btn-blue btn-sm rounded"><?php echo $this->lang->line('POS') ?></a></span>
                    </p>
                </div>
            </div>
            <div class="card-content">

                <div class="table-responsive">
                    <table id="recent-orders" class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Invoices') ?></th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                            <th><?php echo $this->lang->line('Due') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent as $item) {
                            $page = 'subscriptions';
                            $t = 'Sub ';
                            if ($item['i_class'] == 0) {
                                $page = 'invoices';
                                $t = '';
                            } elseif ($item['i_class'] == 1) {
                                $page = 'pos_invoices';
                                $t = 'POS ';
                            }
                            echo '    <tr>
                                <td class="text-truncate"><a href="' . base_url() . $page . '/view?id=' . $item['id'] . '">'.$item['type'] .' '. $item['serie_name'].'/'.$item['tid'] . '</a></td> 
                                <td class="text-truncate"> ' . $item['name'] . '</td>
                                <td class="text-truncate"><span class="badge  st-' . $item['status'] . ' st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td><td class="text-truncate">' . dateformat($item['invoicedate']) . '</td>
                                <td class="text-truncate">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</td>
                            </tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
		<div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('Recent Buyers') ?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content px-1">
                <div id="recent-buyers" class="media-list height-450  mt-1 position-relative">
                    <?php
                    if (isset($recent_buy[0]['csd'])) {
                        foreach ($recent_buy as $item) {
                            echo '       <a href="' . base_url('customers/view?id=' . $item['csd']) . '" class="media border-0">
                        <div class="media-left pr-1">
                            <span class="avatar avatar-md avatar-online"><img class="media-object rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $item['picture'] . '">
                            <i></i>
                            </span>
                        </div>
                        <div class="media-body w-100">
                            <h6 class="list-group-item-heading">' . $item['name'] . ' <span class="font-medium-4 float-right pt-1">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</span></h6>
                            <p class="list-group-item-text mb-0"><span class="badge  st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></p>
                        </div>
                    </a>';

                        }
                    } elseif ($recent_buy == 'sql') {
                        echo ' <div class="media-body w-100">  <h5 class="list-group-item-heading bg-danger white">Critical SQL Strict Mode Error: </h5>Please Disable Strict SQL Mode for in database  settings.</div>';
                    }

                    ?>


                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-group">
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="primary"><?php $ipt = sprintf("%0.0f", ($tt_inc * 100) / $goals['income']); ?><?php echo ' ' . $ipt . '%' ?></h3><?php echo '<span class=" font-medium-1 display-block">' . $this->lang->line($this->lang->line(date('F'))) . ' ' . $this->lang->line('income') . '</span>'; ?>
                                <span class="font-medium-1"><?php echo amountExchange($tt_inc, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['income'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="fa fa-money primary font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="red"><?php $ipt = sprintf("%0.0f", ($tt_exp * 100) / $goals['expense']); ?><?php echo ' ' . $ipt . '%' ?></h3><?php echo '<span class="font-medium-1 display-block">' . $this->lang->line(date('F')) . ' ' . $this->lang->line('expenses') . '</span>'; ?>
                                <span class="font-medium-1"><?php echo amountExchange($tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['expense'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-external-link red font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="blue"><?php $ipt = sprintf("%0.0f", ($monthsales * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?php echo '<span class="font-medium-1 display-block">' . $this->lang->line(date('F')) . ' ' . $this->lang->line('sales') . '</span>'; ?>
                                <span class="font-medium-1"><?php echo amountExchange($monthsales, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['sales'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-flag blue font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-blue" role="progressbar" style="width: <?php echo $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">

                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="purple"><?php $ipt = sprintf("%0.0f", (($tt_inc - $tt_exp) * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?php echo '<span class="font-medium-1 display-block">' . $this->lang->line(date('F')) . ' ' . $this->lang->line('net_income') . '</span>'; ?>
                                <span class="font-medium-1"><?php echo amountExchange($tt_inc - $tt_exp, 0, $this->aauth->get_user()->loc) . '/' . amountExchange($goals['netincome'], 0, $this->aauth->get_user()->loc) ?></span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="ft-inbox purple font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo $ipt ?>%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-7 col-lg-12">
        <div class="card" id="transactions">

            <div class="card-body">
                <h4><?php echo $this->lang->line('cashflow') ?></h4>
                <p><?php echo $this->lang->line('graphical_presentation') ?></p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                           href="#sales"
                           aria-expanded="true"><?php echo $this->lang->line('income') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                           href="#transactions1"
                           aria-expanded="false"><?php echo $this->lang->line('expenses') ?></a>
                    </li>


                </ul>
                <div class="tab-content pt-1">
                    <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true"
                         data-toggle="tab">
                        <div id="dashboard-income-chart"></div>

                    </div>
                    <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                        <div id="dashboard-expense-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('task_manager') . ' ' ?> <a
                            href="<?php echo base_url() ?>tools/todo"><i
                                class="icon-arrow-right deep-orange"></i></a></h4>
            </div>

            <div class="card-content">
                <div id="daily-activity">
                    <table class="table table-striped table-bordered base-style table-responsive" >
                        <thead>
                        <tr>
                            <th>

                            </th>

                            <th><?php echo $this->lang->line('Tasks') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $t = 0;
                        foreach ($tasks as $row) {
                            $name = '<a class="check text-default" data-id="' . $row['id'] . '" data-stat="' . $row['status'] . '"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $row['id'] . '" class="view_task" data-stat="' . $row['status'] . '"></a>';
                            echo ' <tr>
                                <td class="text-truncate">
                                   ' . $name . '
                                </td>
                            
                                <td class="text-truncate">' . $row['name'] . '</td>
                                <td class="text-truncate"><span id="st' . $t . '" class="badge badge-default task_' . $row['status'] . '">' . $row['status'] . '</span></td>
                            </tr>';
                            $t++;
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                            href="<?php echo base_url() ?>transactions"
                            class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
                </h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent_payments as $item) {

                            echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $item['id'] . '">' . dateformat($item['date']) . '</a></td>
                                <td class="text-truncate"> ' . $item['account'] . '</td>
                                <td class="text-truncate">' . amountExchange($item['debit'], 0, $this->aauth->get_user()->loc) . '</td>
                                <td class="text-truncate">' . amountExchange($item['credit'], 0, $this->aauth->get_user()->loc) . '</td>                    
                                <td class="text-truncate">' . $item['methodname'] . '</td>
                            </tr>';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header ">
                <h4 class="card-title"><?php echo $this->lang->line('Stock Alert') ?></h4>

            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">

                    <?php

                    foreach ($stock as $item) {
                        echo '<li class="list-group-item"><span class="badge badge-danger float-xs-right">' . +$item['qty'] . ' ' . $item['unit'] . '</span> <a href="' . base_url() . 'products/edit?id=' . $item['pid'] . '">' . $item['product_name'] . '  </a><small class="purple"> <i class="ft-map-pin"></i> ' . $item['title'] . '</small>
                                </li>';
                    } ?>

                </ul>

            </div>
        </div>
    </div>
</div>
<div id="task_model" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-body">
				<form id="form_model">


					<div class="row">
						<div class="col mb-1" id="description">

						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
										id="priority"></span></strong>

						</div>
					</div>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Assigned to') ?> <strong><span
										id="employee"></span></strong>

						</div>
					</div>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Assigned by') ?> <strong><span
										id="assign"></span></strong>

						</div>
					</div>

					<div class="modal-footer">
						<input type="hidden" class="form-control required"
							   name="tid" id="taskid" value="">
						<button type="button" class="btn btn-default"
								data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(window).on("load", function () {
        $('#recent-buyers').perfectScrollbar({
            wheelPropagation: true
        });
        /********************************************
         *               PRODUCTS SALES              *
         ********************************************/
        var sales_data = [
            <?php foreach ($countmonthlychart as $row) {
            echo "{ y: '" . $row['date'] . "', sales: " . intval(amountExchange_s($row['total'], 0, $this->aauth->get_user()->loc)) . ", invoices: " . intval($row['ttlid']) . "},";
        } ?>
        ];
        var months = ["<?=lang('Jan') ?>", "<?=lang('Feb') ?>", "<?=lang('Mar') ?>", "<?=lang('Apr') ?>", "<?=lang('May') ?>", "<?=lang('Jun') ?>", "<?=lang('Jul') ?>", "<?=lang('Aug') ?>", "<?=lang('Sep') ?>", "<?=lang('Oct') ?>", "<?=lang('Nov') ?>", "<?=lang('Dec') ?>"];
        Morris.Area({
            element: 'products-sales',
            data: sales_data,
            xkey: 'y',
            ykeys: ['sales', 'invoices'],
            labels: ['sales', 'invoices'],
            behaveLikeLine: true,
            xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                var day = x.getDate();
                var month = months[x.getMonth()];
                return day + ' ' + month;
            },
            resize: true,
            pointSize: 0,
            pointStrokeColors: ['#00B5B8', '#FA8E57', '#F25E75'],
            smooth: true,
            gridLineColor: '#E4E7ED',
            numLines: 6,
            gridtextSize: 14,
            lineWidth: 0,
            fillOpacity: 0.9,
            hideHover: 'auto',
            lineColors: ['#00B5B8', '#F25E75']
        });


    });
</script>
<script type="text/javascript">
    function drawIncomeChart(dataVisits) {
        $('#dashboard-income-chart').empty();
        Morris.Area({
            element: 'dashboard-income-chart',
            data: dataVisits,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#00A5A8',
            ],
            pointFillColors: [
                '#00A5A8',
            ],
            fillOpacity: 0.4,
        });
    }

    function drawExpenseChart(dataVisits2) {

        $('#dashboard-expense-chart').empty();
        Morris.Area({
            element: 'dashboard-expense-chart',
            data: dataVisits2,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 0',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#ff6e40',
            ],
            pointFillColors: [
                '#34cea7',
            ]
        });
    }

    drawIncomeChart(dataVisits);
    drawExpenseChart(dataVisits2);
    $('#dashboard-sales-breakdown-chart').empty();
    Morris.Donut({
        element: 'dashboard-sales-breakdown-chart',
        data: [{
            label: "<?php echo $this->lang->line('Income') ?>",
            value: <?php echo intval(amountExchange_s($tt_inc, 0, $this->aauth->get_user()->loc)); ?> },
            {
                label: "<?php echo $this->lang->line('Expenses') ?>",
                value: <?php echo intval(amountExchange_s($tt_exp, 0, $this->aauth->get_user()->loc)); ?> }
        ],
        resize: true,
        colors: ['#34cea7', '#ff6e40'],
        gridTextSize: 6,
        gridTextWeight: 400
    });
    $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
        window.dispatchEvent(new Event('resize'));
    });
</script>