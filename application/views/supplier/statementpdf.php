<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Extrato da Conta Fornecedor</title>

    <style>
        body {
            color: #2B2000;
        }

        .invoice-box {
            width: 210mm;
            height: 120mm;
            margin: auto;
            padding: 4mm;
            border: 0;

            font-size: 13pt;
            line-height: 18pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 14pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
        }

        .sign {
            text-align: right;
            font-size: 8pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
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
        }

        .invoice-box table td {
            padding: 10pt 4pt 5pt 4pt;
            vertical-align: top;

        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 5pt;

        }

        .invoice-box table tr.top table td.title {
            font-size: 20pt;
            line-height: 25pt;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10pt;
        }

        .invoice-box table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        .invoice-box table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #fff;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 80pt;
        }

        .myco2 {
            width: 80pt;
        }

        .myw {
            width: 200pt;
            font-size: 12pt;
            line-height: 30pt;
        }

        .mfill {
            background-color: #eee;
        }

        .tax {
            font-size: 8px;
            color: #515151;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body <?php if (LTR == 'rtl') echo 'dir="rtl"'; ?>>
<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                     style="max-width:80px;">
            </td>
            <td>

            </td>
            <td class="myw">
                <?php echo $this->lang->line('Account Statement');
                $balance = 0; ?>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
        <tr class="heading">
            <td><?php 
					if($company != null)
					{
						echo $company['name_comp'];
					} 
				?></td>

            <td><?php 
					if($supplier != null)
					{
						echo $supplier['name'];
					} 
				?></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php 
					$namel = "";
					$addressl = "";
					$cityl = "";
					$phonel = "";
					$emaill = "";
					if($company != null)
					{
						if($company['address'] != null)
						{
							$addressl = $company['address'];
						}
						
						if($company['city'] != null)
						{
							$cityl = $company['city'];
						}
						
						if($company['phone'] != null)
						{
							$phonel = $company['phone'];
						}
						
						if($company['email'] != null)
						{
							$emaill = $company['email'];
						}
						
						if($company['country_name'] != null)
						{
							$country_name = $company['country_name'];
						}
					}
					
					echo $addressl . '<br>' . $cityl . '<br>Phone: ' . $phonel . '<br>Email: ' . $emaill. '<br>País: ' . $country_name;  
				?>
            </td>

            <td>
                <?php 
				$namec = "";
				$addressc = "";
				$cityc = "";
				$phonec = "";
				$emailc = "";
				if($supplier != null)
				{
					if($supplier['address'] != null)
					{
						$addressc = $supplier['address'];
					}
					
					if($supplier['city'] != null)
					{
						$cityc = $supplier['city'];
					}
					
					if($supplier['phone'] != null)
					{
						$phonec = $supplier['phone'];
					}
					
					if($supplier['email'] != null)
					{
						$emailc = $supplier['email'];
					}
				}
				echo $addressc . '<br>' . $cityc . '<br>Phone: ' . $phonec . '<br>Email: ' . $emailc; ?>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table class="plist" cellpadding="0" cellspacing="0">

        <tr>
            <td><strong><?php echo $this->lang->line('Date') ?></strong></td>
            <td><strong><?php echo $this->lang->line('Description') ?></strong></td>

            <td><strong><?php echo $this->lang->line('Debit') ?></strong></td>
            <td><strong><?php echo $this->lang->line('Credit') ?></strong></td>

            <td><strong><?php echo $this->lang->line('Balance') ?></strong></td>


        </tr>

        <?php
        $fill = false;
		$balance = 0;
		$balanceline = $debitPrevious - $creditPrevious;
        foreach ($list as $row) {
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            //$balance += $row['debit'] - $row['credit'];
            echo '<tr class="item' . $flag . '"><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
            $fill = !$fill;
        }
		
		$balance = $credit - $debit;
		
        ?>
		<tr>
			<td colspan="6"><hr></td>
		</tr>
		<br>
		<tr>
			<td colspan="3"><br></td>
			<td><strong><?php 
				if($balance > 0) 
					echo 'Saldo em Crédito'; 
				else if($balance < 0) 
					echo 'Saldo em Débito';
				else
					echo 'Saldo';
				?>:</strong></td>
			<td colspan="5"><?php echo amountExchange($balance, 0, $this->aauth->get_user()->loc); ?></td>
		</tr>
		<br>
		<br>
		<tr>
			<td colspan="3"></td>
			<?php
				echo '<td style="vertical-align: center;horizontal-align: center;">'. $this->lang->line('Authorized person');
				if($employee['sign'] != "" && $employee['sign'] != null)
				{
					$signimag = base_url('userfiles/employee_sign/' . $employee['sign']);
					echo '<br><img src="' . $signimag . '" width="160" height="50" border="0" alt=""/>';
				}
				echo '<br>(' . $employee['name'] . ')';
				echo '</td>';
			?>
		
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="3"><hr></td>
			<td colspan="4"></td>
		</tr>
    </table>
</div>
</body>
</html>
