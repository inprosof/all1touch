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

class Supplier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model', 'supplier');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(7)) {
            exit($this->lang->line('translate19'));
        }
		 $this->load->library("Custom");
        $this->li_a = 'suppliers';
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
		$this->load->library("Common");
        $data['customergrouplist'] = $this->supplier->group_list();
		$data['custom_fields'] = $this->custom->add_fields(4);
		$data['prazos_vencimento'] = $this->common->sprazovencimento();
		$data['langs'] = $this->common->languagesSystem();
		$data['expeditions'] = $this->common->sexpeditions();
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
		$data['nume_copys'] = $this->common->snum_copys();
		$data['countrys'] = $this->common->countrys();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
		$this->load->library("Common");
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);
        $data['customergroup'] = $this->supplier->group_info($data['details']['gid']);
        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['custom_fields'] = $this->custom->view_fields_data($custid, 4);
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        if ($data['details']['id']) 
			$data['due'] = $this->supplier->get_all_due_supplier($data['details']['id']);
			$this->load->view('supplier/view', $data);
        $this->load->view('fixed/footer');
    }
	
	
	public function search_supplier()
    {
		$out = array();
		$result = $this->supplier->listall();
		foreach ($result as $row) {
			$name = array($row['name'],$row['desc_glo'],$row['id']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
    public function load_list()
    {
        $list = $this->supplier->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $suppler) {
            $no++;
            $row = array();
            $row[] = $no;
			$colunaComplet = '<a href="supplier/view?id=' . $suppler->id . '">' . $suppler->name . '</a><br>';
			$colunaComplet .= $suppler->address.'<br>';
			$colunaComplet .= $suppler->postbox.' '.$suppler->city.' - '.$suppler->region.'<br>';
			$colunaComplet .= $suppler->country;
			
			$row[] = $colunaComplet;
			$row[] = $suppler->email.'<br>'.$suppler->phone;
			$row[] = $suppler->taxid;
			$dueSuppl = $this->supplier->get_all_due_supplier($suppler->id);
			$totdue = $dueSuppl['total']-$dueSuppl['pamnt'];
            $row[] = amountExchange($totdue, 0, $this->aauth->get_user()->loc);
			$row[] = '<a href="supplier/view?id=' . $suppler->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="supplier/edit?id=' . $suppler->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $suppler->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->count_all(),
            "recordsFiltered" => $this->supplier->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //edit section
    public function edit()
    {
        $this->load->model('supplier_model', 'supplier');
		$this->load->library("Common");
		$pid = $this->input->get('id');
		$data['supplier'] = $this->supplier->details($pid);
		$data['prazos_vencimento'] = $this->common->sprazovencimento();
		$data['langs'] = $this->common->languagesSystem();
		$data['expeditions'] = $this->common->sexpeditions();
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
		$data['nume_copys'] = $this->common->snum_copys();
		$data['countrys'] = $this->common->countrys();
        $data['customergroup'] = $this->supplier->group_info($pid);
        $data['customergrouplist'] = $this->supplier->group_list();
		$data['custom_fields'] = $this->custom->view_edit_fields($pid, 4);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function addsupplier()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company_1');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email', true);
        $country = "PT";
		$address = "Desconhecido";
		$city = "Desconhecido";
		$region = "Desconhecido";
		$postbox = "0000-000";
		$postbox = "0000-000";
		if(filter_has_var(INPUT_POST,'address')) {
			$address = $this->input->post('address');
		}
		if(filter_has_var(INPUT_POST,'city')) {
			$city = $this->input->post('city');
		}
		if(filter_has_var(INPUT_POST,'region')) {
			$region = $this->input->post('region');
		}
		
        if(filter_has_var(INPUT_POST,'postbox')) {
			$postbox = $this->input->post('postbox');
		}
        if(filter_has_var(INPUT_POST,'country') ) {
			if($this->input->post('country') != "0" || $this->input->post('country') != 0){
				$country = $this->input->post('country');
			}
		}
        $taxid = $this->input->post('taxid', true);
		$website = $this->input->post('website');
		$n_ative = $this->input->post('n_ative');
		$n_lang = $this->input->post('n_lang');
		$desc_glo = $this->input->post('desc_glo');
		$limit_cre = $this->input->post('limit_cre');
		$n_praz_venc = $this->input->post('n_praz_venc');
		$n_copy = $this->input->post('n_copy');
		$n_met_pag = $this->input->post('n_met_pag');
		$n_met_exp = $this->input->post('n_met_exp');
		$obs = $this->input->post('obs');
		
        $this->supplier->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $taxid, $website, $n_ative,$n_lang,$desc_glo,$limit_cre,$n_praz_venc,$n_copy,$n_met_pag,$n_met_exp,$obs);
		
    }

    public function editsupplier()
    {
        $id = $this->input->post('id', true);
        $name = $this->input->post('name', true);
        $company = $this->input->post('company_1');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email', true);
		
		$country = "PT";
		$address = "Desconhecido";
		$city = "Desconhecido";
		$region = "Desconhecido";
		$postbox = "0000-000";
		$postbox = "0000-000";
		if(filter_has_var(INPUT_POST,'address')) {
			$address = $this->input->post('address');
		}
		if(filter_has_var(INPUT_POST,'city')) {
			$city = $this->input->post('city');
		}
		if(filter_has_var(INPUT_POST,'region')) {
			$region = $this->input->post('region');
		}
		
        if(filter_has_var(INPUT_POST,'postbox')) {
			$postbox = $this->input->post('postbox');
		}
        if(filter_has_var(INPUT_POST,'country')) {
			$country = $this->input->post('country');
		}
        $taxid = $this->input->post('taxid', true);
		$website = $this->input->post('website');
		$n_ative = $this->input->post('n_ative');
		$n_lang = $this->input->post('n_lang');
		$desc_glo = $this->input->post('desc_glo');
		$limit_cre = $this->input->post('limit_cre');
		$n_praz_venc = $this->input->post('n_praz_venc');
		$n_copy = $this->input->post('n_copy');
		$n_met_pag = $this->input->post('n_met_pag');
		$n_met_exp = $this->input->post('n_met_exp');
		$obs = $this->input->post('obs');
		
        if ($id) {
            $this->supplier->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $taxid, $website, $n_ative,$n_lang,$desc_glo,$limit_cre,$n_praz_venc,$n_copy,$n_met_pag,$n_met_exp,$obs);
        }
    }

	public function displaypic()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('supplier_model', 'supplier');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/suppliers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->supplier->editpicture($id, $img);
        }


    }

    public function delete_i()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');

        if ($this->supplier->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function translist()
    {
        $cid = $this->input->post('cid');
        $list = $this->supplier->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->trans_count_all($cid),
            "recordsFiltered" => $this->supplier->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function purchase_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->supplier->purcha_datatables($cid);
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
			$no++;
            $row = array();
            $row[] = $no;
			$row[] = $invoices->serie_name;
			$row[] = '<a href="' . base_url("purchase/view?id=$invoices->id&ty=0") . '">&nbsp; ' . $invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
			if($invoices->status != 'ended'){
				$row[] = '<a href="' . base_url("purchase/view?id=$invoices->id&ty=0") . '" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id&ty=0") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("purchase/view?id=$invoices->id&ty=0") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id&ty=0") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
			}
			$data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->purcha_count_all($cid),
            "recordsFiltered" => $this->supplier->purcha_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
	
	
    public function invoice_list()
    {
		$cid = $this->input->post('cid');
		$typ = $this->input->post('typ');
		if($typ != '' && $typ != null)
		{
			$typ = 1;
		}else {
			$typ = 0;
		}
        $list = $this->supplier->invoice_datatables($cid,$typ);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
			$row = array();
			$row[] = $invoices->serie_name;
            $row[] = '<a href="' . base_url("invoices_supli/view?id=$invoices->id&ty=0") . '">'.$invoices->type.'/'. $invoices->tid . '</a>';
			$row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->name;
            $row[] = $invoices->taxid;
			$row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            if($invoices->status == 'canceled'){
				$row[] = '<a href="' . base_url("invoices_supli/view?id=$invoices->id&ty=0") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices_supli/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("invoices_supli/view?id=$invoices->id&ty=0") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices_supli/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" data-object-draft="1" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->supplier->invoice_count_all($cid),
            "recordsFiltered" => $this->supplier->invoice_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	
	public function products()
    {
        $custid = $this->input->get('id');
		$data['details'] = $this->supplier->details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Products Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/products', $data);
        $this->load->view('fixed/footer');
    }

    public function transactions()
    {
        $custid = $this->input->get('id');
		$data['details'] = $this->supplier->details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Transitions';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/transactions', $data);
        $this->load->view('fixed/footer');
    }
    public function purchaseorder()
    {
        $custid = $this->input->get('id');
		$data['details'] = $this->supplier->details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Purchase';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/purchase', $data);
        $this->load->view('fixed/footer');
    }
	
	public function invoices()
    {
        $custid = $this->input->get('id');
		$data['details'] = $this->supplier->details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/invoices', $data);
        $this->load->view('fixed/footer');
    }
	
	function statement()
    {
        if ($this->input->post()) {

            $this->load->model('reports_model');
			$this->load->model('settings_model', 'settings');
			$this->load->model('invoices_model', 'invocies');
			
            $supplier = $this->input->post('supplier');
            $trans_type = $this->input->post('trans_type');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
            $data['supplier'] = $this->supplier->details($supplier);
			$data['company'] = $this->settings->company_details2($this->aauth->get_user()->loc);
            $data['list'] = $this->reports_model->get_supplier_statements($supplier, $trans_type, $sdate, $edate);
			$data['employee'] = $this->supplier->employee($this->aauth->get_user()->id);
			$debitSupplier = $this->reports_model->get_supplier_debit($supplier);
			
			$debitPreviousSupplier = $this->reports_model->get_supplier_previous_debit($supplier, $trans_type, $sdate, $edate);
			if($debitPreviousSupplier['debit'] == null)
			{
				$data['debitPrevious'] = '0.00';
			}else{
				$data['debitPrevious'] = $debitPreviousSupplier['debit'];
			}
			$creditPreviousSupplier = $this->reports_model->get_supplier_previous_credit($supplier, $trans_type, $sdate, $edate);
			if($creditPreviousSupplier['credit'] == null)
			{
				$data['creditPrevious'] = '0.00';
			}else{
				$data['creditPrevious'] = $creditPreviousSupplier['credit'];
			}
			
			
			if($debitSupplier['debit'] == null)
			{
				$data['debit'] = '0.00';
			}else{
				$data['debit'] = $debitSupplier['debit'];
			}
			$creditSupplier = $this->reports_model->get_supplier_credit($supplier);
			if($creditSupplier['credit'] == null)
			{
				$data['credit'] = '0.00';
			}else{
				$data['credit'] = $creditSupplier['credit'];
			}
            $html = $this->load->view('supplier/statementpdf', $data, true);
            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        } else {
            $data['id'] = $this->input->get('id');
			$data['details'] = $this->supplier->details($data['id']);
            $head['title'] = "Account Statement";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('supplier/statement', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function bulkpayment()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->supplier->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Bulk Payment Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/bulkpayment', $data);
        $this->load->view('fixed/footer');
    }

    public function bulk_post()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $csd = $this->input->post('customer', true);
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $trans_type = $this->input->post('trans_type', true);
        $data['details'] = $this->supplier->sales_due($sdate, $edate, $csd, $trans_type);
        $due = $data['details']['total'] - $data['details']['pamnt'];
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated') . ' ' . amountExchange($due), 'due' => amountExchange_s($due)));
    }

    public function bulk_post_payment()
    {
        if (!$this->aauth->premission(8)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $csd = $this->input->post('customer', true);
        $account = $this->input->post('account', true);
        $pay_method = $this->input->post('pmethod', true);
        $amount = numberClean($this->input->post('amount', true));
        $sdate = datefordatabase($this->input->post('sdate_2'));
        $edate = datefordatabase($this->input->post('edate_2'));

        $trans_type = $this->input->post('trans_type_2', true);
        $note = $this->input->post('note', true);
        $data['details'] = $this->supplier->sales_due($sdate, $edate, $csd, $trans_type, false, $amount, $account, $pay_method, $note);

        $due = 0;
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Paid') . ' ' . amountExchange($amount), 'due' => amountExchange_s($due)));
    }


}