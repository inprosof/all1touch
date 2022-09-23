<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 8pt;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 280px;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 5pt;
        }
		
		.inv_info2 tr td {
            padding-right: 5pt;
        }

        .product_row {
            margin: 10pt;
        }
		
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body dir="<?php echo LTR ?>">
<div id='printbox'>
	<h4><br><?php echo $Tipodoc ?><br></h4>
    <h6 style="margin-top:0"><?php 
				$loc = location($invoice['loc']);
				$loc2 = location(0);
				echo $loc['cname']; ?>
				<?php echo $loc['address'] . ', ' . $loc['city'] . ', ' . $loc['region'] . ', ' . $loc['country'] . ' -  ' . $loc['postbox'] . ', ' . $this->lang->line('Phone') . ': ' . $loc['phone'] . ', ' . $this->lang->line('Email') . ': ' . $loc['email']. ', ' . $this->lang->line('conservator') . ': ' . $loc2['conservator']. ', ' . $this->lang->line('registration') . ': ' . $loc2['registration']. ', ' . $this->lang->line('share_capital') . ': ' . $loc2['share_capital'];
				if ($loc['taxid']) echo ', ' . $this->lang->line('TAX ID') .': '. $loc['taxid'];
				?></h6>

    <table class="inv_info">
        <?php   if ($invoice['taxid']) {      ?> <tr>
            <td style="font-size: 6pt;"><?php echo $this->lang->line('TAX ID')?></td>
            <td style="font-size: 6pt;"><?php echo $invoice['taxid'] ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td style="font-size: 6pt;"><strong><?php echo $invoice['irs_type_s'].' - '.$invoice['irs_type_n']; ?> </strong></td>
            <td style="font-size: 6pt;"><?php echo '<strong>'.$invoice['serie_name'] . '/' . $invoice['tid'].'</strong>';?></td>
        </tr>
        <tr>
            <td style="font-size: 6pt;"><?php echo $this->lang->line('Invoice Date') ?></td>
            <td style="font-size: 6pt;"><?php echo dateformat($invoice['invoicedate']) . ' ' . date('H:i:s') ?><br></td>
        </tr>
        <tr>
            <td style="font-size: 6pt;"><?php echo $this->lang->line('Customer') ?></td>
            <td style="font-size: 6pt;"><?php echo $invoice['name']; ?></td>
        </tr>
        
    </table>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td><b><?php echo $this->lang->line('Description') ?></b></td>
            <td style="width: 50px;"><b><?php echo $this->lang->line('Qty') ?></b></td>
			<td><b><?php echo $this->lang->line('Tax') ?></b></td>
            <td style="width: 50px;"><b><?php echo $this->lang->line('Amount') ?></b></td>
        </tr>
        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <?php
		$sub_t = 0;
		$sub_t_tot = 0;
		$valsum = 0;
        $this->pheight = 0;
        foreach ($products as $row) {
			$sub_t += $row['subtotal']+$row['totaldiscount'];
			$sub_t_tot += $row['totaltax'];
			$myArraytaxid = explode(";", $row['taxavals']);
			$myArraytaxperc = explode(";", $row['taxaperc']);
			
			$valperc = '';
			foreach ($myArraytaxid as $row1) {
				$valsum += $row1;
			}
			foreach ($myArraytaxperc as $row2) {
				$valperc = $valperc.' '.$row2.'%';
			}
            $this->pheight = $this->pheight + 12;
            echo '<tr>
            <td >' . $row['product'] . '</td>
            <td>' . $row['qty'] . ' ' . $row['unit'] . '</td>
			<td>' .$valperc . '</td>
            <td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
			</tr><tr><td colspan="3"></td></tr>';
        }

		$sub_t_tot -= $valsum;
		?>
    </table>
    <hr>
    <table class="inv_info2">
		<tr>
			<td><?php echo $this->lang->line('SubTotal'); ?></td>
			<td style="width: 30%; text-align: right;"><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
		</tr>
		<?php if ($invoice['discount'] > 0) {
			echo '<tr>
				<td>Desconto Comercial</td>
				<td style="width: 30%; text-align: right;">'.amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']).'</td>
			</tr>';
		}
			?>
		<?php if ($invoice['shipping'] > 0) {
			echo '<tr>
				<td>'.$this->lang->line('Shipping').'</td>
				<td style="width: 30%; text-align: right;">'.amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']).'</td>
			</tr>';
		}
			?>
		<?php if ($invoice['discount_rate'] > 0) {
			echo '<tr>
				<td>Desconto Financeiro</td>
				<td style="width: 30%; text-align: right;">'.amountExchange($invoice['discount_rate'], $invoice['multi'], $invoice['loc']).'</td>
			</tr>';
			}
			?>
    </table>
	<hr>
	<h6 style="margin-top:0">Totais Com Iva</h6>
	<table>
		<tr style="width: 100%; text-align: left;">
			<td style="width: 60px; text-align: left;"><?php echo $this->lang->line('Amount') ?>&nbsp;</td>
			<td style="width: 70px; text-align: left;"><?php echo $this->lang->line('Amount').' '.$this->lang->line('Tax') ?></td>
			<td style="width: 100%; text-align: right;"><b><?php echo $this->lang->line('Totaltopay')?></b></td>
		</tr>
		<tr>
			<td style="width: 60px; text-align: left;"><?php echo amountExchange($sub_t_tot, $invoice['multi'], $invoice['loc']) ?></td>
			<td style="width: 70px; text-align: left;"><?php echo amountExchange($valsum, $invoice['multi'], $invoice['loc']) ?></td>
			<?php 
			if ($round_off['other']) {
				$final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
				
			?>
			<?php } else {
					$final_amount = $invoice['total'];
			} ?>
			<td style="width: 100%; text-align: right;"><b><?php echo amountExchange($final_amount, $invoice['multi'], $invoice['loc']) ?></b></td></td>
		</tr>
	</table>
	<hr>
	<h6 style="margin-top:0">Assinatura</h6>
	<hr>
	<h5 style="margin-top:0">(<?php echo $employee['depart_employee'].' - '.$employee['name']?>)</h5>
	<h6 style="margin-top:0"><?php echo 'Documento gerado em '.$date_now?></h6>
	<?php 
		$loc = location($invoice['loc']);
		$loc2 = location(0);
		echo '<h6>Processado por Programa Certificado nº '.$loc2['certification'].' /'.$invoice['irs_type_s'].' - '.$invoice['irs_type_n'].': '.$invoice['serie_name'] . '/' . $invoice['tid'].'<h6><br>';
	?>
	<div class="text-center">
	<img style="max-height:200px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'></div>
</div>
</body>
</html>
