<!doctype html>
<html>
<head>
    <title><?php echo $invoice['irs_type_n'].' '.$invoice['tid'] ?></title>

    <style type="text/css">

        body {
            font: 9px/1.4 Georgia, serif;
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
            font: 10px Georgia, Serif;
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
		
		table tr.heading td {
            background: #eee;
            color: #000;
			font: bold 9px Helvetica, Sans-Serif;
            padding: 5pt;
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
            width: 100%;
            float: right;
			clear: both;
			border:none;
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
		
		#meta td.total-line {
			border-left: 0;
			border-right: 0;
			border-top: 0;
			border-bottom: 0;
			text-align: right;
		}
		
		#meta td.total-line2 {
			border-left: 0;
			border-right: 0;
			border-top: 0;
			border-bottom: 0;
			text-align: left;
		}
		
		#meta td.total-impost {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 2px;
			text-align: right;
			font-size: 9px;
        }
		
		#meta td.total-impost2 {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 2px;
			text-align: left;
			font-size: 9px;
        }
		
		#meta th {
            background: #eee;
        }

        #meta div {
            width: 80px;
            height: 50px;
        }

        #meta tr.item-row td {
            border: #ccc 0px solid;
            vertical-align: top;
			font-size: 9px;
        }
		
		#meta td.total-value {
            border-right: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 9px;
			text-align: right;
			font-size: 9px;
        }
		
		#meta td.total-value div {
            height: 10px;
            background: none;
        }
		
		#taxs td.total-line2 {
			border-left: 0;
			border-right: 0;
			border-top: 0;
			border-bottom: 0;
		}

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
			border:none;
        }
		
		#items td.total-line2 {
			border-left: 0;
			border-right: 0;
			border-top: 0;
			border-bottom: 0;
			text-align: left;
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
			font-size: 9px;
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
            padding: 2px;
			text-align: right;
			font-size: 9px;
        }
		
		#items td.total-impost {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 2px;
			text-align: right;
			font-size: 9px;
        }
		
		#items td.total-impost2 {
            border-right: 0;
			border-left: 0;
			border-top: 0;
			border-bottom: 0;
            padding: 2px;
			text-align: right;
			font-size: 9px;
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
            margin: 15px 0 0 0;
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
            max-width: 200px;
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
		  font-size: 9px;
		}
		
		.blueTableVals {
			width: 100%;
			text-align: right;
			border: none;
			border-collapse: collapse;
		}
		.blueTableVals td, .blueTableVals th {
			border: none;
			padding: 3px 2px;
		}
		.blueTableVals tbody td {
		  font-size: 9px;
		}
    </style>


</head>

<body dir="<?php echo LTR ?>">
<div class="app-content content container-fluid back-form">
	<table class="blueTable">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;">
					<img style="max-height:80px;" id="image" src="<?php 
					$loc = location(0);
					echo base_url('userfiles/company/' . $loc['logo']) ?>" alt="logo" class="top_logo"/>
				</td>
				<td style="width: 50%; text-align: right;">
					<?php 
						//$this->pheight = $this->pheight + 50;
						if (@$qrc and $invoice['status'] != 'paid') { ?>
							
					<?php } else {
						
					} ?>
					
					<div class="col-sm-6">
						<h3><br><?php echo $Tipodoc; ?><br></h3>
						<h3><br><?php echo $invoice['irs_type_n'].' Nº '.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid']; ?><br></h3>
						<h5><br><?php echo 'Data de Emissão: '.$invoice['invoicedate']; ?><br></h5>
					</div>
					
					
					<?php if (@$qrc AND $invoice['status'] != 'paid') {
							
						?>
					<?php } else {
						
					} ?>
				</td>
			</tr>
			<tr>
				<td style="width:150px; font-size:14px;">
					<?php 
						$loc = location($invoice['loc']);
						$loc2 = location(0);
						echo '<strong>' . $loc['cname']; ?></strong><br>
						<?php echo
							$loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email']. '<br> ' . $this->lang->line('conservator') . ': ' . $loc2['conservator']. '<br> ' . $this->lang->line('registration') . ': ' . $loc2['registration']. '<br> ' . $this->lang->line('share_capital') . ': ' . $loc2['share_capital'];
						if ($loc['taxid']) 
							echo '<br>' . $this->lang->line('TAX ID') .': '. $loc['taxid'];
					?>
				</td>
				<td>
					<table class="blueTable">
						<tbody>
							<tr>
								<th style="width: 200px;">__________________Prazo de Venc.</strong></th>
								<th style="width: 140px;">________Código A.T</th>
								<th style="width: 50px;">_____________Moeda</th>
							</tr>
							<tr>
								<td rowspan="1"><?php
									echo 'Pronto Pagamento'; ?>
								</td>
								<td><?php echo 'hash' ?></td>
								<td><?php echo currency($this->aauth->get_user()->loc) ?></td>
							</tr>
							<tr>
									<?php 
										if (isset($invoice['invoiceduedate'])) {
											if ($invoice['invoiceduedate']) { ?>
												<th>_______________Data de Vencimento</th>
											<?php }
										} ?>
									<?php 
										if (isset($invoice['refer'])) {
											if ($invoice['refer']) { ?>
												<th>_________________<?php echo $this->lang->line('Reference') ?></th>
											<?php }
										} ?>
									<?php 
										if (isset($invoice['ref_enc_orc'])) {
											if ($invoice['ref_enc_orc']) { ?>
												<th>___________Enc./Orç.</th>
											<?php }
										} ?>
							</tr>
							<tr>
								<?php 
									if (isset($invoice['invoiceduedate'])) {
										if ($invoice['invoiceduedate']) { ?>
											<td rowspan="1"><?php echo $invoice['invoiceduedate']; ?></td>
										<?php }
								} ?>
								<?php 
									if (isset($invoice['refer'])) {
										if ($invoice['refer']) { ?>
											<td><?php echo $invoice['refer']; ?></td>
										<?php }
									} ?>
								<?php 
									if (isset($invoice['ref_enc_orc'])) {
										if ($invoice['ref_enc_orc']) { ?>
											<td><?php echo $invoice['ref_enc_orc']; ?></td>
									<?php }
									} ?>
							</tr>
							
							<tr>
									<th>______________________________<?php echo $general['person'] ?></th>
									<th>___________________Contribuinte</th>
									<?php if($invoice['irs_type'] == 8 && $invoice['irs_type'] == 10) { ?>
										<th>_____________Prazo</th>
									<?php } ?>
							</tr>
							
							<tr>
								<td rowspan="1"><?php echo $invoice['name'] ?></td>
								<td><?php echo $invoice['taxid'] ?></td>
								<?php if($invoice['irs_type'] == 8 && $invoice['irs_type'] == 10) { ?>
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
	
	<?php if($invoice['irs_type'] == 8 || $invoice['irs_type'] == 10) {
		echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
	}?>
	
	<?php 
		$valsumcisc = 0;
		$valsumtax = 0;
		$sub_t = 0;
		if (is_array($products) && !empty($products)) {?>
		<table class="blueTable clearfix">
			<thead>
				<tr class="heading">
					<td style="width: 1rem;">#</td>
					<td><?php echo $this->lang->line('Artigo') ?>Artigo</td>
					<td><?php echo $this->lang->line('Description') ?></td>
					<td>Pr.Unit</td>
					<td><?php echo $this->lang->line('Qty') ?>.</td>
					<td>Descontos</td>
					<td>Impostos</td>
					<td><?php echo $this->lang->line('Amount') ?></td>
				</tr>
			</thead>
			<tbody>
			<!--<tr><td colspan="7" style="font-size:8px"><hr></td></tr>-->
			<?php
				$n = 1;
				foreach ($products as $row) {
					//$sub_t += $row['price'] * $row['qty'];
					$valsumcisc += $row['totaldiscount'];
					$sub_t += $row['subtotal'];
					$myArraytaxid = explode(";", $row['taxavals']);
					$myArraytaxperc = explode(";", $row['taxaperc']);
					$valperc = '';
					foreach ($myArraytaxid as $row1) {
						$valsumtax += $row1;
					}
					
					foreach ($myArraytaxperc as $row2) {
						$valperc = $valperc.' '.$row2.'%';
					}
					
					
					if(!empty($row['serial'])) 
						$row['product'].=' - '.$row['serial'];
					

					echo '<tr>
							<td>' . $n . '</td>
							<td class="total-value">' . $row['code'] . '</td>
							<td class="total-value">' . $row['product'] . '</td>
							<td class="total-value"> ' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
							<td class="total-value">' . $row['qty'] .' ' .$row['unit'].'</td>
							<td class="total-value">' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']). '</td>
							<td class="total-value">' .$valperc.'</td>
							<td class="total-value">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . '</td>
						</tr>';
					  
					  if (CUSTOM) {
						$p_custom_fields = $this->custom->view_fields_data($row['pid'], 5, 1);

						if (is_array($p_custom_fields[0])) {
							$z_custom_fields = '';

							foreach ($p_custom_fields as $row) {
								$z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
							}

							echo '<tr class="item' . $flag . ' descr">  <td> </td>
									<td colspan="' . $cc . '">' . $z_custom_fields . '&nbsp;</td>
									
								</tr>';
						}
					}
					//<tr class="item-row"><td colspan="7" >$row['product_des']</td></tr>
					$n++;
				}?>
				
				<tr><td class="total-value"></td></tr><br>';
				<tr><td colspan="8" style="font-size:8px"><hr></td></tr>
				<tr><td colspan="8" style="font-size:8px">Os Artigos e/ou Serviços faturados foram colocados/efetuados à disposição do adquirente à data <?php echo $invoice['invoicedate']; ?></td></tr>
			</tbody>
		</table>
		<br>
		
		<?php }?><?php if (is_array(@$i_custom_fields)) {

			foreach ($i_custom_fields as $row) {
				echo $row['name'] . ': ' . $row['data'] . '<br>';
			}
			echo '<br>';
		}
		?>
		<table id="meta" class="blueTableVals clearfix">
			<?php 
			if ($invoice['irs_type'] == 22 || $invoice['irs_type'] == 23) {
				echo '<tr class="total-line"> <td colspan="7" class="total-value"><div id="total"><strong>Recebemos a quantia de '. amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']) .' ('.valorPorExtenso($invoice['total']).')</strong></div></td></tr>';
			}
			?>
			<tr>
				<td colspan="1">
					<table id="meta" class="blueTableVals clearfix">
						<?php 
							if (!empty($taxasprodutosiva)) {
								if(is_array($taxasprodutosiva)){
									if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {
										echo '<tr class="total-impost"><td colspan="6" class="total-line"><strong>Resumo de Impostos</strong><hr><tr class="total-impost2">';
											echo "<th>Designação</th>";
											echo "<th>Valor</th>";
											echo "<th>Incidência</th>";
											echo "<th>Total</th>";
										echo '</tr>';
										for($r = 0; $r < count($taxasprodutosiva); $r++)
										{
											echo '<tr><td class="total-line2">' . $taxasprodutosiva[$r]['title'] . '</td>';
											if($taxasprodutosiva[$r]['typ'] == '2'){
												echo '<td class="total-line2">' . $taxasprodutosiva[$r]['nameise'] . '</td>';
											}else{
												echo '<td class="total-line2">' . $taxasprodutosiva[$r]['perc'] . '</td>';
											}
											echo '<td class="total-line2">' . amountExchange($taxasprodutosiva[$r]['inci'], 0, $this->aauth->get_user()->loc) . '</td>';
											echo '<td class="total-line2">' . amountExchange($taxasprodutosiva[$r]['val'], 0, $this->aauth->get_user()->loc) . '</td></tr>';
										}
										echo '</td>';
									}
								}
								
								echo '</tr>';
							}else{
								echo '</tr>';
							}
							
							if (!empty($activity)) {
								if(is_array($activity))
								{
									if ($invoice['irs_type'] == 22 && $invoice['irs_type'] == 23) {
										echo '<tr class="total-impost"><td colspan="5" class="total-line"><strong>Meios de pagamento utilizados</strong><hr><table id="meta" class="blueTableVals clearfix"><tr>';
									}else{
										echo '<tr class="total-impost"><td colspan="5" class="total-line"><strong>Meios de pagamento utilizados</strong><hr><table id="meta" class="blueTableVals clearfix"><tr>';
									}
									echo "<th>Data</th>";
									echo "<th>Método</th>";
									echo "<th>Valor</th>";
									echo "<th>Obs</th>";
									echo '</tr>';
									foreach ($activity as $row) {
										if($row['debit'] == 0 || $row['debit'] == '0.00')
										{
											echo '<tr class="total-line2"><td class="total-line2">' . $row['date'] . '</td>
												<td class="total-line2">' . $row['methodname'] . '</td>
												<td class="total-line2">Créd. ' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td>
												<td class="total-line2">' . $row['note'] . '</td>
											</tr>';
										}else if(($row['debit'] == 0 || $row['debit'] == '0.00') && ($row['credit'] == 0 || $row['credit'] == '0.00'))
										{
											echo '<tr class="total-line2"><td class="total-line2">' . $row['date'] . '</td>
												<td class="total-line2">' . $row['methodname'] . '</td>
												<td class="total-line2">' . amountExchange(0, 0, $this->aauth->get_user()->loc) . '</td>
												<td class="total-line2">' . $row['note'] . '</td>
											</tr>';
										}else{
											echo '<tr class="total-line2"><td class="total-line2">' . $row['date'] . '</td>
												<td class="total-line2">' . $row['methodname'] . '</td>
												<td class="total-line2">Débi. ' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td>
												<td class="total-line2">' . $row['note'] . '</td>
											</tr>';
										}
									}
									
									echo '</tr></table></td>';
								}
							}
						?>
				
					</table>
				</td>
				
				<td><table id="items">
						<?php 
							if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {?>
								<tr><td colspan="7" class="total-line"><strong>Total Ilíq.</strong></td>
								<td class="total-value"><div id="total"><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></div></td></tr>
							<?php }?>
							<?php 
							if ($valsumcisc > 0) {
								echo '<tr><td colspan="7" class="total-line"><strong>' . $this->lang->line('Total Discount') . ' Comercial</strong></td>
									  <td class="total-value"><div id="total">' . amountExchange($valsumcisc, $invoice['multi'], $invoice['loc']) . '</div></td></tr>';
							}
							
							if (isset($invoice['shipping'])) {
								if ($invoice['shipping'] > 0) {
									echo '<tr><td colspan="7" class="total-line"><strong>' . $this->lang->line('Shipping') . '</strong></td>
										  <td class="total-value"><div id="total">' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</div></td></tr>';
								}
							}
							
							if (isset($invoice['discount_rate'])) {
								if ($invoice['discount_rate'] > 0) {
									echo '<tr><td colspan="7" class="total-line"><strong>' . $this->lang->line('Total Discount') . ' Financeiro</strong></td>
									  <td class="total-value"><div id="total">' . amountExchange($invoice['discount_rate'], $invoice['multi'], $invoice['loc']) . '</div></td></tr>';
								}
							}
						
						?>
						<?php 
							if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {
								echo '<tr><td colspan="7" class="total-line"><strong>Total Impostos</strong></td>
								  <td class="total-value"><div id="total">' . amountExchange($valsumtax, $invoice['multi'], $invoice['loc']) . '</div></td></tr>';
							}
						?>
					</table>
				</td>
			</tr>			
			<?php

			if ($invoice['irs_type'] == 22 || $invoice['irs_type'] == 23) {
				echo '<tr><td colspan="8" class="total-line"><div id="total"><strong>Este documento não serve de fatura</strong></div></td></tr>';
			}else{
				if($invoice['irs_type'] != 8 && $invoice['irs_type'] != 14 && $invoice['irs_type'] != 10)
				{
					echo '<tr><td colspan="8" class="total-line">'. valorPorExtenso($invoice['total']) . '</td> </tr>';
				}
			}
			
			echo '<tr><td colspan="7" class="total-line">';
			
			if($invoice['irs_type'] == 7 && $invoice['irs_type'] == 14)
			{
				echo '<p style="font-size: 12px;"><strong>Valor a Pagar: '. amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) .'</strong></p><br>';
			}else{
				if($invoice['irs_type'] == 8 || $invoice['irs_type'] == 10)
				{
					echo '<p style="font-size: 12px;"><strong>Valor a Pagar: '. amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) .'</strong></p><br>';
				}
			}
			
			if (@$round_off['other']) {
				$final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
				echo '<p style="font-size: 12px;">' . $this->lang->line('Amount').' '.$this->lang->line('Round Off') .': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br>';
			}
			
			if($invoice['irs_type'] != 7 && $invoice['irs_type'] != 14 && $invoice['irs_type'] != 8 && $invoice['irs_type'] != 10)
			{
				echo '<p style="font-size: 12px; text-align: right;"><strong>Valor Pago: '. amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']) .'</strong></p><br><br>';
			}
			echo '</td></tr>';?>
			
			<tr>
				<td colspan="3" class="total-line">
					<?php $signimag = base_url('userfiles/employee_sign/' . $employee['sign']);
					echo '<div class="sign">' . $this->lang->line('Authorized person') . '
							</div>
							<div class="sign1">
								<img src="' . $signimag . '" style="max-width:120px; max-height:50px;" border="0" alt="">
							</div>
							<div class="sign2">(' . $employee['name'] . ')</div>';
					?>
				</td>
				<td colspan="6" class="total-line">
					<img style="max-height:80px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc)?>' alt="QR">
				</td>
			</tr>
			
			<?php
			$rming = 0;
			if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23 && $invoice['irs_type'] != 8 && $invoice['irs_type'] != 10) {
				$rming = $invoice['total'] - $invoice['pamnt'];
			}
			if ($rming > 0) {
				echo '<tr><td colspan="6" class="total-impost">';
					$tipsel = $invoice['status'];
					if ($invoice['status'] == 'Rascunho')
					{
						$tipsel = 'Rascunho';
					}else if($invoice['irs_type_n'] == 'Guia de Remessa' || $invoice['irs_type_n'] == 'Guia de Transporte')
					{
						$tipsel = 'Processada';
					}
					echo $this->lang->line('Status') . ': <strong>'.$tipsel.'</strong></td>';
					if($invoice['irs_type'] != 7 && $invoice['irs_type'] != 14 && $invoice['irs_type'] != 8 && $invoice['irs_type'] != 10)
						echo '<td colspan="7" class="total-impost2"><strong>Total em Dívida: '. amountExchange($rming, $invoice['multi'], $invoice['loc']) .'</strong></td>
				  </tr>';
			}else{
				$rming = 0;
			}	
			?>			
			<?php 
				if(isset($invoice['exp_date']))
				{
					if($invoice['exp_date'] != null && $invoice['expedition'] != null)
					{
						echo '<tr class="total-impost"><td colspan="8" class="total-line"><strong>Entrega e Transporte</strong><hr><table id="meta" class="blueTableVals clearfix"><tr>';
						echo "<th>Expedição</th>";
						echo "<th>Viatura</th>";
						echo "<th>Início do Transporte</th>";
						echo "<th>Local da Carga</th>";
						echo "<th>Local da Descarga</th>";
						echo '</tr>';
						echo '<tr class="total-impost"><td class="total-line">';
						$expedi = 'Nossa Viatura';
						if($invoice['expedition'] == 'exp1'){
							$expedi = 'Correio';
							echo 'Correio';
						}
						elseif($invoice['expedition'] == 'exp2'){
							$expedi = 'Download/Formato Digital';
							echo 'Download/Formato Digital'; 
						}
						elseif($invoice['expedition'] == 'exp3'){
							$expedi = 'Nossa Viatura';
							echo 'Nossa Viatura';
						}
						elseif($invoice['expedition'] == 'exp4'){
							$expedi = 'Transportadora';
							echo 'Transportadora';
						}
						elseif($invoice['expedition'] == 'exp5'){
							$expedi = 'Viatura Cliente';
							echo 'Viatura Cliente';
						}
						else {
							echo 'Nossa Viatura';
						}
						echo '</td>';
						echo '<td class="item-name">';
						if($invoice['autoid'] == 0)
						{
							echo $expedi;
						}else{
							echo $invoice['autoid_name'];
						}
						echo '</td>';
						echo '<td class="total-line">'.$invoice['exp_date'].'</td>';
						echo '<td class="total-line">'.$invoice['charge_address'].'<br>'.$invoice['charge_postbox'].'<br>'.$invoice['charge_city'].'<br>'.$invoice['charge_country_name'].'</td>';
						echo '<td class="total-line">'.$invoice['discharge_address'].'<br>'.$invoice['discharge_postbox'].'<br>'.$invoice['discharge_city'].'<br>'.$invoice['discharge_country_name'].'.</td>';		
						echo '</table></td></tr>';
					}
				}
			?>
			<?php
				if (!empty($docs_origem)) {
					if(is_array($docs_origem)){
						echo '<tr><td colspan="8" class="total-line2"><strong>Documentos relacionados</strong><p>Para pagamento do(s) seguinte(s) documento(s):</p><hr><table id="meta" class="blueTableVals clearfix">>'?>
						<?php
							echo "<thead>
								<tr>
									<th>Documento</th>
									<th>Série/Nº</th>
									<th>Data Emissão</th>
									<th>Valor do documento</th>
									<th>Valor Pago</th>
									<th>Valor Pendente</th>
								</tr>
							</thead>
							<tbody>";
							foreach ($docs_origem as $row) {
								$tiiid = $row['id'];
								echo '<tr>';
								echo "<td><strong>" . $row['tipo'] . "</strong></td>";
								echo "<td>" . $row['serie_name'] . '/' . $row['tid_doc'] . "</td>";
								echo "<td>" . $row['invoicedate'] . "</td>";
								echo "<td>" . amountExchange($row['total'], 0, $this->aauth->get_user()->loc) . "</td>";
								echo "<td>" . amountExchange($row['total_pay'], 0, $this->aauth->get_user()->loc) . "</td>";
								echo "<td>" . amountExchange($row['total_due'], 0, $this->aauth->get_user()->loc) . "</td>";
								echo '</tr>';
							}
						echo "</tbody>";
					}
					?>
				</table></td><tr>
			<?php } ?>
	</table>
</div>
</body>
</html>