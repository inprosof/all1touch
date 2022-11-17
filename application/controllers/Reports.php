<?php
/**
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above PCTECKSERV notice.
 *  *
 *  *
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model', 'reports');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(10)) {

            exit($this->lang->line('translate19'));

        }
        $this->li_a = 'data';
    }

    public function index()
    {
    }

    //Statistics

    public function statistics()
    {
        $data['stat'] = $this->reports->statistics();
        $head['title'] = "Statistics";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/stat', $data);
        $this->load->view('fixed/footer');
    }

    //accounts section

    public function accountstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/statement', $data);
        $this->load->view('fixed/footer');

    }

    public function customerstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/customer_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function supplierstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/supplier_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function viewstatement()

    {
        $this->load->model('accounts_model', 'accounts');
        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $account = $this->accounts->details($pay_acc);
        $data['filter'] = array($pay_acc, $trans_type, $sdate, $edate, $ttype, $account['holder']);
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/statement_list', $data);
        $this->load->view('fixed/footer');
    }

    public function customerviewstatement()

    {
        $this->load->model('customers_model', 'customer');
        $cid = $this->input->post('customer');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $customer = $this->customer->details($cid);
		if($customer != null){
			$data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);

			//  print_r( $data['statement']);
			$head['title'] = "Customer Account Statement";
			$head['usernm'] = $this->aauth->get_user()->username;
			$this->load->view('fixed/header', $head);
			$this->load->view('reports/customerstatement_list', $data);
			$this->load->view('fixed/footer');
		}else{
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor selecione um Cliente.'));
		}
    }

    public function supplierviewstatement()
    {
        $this->load->model('supplier_model', 'supplier');
        $cid = $this->input->post('supplier');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $customer = $this->supplier->details($cid);
		if($customer != null){
			$data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);

			//  print_r( $data['statement']);
			$head['title'] = "Supplier Account Statement";
			$head['usernm'] = $this->aauth->get_user()->username;
			$this->load->view('fixed/header', $head);
			$this->load->view('reports/supplierstatement_list', $data);
			$this->load->view('fixed/footer');
		}else{
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor selecione um Fornecedor.'));
		}
    }


    //

    public function statements()
    {
        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));
        $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;

        foreach ($list as $row) {
            $balance += $row['credit'] - $row['debit'];
            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
        }

    }

    public function customerstatements()
    {
        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));
		
        $list = $this->reports->get_customer_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;

        foreach ($list as $row) {
            $balance += $row['credit'] - $row['debit'];
            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
        }

    }

    public function supplierstatements()
    {
        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));

        $list = $this->reports->get_supplier_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;

        foreach ($list as $row) {
            $balance += $row['debit'] - $row['credit'];
            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
        }
    }


    // income section


    public function incomestatement()

    {
        $head['title'] = "Income Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);

        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $data['income'] = $this->reports->incomestatement();


        $this->load->view('reports/incomestatement', $data);


        $this->load->view('fixed/footer');

    }


    public function customincome()
    {

        if ($this->input->post('check')) {
            $acid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 365) {
                $income = $this->reports->customincomestatement($acid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr><b>Income between the dates is ' . amountExchange($income['credit'], 0, $this->aauth->get_user()->loc) . '</b>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        }
    }

    // expense section


    public function expensestatement()

    {
        $head['title'] = "Expense Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);

        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $data['income'] = $this->reports->expensestatement();


        $this->load->view('reports/expensestatement', $data);


        $this->load->view('fixed/footer');

    }


    public function customexpense()
    {

        if ($this->input->post('check')) {
            $acid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 365) {
                $income = $this->reports->customexpensestatement($acid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr><b>Expense between the dates is ' . amountExchange($income['debit'], 0, $this->aauth->get_user()->loc) . '</b>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        }

    }


    public function refresh_data()

    {


        $head['title'] = "Refreshing Reports";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/refresh_data');
        $this->load->view('fixed/footer');

    }

    public function refresh_process()

    {

        $this->load->model('cronjob_model');
        if ($this->cronjob_model->reports()) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated')));
        }

    }

    public function taxstatement()
    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "TAX Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/tax_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function taxviewstatement()
    {
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $lid = $this->input->post('lid');
        $data['filter'] = array($sdate, $edate, $trans_type, $lid);


        //  print_r( $data['statement']);
        $head['title'] = "TAX Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/tax_out', $data);
        $this->load->view('fixed/footer');


    }

    public function taxviewstatements_load()
    {
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));
        $lid = $this->input->post('loc');

        if ($trans_type == 'Sales') {
            $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate') AND geopos_invoices.ext = 0";
            if ($lid > 0) 
				$where .= " AND (geopos_invoices.loc=$lid)";
            $query = $this->db->query("SELECT geopos_invoices.id as invoic_id, geopos_invoices.tid AS invoice_number, geopos_invoices.csd as invo_csd, geopos_customers.taxid AS VAT_Number,geopos_series.serie AS serie_name, geopos_series.atc AS atc_serie, geopos_irs_typ_doc.type AS irs_type_s,geopos_invoices.tid AS invoice_number,geopos_invoices.total AS amount,geopos_invoices.tax AS tax,geopos_customers.name AS customer_name,geopos_customers.company AS Company_Name,geopos_invoices.invoicedate AS date 
			FROM geopos_invoices 
			LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id
			LEFT JOIN geopos_series ON geopos_invoices.serie = geopos_series.id
			LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id" . $where);
        }else if ($trans_type == 'Sales2') {
            $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate' ) AND geopos_invoices.ext = 1";
			if ($lid > 0) 
				$where .= " AND (geopos_invoices.loc=$lid)";
            $query = $this->db->query("SELECT geopos_invoices.id as invoic_id, geopos_invoices.tid AS invoice_number, geopos_invoices.csd as invo_csd, geopos_supplier.taxid AS VAT_Number,geopos_series.serie AS serie_name, geopos_series.atc AS atc_serie, geopos_irs_typ_doc.type AS irs_type_s,geopos_invoices.tid AS invoice_number,geopos_invoices.total AS amount,geopos_invoices.tax AS tax,geopos_supplier.name AS customer_name,geopos_supplier.company AS Company_Name,geopos_invoices.invoicedate AS date 
			FROM geopos_invoices 
			LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id
			LEFT JOIN geopos_series ON geopos_invoices.serie = geopos_series.id
			LEFT JOIN geopos_supplier ON geopos_invoices.csd=geopos_supplier.id" . $where);
        }else if ($trans_type == 'Purchase') {
			$where = " WHERE (DATE(geopos_purchase.invoicedate) BETWEEN '$sdate' AND '$edate') AND geopos_purchase.ext = 0";
            if ($lid > 0) $where .= " AND (geopos_invoices.loc=$lid)";
            $query = $this->db->query("SELECT geopos_purchase.id as invoic_id, geopos_purchase.tid AS invoice_number, geopos_purchase.csd as invo_csd, geopos_customers.taxid AS VAT_Number,geopos_series.serie AS serie_name, geopos_series.atc AS atc_serie, geopos_irs_typ_doc.type AS irs_type_s,geopos_purchase.tid AS invoice_number,geopos_purchase.total AS amount,geopos_purchase.tax AS tax,geopos_customers.name AS customer_name,geopos_customers.company AS Company_Name,geopos_purchase.invoicedate AS date 
			FROM geopos_purchase 
			LEFT JOIN geopos_irs_typ_doc ON geopos_purchase.irs_type = geopos_irs_typ_doc.id
			LEFT JOIN geopos_series ON geopos_purchase.serie = geopos_series.id
			LEFT JOIN geopos_customers ON geopos_purchase.csd=geopos_customers.id" . $where);
		}else {
            $where = " WHERE (DATE(geopos_purchase.invoicedate) BETWEEN '$sdate' AND '$edate') AND geopos_purchase.ext = 1";
            if ($lid > 0) $where .= " AND (geopos_invoices.loc=$lid)";
            $query = $this->db->query("SELECT geopos_purchase.id as invoic_id, geopos_supplier.taxid AS VAT_Number,geopos_series.serie AS serie_name, 
			geopos_series.atc AS atc_serie, 
			geopos_irs_typ_doc.type AS irs_type_s,
			geopos_purchase.tid AS invoice_number,
			geopos_purchase.total AS amount,
			geopos_purchase.tax AS tax,
			geopos_purchase.csd as invo_csd,
			geopos_supplier.name AS customer_name,geopos_supplier.company AS Company_Name,geopos_purchase.invoicedate AS date 
			FROM geopos_purchase 
			LEFT JOIN geopos_irs_typ_doc ON geopos_purchase.irs_type = geopos_irs_typ_doc.id
			LEFT JOIN geopos_series ON geopos_purchase.serie = geopos_series.id
			LEFT JOIN geopos_supplier ON geopos_purchase.csd=geopos_supplier.id" . $where);
        }


//echo $where;


        $balance = 0;

        foreach ($query->result_array() as $row) {
            $balance += $row['tax'];
			$vamosimp = '<tr>';
			if($trans_type == 'Sales')
			{
				$vamosimp .= '<td><a href="' . base_url("invoices/view?id=".$row['invoic_id']) . '">'.$row['serie_name'].' '. $row['irs_type_s'].'/' . $row['invoice_number']. '</a></td>';
				$vamosimp .= '<td><a href="' . base_url("customers/view?id=".$row['invo_csd']) . '">'.$row['customer_name']. '</a></td>';
			}else if($trans_type == 'Sales2'){
				$vamosimp .= '<td><a href="' . base_url("invoices_supli/view?id=".$row['invoic_id']) . '">'.$row['serie_name'].' '. $row['irs_type_s'].'/' . $row['invoice_number']. '</a></td>';
				$vamosimp .= '<td><a href="' . base_url("supplier/view?id=".$row['invo_csd']) . '">'.$row['customer_name']. '</a></td>';
			}else if($trans_type == 'Purchase'){
				$vamosimp .= '<td><a href="' . base_url("purchase/view?id=".$row['invoic_id'].'&ty=0') . '">'.$row['serie_name'].' '. $row['irs_type_s'].'/' . $row['invoice_number']. '</a></td>';
				$vamosimp .= '<td><a href="' . base_url("customers/view?id=".$row['invo_csd']) . '">'.$row['customer_name']. '</a></td>';
			}else{
				$vamosimp .= '<td><a href="' . base_url("purchase/view?id=".$row['invoic_id'].'&ty=1') . '">'.$row['serie_name'].' '. $row['irs_type_s'].'/' . $row['invoice_number']. '</a></td>';
				$vamosimp .= '<td><a href="' . base_url("supplier/view?id=".$row['invo_csd']) . '">'.$row['customer_name']. '</a></td>';
			}
			
            echo $vamosimp.'<td>' . $row['VAT_Number'] . '</td><td>' . amountExchange($row['amount'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['tax'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
        }
    }

    // profit section


    public function profitstatement()

    {
        $head['title'] = "Profit Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);

        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $data['income'] = $this->reports->profitstatement();


        $this->load->view('reports/profitstatement', $data);


        $this->load->view('fixed/footer');

    }


    public function customprofit()
    {

        if ($this->input->post('check')) {
            $lid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            if ($this->aauth->get_user()->loc) {
                $lid = $this->aauth->get_user()->loc;
            }

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 365) {
                $income = $this->reports->customprofitstatement($lid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr> Profit between the dates is ' . amountExchange($income['col1'], 0, $this->aauth->get_user()->loc) . ' '));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        }
    }

    // profit section


    public function sales()

    {
        $head['title'] = "Sales Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);

        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list();
        $data['income'] = $this->reports->salesstatement();


        $this->load->view('reports/sales', $data);


        $this->load->view('fixed/footer');

    }


    public function customsales()
    {

        if ($this->input->post('check')) {
            $lid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            if ($this->aauth->get_user()->loc) {
                $lid = $this->aauth->get_user()->loc;
            }

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 365) {
                $income = $this->reports->customsalesstatement($lid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr> Sales between the dates is ' . amountExchange($income['total'], 0, $this->aauth->get_user()->loc) . ''));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }
        }
    }

    // products section
    public function products()
    {
        $head['title'] = "Products Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->model('locations_model');
        $this->load->model('categories_model');
        $data['locations'] = $this->locations_model->locations_list();
        $data['cat'] = $this->categories_model->category_list_completa();
        $data['income'] = $this->reports->productsstatement();
        $this->load->view('reports/products', $data);
        $this->load->view('fixed/footer');
    }


    public function customproducts()
    {
        if ($this->input->post('check')) {
            $lid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);
            $diff = $date2->diff($date1)->format("%a");
            if ($this->aauth->get_user()->loc) {
                $lid = $this->aauth->get_user()->loc;
            }
            if ($diff < 365) {
                $income = $this->reports->customproductsstatement($lid, $sdate, $edate);
                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr>Product Sales between the dates is ' . amountExchange($income['subtotal'], 0, $this->aauth->get_user()->loc) . ' <br> Qty between the dates is ' . amountFormat_general($income['qty']) . '.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        }
    }

    public function customproducts_cat()
    {
        if ($this->input->post('check')) {
            $lid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);
            $diff = $date2->diff($date1)->format("%a");
            if ($this->aauth->get_user()->loc) {
                $lid = $this->aauth->get_user()->loc;
            }
            if ($diff < 365) {
                $income = $this->reports->customproductsstatement_cat($lid, $sdate, $edate);
                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr>Product Sales between the dates is ' . amountExchange($income['subtotal'], 0, $this->aauth->get_user()->loc) . ' Qty between the dates is ' . amountFormat_general($income['qty']) . '.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        }
    }

    public function fetch_data()
    {
        if ($this->input->get('p')) {

            $data = $this->reports->fetchdata($this->input->get('p'));
            echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'p1' => $data['p1'], 'p2' => $data['p2'], 'p3' => $data['p3'], 'p4' => $data['p4']));
        }
    }

    public function commission()

    {
        if ($this->input->post('check')) {
            $lid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            if ($this->aauth->get_user()->loc) {
                $lid = $this->aauth->get_user()->loc;
            }

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 365) {
                $commission = $this->reports->customcommission($lid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => 'Commission between the dates is ' . amountExchange($commission, 0, $this->aauth->get_user()->loc)));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));
            }

        } else {
            $head['title'] = "Commission";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);

            $this->load->model('employee_model');
            $data['employee'] = $this->employee_model->list_employee();

            $this->load->view('reports/commission', $data);


            $this->load->view('fixed/footer');
        }

    }


}