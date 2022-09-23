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

class Guides extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('guides_model', 'guides');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('assets_model');
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ((!$this->aauth->premission(13) && !$this->aauth->premission(16)) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		
        if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(128)) {
            $this->limited = '';
        } else {
			$this->limited = $this->aauth->get_user()->id;
        }
		
        $this->load->library("Custom");
        $this->li_a = 'guides';

    }

    //create guide Charge
    public function create()
    {
		$this->load->library("Custom");
		$this->load->library("Common");
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
		$type = $this->input->get('ty');
		$typename = "";
		if($type == 1 || $type == '1')
		{
			if (!$this->aauth->premission(14) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$typename = "Guia de Remessa ";
			if(count($this->settings->billingterms(14)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$data['terms'] = $this->settings->billingterms(14);
		}else{
			if (!$this->aauth->premission(17) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$typename = "Guia de Transporte ";
			if(count($this->settings->billingterms(7)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$data['terms'] = $this->settings->billingterms(7);
		}
        $data['emp'] = $this->plugins->universal_api(69);
        if ($data['emp']['key1']) {
            $this->load->model('employee_model', 'employee');
            $data['employee'] = $this->employee->list_employee();
        }
        $data['type_guide'] = $type;
		$data['guide']['type'] = $typename;
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['withholdings'] = $this->settings->withholdings();
		$data['company'] = $this->settings->company_details(1);
        $data['customergrouplist'] = $this->customers->group_list();
        
        $data['warehouse'] = $this->guides->warehouses();
        $data['currency'] = $this->guides->currencies();
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
		$data['countrys'] = $this->common->countrys();
		$data['expeditions'] = $this->common->sexpeditions();
		$data['typesinvoices'] = "";
		
		$numget = 0;
		if($type == 1)
		{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(14);
			$data['seriesinvoiceselect'] = $this->common->default_series(14);
		}else{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(7);
			$data['seriesinvoiceselect'] = $this->common->default_series(7);
		}
		if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$data['locations'] = $this->settings->company_details(1);
		}else{
			$data['locations'] = $this->settings->company_details2($this->aauth->get_user()->loc);
		}
		$data['taxdetails'] = $this->common->taxdetail();
		$data['autos'] = $this->guides->guide_autos_company();
		
		if($data['seriesinvoiceselect'] == NULL)
		{
			exit('Deve Inserir pelo menos uma Série no Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}else{
			if($type == 1)
			{
				$seri_did_df = $this->common->default_series_id(14);
				$numget = $this->common->lastdoc(14,$seri_did_df);
			}else{
				$seri_did_df = $this->common->default_series_id(7);
				$numget = $this->common->lastdoc(7,$seri_did_df);
			}
			$data['lastinvoice'] = $numget;
			$head['title'] = 'Nova '.$typename;
			$head['usernm'] = $this->aauth->get_user()->username;
			$this->load->view('fixed/header', $head);
			$this->load->view('guides/newguide', $data);
			$this->load->view('fixed/footer');
		}
    }

    //edit Guide Charge
    public function edit()
    {
		$this->load->library("Common");
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['guide'] = $this->guides->guide_details($tid, $this->limited);
        $head['usernm'] = $this->aauth->get_user()->username;
		$type = "";
		if($data['guide']['typeguide'] == 1)
		{
			if (!$this->aauth->premission(15) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Guia de Remessa ';
			$data['terms'] = $this->settings->billingterms(7);
		}else{
			if (!$this->aauth->premission(18) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Guia de Transporte ';
			$data['terms'] = $this->settings->billingterms(6);
		}
		
		if ($data['guide']['id']) 
			$data['products'] = $this->guides->items_with_product($tid);
		
		$data['title'] = 'Alterar '.$type . $data['guide']['tid'];
		$head['title'] = 'Alterar '.$type . $data['guide']['tid'];
		$data['guide']['type'] = $type;
        $data['type_guide'] = $data['guide']['typeguide'];
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['withholdings'] = $this->settings->withholdings();
		$data['company'] = $this->settings->company_details(1);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastguide'] = $this->guides->lastguide();
        $data['warehouse'] = $this->guides->warehouses();
        $data['currency'] = $this->guides->currencies();
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
		$data['countrys'] = $this->common->countrys();
		$data['expeditions'] = $this->common->sexpeditions();
		$data['locations'] = $this->settings->company_details($data['guide']['loc']);
		$data['autos'] = $this->guides->guide_autos_company();
        $data['taxlist'] = $this->common->taxlist_edit($data['guide']['taxstatus']);
		$data['typesinvoices'] = "";
        $data['custom_fields_c'] = $this->custom->add_fields(1);
        $data['custom_fields'] = $this->custom->add_fields(2);
		$data['taxdetails'] = $this->common->taxdetail();
		
        $this->load->view('fixed/header', $head);
        if ($data['guide']['id']) 
			$this->load->view('guides/edit', $data);
        $this->load->view('fixed/footer');
    }
	
    public function index()
    {
		$type = $this->input->get('ty');
		$typename = "";
		$head['usernm'] = $this->aauth->get_user()->username;
        
		if($type == 1 || $type == '1')
		{
			if (!$this->aauth->premission(13) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$head['title'] = "Gestão Guias de Remessa";
			$typename = "Guia de Remessa ";
		}else{
			if (!$this->aauth->premission(16) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$head['title'] = "Gestão Guias de Transporte";
			$typename = "Guia de Transporte ";
		}
        $this->load->view('fixed/header', $head);
		if($type == 1 || $type == '1')
		{
			$this->load->view('guides/charge');
		}else{
			$this->load->view('guides/discharge');
		}		
        $this->load->view('fixed/footer');
    }
	
    //action
	
	public function action2()
    {
		$this->action(0);
	}
    public function action($typp=1,$vers=0,$idgu=0)
    {
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('customers_model', 'customers');
		$this->load->library("Common");
		$this->load->model('accounts_model');
		$this->load->library("Custom");
		
        $currency = $this->input->post('mcurrency');
		
		if($currency == null || $currency="" || $currency="0"){
			$currencyCOde = $this->accounts_model->getCurrency();
			$currency = $currencyCOde['id'];
		}
		
        $tax = $this->input->post('tax_handle');
		
		$vers = 0;
		$status = 0;
		if($typp==0 || $typp==1)
		{
			$status = $typp;
			$vers = 0;
		}else{
			$vers = numberClean($vers)+1;
			if($typp == 2){
				$status = 0;
			}else{
				$status = 1;
			}
		}
		
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
		
		$taxas_tota = $this->input->post('taxas_tota');
        $subtotal = $this->input->post('subttlform_val');
        $shipping = $this->input->post('shipping');
        $shipping_tax = $this->input->post('ship_tax');
		$warehouse = $this->input->post('s_warehouses', true);
        $refer = $this->input->post('refer');
        $total = $this->input->post('totalpay');
        $project = $this->input->post('prjid');
        $total_tax = 0;
        $total_discount_tax = $this->input->post('discs_tot_val');
        $discountFormat = $this->input->post('discountFormat');
		
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
		
		$emp = 0;
        $empl_e = $this->plugins->universal_api(69);
        if ($empl_e['key1']) {
            $emp = $this->input->post('employee');
        } else {
            $emp = $this->aauth->get_user()->id;
        }
		
		$guideddta = $this->input->post('invoicedate', true);
		$guidedate = datefordatabase($guideddta);
		$start_date = $this->input->post('start_date_guide', true);
		$start_date_guide = "";
		
		if ($start_date == "") {
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor Selecione uma data para inicio do transporte.'));
            exit;
        }else{
			$start_date_guide = datefordatabase($start_date);
		}
		
		$id_auto_ins = 0;
		$cop_sele = $this->input->post('val_save_bd');
		$auto_bus = $this->input->post('autos_se');
		if($this->input->post('autos_se') != "") {
			$id_auto_ins = $this->input->post('autos_se');
		}else{
			if($this->input->post('val_save_bd') == 1) {
				$product_name = $this->input->post('matricula_aut', true);
				$catid = 1;
				$warehouse = $this->aauth->get_user()->loc;
				$product_qty = 1;
				$product_desc = $this->input->post('designacao_aut', true);
				$inspection_date = NULL;
				$insurance_date = NULL;
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
		$expedition = $this->input->post('expedival');
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
            echo json_encode(array('status' => 'Error', 'message' => 'Por favor seleccione ou crie o Termo para as Guias no Menu: Configurações de Negócio->Configurações de Faturamento->Termos de Cobrança.'));
            exit;
        }
		
		
		$this->load->library("Common");
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$invocieno = $numget+1;
		
        $data = array('tid' => $invocieno, 
		'typeguide' => $type_guide,
		'invoicedate' => $guidedate,
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
		'loc' => $warehouse, 
		'tax_id' => $customer_tax, 
		'serie' => $invoi_serie,
		'version' => $vers,	
		'irs_type' => $invoi_type);
        $guideno2 = $invocieno;
		
		$this->db->trans_start();
		$transok = true;
		if($typp==0 || $typp==1)
		{
			if ($this->db->insert('geopos_guides', $data)) {
				$invocieno = $this->db->insert_id();
				
				$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
				$this->db->set('start', "$guideno2", FALSE);
				$this->db->where($multiClause);
				$this->db->update('geopos_series_ini_typs');
				
				$this->db->trans_complete();
			}else {
				echo json_encode(array('status' => 'Error', 'message' => "Erro ao inserir Guia!"));
				$transok = false;
				exit;
			}
		}else{
			$this->db->set($data);
			$this->db->where('id', $idgu);
			if ($this->db->update('geopos_guides')) {
				$this->db->delete('geopos_guides_items', array('tid' => $idgu));
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
				$this->db->insert_batch('geopos_guides_items', $productlist);
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
					$striPay = "[ENDED]<br>";
				}else{
					$striPay = "[CREATED]<br>";
				}
				$striPay .= "Utilizador: ".$this->aauth->get_user()->username;
				$striPay .= '<br>'.$yourbrowser;
				$striPay .= '<br>Ip: '.$this->aauth->get_user()->ip_address;
				
				$tipoinseee = "";
				if($typp == 2){
					$tipoinseee = "Guia de Remessa atualizada com Sucesso.";
					$striPay .= '<br>Rascunho Guia Nº (Provisório)'.$guideno2.' atualizada para o Cliente: '.$customer_name;
				}else if($typp == 3)
				{
					$tipoinseee = "Guia de Remessa concluída com Sucesso.";
					$striPay .= '<br>Guia Nº'.$guideno2.' finalizada para o Cliente: '.$customer_name;
				}else if($typp == 0){
					$tipoinseee = "Guia de Remessa guardada como Rascunho com Sucesso.";
					$striPay .= '<br>Rascunho Guia Nº (Provisório)'.$guideno2.' para o Cliente: '.$customer_name;
				}else{
					$tipoinseee = "Guia de Remessa concluída com Sucesso.";
				}
				
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'guide', $invocieno);
				
				//$this->custom->save_fields_data($invocieno, 2);
			}
			echo json_encode(array('status' => 'Success', 'message' => $tipoinseee . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printguide?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a>&nbsp; &nbsp; <a href='create?ty=$type_guide' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
		 }
    }
	
	

    public function ajax_list()
    {
		$type = $this->input->get('ty');
        $list = $this->guides->get_datatables($this->limited, $type);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $guides) {
			$textini = $guides->type.'-'.$guides->tid;
			if($guides->status == 0)
			{
				$textini .= '<br>(Provisório)';
			}
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="' . base_url("guides/view?id=$guides->id&type=1&tid=$guides->tid") . '">&nbsp; ' . $textini . '</a>';
            $row[] = $guides->name;
            $row[] = dateformat($guides->invoicedate);
            $row[] = amountExchange($guides->total, 0, $this->aauth->get_user()->loc);
			$row[] = $guides->viatura;
			
			$option = '<a href="' . base_url("guides/view?id=$guides->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("guides/printguide?id=$guides->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $guides->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->guides->count_all($this->limited, $type),
            "recordsFiltered" => $this->guides->count_filtered($this->limited, $type),
            "data" => $data
        );
        //output to json format
        echo json_encode($output);
    }

    public function view()
    {
		$this->load->library("Custom");
		$this->load->library("Common");
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = $this->input->get('id');
		$type = $this->input->get('type');
        $data['guide'] = $this->guides->guide_details($tid, $this->limited);
		$type = "";
		if($data['guide']['typeguide'] == 1)
		{
			if (!$this->aauth->premission(13) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Guia de Remessa ';
		}else{
			if (!$this->aauth->premission(16) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Guia de Transporte ';
		}		
		
		$data['history'] = $this->common->history($tid,'guide');
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['attach'] = $this->guides->attach($tid);
        $head['usernm'] = $this->aauth->get_user()->username;
		
		$head['title'] = $type . $data['guide']['tid'];
		$data['guide']['type'] = $type;
        $data['type_guide'] = $data['guide']['typeguide'];
        $this->load->view('fixed/header', $head);
        $data['products'] = $this->guides->guide_products($tid);
        $data['employee'] = $this->guides->employee($data['guide']['eid']);
        $data['c_custom_fields'] = $this->custom->view_fields_data($tid, 2);
        if ($data['guide']['id']) {
            $data['guide']['id'] = $tid;
            $this->load->view('guides/view', $data);
        }
        $this->load->view('fixed/footer');
    }

    public function printguide()
    {
        $tid = $this->input->get('id');
		$token = $this->input->get('token');
        $data['id'] = $tid;
        $data['invoice'] = $this->guides->guide_details($tid, $this->limited);
		
        if ($data['invoice']['id']) 
			$data['products'] = $this->guides->guide_products($tid);
        if ($data['invoice']['id']) 
			$data['employee'] = $this->guides->employee($data['invoice']['eid']);
		
		$type = "";
		if($data['invoice']['typeguide'] == 1)
		{
			$type = 'Guia de Remessa';
		}else{
			$type = 'Guia de Transporte';
		}
		$data['type_guide'] = $data['invoice']['typeguide'];
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);
		
		
        $data['general'] = array('title' => $type, 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
		
		$data['invoice']['type'] = $type;
		if($data['invoice']['status'] == 0)
		{
			$data['ImageBackGround'] = 'assets/images/rascunho.png';
		}
		
		if($data['invoice']['status'] == 2)
		{
			$data['ImageBackGround'] = 'assets/images/anulada.png';
		}
		$data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
		$static_q = $data['qrc'];
		
		if($data['invoice']['status'] == 2)
		{
			$data['invoice']['status'] = 'canceled';
		}
		
		if($data['invoice']['status'] == 0){
			$data['invoice']['status'] = 'Rascunho';
		}
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
		$loc2 = location(0);
		$pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">Processado por Programa Certificado nº'.$loc2['certification'].' {PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);
		$pdf->AddPage();
		$pdf->WriteHTML($html2);
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $type.'_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
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
		$draft = $this->input->post('draft');
		
		if($draft == 0)
		{
			if ($this->guides->guide_delete($id, $this->limited)) {
				// now try it
				$ua=$this->aauth->getBrowser();
				$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
				
				$striPay = "Utilizador: ".$this->aauth->get_user()->username;
				$striPay = $striPay.'<br>'.$yourbrowser;
				$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
				$striPay = $striPay.'<br>Rascunho da Guia Removido: '.$tid;
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'guide', $id);
				echo json_encode(array('status' => 'Success', 'message' => 'Rascunho da Guia Removido com Sucesso.'));
			} else {
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
		}else{
			$this->db->set('status', 2);
			$this->db->where('id', $id);
			$this->db->update('geopos_guides');
			
			// now try it
			$ua=$this->aauth->getBrowser();
			$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			
			$striPay = "Utilizador: ".$this->aauth->get_user()->username;
			$striPay = $striPay.'<br>'.$yourbrowser;
			$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
			$striPay = $striPay.'<br>Guia Anulada: '.$tid;
			$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'guide', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Documento Anulado com Sucesso.'));
			
		}
		if ($this->guides->invoice_delete($id, $this->limited)) {
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('DELETED')));
		} else {
			echo json_encode(array('status' => 'Error', 'message' =>
				$this->lang->line('ERROR')));
		}
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

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_guides');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->guides->meta_delete($invoice, 1, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->guides->meta_insert($id, 1, $files);
            }
        }
    }

    public function delivery()
    {
        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Invoice Supplier $tid";
        $data['invoice'] = $this->guides->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->guides->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->guides->employee($data['invoice']['eid']);

		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        ini_set('memory_limit', '64M');

        $html = $this->load->view('invoices_supli/del_note', $data, true);
		$html2 = $this->load->view('invoices_supli/del_note', $data2, true);

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
        $data['invoice'] = $this->guides->invoice_details($tid, $this->limited);
        if ($data['invoice']['id']) $data['products'] = $this->guides->invoice_products($tid);
        if ($data['invoice']['id']) $data['employee'] = $this->guides->employee($data['invoice']['eid']);
		
		$data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
		$static_q = $data['qrc'];
		$qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));
		$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		
        ini_set('memory_limit', '64M');
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        $html = $this->load->view('invoices_supli/proforma', $data, true);
		$html2 = $this->load->view('invoices_supli/proforma', $data2, true);
		
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
        $link = base_url('billing/viewsupli?id=' . $invocieno . '&token=' . $validtoken);
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
}