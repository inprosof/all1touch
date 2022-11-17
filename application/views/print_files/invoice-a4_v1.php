<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $invoice['irs_type_n'].' '.$invoice['tid'] ?></title>
    <style>
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

        .invoice-box {
            width: 210mm;
            height: 280mm;
            margin: auto;
            padding: 2mm;
            border: 0;
            font-size: 8pt;
            line-height: 8pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 12pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 5pt;
        }

        .subtotal {
            page-break-inside: avoid;
        }

        .subtotal tr td {
            line-height: 5pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: none;
        }

        .sign {
            text-align: right;
            font-size: 9pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 9pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 9pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right: 20pt;
        }

        .invoice-box table td {
            padding: 3pt 3pt 5pt 3pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 5pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 7pt;
        }

        table tr.top table td.title {
            font-size: 6pt;
            line-height: 14pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 7pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 5pt;
        }

        table tr.details td {
            padding-bottom: 7pt;
        }

        .invoice-box table tr.item td {
             border: #ccc 0px solid;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 200pt;
        }

        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
            font-size: 8pt;
            line-height: 4pt;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 8pt;
            color: #515151;
        }

        .tax {
            font-size: 8px;
            color: #515151;
        }

        .t_center {
            text-align: right;
        }

        .party {
			border:none;

        }

        .top_logo {
            max-height: 180px;
            max-width: 200px;
			<?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        }

    </style>
</head>
<body dir="<?php echo LTR ?>">
<div class="app-content content container-fluid back-form">
	<table>
		<tr>
			<td class="myco">
				<img src="<?php $loc = location($invoice['loc']);
				echo FCPATH . 'userfiles/company/' . $loc['logo'] ?>"
					 class="top_logo">
			</td>
			
			<td class="myw">
				<table class="top_sum">
					<tr>
						<td colspan="4" class="t_center"><h2><?php echo $invoice['irs_type_n'].' ('.$Tipodoc.')'; ?></h2><br><br></td>
					</tr>
					<tr>
						<td><?php echo 'Documento Nº ' ?></td>
						<td rowspan="1">
							<?php echo '<strong>'.$invoice['irs_type_s'].' '.$invoice['serie_name'] . '/' . $invoice['tid'].'</strong>'; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('Date') ?></td>
						<td><?php echo dateformat($invoice['invoicedate']) ?></td>
					</tr>
					<?php if (isset($invoice['refer'])) { ?>
						<tr>
							<td><?php echo $this->lang->line('Reference') ?></td>
							<td><?php echo $invoice['refer'] ?></td>
						</tr>
					<?php } ?>
					<?php if (isset($invoice['invoiceduedate'])) { ?>
						<tr>
							<td><?php echo $this->lang->line('Due Date') ?></td>
							<td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
						</tr>
					<?php } ?>
					<?php if (isset($invoice['ref_enc_orc'])) { ?>
						<tr>
							<td>Enc./Orç: </td>
							<td><?php echo $invoice['ref_enc_orc'] ?></td>
						</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
	<br>

	<div class="invoice-box">
		<br>
		<table class="party" cellpadding="0" cellspacing="0">
			<thead>
			<tr class="heading">
				<td>Empresa:</td>
				<td><?php echo $general['person'] ?>:</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<?php 
						$loc = location($invoice['loc']);
						echo '<strong>'.$loc['cname'].'</strong><br>';
						echo $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
					if ($loc['taxid']) 
						echo '<br>NIF: ' . $loc['taxid'];
					?>
				</td>
				<td>
					<?php echo '<strong>' . $invoice['name'] . '</strong><br>';
					if ($invoice['company']) 
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
					if ($invoice['taxid']) 
						echo '<br>NIF: ' . $invoice['taxid'];
					if (is_array($c_custom_fields)) {
						echo '<br>';
						foreach ($c_custom_fields as $row) {
							echo $row['name'] . ': ' . $row['data'] . '<br>';
						}
					}
					?>
					</ul>
				</td>
			</tr>
			<tr>
				<?php if (@$invoice['name_s']) { ?>
					<td>
						<?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
						echo $invoice['name_s'] . '<br>';
						echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . ', ' . $invoice['region_s'];
						if ($invoice['country_s']) echo '<br>' . $invoice['country_s'];
						if ($invoice['postbox_s']) echo ' - ' . $invoice['postbox_s'];
						if ($invoice['phone_s']) echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'];
						if ($invoice['email_s']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];

						?>
					</td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
		<br>
		<?php 
		$valsumcisc = 0;
		$valsumtax = 0;
		$sub_t_col = 3;
		$sub_t = 0;
		$arrtudo = [];
		if (is_array($products) && !empty($products)) {?>
		<table class="plist" cellpadding="0" cellspacing="0">
			<tr class="heading">
				<td style="width: 1rem;">#</td>
				<td><?php echo $this->lang->line('Artigo') ?>Artigo</td>
				<td><?php echo $this->lang->line('Description') ?></td>
				<td>Pr.Unit</td>
				<td><?php echo $this->lang->line('Qty') ?>.</td>
				<td>Descontos</td>
				<td>Impostos</td>
				<td class="t_center"><?php echo $this->lang->line('Amount') ?></td>
			</tr>
			<?php
				$fill = true;
				$n = 1;
				foreach ($products as $row) {
					$cols = 4;
					if ($fill == true) {
						$flag = ' mfill';
					} else {
						$flag = '';
					}
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

					if ($row['serial']) 
						$row['product_des'] .= ' - ' . $row['serial'];
					echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
							<td>' . $row['code'] . '</td>
									<td>' . $row['product'] . '</td>
									<td style="width:15%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
									<td style="width:12%;" >' . +$row['qty'] . $row['unit'] . '</td>
									<td>' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']). '</td>';
					if ($invoice['tax'] > 0) {
						$cols++;
						echo '<td style="width:12%;">' . $valperc. '</span></td>';
					}
					if ($invoice['discount'] > 0) {
						$cols++;
						echo ' <td style="width:12%;">' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']). '</td>';
					}
					echo '<td class="t_center">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . '</td></tr>';

					if ($row['product_des']) {
						$cc = $cols++;
						echo '<tr class="item' . $flag . ' descr">  <td> </td>
							<td colspan="' . $cc . '">' . $row['product_des'] . '&nbsp;</td>
							
						</tr>';
					}
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
					$fill = !$fill;
					$n++;
				}

				if ($invoice['shipping'] > 0) {

					$sub_t_col++;
				}
				if ($invoice['tax'] > 0) {
					$sub_t_col++;
				}
				if ($invoice['discount'] > 0) {
					$sub_t_col++;
				}
			?>
		</table>
		<?php }?>
		<br> <?php if (is_array(@$i_custom_fields)) {

			foreach ($i_custom_fields as $row) {
				echo $row['name'] . ': ' . $row['data'] . '<br>';
			}
			echo '<br>';
		}
		?>
		<hr>
		<table class="subtotal">
			<tr>
				<td class="myco2" rowspan="<?php echo $sub_t_col ?>"><br>
					<p><?php 
							$tipsel = $this->lang->line(ucwords($invoice['status']));
							$tipsel = ucwords($invoice['status']);
							if ($invoice['status'] == 'Rascunho' || $invoice['status'] == 'draft')
							{
								$tipsel = 'Rascunho';
							}else if($invoice['irs_type_n'] == 'Guia de Remessa' || $invoice['irs_type_n'] == 'Guia de Transporte')
							{
								$tipsel = 'Processada';
							}else if($invoice['status'] == 'pending')
							{
								$tipsel = 'Pendente';
							}else if($invoice['status'] == 'accepted')
							{
								$tipsel = 'Aceite';
							}else if($invoice['status'] == 'rejected')
							{
								$tipsel = 'Rejeitado';
							}else if($invoice['status'] == 'customer_approved')
							{
								$tipsel = 'Aprovado pelo Cliente';
							}else if($invoice['status'] == 'ended')
							{
								$tipsel = 'Finalizado';
							}else if($invoice['status'] == 'canceled')
							{
								$tipsel = 'Cancelado';
							}else if($invoice['status'] == 'paid')
							{
								$tipsel = 'Pago';
							}
							
							echo '' . $this->lang->line('Status') . ': <strong>' .$tipsel.'</strong></p>';
							if($invoice['irs_type'] != 7 && $invoice['irs_type'] != 14 && $invoice['irs_type'] != 8 && $invoice['irs_type'] != 10)
							{
								echo '<hr><small>' . valorPorExtenso($invoice['total']) . '</small><hr>';
								echo '<br><p style="font-size: 17px;"><strong>Valor a Pagar: </strong>' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><br><p>';
								
								if (@$round_off['other']) {
									$final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
									echo '<p style="font-size: 17px;">' . $this->lang->line('Amount').' '.$this->lang->line('Round Off') .': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br><br>';
								}
								echo '<p style="font-size: 17px;">Valor Pago:' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']).'</p><br><br>';
								
								$rming = $invoice['total'] - $invoice['pamnt'];
								if (@$round_off['other']) {
									$rming = round($rming, $round_off['active'], constant($round_off['other']));
								}
								if ($rming > 0) {
									echo '<p style="font-size: 15px;"><strong>'.$this->lang->line('Balance Due').': </strong>' .amountExchange($rming, $invoice['multi'], $invoice['loc']).'</p><br><br>';
								}else{
									$rming = 0;
								}
							}else{
								if($invoice['irs_type'] == 7 && $invoice['irs_type'] == 14)
								{
									echo '<br><p style="font-size: 18px;"><strong>Guia Valor: </strong>' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
								}else{
									if($invoice['irs_type'] == 8)
									{
										echo '<br><p style="font-size: 18px;"><strong>Orçamento Valor: </strong>' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
									}else{
										echo '<br><p style="font-size: 18px;"><strong>Pró-Forma Valor: </strong>' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
									}
								}
							}
							if($invoice['irs_type'] == 8 && $invoice['irs_type'] == 10)
							{
								echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
							}
						?></p>
				</td>
				<td colspan="2"><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
			</tr>

			<?php if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {?>
			<tr class="f_summary">
				<td colspan="2">Total Ilíq.</td>
				<td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
			</tr>
			<?php }?>
			<?php
			if ($valsumcisc > 0) {
				echo '<tr>
					<td colspan="2">' . $this->lang->line('Total Discount') . ' Comercial:</td>
					<td>' . amountExchange($valsumcisc, $invoice['multi'], $invoice['loc']) . '</td>
				</tr>';
			}
			if (isset($invoice['discount_rate'])) {
				if ($invoice['discount_rate'] > 0) {
					echo '<tr>
						<td colspan="2">' . $this->lang->line('Total Discount') . ' Financeiro:</td>
						<td>' . amountExchange($invoice['discount_rate'], $invoice['multi'], $invoice['loc']) . '</td>
					</tr>';
				}
			}
			if (isset($invoice['shipping'])) {
				if ($invoice['shipping'] > 0) {
					echo '<tr>
						<td colspan="2">' . $this->lang->line('Shipping') . ':</td>
						<td>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td>
					</tr>';
				}
			}
			
			if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {
				echo '<tr>
						<td colspan="2">Total Impostos:</td>
						<td>' . amountExchange($valsumtax, $invoice['multi'], $invoice['loc']) . '</td>
				</tr>';
			}
			
			if (!empty($activity))
			{
				if(is_array($activity))
				{
					echo '<tr>';
					if ($invoice['irs_type'] == 22 && $invoice['irs_type'] == 23) {
						echo '<td colspan="2"><strong>Meios de pagamento utilizados</strong><hr><table id="payments"><thead><tr>';
					}else{
						echo '<td><strong>Meios de pagamento utilizados</strong><hr><table id="payments"><thead><tr>';
					}
					
					echo "<th>Data</th>";
					echo "<th>Método</th>";
					echo "<th>Valor</th>";
					echo "<th>Obs</th>";
					echo '</tr></thead>';
					foreach ($activity as $row) {
						if($row['debit'] == 0 || $row['debit'] == '0.00')
						{
							echo '<tr><td class="item-val">' . $row['date'] . '</td>
								<td class="item-val">' . $row['methodname'] . '</td>
								<td class="item-val">Créd. ' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td>
								<td class="item-val">' . $row['note'] . '</td>
							</tr>';
						}else if(($row['debit'] == 0 || $row['debit'] == '0.00') && ($row['credit'] == 0 || $row['credit'] == '0.00'))
						{
							echo '<tr><td class="item-val">' . $row['date'] . '</td>
								<td class="item-val">' . $row['methodname'] . '</td>
								<td class="item-val">' . amountExchange(0, 0, $this->aauth->get_user()->loc) . '</td>
								<td class="item-val">' . $row['note'] . '</td>
							</tr>';
						}else{
							echo '<tr><td class="item-val">' . $row['date'] . '</td>
								<td class="item-val">' . $row['methodname'] . '</td>
								<td class="item-val">Débi. ' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td>
								<td class="item-val">' . $row['note'] . '</td>
							</tr>';
						}
					}
					
					echo '</table></td>';
					
					if (!empty($taxasprodutosiva)) {
						if(is_array($taxasprodutosiva)){
							if ($invoice['irs_type'] != 22 && $invoice['irs_type'] != 23) {
								echo '<td colspan="3"><strong>Resumo de Impostos</strong><hr><table id="items"><thead><tr>';
									echo "<th>Designação</th>";
									echo "<th>Valor</th>";
									echo "<th>Incidência</th>";
									echo "<th>Total</th>";
								echo '</tr></thead>';
								for($r = 0; $r < count($taxasprodutosiva); $r++)
								{
									echo '<tr><td class="item-name">' . $taxasprodutosiva[$r]['title'] . '</td>';
									if($taxasprodutosiva[$r]['typ'] == '2'){
										echo '<td class="text-xs-right">' . $taxasprodutosiva[$r]['nameise'] . '</td>';
									}else{
										echo '<td class="description">' . $taxasprodutosiva[$r]['perc'] . '</td>';
									}
									echo '<td class="item-val">' . amountExchange($taxasprodutosiva[$r]['inci'], 0, $this->aauth->get_user()->loc) . '</td>';
									echo '<td class="item-tax">' . amountExchange($taxasprodutosiva[$r]['val'], 0, $this->aauth->get_user()->loc) . '</td>';
									echo '</tr>';
								}
								echo '</table></td>';
							}
						}
					}
					
					echo '</tr>';
				}
			}
			
			echo '</table>';
			if(isset($invoice['exp_date']))
			{
				if($invoice['exp_date'] != null && $invoice['expedition'] != null)
				{
					echo '<br><strong>Entrega e Transporte</strong><hr><table id="transport"><tr>';
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
					echo '</table>';
				}
			}
			?>
			<br><table id="transport">
				<tr>
					<td colspan="4">
						<img style="max-height:80px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt="QR">
					</td>
					<td>
						<br>
						<div class="sign">
							<?php echo $this->lang->line('Authorized person') ?>
						</div>
						<div class="sign1">
							<img src="<?php echo FCPATH . 'userfiles/employee_sign/' . $employee['sign'] ?>" width="160" height="50" border="0" alt=""/>
						</div>
						<div class="sign2">
							(<?php echo $employee['name'] ?>)
						</div>						
					</td>
				</tr>
			</table>
			<br>
			<?php
			if (is_array($docs_origem) && !empty($docs_origem)) {
				echo '<br><strong>Documentos relacionados</strong><p>Para pagamento do(s) seguinte(s) documento(s):</p><hr><table id="realations">'?>
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
					echo "</tbody>";?>
				</table>
			<?php } ?>
		</div>
	</div>
</div>
</body>
</html>