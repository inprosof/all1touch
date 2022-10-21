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
require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

				   																							
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\EscposImage;

use Omnipay\Omnipay;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;	


class Pos_invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_invoices_model', 'invocies');

        $this->load->model('extended_invoices_model', 'extended_invoice');
        $this->load->library("Aauth");
        $this->load->library("Registerlog");
        $this->load->library("Common");

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit($this->lang->line('translate19'));
        }
        if ($this->aauth->get_user()->roleid == 2) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }
        $this->load->library("Custom");
        $this->li_a = 'sales';
		$this->tipSelec = 0;
    }

    //create invoice
    public function create()
    {
        if (!$this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('register/create');
        }
		$this->load->model('locations_model', 'locations');
		$this->load->model('accounts_model');
        $this->load->model('customers_model', 'customers');
        $this->load->model('categories_model');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
        $this->load->library("Common");
        $data['custom_fields_c'] = $this->custom->add_fields(1);
		
		////////////////////////Relação entre documentos//////////////////////
		///////////////////////////////////////////////////////////////////////
		$data['autos'] = $this->common->guide_autos_company();
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
		}
		
		if($discship['ac_id_d'] == 0 && $discship['pac'] == 0)
		{
			if($this->aauth->get_user()->loc == 0)
			{
				exit('Defina a conta Por defeito para os Documentos na Empresa! <a class="match-width match-height" href="'.base_url().'settings/company?id=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}else{
				exit('Defina a conta Por defeito para os Documentos na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}
		}else{
			if($discship['ac_id_d'] == 0)
			{
				if($this->aauth->get_user()->loc){
					exit('Defina a conta Por defeito para os Documentos na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
				}
			}
			$accountin = $this->accounts_model->details($discship['ac_id_d'],false);
			$accountincome = ((integer)$accountin['id']);
			$accountincomename = $accountin['holder'];
			$data['accountid'] = $accountincome;
			$data['accountname'] = $accountincomename;
		}
		
		$data['configs'] = $discship;
		$data['permissoes'] = $this->settings->permissions_loc($this->aauth->get_user()->loc);
		
        if ($discship['emps'] == 1) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
		if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$data['locations'] = $this->settings->company_details(1);
		}else{
			$data['locations'] = $this->settings->company_details2($this->aauth->get_user()->loc);
		}
		
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['enable_card'] = $this->plugins->universal_api(54);
        $data['draft_list'] = $this->invocies->drafts();
		
		$this->tipSelec = 0;
		if($this->aauth->get_user()->loc)
		{
			$this->tipSelec = $this->common->default_typ_id_doc(4);
			if(count($this->settings->billingterms($this->tipSelec)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo Definido na Localização. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}else{
				$data['terms'] =$this->settings->billingterms($this->common->default_typ_id_doc($this->tipSelec));
			}
		}else{
			if ($data['configs']['doc_default'] == 0) {
				$this->tipSelec = 2;
				if(count($this->settings->billingterms(2)) == 0)
				{
					exit('Deve Inserir pelo menos um Termo para o Tipo Fatura Recibo. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
														class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
				}
				$data['terms'] =$this->settings->billingterms(2);
			}else{
				$this->tipSelec = $data['configs']['doc_default'];
				if(count($this->settings->billingterms($this->tipSelec)) == 0)
				{
					exit('Deve Inserir pelo menos um Termo para o Tipo Definido para o POS. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
														class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
				}
				$data['terms'] =$this->settings->billingterms($this->tipSelec);
			}
		}
        
        $data['currency'] = $this->invocies->currencies();
        $data['cat'] = $this->categories_model->category_list_completa();
        $data['taxdetails'] = $this->common->taxdetail();
		$data['exchange'] = $this->plugins->universal_api(5);
		$data['company'] = $this->settings->company_details(1);
        $data['customergrouplist'] = $this->customers->group_list();
		$data['countrys'] = $this->common->countrys();
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['warehouse'] = $this->invocies->warehouses();	
		$data['typesinvoices'] = $this->settings->list_irs_typ_id_fact();
		$data['typesinvoicesdefault'] = $this->common->default_typ_doc($this->tipSelec);
		$invoi_type = $this->common->default_typ_id_doc($this->tipSelec);
		$data['seriesinvoiceselect'] = $this->common->default_series($this->aauth->get_user()->loc);
		if($data['seriesinvoiceselect'] == NULL)
		{
			exit('Ainda não definiu nenhuma série para esta Localização. <a class="match-width match-height"  href="'.base_url().'settings/series"><i class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}else{
			$seri_did_df = $this->common->default_series_id($this->aauth->get_user()->loc);
			$numget = $this->common->lastdoc($this->tipSelec,$seri_did_df);
			$data['lastinvoice'] = $numget;
			$head['title'] = "Novo Documento POS";
			$head['usernm'] = $this->aauth->get_user()->username;
			$head['s_mode'] = false;
			$this->load->view('fixed/header-pos', $head);
			$this->load->view('pos/newinvoice', $data);
			$this->load->view('fixed/footer-pos');
		}
		
			
        /*if ($this->input->get('v2')=='true' or POSV == 2) {
            $head['s_mode'] = false;
            $this->load->view('fixed/header-pos', $head);
            $this->load->view('pos/newinvoice_v2', $data);
        } else {
            $head['s_mode'] = true;
            $this->load->view('fixed/header-pos', $head);
            $this->load->view('pos/newinvoice', $data);
        }*/
        
    }


    public function draft()
    {
		$this->load->model('locations_model', 'locations');
		$this->load->model('accounts_model');
        $this->load->model('customers_model', 'customers');
        $this->load->model('categories_model');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
        $this->load->library("Common");
		$tid = $this->input->get('id');
        $data['id'] = $tid;
		$data['invoice'] = $this->invocies->draft_details($tid, $this->limited);
        if ($data['invoice']['id'])
			$data['products'] = $this->invocies->draft_products($tid);
        $data['title'] = "Draft POS Invoice #$tid";
		$head['title'] = "Draft POS Invoice #$tid";
		$data['custom_fields_c'] = $this->custom->add_fields(1);
		
		$discship = $this->plugins->universal_api(65);
		if($data['invoice']['loc'] == 0)
		{
			$data['accounts'] = $this->locations->accountslist();
			$data['accountid'] = $discship['key2'];
			$data['accountname'] = "Conta Por Defeito";
		}else{
			$accountin = $this->accounts_model->details($discship['key2'],false);
			$accountincome = ((integer)$accountin['id']);
			$accountincomename = $accountin['holder'];
			$data['accountid'] = $accountincome;
			$data['accountname'] = $accountincomename;
		}
		
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['enable_card'] = $this->plugins->universal_api(54);
        $data['draft_list'] = $this->invocies->drafts();
        
        $data['currency'] = $this->invocies->currencies();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list_completa();
        $data['taxdetails'] = $this->common->taxdetail();
		$data['exchange'] = $this->plugins->universal_api(5);
		$data['company'] = $this->settings->company_details(1);
        $data['customergrouplist'] = $this->customers->group_list();
		$data['countrys'] = $this->common->countrys();
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['warehouse'] = $this->invocies->warehouses();
		$data['typesinvoices'] = $this->settings->list_irs_typ_id_fact();
		
		$this->load->model('settings_model', 'settings');
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
		}
		$data['configs'] = $discship;
		$data['permissoes'] = $this->settings->permissions_loc($this->aauth->get_user()->loc);
		$this->tipSelec = 0;
		if($this->aauth->get_user()->loc)
		{
			$this->tipSelec = $this->common->default_typ_id_doc(4);
			if(count($this->settings->billingterms($this->tipSelec)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo Definido na Localização. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}else{
				$data['terms'] =$this->settings->billingterms($this->common->default_typ_id_doc($this->tipSelec));
			}
		}else{
			if ($data['configs']['doc_default'] == 0) {
				$this->tipSelec = 2;
				if(count($this->settings->billingterms(2)) == 0)
				{
					exit('Deve Inserir pelo menos um Termo para o Tipo Fatura Recibo. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
														class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
				}
				$data['terms'] =$this->settings->billingterms(2);
			}else{
				$this->tipSelec = $data['configs']['doc_default'];
				if(count($this->settings->billingterms($this->tipSelec)) == 0)
				{
					exit('Deve Inserir pelo menos um Termo para o Tipo Definido para o POS. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
														class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
				}
				$data['terms'] =$this->settings->billingterms($this->tipSelec);
			}
		}
		
		$data['typesinvoicesdefault'] = $this->common->default_typ_doc($this->tipSelec);
		$invoi_type = $this->common->default_typ_id_doc($this->tipSelec);
		$data['seriesinvoiceselect'] = $this->common->default_series($this->aauth->get_user()->loc);
		$seri_did_df = $this->common->default_series_id($this->aauth->get_user()->loc);
		$numget = $this->common->lastdoc($this->tipSelec,$seri_did_df);
		
		$data['typesinvoices'] = $this->settings->list_irs_typ_id_fact();
		$data['lastinvoice'] = $numget;
        if ($discship['emps'] == 1) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
        $head['s_mode'] = false;
		$this->load->view('fixed/header-pos', $head);
		if ($data['invoice']['id'])
			$this->load->view('pos/draft', $data);
        $this->load->view('fixed/footer-pos');
    }


    //edit invoice
    public function edit()
    {
        if (!$this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('register/create');
        }
		
		if (!$this->aauth->premission(16)) {
			exit($this->lang->line('translate19'));
        }
        $head['s_mode'] = false;
        $this->load->model('categories_model');
        $data['gateway'] = $this->invocies->gateway_list('Yes');
        $tid = $this->input->get('id');
        $data['id'] = $tid;
		
		$this->load->model('settings_model', 'settings');
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['currency'] = $this->invocies->currencies();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['cat'] = $this->categories_model->category_list_completa();
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
        $this->load->view('fixed/header-pos', $head);
        if ($data['invoice']['id']) $this->load->view('pos/edit', $data);
        $this->load->view('fixed/footer-pos');
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('pos/invoices');
        $this->load->view('fixed/footer');
    }

        //invoices list
    public function extended()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('pos/extended');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {
		$this->load->model('accounts_model');
		$this->load->model('customers_model', 'customers');
		$this->load->model('settings_model', 'settings');
		
		$v2 = $this->input->get('v2');
        $ptype = $this->input->post('type');
        $coupon = $this->input->post('coupon');
        $notes = $this->input->post('notes', true);
        $draft_id = $this->input->post('draft_id');
        $coupon_amount = 0;
        $coupon_n = '';
        
        $currency = $this->input->post('mcurrency');
		if($currency == null || $currency="" || $currency="0"){
			$currencyCOde = $this->accounts_model->getCurrency();
			$currency = $currencyCOde['id'];
		}
		$customer_id = ((integer)$this->input->post('customer_id'));
		
		$account_set_id = $this->input->post('account_set_id');
		$account_set = $this->input->post('account_set');
		if ($account_set_id == 0 || $account_set_id == "0") {
			if($this->aauth->get_user()->loc == 0)
			{
				echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecione uma Conta.'));
			}else{
				echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecione uma Conta. Ou então defina na parte Configurações de Negócios->Locais da Empresa'));
			}
            exit;
        }
		$invocieencorc = $this->input->post('invocieencorc');
		
		$customer_info = $this->customers->recipientinfo($customer_id);
        $customer_name = $customer_info['name'];
		$customer_tax = $this->input->post('customer_tax');
        $invoicedate = $this->input->post('invoicedate', true);
        $invocieduedate = $this->input->post('invocieduedate', true);
        $notes = $this->input->post('notes', true);
		
		$invoi_type = $this->input->post('invoi_type', true);
		$invoi_serie = $this->input->post('invoi_serie', true);
		
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = $this->input->post('disc_val');
		$discs_come = $this->input->post('discs_come');
		
		$taxas_tota = $this->input->post('taxas_tota');
		
        $subtotal = $this->input->post('subttlform_val');
        $shipping = $this->input->post('shipping');
        $shipping_tax = $this->input->post('ship_tax');
		
        $refer = $this->input->post('refer', true);
        $total = $this->input->post('totalpay');
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount_tax = $this->input->post('discs_tot_val');
        $discountFormat = $this->input->post('discountFormat');
		$tax = $this->input->post('tax_handle');
		$warehouse = $this->input->post('s_warehouses', true);
        $pterms = $this->input->post('pterms', true);
		$tota_items = $this->input->post('tota_items');
        $i = 0;
		$metretnotqo = "";
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecionar um cliente'));
            exit;
        }
		
		if(!filter_has_var(INPUT_POST,'product_name')) {
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir um Produto'));
            exit;
		}

        $this->load->model('settings_model', 'settings');
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
		}
		$emp = 0;
		if ($discship['emps'] == 1) {
            $emp = $this->input->post('employee');
        }else{
			$emp = $this->aauth->get_user()->id;
		}
        $print_now = $this->input->post('printnow');
        $this->load->model('plugins_model', 'plugins');
		
		$this->load->library("Common");
		if($total > 100 && $invoi_type != 2)
		{
			$invoi_type = 2;
		}
		
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$invocieno = $numget+1;
		$transok = true;
        if ($ptype == 4) {
            $p_amount = $this->input->post('p_amount');
            $pmethod = $this->input->post('p_method');
			
			$c_amt = $p_amount;
            $c_amt_v = $p_amount - $total;
            if ($c_amt_v == 0.00) {
                $status = 'Paid';
                $pamnt = $total;
            } elseif ($c_amt_v < 0.00) {
                $status = 'Partial';
                if ($p_amount == 0.00) 
					$status = 'Due';
                $pamnt = $p_amount;
                $c_amt_v = 0;
            } else {
                $status = 'Paid';
                $pamnt = $total;
                $roundoff = $this->custom->api_config(4);
                if ($roundoff['other']) 
					$pamnt = round($total, $roundoff['active'], constant($roundoff['other']));
            }
            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
            $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'pmethod' => $metretnotqo, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $discs_come,'discount_rate' => $disc_val, 'tax' => $taxas_tota, 'total' => $total, 'notes' => $notes, 'status' => 'due', 'csd' => $customer_id, 'eid' => $emp, 'pamnt' => 0, 'items' => $tota_items, 'taxstatus' => $tax, 'total_discount_tax' => $total_discount_tax, 'format_discount' => $discountFormat, 'refer' => $refer, 'ref_enc_orc' => $invocieencorc, 'term' => $pterms, 'multi' => $currency, 'loc' => $warehouse, 'tax_id' => $customer_tax, 'serie' => $invoi_serie, 'i_class' => 1, 'ext' => 0, 'irs_type' => $invoi_type, 'datedoc' => date('Y-m-d H:i:s'));
			if ($this->db->insert('geopos_invoices', $data)) {
                $invocieno_n = $invocieno;
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
				$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
				$this->db->set('start', "$invocieno2", FALSE);
				$this->db->where($multiClause);
				$this->db->update('geopos_series_ini_typs');
				
				$typeinv = $this->settings->irs_typ_view($invoi_type);
				$typeinvserie = $this->settings->irs_typ_series_name($invoi_serie);
				//$transok = $this->settings->AssinaDocumento($invocieno, 0, $invoi_type, $typeinv['type'], $invoi_serie, $typeinvserie['serie'], $invocieno2);
				
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('subtotal');
				$ptotal_tax = $this->input->post('total');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn', true);
                $product_alert = $this->input->post('alert');
                $product_serial = $this->input->post('serial');
				
				$taxaname = $this->input->post('taxaname');
				$taxaid = $this->input->post('taxaid');
				$taxacod = $this->input->post('taxacod');
				$taxaperc = $this->input->post('taxaperc');
				$taxavals = $this->input->post('taxavals');	
				$taxacomo = $this->input->post('taxacomo');
			
                if (is_array($pid)) {
                    foreach ($pid as $key => $value) {
                        $total_discount += numberClean(@$ptotal_disc[$key]);
                        $total_tax += numberClean($ptotal_tax[$key]);

                        $data = array(
                            'tid' => $invocieno,
							'pid' => $product_id[$key],
							'product' => $product_name1[$key],
							'code' => $product_hsn[$key],
							'qty' => $product_qty[$key],
							'price' => $product_price[$key],
							'tax' => $product_tax[$key],
							'discount' => $product_discount[$key],
							'subtotal' => $product_subtotal[$key],
							'totaltax' => $ptotal_tax[$key],
							'i_class' => 1,
							'totaldiscount' => $ptotal_disc[$key],
							'product_des' => $product_des[$key],
							'unit' => $product_unit[$key],
							'serial' => $product_serial[$key],
							'taxaname' => $taxaname[$key],
							'taxaid' => $taxaid[$key],
							'taxacod' => $taxacod[$key],
							'taxaperc' => $taxaperc[$key],
							'taxavals' => $taxavals[$key],
							'taxacomo' => $taxacomo[$key]
                        );

                        $flag = true;
                        $productlist[$prodindex] = $data;
                        $i++;
                        $prodindex++;
						
                        $amt = numberClean($product_qty[$key]);

                        if ($product_id[$key] > 0 and $this->common->zero_stock()) {

                            if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0) {
                                echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                                $transok = false;
                                $st_c = 1;
                            } else {
                                $this->db->set('qty', "qty-$amt", FALSE);
                                $this->db->where('pid', $product_id[$key]);
                                $this->db->update('geopos_products');
                            }
                        }
                        $itc += $amt;
                    }

                }

                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                    $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));
                    $this->db->where('id', $invocieno);
                    $this->db->update('geopos_invoices');

                    if (@count($product_serial) > 0) {
                        $this->db->set('status', 1);
                        $this->db->where_in('serial', $product_serial);
                        $this->db->update('geopos_product_serials');
                    }
                }
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
				$linkprint = base_url('invoices/printinvoice?id=' . $invocieno . '&token=' . $validtoken.'&ty=0');
                if ($transok) {
                    $this->load->library("Printer");
                    $printer = $this->printer->check($this->aauth->get_user()->loc);
                    $p_tid = 'thermal_p';
                    if ($printer['val2'] == 'server') 
						$p_tid = 'thermal_server';

                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('Invoice Success') . " <a target='_blank' href='thermal_pdf?id=$invocieno' class='btn btn-blue btn-lg'><span class='fa fa-ticket' aria-hidden='true'></span> PDF  </a> &nbsp; &nbsp;   <a id='$p_tid' data-ptid='$invocieno' data-url='" . $printer['val3'] . "'  class='btn btn-info btn-lg white'><span class='fa fa-ticket' aria-hidden='true'></span> " . $this->lang->line('Thermal Printer') . "  </a> &nbsp; &nbsp;<a href='#' class='btn btn-reddit btn-lg print_image' id='print_image' data-inid='$invocieno'><span class='fa fa-window-restore' aria-hidden='true'></span></a> &nbsp; &nbsp; <a target='_blank' href='$linkprint' class='btn btn-blue btn-lg'><span class='fa fa-print' aria-hidden='true'></span> A4  </a> &nbsp; &nbsp; <a href='view?id=$invocieno' class='btn btn-purple btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-blue-grey btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp;<a href='create' class='btn btn-flickr btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('Create') . "  </a>"));
                }
                $this->load->model('billing_model', 'billing');
				
				$pmethoget = $this->invocies->methodpayname($pmethod);
				$pmethodname = $pmethoget['methodname'];
                $tnote = 'POS Nº: ' . $invocieno_n . '-' . $pmethodname;
				$r_amt1 = 0;
				$r_amt2 = 0;
				$r_amt3 = 0;
				$r_amt4 = 0;
				$r_amt5 = 0;
				$r_amt6 = 0;
				$r_amt7 = 0;
				$r_amt8 = 0;
				$r_amt9 = 0;
				
				if($pmethod == 40)
				{
					$r_amt1 = $pamnt;
				}else if($pmethod == 44)
				{
					$r_amt2 = $pamnt;
				}else if($pmethod == 46)
				{
					$r_amt3 = $pamnt;
				}else if($pmethod == 41)
				{
					$r_amt4 = $pamnt;
				}else if($pmethod == 62)
				{
					$r_amt5 = $pamnt;
				}else if($pmethod == 42)
				{
					$r_amt6 = $pamnt;
				}else if($pmethod == 45)
				{
					$r_amt7 = $pamnt;
				}else if($pmethod == 63)
				{
					$r_amt8 = $pamnt;
				}else {
					$r_amt9 = $pamnt;
				}
				
				$this->load->model('settings_model', 'settings');
				$discship = [];
				if($this->aauth->get_user()->loc == 0)
				{
					$discship = $this->settings->online_pay_settings_main();
				}else{
					$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
				}
				$d_trans = $discship;
				if($dual['dual_entry']>0){
					$t_data = array(
						'type' => 'Income',
						'cat' => 3,
						'payerid' => $customer_id,
						'method' => $pmethod,
						'date' => $bill_date,
						'eid' =>$emp,
						'tid' => $invocieno,
						'loc' =>$this->aauth->get_user()->loc
					);
					$this->db->select('holder');
					$this->db->from('geopos_accounts');
					$this->db->where('id', $dual['ac_id_d']);
					$query = $this->db->get();
					$account_d = $query->row_array();
					$t_data['credit'] = 0;
					$t_data['debit'] = $total;
					$t_data['type'] = 'Expense';
					$t_data['acid'] = $dual['ac_id_d'];
					$t_data['account'] = $account_d['holder'];
					$t_data['note'] = 'Debit ' . $tnote;
					$this->db->insert('geopos_transactions', $t_data);
					//account update
					$this->db->set('lastbal', "lastbal-$total", FALSE);
					$this->db->where('id', $dual['ac_id_d']);
					$this->db->update('geopos_accounts');
					
					// now try it
					$ua=$this->aauth->getBrowser();
					$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
					
					$striPay = "Utilizador: ".$this->aauth->get_user()->username;
					$striPay = $striPay.'<br>'.$yourbrowser;
					$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
					$striPay = $striPay.'<br>Pagamento Dual'.$pmethodname;
					$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
				}
                if ($pamnt > 0) 
					$this->billing->paynow($invocieno, $pamnt, $tnote, $pmethod, $this->aauth->get_user()->loc, $bill_date, $account);
					$this->registerlog->update($this->aauth->get_user()->id, $r_amt1, $r_amt2, $r_amt3, $r_amt4, $r_amt5, $r_amt6, $r_amt7, $r_amt8, $r_amt9, $c_amt);
					// now try it
					$ua=$this->aauth->getBrowser();
					$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
					
					$striPay = "Utilizador: ".$this->aauth->get_user()->username;
					$striPay = $striPay.'<br>'.$yourbrowser;
					$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
					$striPay = $striPay.'<br>Pagamento '.$pmethodname;
					$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }
                    $amount = $result_c['amount'];
                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->update('geopos_promo');

                    if ($result_c['reflect'] > 0) {
                        $data = array(
                            'payerid' => 0,
                            'payer' => $this->lang->line('Coupon') . '-' . $result_c['code'],
                            'acid' => $result_c['reflect'],
                            'account' => 'Promo',
                            'date' => date('Y-m-d'),
                            'debit' => 0,
                            'credit' => $amount,
                            'type' => 'Income',
                            'cat' => $this->lang->line('Coupon'),
                            'method' => 63,
                            'eid' => $this->aauth->get_user()->id,
                            'note' => $this->lang->line('Coupon') . ' ' . $result_c['code'],
                            'loc' => $this->aauth->get_user()->loc
                        );
                        $this->db->set('lastbal', "lastbal+$amount", FALSE);
                        $this->db->where('id', $result_c['reflect']);
                        $this->db->update('geopos_accounts');
                        $this->db->insert('geopos_transactions', $data);
						// now try it
						$ua=$this->aauth->getBrowser();
						$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
						
						$striPay = "Utilizador: ".$this->aauth->get_user()->username;
						$striPay = $striPay.'<br>'.$yourbrowser;
						$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
						$striPay = $striPay.'<br>Pagamento Com Copão'.$pmethodname;
						$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
                    }
                }
				$data2 = array(
					'acid' => $account_set_id,
					'account' => $account_set,
					'type' => 'Income',
					'cat' => 3,
					'credit' => $total,
					'debit' => 0,
					'payer' => $customer_name,
					'payerid' => $customer_id,
					'method' => $pmethod,
					'date' => $bill_date,
					'eid' => $emp,
					'tid' => $invocieno,
					'note' => $tnote,
					'loc' => $this->aauth->get_user()->loc
				);
				$this->db->insert('geopos_transactions', $data2);
				$trans = $this->db->insert_id();
            } else {
				echo json_encode(array('status' => 'Error', 'message' => "Algum valor em Falta."));
                $transok = false;
            }
			
            if ($transok) {
				if($draft_id > 0){
					$this->db->delete('geopos_draft', array('id' => $draft_id));
					$this->db->delete('geopos_draft_items', array('tid' => $draft_id));
				}
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
        } elseif ($ptype == 2) {
			//Card
            $discountFormat = $this->input->post('discountFormat');
            $pterms = $this->input->post('pterms');
            $currency = $this->input->post('mcurrency');
            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);

            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
			$data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'pmethod' => $metretnotqo, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $discs_come,'discount_rate' => $disc_val, 'tax' => $taxas_tota, 'total' => $total, 'notes' => $notes, 'status' => 'due', 'csd' => $customer_id, 'eid' => $emp, 'pamnt' => 0, 'items' => $tota_items, 'taxstatus' => $tax, 'total_discount_tax' => $total_discount_tax, 'format_discount' => $discountFormat, 'refer' => $refer, 'ref_enc_orc' => $invocieencorc, 'term' => $pterms, 'multi' => $currency, 'loc' => $warehouse, 'tax_id' => $customer_tax, 'serie' => $invoi_serie, 'i_class' => 1, 'ext' => 0, 'irs_type' => $invoi_type);
			$invoice_true = false;
            if ($this->db->insert('geopos_invoices', $data)) {
                $invoice_true = true;
                $tid = $invocieno;
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('subtotal');
				$ptotal_tax = $this->input->post('total');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');
                $product_alert = $this->input->post('alert');
                $product_serial = $this->input->post('serial');
				$taxaname = $this->input->post('taxaname');
				$taxaid = $this->input->post('taxaid');
				$taxacod = $this->input->post('taxacod');
				$taxaperc = $this->input->post('taxaperc');
				$taxavals = $this->input->post('taxavals');	
				$taxacomo = $this->input->post('taxacomo');
				
                foreach ($pid as $key => $value) {
                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);
                    $data = array(
                        'tid' => $invocieno,
						'pid' => $product_id[$key],
						'product' => $product_name1[$key],
						'code' => $product_hsn[$key],
						'qty' => $product_qty[$key],
						'price' => $product_price[$key],
						'tax' => $product_tax[$key],
						'discount' => $product_discount[$key],
						'subtotal' => $product_subtotal[$key],
						'totaltax' => $ptotal_tax[$key],
						'i_class' => 1,
						'totaldiscount' => $ptotal_disc[$key],
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
						'serial' => $product_serial[$key],
						'taxaname' => $taxaname[$key],
						'taxaid' => $taxaid[$key],
						'taxacod' => $taxacod[$key],
						'taxaperc' => $taxaperc[$key],
						'taxavals' => $taxavals[$key],
						'taxacomo' => $taxacomo[$key]
                    );
                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]);
                    if ($product_id[$key] > 0 and $this->common->zero_stock()) {
                        if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0) {
                            echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
                            $transok = false;
                            $st_c = 1;
                        } else {
                            $this->db->set('qty', "qty-$amt", FALSE);
                            $this->db->where('pid', $product_id[$key]);
                            $this->db->update('geopos_products');
                        }
                    }
                    $itc += $amt;
                }
                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_invoice_items', $productlist);
					
					// now try it
					$ua=$this->aauth->getBrowser();
					$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
					
					$striPay = "Utilizador: ".$this->aauth->get_user()->username;
					$striPay = $striPay.'<br>'.$yourbrowser;
					$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
					$striPay = $striPay.'<br>Pagamento com Cartão Online';
					$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
				
                    if (count($product_serial) > 0) {
                        $this->db->set('status', 1);
                        $this->db->where_in('serial', $product_serial);
                        $this->db->update('geopos_product_serials');
                    }
                } else {
                    echo json_encode(array('status' => 'Error', 'message' => "Please choose product from product list. Go to Item manager section if you have not added the products."));
                    $transok = false;
                }
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
				$linkprint = base_url('invoices/printinvoice?id=' . $invocieno . '&token=' . $validtoken.'&ty=0');
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }

                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->update('geopos_promo');

                    if ($result_c['reflect'] > 0) {
                        $data = array(
                            'payerid' => 0,
                            'payer' => $this->lang->line('Coupon') . '-' . $result_c['code'],
                            'acid' => $result_c['reflect'],
                            'account' => 'Promo',
                            'date' => date('Y-m-d'),
                            'debit' => 0,
                            'credit' => $amount,
                            'type' => 'Income',
                            'cat' => $this->lang->line('Coupon'),
                            'method' => 63,
                            'eid' => $this->aauth->get_user()->id,
                            'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Qty') . '-' . $result_c['available'],
                            'loc' => $this->aauth->get_user()->loc
                        );
                        $this->db->set('lastbal', "lastbal+$amount", FALSE);
                        $this->db->where('id', $result_c['reflect']);
                        $this->db->update('geopos_accounts');
                        $this->db->insert('geopos_transactions', $data);
                    }
                }

            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Invalid Entry!"));
                $transok = false;
            }
            //card process
            if ($invoice_true) {
                $gateway = $this->input->post('gateway', true);
                setcookie("pos_set", base_url('pos_invoices/view?id=' . $invocieno), time() + 30 * 24 * 60 * 60, '/');
                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $quckpay = base_url() . "billing/card?id=$invocieno&itype=inv&token=$validtoken&gid=$gateway";
                if ($transok) 
					echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice Success') . " <script type='text/javascript' >window.location.replace('$quckpay');</script><a target='_blank' href='$quckpay' class='btn btn-blue btn-lg'><span class='icon-printer' aria-hidden='true'></span> " . $this->lang->line('Pay') . "  </a> &nbsp; &nbsp;    <a target='_blank' href='thermal_pdf?id=$invocieno' class='btn btn-blue btn-lg'><span class='icon-printer' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp;    &nbsp; &nbsp; <a href='view?id=$invocieno' class='btn btn-purple btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-blue-grey btn-lg'><span class='icon-earth' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> <a href='create' class='btn btn-amber btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('Create') . "  </a>"));
            }

            if ($transok) {
				if($draft_id > 0){
					$this->db->delete('geopos_draft', array('id' => $draft_id));
					$this->db->delete('geopos_draft_items', array('tid' => $draft_id));
				}
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
        } else {
			//draft
            $i = 0;
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            $this->db->trans_start();
            //products
            $transok = true;
            //Invoice Data
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
			$data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'pmethod' => $metretnotqo, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $discs_come,'discount_rate' => $disc_val, 'tax' => $taxas_tota, 'total' => $total, 'notes' => $notes, 'status' => 'due', 'csd' => $customer_id, 'eid' => $emp, 'pamnt' => 0, 'items' => $tota_items, 'taxstatus' => $tax, 'total_discount_tax' => $total_discount_tax, 'format_discount' => $discountFormat, 'refer' => $refer, 'ref_enc_orc' => $invocieencorc, 'term' => $pterms, 'multi' => $currency, 'loc' => $warehouse, 'tax_id' => $customer_tax, 'serie' => $invoi_serie, 'i_class' => 1, 'ext' => 0, 'irs_type' => $invoi_type);
			if ($this->db->insert('geopos_draft', $data)) {
                $invocieno2 = $invocieno;
                $invocieno = $this->db->insert_id();
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('subtotal');
				$ptotal_tax = $this->input->post('total');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');
				$product_alert = $this->input->post('alert');
                $product_serial = $this->input->post('serial');
				
				$taxaname = $this->input->post('taxaname');
				$taxaid = $this->input->post('taxaid');
				$taxacod = $this->input->post('taxacod');
				$taxaperc = $this->input->post('taxaperc');
				$taxavals = $this->input->post('taxavals');	
				$taxacomo = $this->input->post('taxacomo');

                foreach ($pid as $key => $value) {
                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);

                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
						'product' => $product_name1[$key],
						'code' => $product_hsn[$key],
						'qty' => $product_qty[$key],
						'price' => $product_price[$key],
						'tax' => $product_tax[$key],
						'discount' => $product_discount[$key],
						'subtotal' => $product_subtotal[$key],
						'totaltax' => $ptotal_tax[$key],
						'i_class' => 1,
						'totaldiscount' => $ptotal_disc[$key],
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
						'serial' => $product_serial[$key],
						'taxaname' => $taxaname[$key],
						'taxaid' => $taxaid[$key],
						'taxacod' => $taxacod[$key],
						'taxaperc' => $taxaperc[$key],
						'taxavals' => $taxavals[$key],
						'taxacomo' => $taxacomo[$key]
                    );
                    $flag = true;
                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]);
                    $itc += $amt;
                }

                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_draft_items', $productlist);
                    $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));
                    $this->db->where('id', $invocieno);
                    $this->db->update('geopos_draft');

                } else {
                    echo json_encode(array('status' => 'Error', 'message' => "Please choose product from product list. Go to Item manager section if you have not added the products."));
                    $transok = false;
                }

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
				$linkprint = base_url('invoices/printinvoice?id=' . $invocieno . '&token=' . $validtoken.'&ty=1');
                if ($transok) echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Draft Success') . " <a href='create' class='btn btn-info btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a>&nbsp; &nbsp; <a target='_blank' href='$linkprint' class='btn btn-blue btn-lg'><span class='fa fa-print' aria-hidden='true'></span> A4  </a> &nbsp;"));

            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Invalid Entry!"));
                $transok = false;
            }
            if ($transok) {
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }
        }
		
        if ($transok) {
            $this->db->from('univarsal_api');
            $this->db->where('univarsal_api.id', 56);
            $query = $this->db->get();
            $auto = $query->row_array();
            if ($auto['key1'] == 1) {
                $this->db->select('name,email');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();

                $this->load->model('communication_model');
                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);
                $attachmenttrue = false;
                $attachment = '';
                $this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);

            }

            if ($auto['key2'] == 1) {
                $this->db->select('name,phone');
                $this->db->from('geopos_customers');
                $this->db->where('id', $customer_id);
                $query = $this->db->get();
                $customer = $query->row_array();

                $this->load->model('plugins_model', 'plugins');
                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);

                $mobile = $customer['phone'];
                $text_message = $invoice_sms['message'];
                $this->load->model('sms_model', 'sms');
                $this->sms->send_sms($mobile, $text_message, false);
            }
        }
        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $invocieno);
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $data = array('type' => 9, 'rid' => $invocieno, 'col1' => $t_profit, 'd_date' => $bill_date);

        $this->db->insert('geopos_metadata', $data);
        if ($print_now) {
            $print = $this->thermal_print($invocieno, false, false);
        }
    }


    public function ajax_list()
    {
        $list = $this->invocies->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
			$width = 0;
			if($invoices->pamnt == 0 || $invoices->pamnt == null || $invoices->pamnt == "" || $invoices->total == 0 || $invoices->total == null || $invoices->total == "")
			{
				$width = round(0*100,2);
			}else
			{
				$width = round(($invoices->pamnt/$invoices->total)*100,2);
			}
			
            $row = array();
			$row[] = $invoices->serie_name;
            $row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '">'.$invoices->type. $invoices->tid . '</a>';
			$row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->name;
            $row[] = $invoices->taxid;
			$row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$row[] = "<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$invoices->pamnt' aria-valuemin='0' aria-valuemax='$invoices->total' style='width:$width%;'>$width%</div></div>";
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span><br>'.$invoices->loc_cname;
            if($invoices->status == 'canceled'){
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" data-object-draft="1" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);

    }

    public function extended_ajax_list()
    {
        if (!$this->aauth->premission(10)) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }

        $list = $this->extended_invoice->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
			$width = 0;
			
			if($invoices->pamnt == 0 || $invoices->pamnt == null || $invoices->pamnt == "" || $invoices->total == 0 || $invoices->total == null || $invoices->total == "")
			{
				$width = round(0*100,2);
			}else
			{
				$width = round(($invoices->pamnt/$invoices->total)*100,2);
			}
			
            $row = array();
			$row[] = $invoices->serie_name;
            $row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '">'.$invoices->type. $invoices->tid . '</a>';
			$row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->name;
            $row[] = $invoices->taxid;
			$row[] = $invoices->qty;
			$row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$row[] = "<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$invoices->pamnt' aria-valuemin='0' aria-valuemax='$invoices->total' style='width:$width%;'>$width%</div></div>";
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            if($invoices->status == 'canceled'){
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" data-object-draft="1" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			
            $data[] = $row;
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->extended_invoice->count_all($this->limited),
            "recordsFiltered" => $this->extended_invoice->count_filtered($this->limited),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $this->load->model('accounts_model');
		$this->load->library("Common");
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
        $data['id'] = $tid;
		
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['attach'] = $this->invocies->attach($tid);
		$data['history'] = $this->invocies->history($tid,'fa');
        if ($data['invoice']['id']) 
			$data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) 
			$data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1);

        $this->load->library("Printer");
        $data['printer'] = $this->printer->check($data['invoice']['loc']);
		
		$this->load->model('billing_model', 'billing');
		$online_pay = $this->billing->online_pay_settings();
		if ($online_pay['enable'] == 1) {
			$token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
		}	
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $head['title'] = "Invoice " . $data['invoice']['tid'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['id']) $this->load->view('pos/view', $data);
        $this->load->view('fixed/footer');

    }

    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
			$tid = $this->input->post('deletetid');
			$draft = $this->input->post('draft');
			
			if($draft == 0)
			{
				$this->db->delete('geopos_draft_items', array('id' => $id));
				$this->db->delete('geopos_draft', array('id' => $id));
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay = $striPay.'<br>Rascunho Removido: '.$tid;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'draft', $id);
				echo json_encode(array('status' => 'Success', 'message' => 'Rascunho removido com Sucesso. Faça Refresh para ele desaparecer.'));
			}else{
				$this->db->set('status', 'canceled');
				$this->db->where('id', $id);
				$this->db->update('geopos_invoices');
				echo json_encode(array('status' => 'Success', 'message' => 'Fatura Anulada com Sucesso'));
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay = $striPay.'<br>Fatura Anulada: '.$tid;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $id);
			}
			
			
           /* if ($this->invocies->invoice_delete($id, $this->limited)) {
                
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }*/
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function editaction()
    {
        $ptype = $this->input->post('type');
        $coupon = $this->input->post('coupon');
        $notes = $this->input->post('notes', true);
        $coupon_amount = 0;
        $coupon_n = '';
        $account = $this->input->post('account', true);
        $customer_id = $this->input->post('customer_id');
        $invocieno_n = $this->input->post('invoiceno');
        $invocieno = $this->input->post('iid');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $currency = $this->input->post('mcurrency');
        if ($ptype == 4) {
            $p_amount = rev_amountExchange_s($this->input->post('p_amount'), $currency, $this->aauth->get_user()->loc);
            $pmethod = $this->input->post('p_method');
            $notes = $this->input->post('notes');
            $tax = $this->input->post('tax_handle');
            $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
            $ship_taxtype = $this->input->post('ship_taxtype');
            $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
            $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
            if ($ship_taxtype == 'incl') 
				$shipping = $shipping - $shipping_tax;
            $refer = $this->input->post('refer');
            $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
            $old_total = rev_amountExchange_s($this->input->post('old_total'), $currency, $this->aauth->get_user()->loc);
            $total_tax = 0;
            $total_discount = 0;
            $discountFormat = $this->input->post('discountFormat');
            $pterms = $this->input->post('pterms');
            //edit
            $diff = $total - $old_total;
			$c_amt = $p_amount;
            $i = 0;
            if ($this->limited) {
                $employee = $this->invocies->invoice_details($invocieno, $this->limited);
                if ($this->aauth->get_user()->id != $employee['eid']) exit();
            }
            if ($discountFormat == '0') {
                $discstatus = 0;
            } else {
                $discstatus = 1;
            }
            if ($customer_id == 0) {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Please add a new client')));
                exit;
            }
            $this->db->trans_start();
            $transok = true;
            $bill_date = datefordatabase($invoicedate);
            $bill_due_date = datefordatabase($invocieduedate);
            $promo_flag = false;
            if ($coupon) {
                $this->db->select('*');
                $this->db->from('geopos_promo');
                $this->db->where('code', $coupon);
                $query = $this->db->get();
                $result_c = $query->row_array();
                if ($result_c['active'] == 0 && $result_c['available'] > 0) {
                    $promo_flag = true;
                    $amount = $result_c['amount'];
                    $notes .= '-' . $this->input->post('i_coupon');
                    $total_discount += $amount;
                }
            }
            $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
            $this->db->set($data);
            $this->db->where('id', $invocieno);
            if ($this->db->update('geopos_invoices', $data)) {
                //Product Data
                $pid = $this->input->post('pid');
                $productlist = array();
                $prodindex = 0;
                $itc = 0;
                $this->db->delete('geopos_invoice_items', array('tid' => $invocieno));
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name', true);
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description', true);
                $product_unit = $this->input->post('unit');
                $product_hsn = $this->input->post('hsn');
                $product_serial = $this->input->post('serial');
                foreach ($pid as $key => $value) {

                    $total_discount += numberClean(@$ptotal_disc[$key]);
                    $total_tax += numberClean($ptotal_tax[$key]);
                    $data = array(
                        'tid' => $invocieno,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'code' => $product_hsn[$key],
                        'qty' => numberClean($product_qty[$key]),
                        'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                        'tax' => numberClean($product_tax[$key]),
                        'discount' => numberClean($product_discount[$key]),
                        'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                        'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                        'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                        'product_des' => $product_des[$key],
                        'i_class' => 1,
                        'unit' => $product_unit[$key],
                        'serial' => $product_serial[$key]
                    );

                    $productlist[$prodindex] = $data;
                    $i++;
                    $prodindex++;
                    $amt = numberClean($product_qty[$key]) - @numberClean($old_product_qty[$key]);

                    if ($product_id[$key] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    }
                    $itc += $amt;
                }
                if ($prodindex > 0) {
                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                    $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                    $this->db->where('id', $invocieno);
                    $this->db->update('geopos_invoices');
                    if (count($product_serial) > 0) {
                        $this->db->set('status', 1);
                        $this->db->where_in('serial', $product_serial);
                        $this->db->update('geopos_product_serials');
                    }

                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        "Please add at least one product in invoice"));
                    $transok = false;
                }
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice has  been updated') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
                $this->load->model('billing_model', 'billing');
				$pmethoget = $this->invocies->methodpayname($pmethod);
				$pmethodname = $pmethoget['methodname'];
                $tnote = 'POS Nº: ' . $invocieno_n . '-' . $pmethodname;
				$r_amt1 = 0;
				$r_amt2 = 0;
				$r_amt3 = 0;
				$r_amt4 = 0;
				$r_amt5 = 0;
				$r_amt6 = 0;
				$r_amt7 = 0;
				$r_amt8 = 0;
				$r_amt9 = 0;
				
				if($pmethod == 40)
				{
					$r_amt1 = $pamnt;
				}else if($pmethod == 44)
				{
					$r_amt2 = $pamnt;
				}else if($pmethod == 46)
				{
					$r_amt3 = $pamnt;
				}else if($pmethod == 41)
				{
					$r_amt4 = $pamnt;
				}else if($pmethod == 62)
				{
					$r_amt5 = $pamnt;
				}else if($pmethod == 42)
				{
					$r_amt6 = $pamnt;
				}else if($pmethod == 45)
				{
					$r_amt7 = $pamnt;
				}else if($pmethod == 63)
				{
					$r_amt8 = $pamnt;
				}else {
					$r_amt9 = $pamnt;
				}
                $this->billing->paynow($invocieno, $diff, $tnote, $pmethod, $this->aauth->get_user()->loc, 0, $account);
                $this->registerlog->update($this->aauth->get_user()->id, $r_amt1, $r_amt2, $r_amt3, $r_amt4, $r_amt5, $r_amt6, $r_amt7, $r_amt8, $r_amt9, $c_amt);
                if ($promo_flag) {
                    $cqty = $result_c['available'] - 1;
                    if ($cqty > 0) {
                        $data = array('available' => $cqty);
                    } else {
                        $data = array('active' => 1, 'available' => $cqty);
                    }
                    $amount = $result_c['amount'];
                    $this->db->set($data);
                    $this->db->where('id', $result_c['id']);
                    $this->db->update('geopos_promo');

                    if ($result_c['reflect'] > 0) {
                        $data = array(
                            'payerid' => 0,
                            'payer' => $this->lang->line('Coupon') . '-' . $result_c['code'],
                            'acid' => $result_c['reflect'],
                            'account' => 'Promo',
                            'date' => date('Y-m-d'),
                            'debit' => 0,
                            'credit' => $amount,
                            'type' => 'Income',
                            'cat' => $this->lang->line('Coupon'),
                            'method' => 63,
                            'eid' => $this->aauth->get_user()->id,
                            'note' => $this->lang->line('Coupon') . ' ' . $this->lang->line('Delete') . ' ' . $this->lang->line('Qty') . '-' . $result_c['available'],
                            'loc' => $this->aauth->get_user()->loc
                        );
                        $this->db->set('lastbal', "lastbal+$amount", FALSE);
                        $this->db->where('id', $result_c['reflect']);
                        $this->db->update('geopos_accounts');
                        $this->db->insert('geopos_transactions', $data);
                    }
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
                $transok = false;
            }

            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {

                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = numberClean($myArray[1]);
                    if ($prid > 0) {
                        $this->db->set('qty', "qty+$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->update('geopos_products');
                    }
                }
            }


            if ($transok) {
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
            }

        }

        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $invocieno);
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $this->db->set('col1', $t_profit);
        $this->db->where('type', 9);
        $this->db->where('rid', $invocieno);
        $this->db->update('geopos_metadata');

    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_invoices');
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }


    public function addcustomer()
    {
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $taxid = $this->input->post('taxid', true);
        $customergroup = $this->input->post('customergroup', true);
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
           $custom = $this->input->post('c_field', true);
        $this->load->model('customers_model', 'customers');
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s,'', '', '', '', $custom);

    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->invocies->meta_delete($invoice, 1, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->invocies->meta_insert($id, 1, $files);
            }
        }


    }


    function thermal_print($id = 0, $mode = true, $d = true)
    {
        //dual mode -basic for standard users and advanced mode

        $basic_mode = false;

        $tid = $this->input->get('id');
        if (!$tid > 0) $tid = $id;
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

        $this->load->library("Printer");
        $printer_data = $this->printer->check($data['invoice']['loc']);

        if ($printer_data) {

            if ($printer_data['val2'] != 'server') {
                if ($d) echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('your thermal printer')));
                switch ($printer_data['val2']) {
                    case 'file' :
                        $connector = new FilePrintConnector($printer_data['val3']);
                        break;
                    case 'network' :
                        $address = parse_url($printer_data['val3']);
                        $connector = new NetworkPrintConnector($address['host'], $address['port']);
                        break;
                    case 'windows' :
                        $connector = new WindowsPrintConnector($printer_data['val3']);
                        break;

                    case 'test' :
                        $connector = new DummyPrintConnector();
                        break;

                }

                $items = array();
                $sub_t = 0;
                foreach ($data['products'] as $row) {
                    $items[] = $this->toString($row['product'], $row['subtotal']);
                    $sub_t += $row['price'] * $row['qty'];
                }
                $subtotal = $this->toString($this->lang->line('Subtotal'), $sub_t);
                $tax = $this->toString($this->lang->line('Tax'), $data['invoice']['tax']);
                $total = $this->toString($this->lang->line('Total'), $data['invoice']['total'], true);
                $round_off = $this->custom->api_config(4);
                if ($round_off['other']) {
                    $final_amount = round($data['invoice']['total'], $round_off['active'], constant($round_off['other']));
                    $total_round = $this->toString($this->lang->line('Round Off'), $final_amount, true);
                }


                //Date is kept the same for testing
                // $date = date('l jS \of F Y h:i:s A');
                $date = dateformat($data['invoice']['invoicedate']) . ' ' . date('h:i:s A');


//simple and fast printing
                if (!$printer_data['other']) {

                    // Start the printer
                    //$logo = EscposImage::load(FCPATH . "userfiles/company/logo.png", false);
                    $printer = new Printer($connector);

                    // Print top logo
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    //$printer->graphics($logo);

                    //Name of shop
                    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer->text($this->config->item('ctitle') . "\n");
                    $printer->selectPrintMode();
                    $printer->text($this->config->item('address') . "\n");
                    $printer->feed();

                    //Title of receipt
                    $printer->setEmphasis(true);
                    $printer->text($this->lang->line('Invoice') . ' ' . $data['invoice']['tid'] . "\n");
                    $printer->setEmphasis(false);

                    //Items
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->setEmphasis(true);
                    $printer->text($this->toString('', $this->config->item('currency')));
                    $printer->setEmphasis(false);
                    foreach ($items as $item) {
                        $printer->text($item);
                    }
                    $printer->setEmphasis(true);
                    $printer->text($subtotal);
                    $printer->setEmphasis(false);
                    $printer->feed();

                    // Tax and total
                    $printer->text($tax);
                    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer->text($total);
                    if ($round_off['other']) {
                        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                        $printer->text($total_round);
                    }
                    $printer->selectPrintMode();

                    // Footer
                    $printer->feed(2);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text($this->lang->line('Thank you') . "\n");
                    $printer->text("\n");
                    $printer->feed(2);
                    $printer->text($date . "\n");

                    // Cut the receipt and open the cash drawer
                    $printer->cut();
                    //   $printer->pulse();
                    if ($printer_data['val2'] == 'test') {
                        $data = $connector->getData();

                        header('Content-type: application/octet-stream');
                        header('Content-Length: ' . strlen($data));

                        $file = FCPATH . "pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                        file_put_contents($file, $data);
                    }


                    $printer->close();
                } else {
                    //thermal pdf printing
                    $printer = new Printer($connector);
                    $this->pheight = 0;
                    $data['id'] = $tid;
                    $data['title'] = "Invoice $tid";
                    $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
					$data['date_now'] = date('Y_m_d_H_i_s');
                    if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
                    if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

                    $this->load->model('billing_model', 'billing');
                    $online_pay = $this->billing->online_pay_settings();
                    if ($online_pay['enable'] == 1) {
                        $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
                        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
                        $static_q = $data['qrc'];
                        $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));
                        $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
                    }

                    // boost the memory limit if it's low ;)
                    ini_set('memory_limit', '64M');
                    // load library
                    $this->load->library('pdf');
                    $pdf = $this->pdf->load_thermal();
                    // retrieve data from model or just static date
                    $data['title'] = "items";
                    $pdf->allow_charset_conversion = true;  // Set by default to TRUE
                    $pdf->charset_in = 'UTF-8';
                    //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
                    $pdf->autoLangToFont = true;
                    $html = $this->load->view('pos/pdfposthermal', $data, true);
                    // render the view into HTML

                    $h = 160 + $this->pheight;
                    $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
                    $pdf->WriteHTML($html);
                    $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'PosInvoice_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);

                    $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');


                    if (!extension_loaded('imagick')) {
                        // echo 'imagick not installed';
                        echo json_encode(array('status' => 'Error', 'message' => 'imagick not installed'));
                        $printer->close();
die();
                    }
                    try {
                        $im = new Imagick();

                        $image=FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.png';

                        $im->setResolution(300, 300);
                        $im->readimage(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.pdf');
                        $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
                        $im->setImageFormat('png');
                        //$im->transparentPaintImage(      'white', 0, 100, false    );
                        $im->writeImage($image);
                        $im->clear();
                        $im->destroy();
                        $printer->graphics(EscposImage::load($image));
                        $printer->cut();
                        if ($printer_data['val2'] == 'test') {
                            $data = $connector->getData();

                            header('Content-type: application/octet-stream');
                            header('Content-Length: ' . strlen($data));

                            $file = FCPATH . "advanced_pos_test_receipt_" . date('Y-m-d_H_i_s') . ".bin";
                            file_put_contents($file, $data);
                        }
                        $printer->close();
                        unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $static_q);
                        unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.pdf');
                        unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_name . '.png');


                    } catch (ImagickException $imagick_exception) {
						echo 6;
                    }
                }


            } elseif ($printer_data['val2'] == 'server') {

                $this->db->select('key');
                $this->db->from('geopos_restkeys');
                $this->db->limit(1);
                $query_r = $this->db->get();
                if ($query_r->num_rows() > 0) {
                    $rest = $query_r['key'];
                    $ch = curl_init();
                    // Set cURL options
                    curl_setopt($ch, CURLOPT_URL, $printer_data['val3'] . "pos_printer/index.php?app_url=" . htmlentities(base_url() . '&id=' . $tid . '&rest_key=' . $rest . '&printer_connection=server'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.66 Safari/537.36");
                    // Decode returned JSON
                    $output = json_decode(curl_exec($ch), true);
                    // Close Channel
                    curl_close($ch);

                } else {
                    if ($mode) echo json_encode(array('status' => 'Error', 'message' => 'Please create  a rest key.'));
                }
            } else {
                if ($mode) echo json_encode(array('status' => 'Error', 'message' => 'Please setup a thermal printer in printer section.'));
            }
        }

    }

    public function toString($name = '', $price = '', $dollarSign = false)
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($name, $leftCols);

        $sign = $this->config->item('currency');
        $right = str_pad($sign . $price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";

    }


    function thermal_pdf()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
		$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['round_off'] = $this->custom->api_config(4);
		if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
		
		if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
        }
		
		$data['invoice']['type'] = $data['invoice']['irs_type_n'];
		
		$data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
		$static_q = $data['qrc'];
		
		
		$codQRD = 'A:'.$data['invoice']['loc_country'].$data['invoice']['loc_taxid'].'*';
		$codQRD .= 'B:'.$data['invoice']['taxid'].'*';
		$codQRD .= 'C:'.$data['invoice']['country'].'*';
		$codQRD .= 'D:'.$data['invoice']['irs_type_s'].'*';
		
		//“N” – Normal; “S” – Autofaturação; “A” – Documento anulado; “R” – Documento de resumo doutros documentos criados noutras aplicações e gerado nesta aplicação; “F” – Documento faturado
		
		if($data['invoice']['status'] == 'canceled')
		{
			$codQRD .= 'E:A*';
		}else{
			$codQRD .= 'E:N*';
		}
		
		$date = new DateTime($data['invoice']['invoicedate']);
		//$date = $date->format('Y-m-dTH:i:s');
		$date = $date->format('Ymd');
		
		$codQRD .= 'F:'.$date.'*';
		$codQRD .= 'G:'.$data['invoice']['irs_type_s'].$data['invoice']['serie_name'].'/'.$data['invoice']['tid'].'*';
		if($data['invoice']['atc_serie'] == "")
		{
			$codQRD .= 'H:0*';
		}else{
			$codQRD .= 'H:'.$data['invoice']['atc_serie'].$data['invoice']['tid'].'*';
		}
		
		$arrtudo = [];
		foreach ($data['products'] as $row) {
			$myArraytaxname = explode(";", $row['taxaname']);
			$myArraytaxcod = explode(";", $row['taxacod']);
			$myArraytaxvals = explode(";", $row['taxavals']);
			$myArraytaxcomo = explode(";", $row['taxacomo']);
			$myArraytaxperc = explode(";", $row['taxaperc']);
			for($i = 0; $i < count($myArraytaxname); $i++)
			{
				$jatem = false;
				for($oo = 0; $oo < count($arrtudo); $oo++)
				{
					if($arrtudo[$oo]['title'] == $myArraytaxname[$i])
					{
						$arrtudo[$oo]['total'] = ($arrtudo[$oo]['total']+$myArraytaxvals[$i]);
						$jatem = true;
						break;
					}
				}
				
				if(!$jatem)
				{
					$stack = array('title'=>$myArraytaxname[$i], 'total'=>$myArraytaxvals[$i], 'base'=>$myArraytaxvals[$i], 'cod'=>$myArraytaxcod[$i], 'como'=>$myArraytaxcomo[$i], 'perc'=>$myArraytaxperc[$i]);
					array_push($arrtudo, $stack);
				}
			}
		}
		
		//“PT-AC” – Espaço fiscal da Região Autónoma dos Açores; e “PT-MA” – Espaço fiscal da Região Autónoma da Madeira
		if($data['invoice']['loc_zon_fis'] == 0)
		{
			$codQRD .= 'J1:PT-AC*';
			for($r = 0; $r < count($arrtudo); $r++)
			{
				if($arrtudo[$r]['cod'] == 'ISE')
				{
					$codQRD .= 'J2:'.$arrtudo[$r]['base'].'*';
				}else if($arrtudo[$r]['cod'] == 'RED')
				{
					$codQRD .= 'J3:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'J4:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else if($arrtudo[$r]['cod'] == 'INT')
				{
					$codQRD .= 'J5:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'J6:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else{
					$codQRD .= 'J7:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'J8:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}
			}
		}else if($data['invoice']['loc_zon_fis'] == 1)
		{
			$codQRD .= 'K1:PT-MA*';
			for($r = 0; $r < count($arrtudo); $r++)
			{
				if($arrtudo[$r]['cod'] == 'ISE')
				{
					$codQRD .= 'K2:'.$arrtudo[$r]['base'].'*';
				}else if($arrtudo[$r]['cod'] == 'RED')
				{
					$codQRD .= 'K3:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'K4:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else if($arrtudo[$r]['cod'] == 'INT')
				{
					$codQRD .= 'K5:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'K6:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else{
					$codQRD .= 'K7:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'K8:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}
			}
		}else{
			$codQRD .= 'I1:'.$data['invoice']['loc_country'].'*';
			for($r = 0; $r < count($arrtudo); $r++)
			{
				if($arrtudo[$r]['cod'] == 'ISE')
				{
					$codQRD .= 'I2:'.$arrtudo[$r]['base'].'*';
				}else if($arrtudo[$r]['cod'] == 'RED')
				{
					$codQRD .= 'I3:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'I4:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else if($arrtudo[$r]['cod'] == 'INT')
				{
					$codQRD .= 'I5:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'I6:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}else{
					$codQRD .= 'I7:'.@number_format($arrtudo[$r]['base'], 2, '.', '').'*';
					$codQRD .= 'I8:'.@number_format($arrtudo[$r]['total'], 2, '.', '').'*';
				}
			}
		}

		
		
		
		//$codQRD .= 'L:'.'*';
		//$codQRD .= 'M:'.'*';
		
		$codQRD .= 'N:'.@number_format($data['invoice']['tax'], 2, '.', '').'*';
		$codQRD .= 'O:'.@number_format($data['invoice']['total'], 2, '.', '').'*';
		
		//Valor do total das retenções na fonte - campo WithholdingTaxAmount do SAF-T (PT).
		//$codQRD .= 'P:'.'*';
		
		
		//4 carateres do Hash gerados na criação do documento e buscar a AT
		$codQRD .= 'Q:'.'*';
		
		
		$codQRD .= 'R:'.$data['invoice']['loc_certification'].'*';
		
		$campfim = "";
		if($data['invoice']['loc_contabancaria'] != null)
		{
			$campfim .= "IBAN-".$data['invoice']['loc_contabancaria'];
		}
		
		$campfim .= ";".$data['invoice']['loc_cname'];
		$codQRD .= 'S:'.$campfim.'*';
		
		$qrCode = new QrCode($codQRD);
		//$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		
		$writer = new PngWriter();
		$writer->write($qrCode)->saveToFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		ini_set('memory_limit', '64M');
        // load library
        $this->load->library('pdf');
        $this->pheight = 0;
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $h = 230 + $this->pheight;
        //  $pdf->_setPageSize(array(70, $h), $this->orientation);
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		$data3 = $data;
		$data3['Tipodoc'] = "Triplicado";
		$data4 = $data;
		$data4['Tipodoc'] = "Quadruplicado";
		
		$html = $this->load->view('print_files/pos_pdf_compact' . POSV, $data, true);
		$html2 = $this->load->view('print_files/pos_pdf_compact' . POSV, $data2, true);
		$html3 = $this->load->view('print_files/pos_pdf_compact' . POSV, $data3, true);
		$html4 = $this->load->view('print_files/pos_pdf_compact' . POSV, $data4, true);
		
        $pdf = $this->pdf->load_split(array('margin_top' => 10));
		$loc2 = location(0);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">Processado por Programa Certificado nº'.$loc2['certification'].' {PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
		if($data['invoice']['numcop'] == 'copy1')
		{
			$pdf->WriteHTML($html);
		}else if($data['invoice']['numcop'] == 'copy2')
		{
			$pdf->WriteHTML($html);
			$pdf->AddPage();
			$pdf->WriteHTML($html2);
		}else if($data['invoice']['numcop'] == 'copy3')
		{
			$pdf->WriteHTML($html);
			$pdf->AddPage();
			$pdf->WriteHTML($html2);
			$pdf->AddPage();
			$pdf->WriteHTML($html3);
		}else if($data['invoice']['numcop'] == 'copy4')
		{
			$pdf->WriteHTML($html);
			$pdf->AddPage();
			$pdf->WriteHTML($html2);
			$pdf->AddPage();
			$pdf->WriteHTML($html3);
			$pdf->AddPage();
			$pdf->WriteHTML($html4);
		}
		
        // render the view into HTML
        // write the HTML into the PDF
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'PosInvoice_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }

        unlink('userfiles/pos_temp/' . $data['qrc']);
    }


    public function set_coupon()
    {
        $id = $this->input->post('coupon');
        if ($id) {
            $this->db->select('*');
            $this->db->from('geopos_promo');
            $this->db->where('code', $id);
            $query = $this->db->get();
            $promo = $query->row_array();
            if (($promo['active'] == 0) && ($promo['available'] > 0) && (strtotime($promo['valid']) >= strtotime(date('Y-m-d')))) {
                echo json_encode(array('status' => 'Success', 'message' => $promo['code'] . ' ' . $this->lang->line('Coupon Applied') . ' ' . $this->lang->line('Amount') . ' ' . amountFormat_general($promo['amount']), 'amount' => amountFormat_general($promo['amount'])));
            } elseif (($promo['active'] == 0) && ($promo['available'] > 0) && (strtotime($promo['valid']) < strtotime(date('Y-m-d')))) {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Coupon Expired'), 'amount' => 0));
            } elseif ($promo['active'] > 0) {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Usages Exceed'), 'amount' => 0));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('Invalid Coupon'), 'amount' => 0));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => '', 'amount' => 0));
        }


    }

    public function send_invoice_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(6);
		
		$mailfromtilte = '';
		$mailfrom = '';
		
		$this->db->select("emailo_remet, email_app");
		$this->db->from('geopos_system_permiss');
		$this->db->where('docs_email', 1);
		if($this->aauth->get_user()->loc > 0){
			$this->db->where('loc', $this->aauth->get_user()->loc);
		}else{
			$this->db->where('loc', 0);
		}
		$query = $this->db->get();
		$vals = $query->row_array();
		$mailfromtilte = $vals['emailo_remet'];
		$mailfrom = $vals['email_app'];
		
        $data = array(
            'Company' => $mailfromtilte,
            'BillNumber' => $invocieno2
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);


        $data = array(
            'Company' => $mailfromtilte,
            'BillNumber' => $invocieno2,
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $mailfromtilte . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
        return array('subject' => $subject, 'message' => $message);
    }

    public function send_sms_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(30);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
        $this->load->model('plugins_model', 'plugins');
        $sms_service = $this->plugins->universal_api(1);
        if ($sms_service['active']) {
            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);
        }
        $data = array(
            'BillNumber' => $invocieno2,
            'URL' => $link,
            'DueDate' => dateformat($idate),
            'Amount' => amountExchange($total, $multi)
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
        return array('message' => $message);
    }


    public function invoicepdf()
    {
        $run = false;
        $id = $this->input->get('id');
        $key = $this->input->get('key');
        $this->db->select('key');
        $this->db->from('geopos_restkeys');
        $this->db->limit(1);
        $this->db->where('key', $key);
        $query_r = $this->db->get();
        if ($query_r->num_rows() > 0) {
            $run = true;
        }

        if (!$run) {
            exit('eer');
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $tid = $id;
        $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);


        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';

            $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
            $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
        }

        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $data['round_off'] = $this->custom->api_config(4);
        $html = $this->load->view('print_files/pos_pdf_compact', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);
        $file_name = substr($key, 0, 6) . $id;
        $pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        if (!extension_loaded('imagick')) {
            echo 'imagick not installed';
        }
        $im = new Imagick();
        $im->setResolution(300, 300);
        $im->readimage(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');
        $im->setImageType(imagick::IMGTYPE_TRUECOLOR);
        $im->setImageFormat('png');
        //$im->transparentPaintImage(      'white', 0, 100, false    );
        $im->writeImage(FCPATH . 'userfiles/pos_temp/rest-' . $file_name . '.png');
        $im->clear();
        $im->destroy();
        unlink('userfiles/pos_temp/' . $data['qrc']);
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.pdf');


    }

    public function invoiceclean()
    {
        $file_name = substr($this->input->get('key'), 0, 6) . $this->input->get('id');
        unlink(FCPATH . 'userfiles/pos_temp/' . $file_name . '.png');

    }

    public function view_payslip()
    {
        $id = $this->input->get('id');
        $inv = $this->input->get('inv');
        $data['invoice'] = $this->invocies->invoice_details($inv, $this->limited);
        if (!$data['invoice']['id']) exit('Limited Permissions!');

        $this->load->model('transactions_model', 'transactions');
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;

        $data['trans'] = $this->transactions->view($id);

        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'], $data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }
        ini_set('memory_limit', '64M');

        $html = $this->load->view('transactions/view-print-customer', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Trans_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Trans_#' . $id . '.pdf', 'I');
        }


    }

        public function invoice_legacy()
    {

        $id = $this->input->post('inv');

        if (!$id) {
            exit('eer');
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $file_name = rand(99,999) . $id.time();

        $tid = $id;
        $data['qrc'] = $file_name. '.png';
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);


        $this->load->model('billing_model', 'billing');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 1) {
            $token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
            $data['qrc'] = $file_name. '.png';

            $qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));

//header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();
            $qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
        }

        $this->pheight = 0;
        $this->load->library('pdf');
        $pdf = $this->pdf->load_thermal();
        // retrieve data from model or just static date
        $data['title'] = "items";
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        //   $pdf->SetDirectionality('rtl'); // Set lang direction for rtl lang
        $pdf->autoLangToFont = true;
        $data['round_off'] = $this->custom->api_config(4);
        $html = $this->load->view('print_files/pos_pdf_compact', $data, true);
        // render the view into HTML

        $h = 160 + $this->pheight;
        $pdf->_setPageSize(array(70, $h), $pdf->DefOrientation);
        $pdf->WriteHTML($html);

        $r=$pdf->Output('userfiles/pos_temp/' . $file_name . '.pdf', 'F');
        echo  json_encode(array('status'=>'Success','file_name'=> $file_name));

    }
    public function invoice_clean()
    {
        $file_id = $this->input->post('file_id', true);
        unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_id . '.png');
        unlink(FCPATH . 'userfiles' . DIRECTORY_SEPARATOR . 'pos_temp' . DIRECTORY_SEPARATOR . $file_id . '.pdf');

    }

}