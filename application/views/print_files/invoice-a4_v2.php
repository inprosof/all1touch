<!doctype html>
<html>
<head>
    <title><?php echo $invoice['irs_type_n'].' '.$invoice['tid'] ?></title>

    <style type="text/css">

        body {
            font: 12px/1.4 Georgia, serif;
        }
		
		.back-form{
			background-image: url(<?php echo FCPATH.$ImageBackGround; ?>);
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
        div {
            border: 0;
            font: 13px Georgia, Serif;
            overflow: hidden;
            resize: none;
        }

        table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
            padding: 5px;
        }

        #header {
            height: 15px;
            width: 100%;
            margin: 5px 0;
            background: #222;
            color: white;
            font: bold 15px Helvetica, Sans-Serif;
            text-decoration: uppercase;
            letter-spacing: 10px;
            padding: 8px 0px;
        }


        #meta {
            margin-top: 1px;
            width: 300px;
            float: right;
        }

        #meta td {
            text-align: right;
        }
		
		#meta td.item-meto {
            width: 150;
        }

        #meta td.meta-head {
            text-align: left;
            background: #eee;
        }

        #meta td div {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
			border:none;
        }

        #items th {
            background: #eee;
        }

        #items div {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            border: #ccc 0px solid;
            vertical-align: top;
        }

        #items td.description {
            width: 270px;
        }

        #items td.item-name {
            width: 175px;
        }
		
		#items td.item-val {
			text-align: right;
            width: 80;
        }
		
		#items td.item-qtd {
            width: 60;
        }
		
		#items td.item-tax {
            width: 70;
        }
		
		#items td.item-disc {
            width: 60;
        }

        #items td.description div, #items td.item-name div {
            width: 100%;
        }

        #items td.total-line {
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            text-align: right;
        }

        #items td.total-value {
            border-right: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 10px;
			text-align: right;
			font-size: 22px;
        }
		
		#items td.total-impost {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 10px;
			text-align: right;
			font-size: 18px;
        }
		
		#items td.total-impost2 {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 10px;
			text-align: right;
			font-size: 14px;
        }
		

        #items td.total-value div {
            height: 10px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: left;
            margin: 20px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px Helvetica, Sans-Serif;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms div {
            width: 100%;
            text-align: center;
        }

        .top_logo {
            max-height: 180px;
            max-width: 250px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>

        }

        .company {
            width: 200px;
			height: 50px;
        }
		
		.companyrest {
            width: 100%;
        }
		
		.companyrest1 {
            width: 60%;
        }
		
		.companyrest2 {
            width: 40%;
        }
		
		.companyrest3 {
            width: 160pt;
        }
		
		.header {
			width: 100%;
            height: 50px;
        }
		
		

        .header_table td {
            width: 100%;
			height: 50px;
			border: none;
			padding: 5px;
			content: "";
			clear: both;
        }
		
		#clearfix {
			width: 100%;
			height: 50px;
			border: 1px solid #4CAF50;
			padding: 5px;
			content: "";
			clear: both;
			display: table;
			}

        .blueTable {
		  width: 100%;
		  text-align: left;
		  border: none;
		  border-collapse: collapse;
		}
		.blueTable td, .blueTable th {
			border: none;
			padding: 3px 2px;
		}
		.blueTable tbody td {
		  font-size: 13px;
		}
    </style>


</head>

<body dir="<?php echo LTR ?>">
<div class="app-content content container-fluid back-form">
	<table class="blueTable">
		<tbody>
			<tr>
				<th style="width: 50%; text-align: left;">
					<img style="max-height:80px;" id="image" src="<?php 
					$loc = location(0);
					echo base_url('userfiles/company/' . $loc['logo']) ?>" alt="logo" class="top_logo"/>
				</th>
				<th style="width: 50%; text-align: right;">
					<?php 
						//$this->pheight = $this->pheight + 50;
						if (@$qrc and $invoice['status'] != 'paid') { ?>
							
					<?php } else {
						
					} ?>
					
					<div class="col-sm-6">
						<h3><br><?php echo $invoice['irs_type_n'].' ('.$Tipodoc.')'; ?><br></h3>
						<img style="max-height:80px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'>
					</div>
					
					
					<?php if (@$qrc AND $invoice['status'] != 'paid') {
							
						?>
					<?php } else {
						
					} ?>
				</th>
			</tr>
			<tr>
				<td rowspan="1" style="width:150px">
					<?php 
					$loc = location($invoice['loc']);
					$loc2 = location(0);
					echo '<strong>' . $loc['cname']; ?></strong><br>
					<?php echo
						$loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email']. '<br> ' . $this->lang->line('conservator') . ': ' . $loc2['conservator']. '<br> ' . $this->lang->line('registration') . ': ' . $loc2['registration']. '<br> ' . $this->lang->line('share_capital') . ': ' . $loc2['share_capital'];
					if ($loc['taxid']) echo '<br>' . $this->lang->line('TAX ID') .': '. $loc['taxid'];
					?>
					<hr>
					<strong><?php echo $invoice['termtit']?></strong><br><h6><?php echo $invoice['terms']?></h6>
					<?php if ($invoice['notes'])
						echo '<br>'.$this->lang->line('Note') . ': <br><h6>' . $invoice['notes'] . '</h6>'; 
					?>
				</td>
				<td>
					<table class="blueTable">
						<tbody>
							<tr>
								<th style="width: 200px;">__________________Nº do documento</strong></th>
								<th style="width: 140px;">________Data de Emissão</th>
								<th style="width: 50px;">_____________Moeda</th>
							</tr>
							<tr>
								<td rowspan="1"><?php
									echo $invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid']; ?>
								</td>
								<td><?php echo $invoice['invoicedate'] ?></td>
								<td><?php echo currency($this->aauth->get_user()->loc) ?></td>
							</tr>
							<tr>
									<?php if ($invoice['invoiceduedate']) { ?>
										<th>_______________Data de Vencimento</th>
									<?php } ?>
									<?php if ($invoice['refer']) { ?>
										<th>_________________<?php echo $this->lang->line('Reference') ?></th>
									<?php } ?>
									<?php if ($invoice['ref_enc_orc']) { ?>
										<th>___________Enc./Orç.</th>
									<?php } ?>
							</tr>
							<tr>
								<?php if ($invoice['invoiceduedate']) { ?>
									<td rowspan="1"><?php echo $invoice['invoiceduedate']; ?></td>
								<?php } ?>
								<?php if ($invoice['refer']) { ?>
									<td><?php echo $invoice['refer']; ?></td>
								<?php } ?>
								<?php if ($invoice['ref_enc_orc']) { ?>
									<td><?php echo $invoice['ref_enc_orc']; ?></td>
								<?php } ?>
							</tr>
							
							<tr>
									<th>______________________________<?php echo $general['person'] ?></th>
									<th>________________________NIF</th>
									<?php if ($invoice['propdue_name']) { ?>
										<th>_____________Prazo</th>
									<?php } ?>
							</tr>
							
							<tr>
								<td rowspan="1"><?php echo $invoice['name'] ?></td>
								<td><?php echo $invoice['taxid'] ?></td>
								<?php if ($invoice['propdue_name']) { ?>
									<td><?php echo $invoice['propdue_name']; ?></td>
								<?php } ?>
							</tr>
							
							<tr>
								<td colspan="1"><strong>_______________________End.Cliente</strong><br />
									
									<?php if ($invoice['company']) 
											echo $invoice['company'] . '<br>';
										echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'];
										if ($invoice['country']) 
											echo '<br>' . $invoice['country'];
										if ($invoice['postbox'])
											echo ' - ' . $invoice['postbox'];
										if ($invoice['phone']) 
											echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'];
										if ($invoice['email']) 
											echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email'];
										if (is_array($c_custom_fields)) {
											echo '<br>';
											foreach ($c_custom_fields as $row) {
												echo $row['name'] . ': ' . $row['data'] . '<br>';
											}
										}
										echo '<br><br>';
										?>
								</td>
								<td colspan="2"><strong>____________________________End. Entrega</strong><br />
									
									<?php if ($invoice['company']) 
											echo $invoice['company'] . '<br>';
										echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'];
										if ($invoice['country']) 
											echo '<br>' . $invoice['country'];
										if ($invoice['postbox'])
											echo ' - ' . $invoice['postbox'];
										if ($invoice['phone']) 
											echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'];
										if ($invoice['email']) 
											echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email'];
										if (is_array($c_custom_fields)) {
											echo '<br>';
											foreach ($c_custom_fields as $row) {
												echo $row['name'] . ': ' . $row['data'] . '<br>';
											}
										}
										echo '<br><br>';
										?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php if ($general['t_type'] == 1) {
		echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
	}?>
	
	<table id="items">
		<tr>
			<th><?php echo $this->lang->line('Artigo') ?>Artigo</th>
			<th><?php echo $this->lang->line('Description') ?></th>
			<th>Pr.Unit</th>
			<th><?php echo $this->lang->line('Qty') ?>.</th>
			<th>Descontos</th>
			<th>Impostos</th>
			<th><?php echo $this->lang->line('Amount') ?></th>
		</tr>

		<?php
		$sub_t = 0;
		$valsumtax = 0;
		$valsumcisc = 0;
		$arrtudo = [];
		foreach ($products as $row) {
			//$sub_t += $row['price'] * $row['qty'];
			$valsumcisc += $row['totaldiscount'];
			$sub_t += $row['subtotal'];
			$myArraytaxid = explode(";", $row['taxavals']);
			$myArraytaxperc = explode(";", $row['taxaperc']);
			$valsum = 0;
			$valperc = '';
			foreach ($myArraytaxid as $row1) {
				$valsum += $row1;
				$valsumtax += $row1;
			}
			
			foreach ($myArraytaxperc as $row2) {
				$valperc = $valperc.' '.$row2.'%';
			}
			if($row['serial'] != '') $row['product'].=' - '.$row['serial'];
			$myArraytaxname = explode(";", $row['taxaname']);
			$myArraytaxcod = explode(";", $row['taxacod']);
			$myArraytaxvals = explode(";", $row['taxavals']);
			$myArraytaxperc = explode(";", $row['taxaperc']);
			for($i = 0; $i < count($myArraytaxname); $i++)
			{
				$jatem = false;
				for($oo = 0; $oo < count($arrtudo); $oo++)
				{
					if($arrtudo[$oo]['title'] == $myArraytaxname[$i])
					{
						$arrtudo[$oo]['val'] = ($arrtudo[$oo]['val']+$myArraytaxvals[$i]);
						$arrtudo[$oo]['inci'] = ($arrtudo[$oo]['inci']+$row['subtotal']);
						$jatem = true;
						break;
					}
				}
				
				if(!$jatem)
				{
					$stack = array('title'=>$myArraytaxname[$i], 'val'=>$myArraytaxvals[$i], 'perc'=>$myArraytaxperc[$i].' %', 'inci'=>$row['subtotal']);
					array_push($arrtudo, $stack);
				}
			}

			echo '	  <tr class="item-row">
				  <td class="item-name">' . $row['code'] . '</td>
				  <td class="description">' . $row['product'] . '<br>'.$row['product_des'].'</td>
				  <td class="item-val"> ' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
				  <td class="item-qtd">' . $row['qty'] .' ' .$row['unit'].'</td>
				  <td class="item-disc">' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']). '</td>
				  <td class="item-tax">' .$valperc.'</td>
				  <td class="item-val">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . '</td>
			  </tr>';
		}
		?>

		<tr>
			<td colspan="7" class="blank">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="6" class="total-line"><strong>Total Ilíq.</strong></td>
			<td class="total-value"><div id="total"><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></div></td>
		</tr>
		<?php 
		if ($valsumcisc > 0) {
			echo '<tr>
				  <td colspan="2" class="blank"></td>
				  <td colspan="4" class="total-line"><strong>' . $this->lang->line('Total Discount') . ' Comercial</strong></td>
				  <td class="total-value"><div id="total">' . amountExchange($valsumcisc, $invoice['multi'], $invoice['loc']) . '</div></td>
			  </tr>';
		}
		
		if ($invoice['shipping'] > 0) {
			echo '<tr>
				  <td colspan="2" class="blank"> </td>
				  <td colspan="4" class="total-line"><strong>' . $this->lang->line('Shipping') . '</strong></td>
				  <td class="total-value"><div id="total">' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</div></td>
			  </tr>';
		}
		
		if ($invoice['discount_rate'] > 0) {
			echo '<tr>
				  <td colspan="2" class="blank"></td>
				  <td colspan="4" class="total-line"><strong>' . $this->lang->line('Total Discount') . ' Financeiro</strong></td>
				  <td class="total-value"><div id="total">' . amountExchange($invoice['discount_rate'], $invoice['multi'], $invoice['loc']) . '</div></td>
			  </tr>';
		}
		
		?>
		<?php 
			echo '<tr>
				  <td colspan="2" class="blank"></td>
				  <td colspan="4" class="total-line"><strong>Total Impostos</strong></td>
				  <td class="total-value"><div id="total">' . amountExchange($valsumtax, $invoice['multi'], $invoice['loc']) . '</div></td>
			  </tr>';
		?>
		
		<?php 
			if($activity != null)
			{
				echo '<tr><td colspan="2" class="total-impost"><strong>Meios de pagamento utilizados</strong><hr><table id="items"><tr>';
				echo "<th>Data</th>";
				echo "<th>Método</th>";
				echo "<th>Valor</th>";
				echo "<th>Obs</th>";
				echo '</tr>';
				foreach ($activity as $row) {
					if($row['debit'] == 0 || $row['debit'] == '0.00')
					{
						echo '<tr class="total-impost"><td class="item-val">' . $row['date'] . '</td>
							<td class="item-val">' . $row['methodname'] . '</td>
							<td class="item-val">Créd. ' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td>
							<td class="item-val">' . $row['note'] . '</td>
						</tr>';
					}else if(($row['debit'] == 0 || $row['debit'] == '0.00') && ($row['credit'] == 0 || $row['credit'] == '0.00'))
					{
						echo '<tr class="total-impost"><td class="item-name">' . $row['date'] . '</td>
							<td class="item-tax">' . $row['methodname'] . '</td>
							<td class="item-val">' . amountExchange(0, 0, $this->aauth->get_user()->loc) . '</td>
							<td class="description">' . $row['note'] . '</td>
						</tr>';
					}else{
						echo '<tr class="total-impost"><td class="item-val">' . $row['date'] . '</td>
							<td class="item-val">' . $row['methodname'] . '</td>
							<td class="item-val">Débi. ' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td>
							<td class="item-val">' . $row['note'] . '</td>
						</tr>';
					}
				}
				
				echo '</table></td>';
				echo '<td colspan="5" class="total-impost"><strong>Resumo de Impostos</strong><hr><table id="items"><tr class="total-impost">';
					echo "<th>Designação</th>";
					echo "<th>Valor</th>";
					echo "<th>Incidência</th>";
					echo "<th>Total</th>";
				echo '</tr>';
				for($r = 0; $r < count($arrtudo); $r++)
				{
					echo '<tr><td class="item-name">' . $arrtudo[$r]['title'] . '</td>';
					echo '<td class="description">' . $arrtudo[$r]['perc'] . '</td>';
					echo '<td class="item-val">' . amountExchange($arrtudo[$r]['inci'], 0, $this->aauth->get_user()->loc) . '</td>';
					echo '<td class="item-tax">' . amountExchange($arrtudo[$r]['val'], 0, $this->aauth->get_user()->loc) . '</td></tr>';
				}
				echo '</table></td></tr>';
				
			}
		?>
		<?php 
			if($invoice['exp_date'] != null && $invoice['expedition'] != null)
			{
				echo '<tr><td colspan="7" class="total-impost"><strong>Entrega e Transporte</strong><hr><table id="items"><tr>';
				echo "<th>Expedição</th>";
				echo "<th>Viatura</th>";
				echo "<th>Início do Transporte</th>";
				echo "<th>Local da Carga</th>";
				echo "<th>Local da Descarga</th>";
				echo '</tr>';
				echo '<tr class="total-impost"><td class="item-name">';
				if($invoice['expedition'] == 'exp1') 
						echo 'Correio'; 
					elseif($invoice['expedition'] == 'exp2') 
						echo 'Download/Formato Digital'; 
					elseif($invoice['expedition'] == 'exp3') 
						echo 'Nossa Viatura';
					elseif($invoice['expedition'] == 'exp4') 
						echo 'Transportadora';
					elseif($invoice['expedition'] == 'exp5') 
						echo 'Viatura Cliente';
					else 
						echo 'Nossa Viatura';
				
				echo '</td>';
				echo '<td class="item-name">';
				if($invoice['autoid'] == 0)
				{
					echo $invoice['methodname'];
				}else{
					echo $invoice['autoid_name'];
				}
				echo '</td>';
				echo '<td class="item-description">'.$invoice['exp_date'].'</td>';
				echo '<td class="item-description">'.$invoice['charge_address'].'<br>'.$invoice['charge_postbox'].'<br>'.$invoice['charge_city'].'<br>'.$invoice['charge_country_name'].'</td>';
				echo '<td class="item-description">'.$invoice['discharge_address'].'<br>'.$invoice['discharge_postbox'].'<br>'.$invoice['discharge_city'].'<br>'.$invoice['discharge_country_name'].'.</td>';		
				echo '</table></td></tr>';
			}
		?>
		
		<?php
		
		if(!$invoice['propdue_name'] && $invoice['irs_type_n'] != 'Guia de Remessa' && $invoice['irs_type_n'] != 'Guia de Transporte')
		{
			echo '<tr> <td colspan="7" class="total-impost2"><div id="total"><strong>' . valorPorExtenso($invoice['total']) . '</strong></div></td> </tr>';
		}
		
		echo '<tr>
				<td colspan="3" class="total-impost2">';
					$signimag = base_url('userfiles/employee_sign/' . $employee['sign']);
					echo '<div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . $signimag . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div>';
				echo '</td>';
				
				if(!$invoice['propdue_name'] && $invoice['irs_type_n'] != 'Guia de Remessa' && $invoice['irs_type_n'] != 'Guia de Transporte')
				{
					echo '<td colspan="7" class="total-impost2"><p style="font-size: 22px;"><strong>Valor a Pagar: '. amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) .'</strong></p><br>';
				}else{
					if($invoice['irs_type_n'] == 'Guia de Remessa' || $invoice['irs_type_n'] == 'Guia de Transporte')
					{
						echo '<td colspan="7" class="total-impost2"><p style="font-size: 22px;"><strong>Guia Valor: '. amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) .'</strong></p><br>';
					}else{
						echo '<td colspan="7" class="total-impost2"><p style="font-size: 22px;"><strong>Orçamento Valor: '. amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) .'</strong></p><br>';
					}
				}
				
				if (@$round_off['other']) {
					$final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
					echo '<p style="font-size: 20px;">' . $this->lang->line('Amount').' '.$this->lang->line('Round Off') .': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br>';
				}
				
				if(!$invoice['propdue_name'] && $invoice['irs_type_n'] != 'Guia de Remessa' && $invoice['irs_type_n'] != 'Guia de Transporte')
				{
					echo '<p style="font-size: 20px;">Valor Pago: '. amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']) .'</p></td>';
				}
				
		echo '</tr>';
		$rming = $invoice['total'] - $invoice['pamnt'];
		if ($rming > 0) {
			echo '<tr><td colspan="3" class="total-impost">';
				$tipsel = $invoice['status'];
				if ($invoice['status'] == 'Rascunho')
				{
					$tipsel = 'Rascunho';
				}else if($invoice['irs_type_n'] == 'Guia de Remessa' || $invoice['irs_type_n'] == 'Guia de Transporte')
				{
					$tipsel = 'Processada';
				}
				echo $this->lang->line('Status') . ': <strong>'.$tipsel.'</strong></td>';
				if(!$invoice['propdue_name'] && $invoice['irs_type_n'] != 'Guia de Remessa' && $invoice['irs_type_n'] != 'Guia de Transporte')
					echo '<td colspan="7" class="total-impost2"><strong>Total em Dívida: '. amountExchange($rming, $invoice['multi'], $invoice['loc']) .'</strong></td>
			  </tr>';
		}else{
			$rming = 0;
		}	
		?>


	</table>
</div>
</body>
</html>