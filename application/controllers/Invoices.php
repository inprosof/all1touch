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

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Endroid\QrCode\QrCode;

class Invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('plugins_model', 'plugins');
		$this->load->library("Common");
		$this->load->library("Custom");
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		
        if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(128)) {
            $this->limited = '';
        } else {
			$this->limited = $this->aauth->get_user()->id;
        }
        $this->load->library("Custom");
        $this->li_a = 'sales';
    }
	
	public function nt_convert()
	{
		$tid = $this->input->get('qo');
		$this->create(0, $tid);
	}
	
	public function quote_convert()
	{
		$tid = $this->input->get('qo');
		$this->create($tid);
	}

    //create invoice
    public function create($quo = 0, $nt = 0)
    {
		if (!$this->aauth->premission(2) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		$this->load->model('locations_model', 'locations');
		$this->load->model('accounts_model');
        $this->load->library("Common");
		$this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
		$typegg = $this->input->get('ty');
		$typename = "";
		if($typegg == null || $typegg == '')
		{
			$typegg = 1;
			$typename = 'Fatura';
		}else if($typegg == 1)
		{
			$typename = 'Fatura';
		}else if($typegg == 2)
		{
			$typename = 'Fatura Recibo';
		}else if($typegg == 3)
		{
			$typename = 'Fatura Simplificada';
		}else{
			$typegg = 1;
			$typename = 'Fatura';
		}
		$projectget = $this->input->get('project');
		$data['csd_name'] = $this->lang->line('Default').": Consumidor Final";
		$data['csd_tax'] = "999999990";
		$data['csd_id'] = "99999999";
		
		if($projectget != "")
		{
			$csdproject = $this->customers->detailsFromProject($projectget);
			$data['csd_name'] = $csdproject['name'];
			$data['csd_tax'] = $csdproject['taxid'];
			$data['csd_id'] = $csdproject['id'];
		}
		
		if($quo > 0)
		{
			$data['invoice'] = $this->invocies->detailsFromQuote($quo);
			$data['csd_name'] = $data['invoice']['name'];
			$data['csd_tax'] = $data['invoice']['taxid'];
			$data['csd_id'] = $data['invoice']['id'];
			$data['quote'] = $quo;
			$data['products'] = $this->invocies->items_with_product_quote($quo);
		}
		
		if($nt > 0)
		{
			$data['invoice'] = $this->invocies->detailsFromNT($nt);
			$data['csd_name'] = $data['invoice']['name'];
			$data['csd_tax'] = $data['invoice']['taxid'];
			$data['csd_id'] = $data['invoice']['id'];
			$data['not_enc'] = $nt;
			$data['products'] = $this->invocies->items_with_product_note_enco($nt);
		}
		
		$discship = $this->plugins->universal_api(65);
		
		if($this->aauth->get_user()->loc == 0)
		{
			$data['accounts'] = $this->locations->accountslist();
			$data['accountid'] = $discship['key2'];
			$data['accountname'] = "Conta Por Defeito";
		}else{
			if($discship['key2'] == "" || $discship['key2'] == null)
			{
				echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecionar uma conta por defeito Configurações de Negócio->Configurações Avançadas->Contabilidade e Entrada Dupla'));
				exit;
			}else{
				$accountin = $this->accounts_model->details($discship['key2'],false);
				$accountincome = ((integer)$accountin['id']);
				$accountincomename = $accountin['holder'];
				$data['accountid'] = $accountincome;
				$data['accountname'] = $accountincomename;
			}
		}
        
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['company'] = $this->settings->company_details(1);
        $data['customergrouplist'] = $this->customers->group_list();
		$data['countrys'] = $this->common->countrys();
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['warehouse'] = $this->invocies->warehouses();
        
        $data['currency'] = $this->invocies->currencies();
		$data['taxsiva'] = $this->settings->slabscombo();
		$data['typesinvoices'] = $this->settings->list_irs_typ_id_fact();
		
		$data['typesinvoicesdefault'] = $this->common->default_typ_doc($typegg);
		$data['seriesinvoiceselect'] = $this->common->default_series($typegg);
		
		if(count($this->settings->billingterms($typegg)) == 0)
		{
			exit('Deve Inserir pelo menos um Termo para o Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}
		$data['terms'] = $this->settings->billingterms($typegg);
		
		
		if($data['seriesinvoiceselect'] == NULL)
		{
			exit('Deve Inserir pelo menos uma Série no Tipo Fatura. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}else{
			$invoi_type = $this->common->default_typ_id_doc($typegg);
			$seri_did_df = $this->common->default_series_id($typegg);
			$numget = $this->common->lastdoc($invoi_type,$seri_did_df);
			$data['lastinvoice'] = $numget;
			
			$head['title'] = 'Novo Documento';
			$head['usernm'] = $this->aauth->get_user()->username;
			$data['taxdetails'] = $this->common->taxdetail();
			$data['custom_fields'] = $this->custom->add_fields(2);
			$this->load->view('fixed/header', $head);
			$this->load->view('invoices/newinvoice', $data);
			$this->load->view('fixed/footer');
		}
    }

    //edit invoice
    public function edit()
    {
		if (!$this->aauth->premission(3) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		$this->load->model('accounts_model');
		$this->load->library("Common");
		$this->load->model('customers_model', 'customers');
		$this->load->model('settings_model', 'settings');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('locations_model', 'locations');
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
		$data['company'] = $this->settings->company_details(1);
		$data['typesinvoices'] = $this->settings->list_irs_typ_id();
		$data['seriesinvoice'] = $this->settings->irs_typ_series(1);
        $data['customergrouplist'] = $this->customers->group_list();
		$data['terms'] = $this->settings->billingterms(1);
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['currency'] = $this->invocies->currencies();
		$type = $this->input->get('ty');
		if($type == 0){
			$head['title'] = "Alterar Fatura #$tid";
			$data['title'] = "Alterar Fatura #$tid";
			$data['typeinvoice'] = 'Invoice';
			$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
			$data['products'] = $this->invocies->items_with_product($tid);
			$data['payments'] = $this->invocies->invoice_transactions($tid);
		}else{
			$head['title'] = "Alterar Rascunho #$tid";
			$data['title'] = "Alterar Rascunho #$tid";
			$data['invoice'] = $this->invocies->invoice_details2($tid, $this->limited);
			$data['products'] = $this->invocies->items_with_product2($tid);
			$data['payments'] = $this->invocies->invoice_transactions2($tid);
			$data['typeinvoice'] = 'Rascunho';
		}

		$data['quote'] = 0;
		if (strpos($data['invoice']['pmethod'], 'NT') !== false)
		{
			$data['quote'] = str_replace("", "QO", $data['invoice']['pmethod']);
		}
		
		$data['not_enc'] = 0;
		if (strpos($data['invoice']['pmethod'], 'NT') !== false)
		{
			$data['not_enc'] = str_replace("", "NT", $data['invoice']['pmethod']);
		}
        
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['countrys'] = $this->common->countrys();
        $data['warehouse'] = $this->invocies->warehouses();
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['taxsiva'] = $this->settings->slabscombo();
        $data['custom_fields'] = $this->custom->view_edit_fields($tid, 2);
		$data['taxdetails'] = $this->common->taxdetail();
		$discship = $this->plugins->universal_api(65);
		
		if($this->aauth->get_user()->loc == 0)
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
		
		if($data['invoice']['status'] == 'paid') 
			redirect(base_url('invoices'));
		
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/edit', $data);	
        $this->load->view('fixed/footer');
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/invoices');
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
	
	public function action2()
    {
		$this->action(1);
	}
	
    //action
    public function action($typ = 0, $idgu = 0)
    {
		$this->load->model('accounts_model');
		$this->load->model('customers_model', 'customers');
		$this->load->model('settings_model', 'settings');
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
		
		$not_e_tid = $this->input->post('not_e_tid');
		$quote_tid = $this->input->post('quote_tid');
		
		$metretnotqo = "";
		if($not_e_tid > 0)
		{
			$metretnotqo = 'NT'.$not_e_tid;
		}
		
		if($quote_tid > 0)
		{
			$metretnotqo = 'QO'.$quote_tid;
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
		$warehouse = $this->input->post('s_warehouses', true);
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
		
        $pterms = $this->input->post('pterms', true);
		$tota_items = $this->input->post('tota_items');
        $i = 0;
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecionar um cliente'));
            exit;
        }
		
		if(!filter_has_var(INPUT_POST,'product_name')) {
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir um Produto'));
            exit;
		}
		
		if(!filter_has_var(INPUT_POST,'pay_met')) {
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir um pagamento'));
            exit;
		}
		
        $this->load->model('plugins_model', 'plugins');
        $empl_e = $this->plugins->universal_api(69);
        if ($empl_e['key1']) {
            $emp = $this->input->post('employee');
        } else {
            $emp = $this->aauth->get_user()->id;
        }
		
        $transok = true;
        $st_c = 0;
       
        $this->db->trans_start();
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
		$this->load->library("Common");
		if($total > 100 && $invoi_type != 2)
		{
			$invoi_type = 2;
		}
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$numget = $numget+1;
		$invocieno = $numget;
		$invocieno2 = $invocieno;
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'pmethod' => $metretnotqo, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $discs_come,'discount_rate' => $disc_val, 'tax' => $taxas_tota, 'total' => $total, 'notes' => $notes, 'status' => 'due', 'csd' => $customer_id, 'eid' => $emp, 'pamnt' => 0, 'items' => $tota_items, 'taxstatus' => $tax, 'total_discount_tax' => $total_discount_tax, 'format_discount' => $discountFormat, 'refer' => $refer, 'ref_enc_orc' => $invocieencorc, 'term' => $pterms, 'multi' => $currency, 'loc' => $warehouse, 'tax_id' => $customer_tax, 'serie' => $invoi_serie, 'i_class' => 0, 'ext' => 0, 'irs_type' => $invoi_type, 'datedoc' => date('Y-m-d H:i:s'));
		
		if($typ == 0 || $typ == 3){
			if($typ == 3){
				$this->db->delete('geopos_draft', array('id' => $idgu));
				$this->db->delete('geopos_draft_items', array('tid' => $idgu));
				$this->db->delete('geopos_draft_payments', array('tid' => $idgu));
			}
			
			if ($this->db->insert('geopos_invoices', $data)) {
				$invocieno = $this->db->insert_id();
				$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
				$this->db->set('start', "$invocieno2", FALSE);
				$this->db->where($multiClause);
				$this->db->update('geopos_series_ini_typs');
				$typeinv = $this->settings->irs_typ_view($invoi_type);
				$typeinvserie = $this->settings->irs_typ_series_name($invoi_serie);
				//$transok = $this->settings->AssinaDocumento($invocieno, 0, $invoi_type, $typeinv['type'], $invoi_serie, $typeinvserie['serie'], $invocieno2);
				
				/*if(!$transok)
				{
					exit;
				}*/
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
				$product_alert = $this->input->post('alert');
				$product_serial = $this->input->post('serial');
				
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
					if ($product_id[$key] > 0) {
						$this->db->set('qty', "qty-$amt", FALSE);
						$this->db->where('pid', $product_id[$key]);
						$this->db->update('geopos_products');
						if ((numberClean($product_alert[$key]) - $amt) < 0 and $st_c == 0 and $this->common->zero_stock()) {
							echo json_encode(array('status' => 'Error', 'message' => 'Product - <strong>' . $product_name1[$key] . "</strong> - Low quantity. Available stock is  " . $product_alert[$key]));
							$transok = false;
							$st_c = 1;
						}
					}
					$itc += $amt;
				}
				if (count($product_serial) > 0) {
					$this->db->set('status', 1);
					$this->db->where_in('serial', $product_serial);
					$this->db->update('geopos_product_serials');
				}
				$total_pay = 0;
				if ($prodindex > 0) {
					$this->db->insert_batch('geopos_invoice_items', $productlist);
					$pay_obs = $this->input->post('pay_obs');
					$pay_date = $this->input->post('pay_date');
					$pay_met = $this->input->post('pay_met');	
					$pay_tot = $this->input->post('pay_tot');
					$paymentslist = array();
					foreach ($pay_met as $keyp => $value) {
						$bill_date = datefordatabase($pay_date[$keyp]);
						$total_pay += $pay_tot[$keyp];
						$pmethoget = $this->invocies->methodpayname($pay_met[$keyp]);
						$pmethodname = $pmethoget['methodname'];
						$tnote = 'Fatura Nº: ' . $invocieno2 . '-'.$pay_obs[$keyp]. '-' . $pmethodname;
						$d_trans = $this->plugins->universal_api(69);
						if ($d_trans['key1'] == 1) 
						{
							$t_data = array(
								'type' => 'Income',
								'cat' => 3,
								'payerid' => $customer_id,
								'method' => $pay_met[$keyp],
								'date' => $bill_date,
								'eid' =>$emp,
								'tid' => $invocieno,
								'loc' =>$this->aauth->get_user()->loc
							);
							
							
							
							$dual = $this->custom->api_config(65);
							$this->db->select('holder');
							$this->db->from('geopos_accounts');
							$this->db->where('id', $dual['key2']);
							$query = $this->db->get();
							$account_d = $query->row_array();
							$t_data['credit'] = 0;
							$t_data['debit'] = $pay_tot[$keyp];
							$t_data['type'] = 'Expense';
							$t_data['acid'] = $dual['key2'];
							$t_data['account'] = $account_d['holder'];
							$t_data['note'] = 'Debit ' . $tnote;

							$this->db->insert('geopos_transactions', $t_data);
							//account update
							$this->db->set('lastbal', "lastbal-$total_pay", FALSE);
							$this->db->where('id', $dual['key2']);
							$this->db->update('geopos_accounts');
							
							// now try it
							$ua=$this->aauth->getBrowser();
							$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
							
							$striPay = "Utilizador: ".$this->aauth->get_user()->username;
							$striPay = $striPay.'<br>'.$yourbrowser;
							$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
							$striPay = $striPay.'<br>Transação Dupla: '.$pmethodname;
							$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
						}
						
						
						$data2 = array(
							'acid' => $account_set_id,
							'account' => $account_set,
							'type' => 'Income',
							'cat' => 3,
							'credit' => $pay_tot[$keyp],
							'debit' => 0,
							'payer' => $customer_name,
							'payerid' => $customer_id,
							'method' => $pay_met[$keyp],
							'date' => $bill_date,
							'eid' => $emp,
							'tid' => $invocieno,
							'note' => $tnote,
							'loc' => $this->aauth->get_user()->loc
						);
						$this->db->trans_start();
						$this->db->insert('geopos_transactions', $data2);
						$trans = $this->db->insert_id();
						// now try it
						$ua=$this->aauth->getBrowser();
						$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
						
						$striPay = "Utilizador: ".$this->aauth->get_user()->username;
						$striPay = $striPay.'<br>'.$yourbrowser;
						$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
						$striPay = $striPay.'<br>Transação: '.$pmethodname;
						$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
					}
					$this->db->trans_complete();
					$this->db->set('lastbal', "lastbal+$total_pay", FALSE);
					$this->db->where('id', $accountincome);
					$this->db->update('geopos_accounts');
				} else {
					echo json_encode(array('status' => 'Error', 'message' =>
						"Please choose product from product list. Go to Item manager section if you have not added the products."));
					$transok = false;
				}
				if ($transok) {
					$validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
					$link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
					
					$statuPay = 'due';
					if($total == $total_pay)
					{
						$statuPay = 'paid';
					}else if($total > $total_pay)
					{
						$statuPay = 'partial';
					}
					$this->db->set(array('pamnt' => $total_pay, 'status' => $statuPay));
					$this->db->where('id', $invocieno);
					$this->db->update('geopos_invoices');
					
					// now try it
					$ua=$this->aauth->getBrowser();
					$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
					
					$statuPay = 'Não paga.';
					if($total == $total_pay)
					{
						$statuPay = 'Paga na Totalidade.';
					}else if($total > $total_pay)
					{
						$statuPay = 'Paga na Parcialidade.';
					}
					
					$striPay = "[CREATED]<br>Utilizador: ".$this->aauth->get_user()->username;
					$striPay = $striPay.'<br>'.$yourbrowser;
					$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
					$striPay = $striPay.'<br>Fatura Nº: '.$invocieno2.' - '.$statuPay;
					$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $invocieno);
					
					$passouquo = false;
					if($quote_tid > 0){
						$this->db->set('status', 'ended');
						$this->db->where('id', $quote_tid);
						$this->db->update('geopos_quotes');
						$passouquo = true;
					}
					
					$passount = false;
					if($not_e_tid > 0)
					{
						$this->db->set('status', 'ended');
						$this->db->where('id', $not_e_tid);
						$this->db->update('geopos_purchase');
						$passount = true;
					}
					
					$this->custom->save_fields_data($invocieno, 2);
					
					if($passouquo)
					{
						echo json_encode(array('status' => 'Success', 'message' => "Converteu com sucesso em Fatura o Orçamento. <a href='view?id=$invocieno&ty=0' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&ty=0' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
					}else if($passount)
					{
						echo json_encode(array('status' => 'Success', 'message' => "Converteu com sucesso em Fatura a Nota de Encomenda. <a href='view?id=$invocieno&ty=0' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&ty=0' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
					}else{
						echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno&ty=0' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&ty=0' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-purple btn-lg'><span class='fa fa-globe' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
					}
				}
			} else {
				echo json_encode(array('status' => 'Error', 'message' => "Problema ao criar a fatura. Tente mais tarde."));
				$transok = false;
			}
			if ($transok) {
				if ($this->aauth->premission(4) and $project > 0) {
					$data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');
					$this->db->insert('geopos_project_meta', $data);
				}
				$this->db->trans_complete();
			} else {
				$this->db->trans_rollback();
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

				$this->custom->save_fields_data($invocieno, 2);

			}
		}else if($typ == 1){
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
				$this->db->insert_batch('geopos_draft_items', $productlist);
				
				$paymentslist = array();
				$pay_obs = $this->input->post('pay_obs');
				$pay_date = $this->input->post('pay_date');
				$pay_met = $this->input->post('pay_met');	
				$pay_tot = $this->input->post('pay_tot');
				foreach ($pay_met as $keyp => $value) {
					$bill_date = datefordatabase($pay_date[$keyp]);
					$data2 = array(
						'tid' => $invocieno,
						'pay_date' => $bill_date,
						'pay_met' => $pay_met[$keyp],
						'pay_tot' => $pay_tot[$keyp],
						'pay_obs' => $pay_obs[$keyp]
					);
					$paymentslist[$prodindex] = $data2;
				}
				$this->db->insert_batch('geopos_draft_payments', $paymentslist);
				/*$this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));
				$this->db->where('id', $invocieno);
				$this->db->update('geopos_draft');*/
				
				$this->db->trans_complete();
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "[CREATED]<br>Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay .= '<br>Rascunho Nº (Provisório)'.$invocieno2.' para o Cliente: '.$customer_name;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'draft', $invocieno);
				
                if ($transok) 
					echo json_encode(array('status' => 'Success', 'message' => "Rascunho criado com Sucesso. <a href='view?id=$invocieno&ty=1' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&ty=1' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Erro a criar rascunho na Fatura. Tente mais tarde."));
                $transok = false;
            }
		}else{
			$this->db->set($data);
			$this->db->where('id', $idgu);
			if ($this->db->update('geopos_draft')) {
				$this->db->delete('geopos_draft_items', array('tid' => $idgu));
				$this->db->delete('geopos_draft_payments', array('tid' => $idgu));
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
				
				$this->db->insert_batch('geopos_draft_items', $productlist);
				
				$paymentslist = array();
				$pay_obs = $this->input->post('pay_obs');
				$pay_date = $this->input->post('pay_date');
				$pay_met = $this->input->post('pay_met');	
				$pay_tot = $this->input->post('pay_tot');
				foreach ($pay_met as $keyp => $value) {
					$data2 = array(
						'tid' => $invocieno,
						'pay_date' => $pay_date[$keyp],
						'pay_met' => $pay_met[$keyp],
						'pay_tot' => $pay_tot[$keyp],
						'pay_obs' => $pay_obs[$keyp]
					);
					$paymentslist[$prodindex] = $data2;
				}
				$this->db->insert_batch('geopos_draft_payments', $paymentslist);
				
				/*$this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));
				$this->db->where('id', $invocieno);
				$this->db->update('geopos_draft');*/
				
				$this->db->trans_complete();
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "[UPDATED]<br>Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay .= '<br>Rascunho Nº (Provisório)'.$invocieno2.' para o Cliente: '.$customer_name;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'draft', $invocieno);
				
                echo json_encode(array('status' => 'Success', 'message' => "Atualização de Rascunho com Sucesso. <a href='view?id=$invocieno&ty=1' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno&ty=1' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
			}else {
				echo json_encode(array('status' => 'Error', 'message' => "Erro ao guardar Rascunho!"));
				$transok = false;
				exit;
			}
			
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
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id&ty=0") . '">'.$invoices->type. $invoices->tid . '</a>';
			$row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->name;
            $row[] = $invoices->taxid;
			$row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$row[] = "<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$invoices->pamnt' aria-valuemin='0' aria-valuemax='$invoices->total' style='width:$width%;'>$width%</div></div>";
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span><br>'.$invoices->loc_cname;
            if($invoices->status == 'canceled'){
				$row[] = '<a href="' . base_url("invoices/view?id=$invoices->id&ty=0") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			}else{
				$option = '<a href="' . base_url("invoices/view?id=$invoices->id&ty=0") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
				if ($this->aauth->get_user()->roleid == 7 || $this->aauth->premission(121)) {
					$option .= '<a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" data-object-draft="1" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
				}
				$row[] = $option;
			}
			
            $data[] = $row;
        }
		
		$numtab1 = $this->invocies->count_all($this->limited);
		$numfil1 = $this->invocies->count_filtered($this->limited);
		$list = $this->invocies->get_datatables2($this->limited);
        foreach ($list as $drafts) {
            $no++;
			$textini = $drafts->type.$drafts->tid;
			$textini .= '<br>(Provisório)';
			$width = round(0,2);
            $row = array();
			$row[] = $drafts->serie_name;
            $row[] = '<a href="' . base_url("invoices/view?id=$drafts->id&ty=1") . '">' . $textini . '</a>';
			$row[] = dateformat($drafts->invoicedate);
            $row[] = $drafts->name;
            $row[] = $drafts->taxid;
			$row[] = amountExchange($drafts->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($drafts->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($drafts->total, 0, $this->aauth->get_user()->loc);
			$row[] = "<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$drafts->pamnt' aria-valuemin='0' aria-valuemax='$drafts->total' style='width:$width%;'>$width%</div></div>";
            $row[] = 'Rascunho';
			$option = '<a href="' . base_url("invoices/view?id=$drafts->id&ty=1") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("invoices/printinvoice?id=$drafts->id&ty=1") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
			if ($this->aauth->get_user()->roleid == 7 || $this->aauth->premission(121)) {
				$option .= '<a href="#" data-object-id="' . $drafts->id . '" data-object-tid="' . $drafts->tid . '" data-object-draft="0" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
            $row[] = $option;
            $data[] = $row;
        }
		
		$numtab1 = $numtab1+$this->invocies->count_all2($this->limited);
		$numfil1 = $numfil1+$this->invocies->count_filtered2($this->limited);
		
		
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
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
		$token = $this->input->get('token');
		$type = $this->input->get('ty');
		if($type == 0){
			
			$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
			$data['products'] = $this->invocies->invoice_products($tid);
			$data['activity'] = $this->invocies->invoice_transactions($tid);
			$data['title'] = $data['invoice']['irs_type_n'].': ' . $data['invoice']['tid'];
			$head['title'] = $data['invoice']['irs_type_n'].': ' . $data['invoice']['tid'];
			$data['attach'] = $this->invocies->attach($tid);
			$data['history'] = $this->common->history($tid,'fa');
			$data['typeinvoice'] = 0;
		}else{
			$data['invoice'] = $this->invocies->invoice_details2($tid, $this->limited);
			$data['products'] = $this->invocies->invoice_products2($tid);
			$data['activity'] = $this->invocies->invoice_transactions2($tid);
			$data['title'] = 'Rascunho: ' . $data['invoice']['tid'];
			$head['title'] = 'Rascunho: ' . $data['invoice']['tid'];
			$data['typeinvoice'] = 1;
			$data['history'] = $this->common->history($tid,'draft');
		}
        $data['iddoc'] = $data['invoice']['id'];
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $data['custom_fields'] = $this->custom->view_fields_data($tid, 2);
        if ($data['invoice']['id']) {
            $data['invoice']['id'] = $tid;
			if($type == 0){
				$this->load->view('invoices/view', $data);
			}else{
				$this->load->view('invoices/viewdraft', $data);
			}
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
			$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
			$data['products'] = $this->invocies->invoice_products($tid);
			$data['activity'] = $this->invocies->invoice_transactions($tid);
			if($data['invoice']['status'] == 'canceled')
			{
				$data['ImageBackGround'] = 'assets/images/anulada.png';
			}
		}else{
			$data['invoice'] = $this->invocies->invoice_details2($tid, $this->limited);
			$data['products'] = $this->invocies->invoice_products2($tid);
			$data['activity'] = $this->invocies->invoice_transactions2($tid);
			$data['typeinvoice'] = 'Rascunho';
			$data['invoice']['status'] = 'Rascunho';
			$data['ImageBackGround'] = 'assets/images/rascunho.png';
		}
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if (CUSTOM) 
			$data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
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
		$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
		
        $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
		$html2 = $this->load->view('print_files/invoice-a4_v' . INVV, $data2, true);
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split(array('margin_top' => 10));
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
		$pdf->WriteHTML($html);
		$pdf->AddPage();
		$pdf->WriteHTML($html2);
		
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $data['invoice']['irs_type_s'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    public function delete_i()
    {
		if (!$this->aauth->premission(121)){
            exit($this->lang->line('translate19'));
        }
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
			echo json_encode(array('status' => 'Success', 'message' => 'Rascunho removido com Sucesso.'));
		}else{
			$this->db->set('status', 'canceled');
			$this->db->where('id', $id);
			$this->db->update('geopos_invoices');
			
			// now try it
			$ua=$this->aauth->getBrowser();
			$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			
			$striPay = "Utilizador: ".$this->aauth->get_user()->username;
			$striPay = $striPay.'<br>'.$yourbrowser;
			$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
			$striPay = $striPay.'<br>Fatura Anulada: '.$tid;
			$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'fa', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Documento Anulado com Sucesso.'));
		}
		
	   /* if () {
			
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}*/
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
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);

        $this->load->model('customers_model', 'customers');
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s);

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

    public function delivery()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        ini_set('memory_limit', '64M');

        $html = $this->load->view('invoices/del_note', $data, true);
		$html2 = $this->load->view('invoices/del_note', $data2, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

        $pdf->WriteHTML($html);
		$pdf->AddPage();
		$pdf->WriteHTML($html2);

        if ($this->input->get('d')) {

            $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('DO_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }

    public function proforma()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
		
		$data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
		$static_q = $data['qrc'];
		$qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));
		$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		
        ini_set('memory_limit', '64M');
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        $html = $this->load->view('invoices/proforma', $data, true);
		$html2 = $this->load->view('invoices/proforma', $data2, true);
		
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');
        $pdf->WriteHTML($html);
		$pdf->AddPage();
		$pdf->WriteHTML($html2);
        if ($this->input->get('d')) {
            $pdf->Output('Proforma_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Proforma_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }


    public function send_invoice_auto($invocieno, $invocieno2, $idate, $total, $multi)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(6);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);
        $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
        $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invocieno2,
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
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

    public function view_payslip()
    {
        $id = $this->input->get('id');
        $inv = $this->input->get('inv');
        $data['invoice'] = $this->invocies->invoice_details($inv, $this->limited);
        if (!$data['invoice']['id']) 
			exit('Limited Permissions!');

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
}