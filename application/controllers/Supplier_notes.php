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
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Omnipay\Omnipay;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Supplier_notes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_notes_model', 'notes_model');
		$this->load->library("Custom");
        $this->load->library("Aauth");
		$this->load->library("Common");
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('supplier_model', 'supplier');
		$this->load->model('settings_model', 'settings');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ((!$this->aauth->premission(57) && !$this->aauth->premission(122)) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		
		if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(128)) {
            $this->limited = '';
        } else {
			$this->limited = $this->aauth->get_user()->id;
        }
		$this->li_a = 'suppliers';
        //exit('Em desenvolvimento. Obrigado pela Compreensão.');
    }
	
	//invoices list
    public function index()
    {
		$ty = $this->input->get('ty');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
		if($ty == 'c'){
			$head['title'] = "Gestor de Notas de Crédito";
			$this->li_a = 'suppliers';
			$this->load->view('supplier_notes/invoices');
		}else if($ty == 'p'){
			$head['title'] = "Gestor de Pedidos de Garantias";
			$this->li_a = 'suppliers';
			$this->load->view('supplier_notes/invoices_p');
		}else{
			$head['title'] = "Gestor de Notas de Débito";
			$this->li_a = 'suppliers';
			$this->load->view('supplier_notes/invoices_d');
		}
        $this->load->view('fixed/footer');
    }
	
	public function create_p()
    {
		$this->create(0,0,2);
	}
	
	public function create_c()
    {
		$this->create(0,0,1);
	}
	
	public function create_d()
    {
		$this->create(0,0,0);
	}
	
    //
    public function create($relation = 0, $typrelation = 0, $typ = 0)
    {
		$this->load->model('accounts_model');
		$this->load->model('locations_model', 'locations');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
		$this->load->model('customers_model', 'customers');
		$this->load->library("Custom");
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->notes_model->currencies();
		$typename = "";
		if($typ == 1)
		{
			$head['title'] = "Nova Nota de Crédito Fornecedor";
			if(count($this->settings->billingterms(21)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo Notas de Crédito Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$typename = "Nota de Crédito ";
			$data['terms'] = $this->settings->billingterms(21);
		}else if($typ == 2)
		{
			$head['title'] = "Novo Pedido de Garantia Fornecedor";
			if(count($this->settings->billingterms(25)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Pedido de Garantia Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$typename = "Pedido de Garantia ";
			$data['terms'] = $this->settings->billingterms(25);
		}else{
			$head['title'] = "Nova Nota de Débito Fornecedor";
			if(count($this->settings->billingterms(20)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo Notas de Débito Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$typename = "Nota de Débito ";
			$data['terms'] = $this->settings->billingterms(20);
		}
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		
		$data['typrelation'] = $typrelation;
		$data['relationid'] = $relation;
		
		if($relation > 0)
		{
			if($typrelation == 0){
				$data['tiprelated'] = 1;
			}
			$this->load->library("Related");
			$data['docs_origem'][] = $this->related->detailsAfterRelation($relation,$typrelation);
			$data['csd_name'] = $data['docs_origem'][0]['name'];
			$data['csd_tax'] = $data['docs_origem'][0]['taxid'];
			$data['csd_id'] = $data['docs_origem'][0]['id'];
			$data['products'] = $this->related->detailsAfterRelationProducts($relation,$typrelation,0);
		}else{
			$data['csd_name'] = '';
			$data['csd_tax'] = "";
			$data['csd_id'] = "";
			$data['docs_origem'] = [];
			$data['products'] = [];
		}
		
		////////////////////////Relação entre Permissões//////////////////////
		///////////////////////////////////////////////////////////////////////
		$data['autos'] = $this->common->guide_autos_company();
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
		}
		
		if($discship['ac_id_f'] == 0 && $discship['pac'] == 0)
		{
			if($this->aauth->get_user()->loc == 0)
			{
				exit('Defina a conta Por defeito para os Documentos de Fornecedor na Empresa! <a class="match-width match-height" href="'.base_url().'settings/company?id=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}else{
				exit('Defina a conta Por defeito para os Documentos de Fornecedor na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}
		}else{
			if($discship['ac_id_f'] == 0)
			{
				if($this->aauth->get_user()->loc){
					exit('Defina a conta Por defeito para os Documentos de Fornecedor na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
				}
			}
			$accountin = $this->accounts_model->details($discship['ac_id_f'],false);
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
		
		$data['typenote'] = $typ;
		$data['type_return'] = $typename;
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->notes_model->warehouses();
        $data['taxdetails'] = $this->common->taxdetail();
		$data['currency'] = $this->notes_model->currencies();
		$data['taxsiva'] = $this->settings->slabscombo();		
		$data['typesinvoices'] = "";
		if($typ == 1)
		{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(21);
		}else if($typ == 2)
		{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(25);
		}else{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(20);
		}
		$data['seriesinvoiceselect'] = $this->common->default_series($this->aauth->get_user()->loc);
		
		if($data['seriesinvoiceselect'] == NULL)
		{
			if($typ == 1)
			{
				exit('Deve Inserir pelo menos uma Série no Tipo Notas de Crédito Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}else if($typ == 2)
			{
				exit('Deve Inserir pelo menos uma Série no Pedido de Garantia Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}else{
				exit('Deve Inserir pelo menos uma Série no Tipo Notas de Débito Fornecedores. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
		}else{
			$seri_did_df = $this->common->default_series_id($this->aauth->get_user()->loc);
			if($typ == 1)
			{
				$numget = $this->common->lastdoc(21,$seri_did_df);
			}else if($typ == 2)
			{
				$numget = $this->common->lastdoc(25,$seri_did_df);
			}else{
				$numget = $this->common->lastdoc(20,$seri_did_df);
			}
			
			$data['custom_fields'] = [];
			$data['c_custom_fields'] = $this->custom->add_fields(4);
			$data['lastinvoice'] = $numget;
			$this->load->view('fixed/header', $head);
			if($typ == 1)
			{
				$this->load->view('supplier_notes/newinvoice', $data);
			}else if($typ == 2)
			{
				$this->load->view('supplier_notes/newinvoicep', $data);
			}else{
				$this->load->view('supplier_notes/newinvoiced', $data);
			}
			
			$this->load->view('fixed/footer');
		}
    }

	
    //edit invoice
    public function edit()
    {
		$this->load->model('accounts_model');
		$this->load->library("Common");
		$this->load->model('supplier_model', 'supplier');
		$this->load->model('settings_model', 'settings');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('locations_model', 'locations');
		
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        
		$data['company'] = $this->settings->company_details(1);
		$data['typesinvoices'] = "";
		$data['seriesinvoice'] = "";
		
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['currency'] = $this->notes_model->currencies();
		$draf = $this->input->get('draf');
		
		if($draf == 0){
			$head['title'] = "Alterar Nota #$tid";
			$data['title'] = "Alterar Nota #$tid";
			$data['typeinvoice'] = 'Alteração';
		}else{
			$head['title'] = "Alterar Rascunho #$tid";
			$data['title'] = "Alterar Rascunho #$tid";
			$data['typeinvoice'] = 'Rascunho';
		}
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$data['iddoc'] = $data['invoice']['id'];
		$data['csd_name'] = $data['invoice']['name'];
		$data['csd_tax'] = $data['invoice']['taxid'];
		$data['csd_id'] = $data['invoice']['id'];
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$data['relationid'] = $data['invoice']['factura_duplicada'];
		$data['tiprelated'] = 0;
		$this->load->library("Related");
		$typerelatset = 0;
		if($data['invoice']['irs_type'] == 20){
			$typerelatset = 10;
		}else if($data['invoice']['irs_type'] == 21){
			$typerelatset = 11;
		}else{
			$typerelatset = 111;
		}
		
		if($draf == 0){
			$data['docs_origem'] = $this->related->getRelated($tid,0,0,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,0,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,0);
		}else{
			$data['docs_origem'] = $this->related->getRelated($tid,0,1,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,1,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,1);
		}
		///////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////
		if($data['docs_deu_origem'] != null){
			if(count($data['docs_deu_origem']) > 0)
			{
				if($data['docs_deu_origem'][0] != null)
				{
					for($i = 0; $i < count($data['docs_deu_origem']); $i++)
					{
						if($data['docs_deu_origem'][$i]['tipologia'] == 1){
							$data['tiprelated'] = $data['docs_deu_origem'][$i]['doc'];
							break;
						}
					}
				}
			}
		}
		
		$data['custom_fields'] = [];
		$data['c_custom_fields'] = $this->custom->view_edit_fields($data['invoice']['cid'], 4);
		
		$data['invoice'] = $this->notes_model->purchase_details($tid);
        $data['products'] = $this->notes_model->purchase_products($tid);
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['countrys'] = $this->common->countrys();
        $data['warehouse'] = $this->notes_model->warehouses();
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['taxsiva'] = $this->settings->slabscombo();
		$data['taxdetails'] = $this->common->taxdetail();
		
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
		}
		
		if($discship['ac_id_f'] == 0 && $discship['pac'] == 0)
		{
			if($this->aauth->get_user()->loc == 0)
			{
				exit('Defina a conta Por defeito dos Fornecedores para os Documentos na Empresa! <a class="match-width match-height" href="'.base_url().'settings/company?id=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}else{
				exit('Defina a conta Por defeito para os Documentos dos Fornecedores na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
			}
		}else{
			if($discship['ac_id_f'] == 0)
			{
				if($this->aauth->get_user()->loc){
					exit('Defina a conta Por defeito para os Documentos dos Fornecedores na Localização! <a class="match-width match-height" href="'.base_url().'locations/edit?id='.$this->aauth->get_user()->loc.'&param=77"><i class="ft-chevron-right">Click aqui para o Fazer.</i></a>');
				}
			}
			$accountin = $this->accounts_model->details($discship['ac_id_f'],false);
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
		
		$data['typesinvoices'] = [];
		$data['typesinvoicesdefault'] = $this->common->default_typ_doc($data['invoice']['irs_type']);
		$data['seriesinvoiceselect'] = $this->common->default_series($this->aauth->get_user()->loc);
		if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$data['locations'] = $this->settings->company_details(1);
		}else{
			$data['locations'] = $this->settings->company_details2($this->aauth->get_user()->loc);
		}
		
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier_notes/edit', $data);
        $this->load->view('fixed/footer');

    }
	
	public function editaction()
    {
		$idg = $this->input->post('iddoc');
		$this->action(3,$idg);
	}
	
	public function editaction2()
    {
		$idg = $this->input->post('iddoc');
		$this->action(2,$idg);
	}
	
	
	public function editaction3()
    {
		$idg = $this->input->post('iddoc');
		$this->action(4,$idg);
	}
	
	public function editaction4()
    {
		$idg = $this->input->post('iddoc');
		$this->action(5,$idg);
	}
	
	public function action3()
    {
		$this->action(4);
	}
	
	public function action4()
    {
		$this->action(6);
	}
	
	public function action2()
    {
		$this->action(1);
	}

    //action
	public function action($typ = 0, $idgu = 0)
	{
        $this->load->model('accounts_model');
		$this->load->model('customers_model', 'customers');
        $currency = $this->input->post('mcurrency');
		if($currency == null || $currency="" || $currency="0"){
			$currencyCOde = $this->accounts_model->getCurrency();
			$currency = $currencyCOde['id'];
		}
		$quote_tid = $this->input->post('quote_tid');
		$customer_id = ((integer)$this->input->post('customer_id'));
		$account_set_id = $this->input->post('account_set_id');
		$account_set = $this->input->post('account_set');
		if ($account_set_id == 0 || $account_set_id == "0") {
			echo json_encode(array('status' => 'Error', 'message' => 'Não foi selecionada qualquer conta para a Operação.'));
            exit;
        }
		
		$accountincome = $account_set_id;
		$accountincomename = $account_set;
		
        $invoicedate = $this->input->post('invoicedate', true);
        $invocieduedate = $this->input->post('invocieduedate', true);
        $notes = $this->input->post('notes', true);
		$typenot = $this->input->post('type_note', true);
		$invoi_type = $this->input->post('invoi_type', true);
		$invoi_serie = $this->input->post('invoi_serie', true);
		
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = $this->input->post('disc_val');
		$discs_come = $this->input->post('discs_come');
		
		$taxas_tota = $this->input->post('taxas_tota');
		$warehouse = $this->input->post('s_warehouses', true);
        $subtotal = $this->input->post('subttlform_val');
        $shipping = $this->input->post('shipping');
        $shipping_tax = $this->input->post('ship_tax');
		
        $refer = $this->input->post('refer', true);
        $total = $this->input->post('totalpay');
        $total_tax = 0;
        $total_discount_tax = $this->input->post('discs_tot_val');
        $discountFormat = $this->input->post('discountFormat');
		
		$tax = $this->input->post('tax_handle');
        $pterms = $this->input->post('pterms', true);
		$tota_items = $this->input->post('tota_items');
        $i = 0;
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecionar um Fornecedor'));
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
		
        $transok = true;
        $st_c = 0;
        $this->load->library("Common");
        $this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
		
		$this->load->library("Common");
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$invocieno = $numget+1;
		$invocieno2 = $invocieno;
		
		$extmov = 0;
		if($typ == 4 || $typ == 5){
			$extmov = 1;
		}
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'type' => $typenot, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $discs_come,'discount_rate' => $disc_val, 'tax' => $taxas_tota, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $emp, 'items' => $tota_items, 'taxstatus' => $tax, 'total_discount_tax' => $total_discount_tax, 'format_discount' => $discountFormat, 'refer' => $refer, 'ref_enc_orc' => $invocieencorc, 'term' => $pterms, 'multi' => $currency, 'loc' => $warehouse, 'tax_id' => $customer_tax, 'serie' => $invoi_serie, 'irs_type' => $invoi_type);
		
		if($typ == 0 || $typ == 3 || $typ == 4){
			if($typ == 3 || $typ == 4){
				$this->db->delete('geopos_draft', array('id' => $idgu));
				$this->db->delete('geopos_draft_items', array('tid' => $idgu));
				$this->db->where('type_log', 'notes_f_draft');
				$this->db->delete('geopos_log', array('id_c' => $idgu));
			}
			
			if ($this->db->insert('geopos_supplier_notes', $data)) {
				$invocieno = $this->db->insert_id();
				
				$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
				$this->db->set('start', "$invocieno2", FALSE);
				$this->db->where($multiClause);
				$this->db->update('geopos_series_ini_typs');
				
				//products
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
				
				$taxaname = $this->input->post('taxaname');
				$taxaid = $this->input->post('taxaid');
				$taxacod = $this->input->post('taxacod');
				$taxaperc = $this->input->post('taxaperc');
				$taxavals = $this->input->post('taxavals');	
				$taxacomo = $this->input->post('taxacomo');
				
				foreach ($product_id as $key => $value) {
					$total_tax = 0;
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
						'totaldiscount' => $ptotal_disc[$key],
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
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
				}
				if ($prodindex > 0) {
					$this->db->insert_batch('geopos_supplier_notes_items', $productlist);
					$this->db->trans_complete();
				} else {
					echo json_encode(array('status' => 'Error', 'message' => "Please choose product from product list. Go to Item manager section if you have not added the products."));
					$transok = false;
				}
				if ($transok) {
					$validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
					$link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
					
					// now try it
					$ua=$this->aauth->getBrowser();
					$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
					$striPay = "[CREATED]<br>Utilizador: ".$this->aauth->get_user()->username;
					$striPay = $striPay.'<br>'.$yourbrowser;
					$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
					
					
					$striPay .= '<br>Nota Crédito Nº para o Fornecedor: '.$customer_name;
					$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'notes_f', $invocieno);
					
					
					$this->db->set('lastbal', "lastbal+$total_pay", FALSE);
					$this->db->where('id', $accountincome);
					$this->db->update('geopos_accounts');
					
					echo json_encode(array('status' => 'Success', 'message' => "Documento Criado com Sucesso. <a href='view?id=$invocieno&draf=0&ty=$typenot' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&draf=0&ty=$typenot' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
				}
			} else {
				echo json_encode(array('status' => 'Error', 'message' => "Problema ao criar a fatura. Tente mais tarde."));
				$transok = false;
			}
			if ($transok) {
				$this->db->trans_complete();
			} else {
				$this->db->trans_rollback();
			}
			if ($transok) {
				$this->db->from('univarsal_api');
				$this->db->where('univarsal_api.id', 56);
				$query = $this->db->get();
				$auto = $query->row_array();
				/*if ($auto['key1'] == 1) {
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
				}*/
			}
		}else if($typ == 1 || $typ == 5){
			if ($this->db->insert('geopos_draft', $data)) {
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
						'totaldiscount' => $ptotal_disc[$key],
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
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
                }
				$this->db->insert_batch('geopos_draft_items', $productlist);
				$this->db->set(array('i_class' => 3));
				$this->db->where('id', $invocieno);
				$this->db->update('geopos_draft');
				
				$this->db->trans_complete();
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "[CREATED]<br>Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay .= '<br>Rascunho Nº (Provisório)'.$invocieno2.' para o Fornecedor: '.$customer_name;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'notes_f_draft', $invocieno);
				
                if ($transok) 
					echo json_encode(array('status' => 'Success', 'message' => "Rascunho criado com Sucesso. <a href='view?id=$invocieno&draf=1&ty=$typenot' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&draf=1&ty=$typenot' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Erro a criar rascunho na Fatura. Tente mais tarde."));
                $transok = false;
            }
		}else{
			$this->db->set($data);
			$this->db->where('id', $idgu);
			if ($this->db->update('geopos_draft')) {
				$this->db->delete('geopos_draft_items', array('tid' => $idgu));
				$invocieno = $idgu;
				$this->db->trans_complete();
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
						'totaldiscount' => $ptotal_disc[$key],
						'product_des' => $product_des[$key],
						'unit' => $product_unit[$key],
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
                }
				
				$this->db->insert_batch('geopos_supplier_notes_items', $productlist);
				$this->db->trans_complete();
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "[UPDATED]<br>Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay .= '<br>Rascunho Atualizado Nº (Provisório)'.$invocieno2.' para o Fornecedor: '.$customer_name;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'notes_f_draft', $invocieno);
				
                echo json_encode(array('status' => 'Success', 'message' => "Atualização de Rascunho com Sucesso. <a href='view?id=$invocieno&draf=1&ty=$typenot' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&draf=1&ty=$typenot' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
			}else {
				echo json_encode(array('status' => 'Error', 'message' => "Erro ao guardar Rascunho!"));
				$transok = false;
				exit;
			}
			
		}
    }

    public function ajax_list()
    {
		$ty = $this->input->post('typ');
        $list = $this->notes_model->get_datatables($ty);
        $data = array();

        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
			$row['status'] = $invoices->status;
            $row[] = $no;
			$row[] = $invoices->serie_name;
			$row[] = '<a href="' . base_url("supplier_notes/view?id=$invoices->id&draf=0&ty=".$ty) . '">&nbsp; ' . $invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
			$option = '';
			if($invoices->status == 'canceled'){
				if($ty == 1)
				{
					if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(57))
					{
						$option .= '<a href="' . base_url("supplier_notes/view?id=$invoices->id&draf=0&ty=".$ty) . '" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("supplier_notes/printinvoice?id=$invoices->id&draf=0&ty=".$ty) . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
					}
				}else{
					if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(122))
					{
						$option .= '<a href="' . base_url("supplier_notes/view?id=$invoices->id&draf=0&ty=".$ty) . '" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("supplier_notes/printinvoice?id=$invoices->id&draf=0&ty=".$ty) . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
					}
				}
				$option .= '<a data-toggle="modal" data-target="#choise_type_duplicate" href="#" data-object-serie="'.$invoices->serie_name.'" data-object-type="'.$invoices->irs_type.'" data-object-type_n="'.$invoices->irs_type_c.'" data-object-type_s="'.$invoices->type.'" data-object-ext="' . $invoices->ext . '" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm duplicate-object" title="Duplicar"><span class="ft-target"></span></a>';
				$row[] = $option;
			}else{
				if($ty == 1)
				{
					if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(45))
					{
						$option .= '<a href="' . base_url("supplier_notes/view?id=$invoices->id&draf=0&ty=".$ty) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("supplier_notes/printinvoice?id=$invoices->id&ty=".$ty) . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
					}
				}else{
					if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(125))
					{
						$option .= '<a href="' . base_url("supplier_notes/view?id=$invoices->id&draf=0&ty=".$ty) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("supplier_notes/printinvoice?id=$invoices->id&ty=".$ty) . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
					}
				}
				$option .= '<a data-toggle="modal" data-target="#choise_type_convert" href="#" data-object-serie="'.$invoices->serie_name.'" data-object-type="'.$invoices->irs_type.'" data-object-type_n="'.$invoices->irs_type_c.'" data-object-type_s="'.$invoices->type.'" data-object-ext="' . $invoices->ext . '" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm convert-object" title="Converter"><span class="icon-briefcase"></span></a>&nbsp;';
				$option .= '<a data-toggle="modal" data-target="#choise_type_duplicate" href="#" data-object-serie="'.$invoices->serie_name.'" data-object-type="'.$invoices->irs_type.'" data-object-type_n="'.$invoices->irs_type_c.'" data-object-type_s="'.$invoices->type.'" data-object-ext="' . $invoices->ext . '" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm duplicate-object" title="Duplicar"><span class="ft-target"></span></a>&nbsp;';
				$option .= '<a data-toggle="modal" data-target="#choise_docs_related" data-object-serie="'.$invoices->serie_name.'" data-object-type="'.$invoices->irs_type.'" data-object-type_n="'.$invoices->irs_type_c.'" data-object-type_s="'.$invoices->type.'" data-object-ext="' . $invoices->ext . '" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '"href="#" class="btn btn-success btn-sm related-object" title="Documentos Relacionados"><span class="icon-list"></span></a>';
				
				if ($this->aauth->get_user()->roleid == 7 || $this->aauth->premission(121)) {
					$option .= '&nbsp;<a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
				}
				$row[] = $option;
			}
            $data[] = $row;
        }

        $numtab1 = $this->notes_model->count_all($this->limited);
		$numfil1 = $this->notes_model->count_filtered($this->limited);
		$list = $this->notes_model->get_datatables2($this->limited,'c');
        foreach ($list as $drafts) {
            $no++;
			$textini = $drafts->tid;
			$textini .= '<br>(Provisório)';
			$width = round(0,2);
            $row = array();
			$row['status'] = 'draft';
			$row[] = $no;
			$row[] = $drafts->serie_name;
            $row[] = '<a href="' . base_url("supplier_notes/view?id=$drafts->id&draf=1&ty=".$ty) . '">&nbsp; ' . $textini . '</a>';
            $row[] = $drafts->name;
            $row[] = dateformat($drafts->invoicedate);
            $row[] = amountExchange($drafts->total, 0, $this->aauth->get_user()->loc);
            $row[] = 'Rascunho';
            $option = '<a href="' . base_url("supplier_notes/view?id=$drafts->id&draf=1&ty=".$ty) . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$drafts->id&draf=1&ty=".$ty) . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7)
			{
				$option .= '<a href="#" data-object-id="' . $drafts->id . '" data-object-tid="' . $drafts->tid . '" data-object-draft="0" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
		
		$numtab1 .= $this->notes_model->count_all2($this->limited);
		$numfil1 .= $this->notes_model->count_filtered2($this->limited);
		
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $numtab1,
            "recordsFiltered" => $numfil1,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

	public function view()
    {
        $this->load->model('accounts_model');
		$this->load->library("Common");
        $tid = $this->input->get('id');
		$token = $this->input->get('token');
		$draf = $this->input->get('draf');
		$type = $this->input->get('ty');
		
		if($type == 1){
			$data['typeinvoice'] = 1;
			if($draf == 0){
				$data['draft'] = 0;
				$data['invoice'] = $this->notes_model->supplier_notes_details($tid, $this->limited);
				$data['title'] = "Nota de Crédito Fornecedor " . $data['invoice']['tid'];
				$head['title'] = "Nota de Crédito Fornecedor " . $data['invoice']['tid'];
				$data['attach'] = $this->notes_model->attach($tid);
				$data['history'] = $this->common->history($tid,'notes_f');
			}else{
				$data['draft'] = 1;
				$data['invoice'] = $this->notes_model->supplier_notes_details2($tid, $this->limited);
				$data['title'] = "Rascunho Nota de Crédito Fornecedor " . $data['invoice']['tid'];
				$head['title'] = "Rascunho Nota de Crédito Fornecedor " . $data['invoice']['tid'];
				$data['history'] = $this->common->history($tid,'notes_f_draft');
			}
		}else{
			$data['typeinvoice'] = 2;
			if($draf == 0){
				$data['draft'] = 0;
				$data['invoice'] = $this->notes_model->supplier_notes_details($tid, $this->limited);
				$data['title'] = "Nota de Débito Fornecedor " . $data['invoice']['tid'];
				$head['title'] = "Nota de Débito Fornecedor " . $data['invoice']['tid'];
				$data['attach'] = $this->notes_model->attach($tid);
				$data['history'] = $this->common->history($tid,'notes_f');
			}else{
				$data['draft'] = 1;
				$data['invoice'] = $this->notes_model->supplier_notes_details2($tid, $this->limited);
				$data['title'] = "Rascunho Nota de Débito Fornecedor " . $data['invoice']['tid'];
				$head['title'] = "Rascunho Nota de Débito Fornecedor " . $data['invoice']['tid'];
				$data['history'] = $this->common->history($tid,'notes_f_draft');
			}
		}
		
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$data['relationid'] = $data['invoice']['factura_duplicada'];
		$data['tiprelated'] = 0;
		$this->load->library("Related");
		$typerelatset = 0;
		if($data['invoice']['irs_type'] == 20){
			$typerelatset = 10;
		}else if($data['invoice']['irs_type'] == 21){
			$typerelatset = 11;
		}else{
			$typerelatset = 111;
		}
		
		if($draf == 0){
			$data['docs_origem'] = $this->related->getRelated($tid,0,0,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,0,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,0);
		}else{
			$data['docs_origem'] = $this->related->getRelated($tid,0,1,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,1,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,1);
		}
		///////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////
		
		$data['c_custom_fields'] = [];
		$data['custom_fields'] = [];
        if (CUSTOM) 
			$data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 4, 1);
			
        $data['iddoc'] = $data['invoice']['id'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $data['employee'] = $this->notes_model->employee($data['invoice']['eid']);
		$data['invoice']['id'] = $tid;
		if($type == 0){
			$this->load->view('supplier_notes/view', $data);
		}else{
			$this->load->view('supplier_notes/viewdraft', $data);
		}
        $this->load->view('fixed/footer');
    }

    public function printinvoice()
    {
		if (!$this->input->get()) {
            exit();
        }
        $tid = $this->input->get('id');
		$token = $this->input->get('token');
		$type = $this->input->get('ty');
		$data['id'] = $tid;
		
		if($type == 0){
			$data['typeinvoice'] = 'Invoice';
			$data['invoice'] = $this->notes_model->supplier_notes_details($tid, $this->limited);
			if($data['invoice']['status'] == 'canceled')
			{
				$data['ImageBackGround'] = 'assets/images/anulada.png';
			}
		}else{
			$data['invoice'] = $this->notes_model->supplier_notes_details2($tid, $this->limited);
			$data['typeinvoice'] = 'Rascunho';
			$data['invoice']['status'] = 'Rascunho';
			$data['ImageBackGround'] = 'assets/images/rascunho.png';
		}
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$data['relationid'] = $data['invoice']['factura_duplicada'];
		$data['tiprelated'] = 0;
		$this->load->library("Related");
		$typerelatset = 0;
		if($data['invoice']['irs_type'] == 20){
			$typerelatset = 10;
		}else if($data['invoice']['irs_type'] == 21){
			$typerelatset = 11;
		}else{
			$typerelatset = 111;
		}
		
		if($draf == 0){
			$data['docs_origem'] = $this->related->getRelated($tid,0,0,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,0,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,0);
		}else{
			$data['docs_origem'] = $this->related->getRelated($tid,0,1,$typerelatset,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,1,0,$typerelatset);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,$typerelatset,1);
		}
		///////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////
		
		$data['c_custom_fields'] = [];
		$data['custom_fields'] = [];
        if (CUSTOM) 
			$data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 4, 1);
		
		$data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $data['general'] = array('title' => $data['invoice']['irs_type_s'].' - '.$data['invoice']['irs_type_n'], 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
		
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
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		$data3 = $data;
		$data3['Tipodoc'] = "Triplicado";
		$data4 = $data;
		$data4['Tipodoc'] = "Quadruplicado";
		
		$html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
		$html2 = $this->load->view('print_files/invoice-a4_v' . INVV, $data2, true);
		$html3 = $this->load->view('print_files/invoice-a4_v' . INVV, $data3, true);
		$html4 = $this->load->view('print_files/invoice-a4_v' . INVV, $data4, true);
		
		$this->load->library('pdf');
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
		
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'NT_'.$data['invoice']['irs_type_s'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    public function delete_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');
		$tid = $this->input->post('deletetid');
		$draft = $this->input->post('draft');
		
		if($draft == 0)
		{
			//$this->db->delete('geopos_log', array('id_c' => $id,'type_log' => 'note_f'));
			$this->db->delete('geopos_data_related', array('tid' => $id));
			$this->db->delete('geopos_data_transport', array('tid' => $id));
			$this->db->delete('geopos_supplier_notes_items', array('id' => $id));
			$this->db->delete('geopos_supplier_notes', array('id' => $id));
			// now try it
			//$ua=$this->aauth->getBrowser();
			//$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			
			//$striPay = "Utilizador: ".$this->aauth->get_user()->username;
			//$striPay = $striPay.'<br>'.$yourbrowser;
			//$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
			//$striPay = $striPay.'<br>Rascunho Removido: '.$tid;
			//$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'note_f', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Rascunho removido com Sucesso.'));
		}else{
			$justification = $this->input->post('justification');
			$this->db->set('status', 'canceled');
			$this->db->set('justification_cancel', $justification);
			$this->db->where('id', $id);
			$this->db->update('geopos_supplier_notes');
			
			$ua=$this->aauth->getBrowser();
			$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			
			$striPay = "Utilizador: ".$this->aauth->get_user()->username;
			$striPay = $striPay.'<br>'.$yourbrowser;
			$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
			$striPay = $striPay.'<br>Nota Apagada Nº: '.$id;
			$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'note_f', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Documento Anulado com Sucesso.'));
		}
		
        $id = $this->input->post('deleteid');
		$this->db->delete('geopos_supplier_notes_items', array('tid' => $id));
		
		
        if ($this->notes_model->purchase_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }

    
    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');

        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_supplier_notes');

        echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->notes_model->meta_delete($invoice, 5, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->notes_model->meta_insert($id, 5, $files);
            }
        }
    }
}