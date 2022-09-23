<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $lang['title']; ?></title>

    <style>
        body {
            color: #2B2000;
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;

            font-size: 8pt;
            line-height: 12pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 10pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 10pt;
        }

        .subtotal tr td {
            line-height: 8pt;
        }

        .sign {
            text-align: right;
            font-size: 8pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 8pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 8pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 8pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 7pt;
            line-height: 10pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 5pt 4pt;
            vertical-align: top;

        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        .invoice-box table tr.top table td.title {
            font-size: 20pt;
            line-height: 20pt;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.heading td {
            background: #ccc;
            color: #000000;
            padding: 0pt;

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
            width: 300pt;
        }

        .myco2 {
            width: 290pt;
        }

        .myw {
            width: 500pt;
            font-size: 14pt;
            line-height: 30pt;
        }

        .mfill {
            background-color: #eee;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .td-lable {
            width: 120pt;
            padding: 2px 0;
        }

        .td-val {
            font-weight: bold;
            width: 220pt;
            padding: 2px 0;
        }
        .table-right-info {
            border: 1px solid #000000;
        }

        .no-border-left {
            border-left: none;
        }

        .no-border-right {
            border-right: none;
        }
        .color-red{
            color:red;
        }

        tbody tr td {
            border-bottom: none;
            border-top: none;
        }

        tfoot td {
            font-size: 12px;
            width: 100px;
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

<body dir="ltr">
<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                     style="max-width:260px;">
                <p style="padding-top: 30px">
                    <?php echo $lang['company']; ?>
                </p>
            </td>
            <td class="myw">
                <?php
                $date = new DateTime($process['year'].'-'.$process['month']);
                $date = $date->format('F Y');
                ?>

                <?php echo $this->lang->line('Remuneration Receipt') .' '. $date?>
                <table class="table-right-info">
                    <tr>
                        <td class="td-label"> <?php echo $this->lang->line('Employee No.') ?>:</td>
                        <td class="td-val"><?php echo $employee['id']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('Name') ?>:</td>
                        <td class="td-val"><?php echo $employee['name']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('Prof Category') ?>:</td>
                        <?php 
                            if($employee['roleid'] == 5){
                                echo '<td class="td-val">'.$this->lang->line('Business Owner').'</td>';
                        } ?>
                        <?php 
                            if($employee['roleid'] == 4){
                            echo '<td class="td-val">'.$this->lang->line('Business Manager').'</td>';
                        } ?>
                        <?php 
                            if($employee['roleid'] == 3){
                            echo '<td class="td-val">'.$this->lang->line('Sales Manager').'</td>';
                        } ?>
                        <?php 
                            if($employee['roleid'] == 2){
                            echo '<td class="td-val">'.$this->lang->line('Sales Person').'</td>';
                        } ?>
                        <?php 
                            if($employee['roleid'] == 1){
                            echo '<td class="td-val">'.$this->lang->line('Inventory Manager').'</td>';
                        } ?>
                        <?php 
                            if($employee['roleid'] == -1){
                            echo '<td class="td-val">'.$this->lang->line('Project Manager').'</td>';
                        } ?>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('Department') ?>:</td>
                        <td class="td-val color-red"><?php echo $employee['departament']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('IRS Number') ?>:</td>
                        <td class="td-val color-red"><?php echo $employee['irs_number']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('NISS') ?>:</td>
                        <td class="td-val"><?php echo $employee['niss']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('NIB/DEP. Bank Officer') ?>:</td>
                        <td class="td-val"><?php echo $employee['account_bank']; ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('Salary/Hour') ?>:</td>
                        <td class="td-val color-red"><?php echo $process['single_hour_val'] ?></td>
                    </tr>
                    <tr>
                        <td class="td-label"><?php echo $this->lang->line('Base Remuneration') ?>:</td>
                        <td class="td-val"><?php echo $process['monthly_basic_salary'] ?></td>
                    </tr>
                    <?php if($process['faults_month'] > 0){ ?>
                        <tr>
                            <td class="td-label"><?php echo $this->lang->line('Faults') ?>:</td>
                            <td class="td-val"><?php echo $process['faults_month'].'- Just.: '.$process['faults_month_just'].' - Não Just.: '.$process['faults_month_not_just'] ?></td>
                        </tr>
                    <?php } ?>
                    <?php if($process['holidaysDaysMonth'] > 0){ ?>
                        <tr>
                            <td class="td-label"><?php echo $this->lang->line('Holidays') ?>:</td>
                            <td class="td-val"><?php echo $process['holidaysDaysMonth'] ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="td-label">Tipo IRS:</td>
                        <td class="td-val"><?php echo $employee['married'] ? "Casado" : "Not Married"; ?>  
						<?php 
						if($employee['type_irs'] == 1)
						{
							echo '<span>- NÃO CASADO </span>- ';
							
						}else if($employee['type_irs'] == 2)
						{
							echo '<span>- CASADO UNICO TITULAR </span>- ';
						}else if($employee['type_irs'] == 3)
						{
							echo '<span>- CASADO DOIS TITULARES </span>- ';
						}else if($employee['type_irs'] == 4)
						{
							echo '<span>- NÃO CASADO - DEFICIENTE </span>- ';
						}else if($employee['type_irs'] == 5)
						{
							echo '<span>- CASADO UNICO TITULAR - DEFICIENTE </span>- ';
						}else if($employee['type_irs'] == 6)
						{
							echo '<span>- CASADO DOIS TITULARES - DEFICIENTE </span>- ';
						}else
						{
							echo '<span>- Não Definido </span>- ';
						}
						
						echo $employee['number_children']. ' Crianca(s)';
						?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table border="1" cellpadding="0" cellspacing="0">
        <thead>
        <tr class="heading">
            <td><?php echo $this->lang->line('Code') ?>:</td>
            <td><?php echo $this->lang->line('Description') ?>:</td>
            <td><?php echo $this->lang->line('Time Course') ?>:</td>
            <td><?php echo $this->lang->line('Hours/Days/Month') ?>:</td>
            <td><?php echo $this->lang->line('Allowances') ?>:</td>
            <td><?php echo $this->lang->line('Tax.SS/IRS') ?>:</td>
            <td><?php echo $this->lang->line('Discounts') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td></td>
            <td><strong><?php echo $this->lang->line('Remunerations') ?></strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>1000</td>
            <td><?php echo $this->lang->line('Maturity Base') ?></td>
            <td><?php echo $time_course ?></td>
            <td><?php echo $process['days_work_in_month']. ' days' ?></td>
            <td><?php echo $process['matury_monthly_salary'] ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><strong><?php echo $this->lang->line('Complementary Payments') ?></strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>422</td>
            <td><?php echo $this->lang->line('Subs. Meal') ?>.</td>
            <td><?php echo $time_course ?></td>
            <td><?php echo $process['days_work_in_month']. ' days' ?></td>
            <td><?php echo $process['monthly_meal_subsidy']?></td>
            <td></td>
            <td></td>
        </tr>

        <?php if($process['monthly_vacations'] > 0){ ?>
            <tr>
                <td>521</td>
                <td><?php echo $this->lang->line('Vacations') ?></td>
                <td><?php echo $time_course ?></td>
                <td><?php echo $process['monthly_vacations']. ' days' ?></td>
                <td><?php echo $process['vacations_value']?></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>

        <?php if($process['attendance_hour_mont'] > 0){ ?>
            <tr>
                <td>621</td>
                <td><?php echo $this->lang->line('Attendance') ?></td>
                <td><?php echo $time_course ?></td>
                <td><?php echo $process['attendance_hour_mont']. ' hours' ?></td>
                <td><?php echo $process['attendance_hour_month_value']?></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
        
        <tr>
            <td>1204</td>
            <td><?php echo $this->lang->line('Premium Imp') ?></td>
            <td><?php echo $time_course ?></td>
            <td><?php echo $process['days_work_in_month']. ' days' ?></td>
            <td><?php echo $process['produtivity_month_value']?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>721</td>
            <td><?php echo $this->lang->line('this_month_sales') ?></td>
            <td><?php echo $time_course ?></td>
            <td><?php echo $process['days_work_in_month']. ' days' ?></td>
            <td><?php echo $process['saleDataCommissionsValue']?></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
            <td><strong><?php echo $this->lang->line('Legal Deductions') ?></strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>350</td>
            <td><?php echo $this->lang->line('Employee Contribution to.') ?></td>
            <td><?php echo $time_course ?></td>
            <td></td>
            <td></td>
            <td class="color-red"><?php echo $lang['ss_taxe']?></td>
            <td class="color-red"><?php echo $process['monthly_social_security']?></td>
        </tr>
        <tr>
            <td>401</td>
            <td><?php echo $this->lang->line('SS Tax Ded.') ?></td>
            <td><?php echo $time_course ?></td>
            <td></td>
            <td></td>
            <td class="color-red"><?php echo $process['irs_percen_use']?></td>
            <td class="color-red"><?php echo $process['monthly_irs']?></td>
        </tr>

        <?php if($process['total_debit'] > 0){ ?>
            <tr>
                <td></td>
                <td><strong><?php echo $this->lang->line('Net Deductions') ?></strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>821</td>
                <td><?php echo $this->lang->line('Total_Debit') ?></td>
                <td><?php echo $time_course ?></td>
                <td></td>
                <td><?php echo $process['total_debit']?></td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" >
                    <p>
                        <span><?php echo $this->lang->line('BC IRS Gross Income') ?>:</span>
                        <span><strong><?php echo $lang['bcgrossincom']; ?></strong></span>
                    </p>
                    <p>
                        <span><?php echo $this->lang->line('BC IRS Discounts') ?>:</span>
                        <span><strong><?php echo $lang['bctotirs']; ?></strong></span>
                    </p>
                    <p>
                        <span><?php echo $this->lang->line('BC SS Discount') ?>:</span>
                        <span><strong><?php echo $lang['bctotss']; ?></strong></span>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <span>Companhia:</span>
                        <span><?php echo $employee['medical_allowance'] ?></span>
                    </p>
                    <p>
                        <span><?php echo $this->lang->line('Policy No.') ?>:</span>
                        <span>000000000</span>
                    </p>
                </td>
                <td colspan="2" class="no-border-right">
                    <p>
                        <span>
                            <?php echo $this->lang->line('Totals') ?>:
                        </span>
                        <span><strong><?php echo $process['total_use_irs_ss'] ?></strong></span>
                    </p>
                    <p><br></p>
                    <p>
                        <span>
                            <?php echo $this->lang->line('Total_Credit') ?>:
                        </span>
                    </p>
                    <p> <?php echo $this->lang->line('Net Receivable') ?>:</p>
                    <p><?php echo $this->lang->line('Total Net') ?>:</p>
                </td>
                <td colspan="1" class="no-border-left">
                    <p><span><strong><?php echo $process['total_income'] ?></strong></span></p>
                    <p><br></p>
                    <p><span><strong><?php echo $process['total_credit']?></strong></span></p>
                    <p><span><strong><?php echo $process['total_net'] ?></strong></span></p>
                    <p><span><strong><?php echo $process['total_transfer'] ?></strong></span></p>
                </td>
            </tr>
        </tfoot>
    </table>
    <hr>

    <h3><?php echo $this->lang->line('Message of the month') ?></h3>
    <table>
        <tr>
            <td>
                <?php echo $process['monthly_message'] ?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
