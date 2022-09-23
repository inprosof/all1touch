<?php
/**

 * 
 * ***********************************************************************
 *
 
 
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
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

class Quote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quote_model', 'quote');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit($this->lang->line('translate19'));
        }
		$this->load->library("Custom");
        $this->li_a = 'sales';

    }

    //create invoice
    public function create()
    {
        $this->load->model('plugins_model', 'plugins');
        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->quote->currencies();
		$data['countrys'] = $this->common->countrys();
		$data['expeditions'] = $this->common->sexpeditions();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['prazos_vencimento'] = $this->common->sprazovencimento();
		
		if(count($this->settings->billingterms(8)) == 0)
		{
			exit('Deve Inserir pelo menos um Termo para o Tipo Orçamento. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}
			
        $data['terms'] = $this->settings->billingterms(8);
        $head['title'] = "New Quote";
		if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$data['locations'] = $this->settings->company_details(1);
		}else{
			$data['locations'] = $this->settings->company_details2($this->aauth->get_user()->loc);
		}
		
		$data['typesinvoices'] = "";
		$data['typesinvoicesdefault'] = $this->common->default_typ_doc(8);
		$data['seriesinvoiceselect'] = $this->common->default_series(8);
		if($data['seriesinvoiceselect'] == NULL)
		{
			exit('Deve Inserir pelo menos uma Série no Tipo Orçamento. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}else{
			$seri_did_df = $this->common->default_series_id(8);
			$numget = $this->common->lastdoc(8,$seri_did_df);
			$data['lastinvoice'] = $numget;
			$data['custom_fields'] = $this->custom->add_fields(3);
			$head['usernm'] = $this->aauth->get_user()->username;
			$data['warehouse'] = $this->quote->warehouses();
			$data['taxdetails'] = $this->common->taxdetail();
			$this->load->view('fixed/header', $head);
			$this->load->view('quotes/newquote', $data);
			$this->load->view('fixed/footer');
		}
    }

    //edit invoice
    public function edit()
    {
		$tid = intval($this->input->get('id'));
        $this->load->model('customers_model', 'customers');
		$this->load->model('settings_model', 'settings');
		$this->load->model('plugins_model', 'plugins');
		$this->load->library("Common");
        $data['customergrouplist'] = $this->customers->group_list();
        $data['prazos_vencimento'] = $this->common->sprazovencimento();
        $data['id'] = $tid;
        $data['terms'] = $this->settings->billingterms(2);
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['currency'] = $this->quote->currencies();
        $head['title'] = "Alterar Orçamento Nº" . $data['invoice']['tid'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->quote->warehouses();
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['custom_fields'] = $this->custom->view_edit_fields($tid, 3);
		$data['typesinvoices'] = "";
		$data['expeditions'] = $this->common->sexpeditions();
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
		$data['countrys'] = $this->common->countrys();
		
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/edit', $data);
        $this->load->view('fixed/footer');
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Quote";
        $data['eid'] = intval($this->input->get('eid'));
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/quotes', $data);
        $this->load->view('fixed/footer');
    }
	
	public function editaction2()
    {
		$idg = $this->input->post('iddoc');
		$vers = $this->input->post('vers');
		$this->action(2,$vers,$idg);
	}
	
    public function editaction()
    {
		$idg = $this->input->post('iddoc');
		$vers = $this->input->post('vers');
		$this->action(3,$vers,$idg);
    }
	
	//action
	
	public function action2()
    {
		$this->action(0);
	}

    //action
    public function action($typp=1,$vers=0,$idgu=0)
    {
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('customers_model', 'customers');
		$this->load->library("Common");
		$this->load->model('accounts_model');
		$this->load->model('settings_model', 'settings');
        $currency = $this->input->post('mcurrency');
		
		if($currency == null || $currency="" || $currency="0"){
			$currencyCOde = $this->accounts_model->getCurrency();
			$currency = $currencyCOde['id'];
		}
		
        $tax = $this->input->post('tax_handle');
		$vers = 0;
		$status = "pending";
		if($typp==0 || $typp==1)
		{
			$vers = 0;
			if($typp==0 || $typp==1)
			{
				$status = 'draft';
			}else{
				$status = 'pending';
			}
		}else{
			$vers = numberClean($vers)+1;
		}
		$proposal = $this->input->post('propos', true);
		
        $customer_id = ((integer)$this->input->post('customer_id'));
		$invocieencorc = $this->input->post('invocieencorc');
		
		$customer_info = $this->customers->recipientinfo($customer_id);
        $customer_name = $customer_info['name'];
		$customer_tax = $this->input->post('customer_tax');
        $notes = $this->input->post('notes');
		$type_guide = $this->input->post('type_guide');
		$invoi_type = $this->input->post('invoi_type', true);
		$invoi_serie = $this->input->post('invoi_serie', true);
		
        $ship_taxtype = $this->input->post('ship_taxtype');
        $disc_val = $this->input->post('disc_val');
		$discs_come = $this->input->post('discs_come');
		
		$n_praz_venc = $this->input->post('n_praz_venc');
		
		$taxas_tota = $this->input->post('taxas_tota');
        $subtotal = $this->input->post('subttlform_val');
        $shipping = $this->input->post('shipping');
        $shipping_tax = $this->input->post('ship_tax');
		
        $refer = $this->input->post('refer');
        $total = $this->input->post('totalpay');
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount_tax = $this->input->post('discs_tot_val');
        $discountFormat = $this->input->post('discountFormat');
		
		$tota_items = $this->input->post('tota_items');
        $i = 0;
		
		if ($n_praz_venc == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Escolha um Prazo ed Vencimento'));
            exit;
        }
		
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecionar um cliente'));
            exit;
        }
		
		if(!filter_has_var(INPUT_POST,'product_name')) {
			echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir um Produto'));
            exit;
		}
		
		$emp = 0;
        $empl_e = $this->plugins->universal_api(69);
        if ($empl_e['key1']) {
            $emp = $this->input->post('employee');
        } else {
            $emp = $this->aauth->get_user()->id;
        }
		
		$start_date = $this->input->post('start_date_guide', true);
		$start_date_guide = "";
		
		if ($start_date == "") {
            $start_date_guide = null;
        }else{
			$start_date_guide = datefordatabase($start_date);
		}
		
		$id_auto_ins = 0;
		if(filter_has_var(INPUT_POST,'autos_se')) {
			$id_auto_ins = $this->input->post('autos_se');
		}else{
			if(filter_has_var(INPUT_POST,'copy_autos')) {
				$product_name = $this->input->post('matricula_aut', true);
				$catid = 1;
				$warehouse = $this->aauth->get_user()->loc;
				$product_qty = 1;
				$product_desc = $this->input->post('designacao_aut', true);
				$inspection_date = '0000-00-00';
				$insurance_date = '0000-00-00';
				$employee_id = $emp;
				$data = array('acat' => $catid, 'warehouse' => $warehouse, 'assest_name' => $product_name, 'qty' => $product_qty, 'product_des' => $product_desc, 'inspection_date' => $inspection_date, 'insurance_date' => $insurance_date, 'employee_id' => $employee_id);
				if ($this->db->insert('geopos_assets', $data)) {
					$id_auto_ins = $this->db->insert_id();
				}
			}else{
				$id_auto_ins = 0;
			}
		}
		
		$matricula_aut = "";
		$designacao_aut = "";
		$expeditionid = "";
		$expedition = "";
		if(filter_has_var(INPUT_POST,'expedival')) {
			$expedition = $this->input->post('expedival');
		}
		$expeditionid = $this->input->post('exped_se');
		if($id_auto_ins == 0 || $id_auto_ins == "0"){
			if($expedition == 'exp3'){
				$matricula_aut = $this->input->post('matricula_aut');
				$designacao_aut = $this->input->post('designacao_aut');
			}else if($expedition == 'exp4'){
				$matricula_aut = $this->input->post('matricula_aut');
				$designacao_aut = $this->input->post('designacao_aut');
			}else if($expedition == 'exp5'){
				$matricula_aut = $this->input->post('matricula_aut');
				$designacao_aut = $this->input->post('designacao_aut');
			}else if($expedition == 'exp1'){
				$matricula_aut = "Correio";
				$designacao_aut = "Expedido Por Correio";
			}else if($expedition == 'exp2'){
				$matricula_aut = "Download/Formato Digital";
				$designacao_aut = "Envio online";
			}
			if($matricula_aut == ""){
				$matricula_aut = "Nossa Viatura";
			}
			
			if($designacao_aut == ""){
				$designacao_aut = "Por defeito";
			}
		}else{
			$matricula_aut = "";
			$designacao_aut = "";
		}
		
		$loc_guide_comp = "";
		$post_guide_comp = "";
		$city_guide_comp = "";
		$mcustomer_gui_comp = "";
		
		if(filter_has_var(INPUT_POST,'copy_comp')) {
			if(filter_has_var(INPUT_POST,'loc_guide_comp')) {
				$loc_guide_comp = $this->input->post('loc_guide_comp');
				if($loc_guide_comp == ""){
					$loc_guide_comp = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'post_guide_comp')) {
				$post_guide_comp = $this->input->post('post_guide_comp');
				if($post_guide_comp == ""){
					$post_guide_comp = "0000-000";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'city_guide_comp')) {
				$city_guide_comp = $this->input->post('city_guide_comp');
				if($city_guide_comp == ""){
					$city_guide_comp = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'mcustomer_gui_comp')) {
				$mcustomer_gui_comp = $this->input->post('mcustomer_gui_comp');
				if($mcustomer_gui_comp == ""){
					$mcustomer_gui_comp = "PT";
				}
			}
		}else{
			if(filter_has_var(INPUT_POST,'loc_guide_comp')) {
				$loc_guide_comp = $this->input->post('loc_guide_comp');
				if($loc_guide_comp == ""){
					$loc_guide_comp = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'post_guide_comp')) {
				$post_guide_comp = $this->input->post('post_guide_comp');
				if($post_guide_comp == ""){
					$post_guide_comp = "0000-000";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'city_guide_comp')) {
				$city_guide_comp = $this->input->post('city_guide_comp');
				if($city_guide_comp == ""){
					$city_guide_comp = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'mcustomer_gui_comp')) {
				$mcustomer_gui_comp = $this->input->post('mcustomer_gui_comp');
				if($mcustomer_gui_comp == ""){
					$mcustomer_gui_comp = "PT";
				}
			}
		}
		
		
		$loc_guide_cos = "";
		$post_guide_cos = "";
		$city_guide_cos = "";
		$mcustomer_gui_cos = "";
		if(filter_has_var(INPUT_POST,'copy_cos')) {
			if(filter_has_var(INPUT_POST,'loc_guide_cos')) {
				$loc_guide_cos = $this->input->post('loc_guide_cos');
				if($loc_guide_cos == ""){
					$loc_guide_cos = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'post_guide_cos')) {
				$post_guide_cos = $this->input->post('post_guide_cos');
				if($post_guide_cos == ""){
					$post_guide_cos = "0000-000";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'city_guide_cos')) {
				$city_guide_cos = $this->input->post('city_guide_cos');
				if($city_guide_cos == ""){
					$city_guide_cos = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'mcustomer_gui_cos')) {
				$mcustomer_gui_cos = $this->input->post('mcustomer_gui_cos');
				if($mcustomer_gui_cos == ""){
					$mcustomer_gui_cos = "PT";
				}
			}
		}else{
			if(filter_has_var(INPUT_POST,'loc_guide_cos')) {
				$loc_guide_cos = $this->input->post('loc_guide_cos');
				if($loc_guide_cos == ""){
					$loc_guide_cos = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'post_guide_cos')) {
				$post_guide_cos = $this->input->post('post_guide_cos');
				if($post_guide_cos == ""){
					$post_guide_cos = "0000-000";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'city_guide_cos')) {
				$city_guide_cos = $this->input->post('city_guide_cos');
				if($city_guide_cos == ""){
					$city_guide_cos = "Desconhecido";
				}
			}
			
			
			if(filter_has_var(INPUT_POST,'mcustomer_gui_cos')) {
				$mcustomer_gui_cos = $this->input->post('mcustomer_gui_cos');
				if($mcustomer_gui_cos == ""){
					$mcustomer_gui_cos = "PT";
				}
			}
		}
        
		$pterms = 0;
		if(filter_has_var(INPUT_POST,'pterms')) {
			$pterms = $this->input->post('pterms');
		}
		
		if ($pterms == 0 || $pterms == '') {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor seleccione ou crie o Termo para os Orçamentos no Menu: Configurações de Negócio->Configurações de Faturamento->Termos de Cobrança.'));
            exit;
        }
		
		$this->load->library("Common");
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$invocieno = $numget+1;
		
		$invoiceddate = $this->input->post('invoicedate');
		$invoicedate = datefordatabase($invoiceddate);
		$invociedueddate = $this->input->post('invocieduedate');
		$invocieduedate = datefordatabase($invociedueddate);
		
        $data = array('tid' => $invocieno, 
		'proposal' => $proposal,
		'invoicedate' => $invoicedate,
		'invoiceduedate' => $invocieduedate,
		'prop_due' => $n_praz_venc,
		'subtotal' => $subtotal, 
		'shipping' => $shipping, 
		'status' => $status,
		'ship_tax' => $shipping_tax, 
		'ship_tax_type' => $ship_taxtype, 
		'discount_rate' => $disc_val, 
		'total' => $total, 
		'discount' => $discs_come, 
		'tax' => $taxas_tota, 
		'notes' => $notes, 
		'autoid' => $id_auto_ins,
		'expedition' => $expeditionid,
		'exp_date' => $start_date_guide,
		'exp_mat' => $matricula_aut,
		'exp_des' => $designacao_aut,
		'charge_address' => $loc_guide_comp,
		'charge_postbox' => $post_guide_comp,
		'charge_city' => $city_guide_comp,
		'charge_country' => $mcustomer_gui_comp,
		'discharge_address' => $loc_guide_cos,
		'discharge_postbox' => $post_guide_cos,
		'discharge_city' => $city_guide_cos,
		'discharge_country' => $mcustomer_gui_cos,
		'csd' => $customer_id, 
		'eid' => $emp, 
		'items' => $tota_items,
		'taxstatus' => $tax, 
		'total_discount_tax' => $total_discount_tax, 
		'format_discount' => $discountFormat, 
		'refer' => $refer, 
		'ref_enc_orc' => $invocieencorc, 
		'term' => $pterms, 
		'multi' => $currency, 
		'loc' => $this->aauth->get_user()->loc, 
		'tax_id' => $customer_tax, 
		'serie' => $invoi_serie,
		'version' => $vers,	
		'irs_type' => $invoi_type);
        $guideno2 = $invocieno;
		
		$this->db->trans_start();
		$transok = true;
		if($typp==0 || $typp==1)
		{
			if ($this->db->insert('geopos_quotes', $data)) {
				$invocieno = $this->db->insert_id();
				$this->db->trans_complete();
			}else {
				echo json_encode(array('status' => 'Error', 'message' => "Erro ao inserir Orçamento!"));
				$transok = false;
				exit;
			}
		}else{
			$this->db->set($data);
			$this->db->where('id', $idgu);
			if ($this->db->update('geopos_quotes')) {
				$this->db->delete('geopos_quotes_items', array('tid' => $idgu));
				$invocieno = $idgu;
				$this->db->trans_complete();
			}else {
				echo json_encode(array('status' => 'Error', 'message' => "Erro ao guardar Rascunho!"));
				$transok = false;
				exit;
			}
		}
		
		if ($transok) {
			 //products
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
			$product_des = $this->input->post('product_description');
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
				//$total_discount += numberClean(@$ptotal_disc[$key]);
				//$total_tax += numberClean($ptotal_tax[$key]);
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
				$prodindex++;
				$amt = numberClean($product_qty[$key]);
				$itc += $amt;
			}
			if ($prodindex > 0) {
				$this->db->insert_batch('geopos_quotes_items', $productlist);
				//var_dump($productlist);
				//$this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));
				//$this->db->where('id', $invocieno);
				//$this->db->update('geopos_guides');
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				if($typp == 2){
					$striPay = "[UPDATE]<br>";
				}else if($typp == 3)
				{
					$striPay = "[PENDING]<br>";
				}else{
					$striPay = "[CREATED]<br>";
				}
				$striPay .= "Utilizador: ".$this->aauth->get_user()->username;
				$striPay .= '<br>'.$yourbrowser;
				$striPay .= '<br>Ip: '.$this->aauth->get_user()->ip_address;
				
				$tipoinseee = "";
				if($typp == 2){
					$this->custom->edit_save_fields_data($invocieno, 3);
					$tipoinseee = "Orçamento atualizado com Sucesso.";
					$striPay .= '<br>Rascunho Orçamento Nº (Provisório)'.$guideno2.' atualizada para o Cliente: '.$customer_name;
				}else if($typp == 3)
				{
					$this->custom->save_fields_data($invocieno, 3);
					$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
					$this->db->set('start', "$guideno2", FALSE);
					$this->db->where($multiClause);
					$this->db->update('geopos_series_ini_typs');
				
					$this->db->set(array('status' => 'pending'));
					$this->db->where('id', $invocieno);
					$this->db->update('geopos_quotes');
					
					$tipoinseee = "Orçamento concluído com Sucesso.";
					$striPay .= '<br>Orçamento Nº'.$guideno2.' finalizada para o Cliente: '.$customer_name;
				}else if($typp == 0){
					$tipoinseee = "Orçamento guardado como Rascunho com Sucesso.";
					$striPay .= '<br>Rascunho Orçamento Nº (Provisório)'.$guideno2.' para o Cliente: '.$customer_name;
				}else{
					$tipoinseee = "Orçamento concluído com Sucesso.";
				}
				
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $invocieno);
				
				//$this->custom->save_fields_data($invocieno, 2);
			}
			echo json_encode(array('status' => 'Success', 'message' => $tipoinseee . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printquote?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a>&nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
		 }
	}


    public function ajax_list()
    {
        $eid = 0;
        if ($this->aauth->premission(9)) {
            $eid = $this->input->post('eid');
        }
        $list = $this->quote->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $invoices->serie_name;
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '">&nbsp; ' . $invoices->tid . '</a>';
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$statt = "";
			$statt2 = "";
			if($invoices->status == 'draft')
			{
				$statt2 .= "badge st-pending";
				$statt = 'Rascunho';
			}else{
				$statt2 .= "badge st-". $invoices->status;
				$statt = $this->lang->line(ucwords($invoices->status));
			}
            $row[] = '<span class="'.$statt2. '">' . $statt . '</span>';
			if($invoices->status == 'draft' || $invoices->status == 'pending' || $invoices->status == 'rejected' || $invoices->status == 'draft')
			{
				$row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a> &nbsp; <a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>&nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a> &nbsp; <a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>';
			}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->quote->count_all($eid),
            "recordsFiltered" => $this->quote->count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
		$this->load->library("Custom");
		$this->load->library("Common");
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $this->load->model('accounts_model');
		$data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
		$data['history'] = $this->common->history($tid,'quote');
        $data['attach'] = $this->quote->attach($tid);
        $data['employee'] = $this->quote->employee($data['invoice']['eid']);
		$data['attach'] = $this->quote->attach($tid);
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['custom_fields'] = $this->custom->view_fields_data($tid, 3);
        $head['title'] = "Orçamento Nº" . $data['invoice']['tid'];
        $this->load->view('fixed/header', $head);
        if ($data['invoice']) 
			$this->load->view('quotes/view', $data);
        $this->load->view('fixed/footer');
    }


    public function printquote()
    {
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = $this->lang->line('Quote')." $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['employee'] = $this->quote->employee($data['invoice']['eid']);
        $data['general'] = array('title' => $this->lang->line('Quote'), 'person' => $this->lang->line('Customer'), 'prefix' => prefix(1), 't_type' => 1);
		$data['invoice']['type'] = $this->lang->line('Quote');
        //PDF Rendering
		
		if($data['invoice']['status'] == 'draft'){
			$data['invoice']['status'] = 'Rascunho';
		}else if($data['invoice']['status'] == 'pending'){
			$data['invoice']['status'] = 'Orc1';
		}else if($data['invoice']['status'] == 'accepted'){
			$data['invoice']['status'] = 'Orc2';
		}else if($data['invoice']['status'] == 'customer_approved'){
			$data['invoice']['status'] = 'Orc3';
		}else if($data['invoice']['status'] == 'rejected'){
			$data['invoice']['status'] = 'Orc4';
		}
		
		$token = $this->input->get('token');
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
		
        ini_set('memory_limit', '64M');
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
		$html2 = $this->load->view('print_files/invoice-a4_v' . INVV, $data2, true);
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split(array('margin_top' => 10));
		$loc2 = location(0);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">Processado por Programa Certificado nº'.$loc2['certification'].' {PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);

        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Orcamento_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
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
        if ($this->quote->quote_delete($id)) {
			// now try it
			$this->db->delete('geopos_quotes_items', array('tid' => $id));
			$ua=$this->aauth->getBrowser();
			$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			
			$striPay = "Utilizador: ".$this->aauth->get_user()->username;
			$striPay = $striPay.'<br>'.$yourbrowser;
			$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
			$striPay = $striPay.'<br>Orçamento Apagado: '.$id;
			$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Orçamento apagado com Sucesso.'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_quotes');
		
		$ua=$this->aauth->getBrowser();
		$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
		$striPay = "[UPDATE]<br>";
		$striPay .= "Utilizador: ".$this->aauth->get_user()->username;
		$striPay .= '<br>'.$yourbrowser;
		$striPay .= '<br>Ip: '.$this->aauth->get_user()->ip_address;
		$striPay .= '<br>Atualizado o Estado do Orçamento.';
		$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $tid);

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Quote Status updated') . '', 'pstatus' => $status));
    }

    public function convert()
    {
        $tid = $this->input->post('tid');
        if ($this->quote->convert($tid)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Quote to invoice conversion')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function convert_po()
    {
        $tid = $this->input->post('tid');
        $person = $this->input->post('customer_id');

        if ($this->quote->convert_po($tid, $person)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Quote to invoice conversion')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->quote->meta_delete($invoice, 2, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {
                $fid = rand(100, 9999);
                $this->quote->meta_insert($id, 2, $files);
            }
        }


    }


}