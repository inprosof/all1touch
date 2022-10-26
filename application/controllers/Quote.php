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
use Endroid\QrCode\Writer\PngWriter;

class Quote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quote_model', 'quote');
		$this->load->model('plugins_model', 'plugins');
		$this->load->model('assets_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
		if ((!$this->aauth->premission(7)) && (!$this->aauth->premission(136)) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
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
	
	////////////////////////Funcões Get convert//////////////////////
	///////////////////////////////////////////////////////////////////////
	
	public function duplicate()
	{
		$tid = $this->input->get('id');
		$typ = $this->input->get('typ');
		$this->create($tid, $typ);
	}
	
	
	public function convert()
	{
		$tid = $this->input->get('id');
		$typ = $this->input->get('typ');
		$this->create($tid, $typ);
	}
	
	public function create_typ()
	{
		$typ = $this->input->get('typ');
		$this->create(0, $typ);
	}
	
    //create invoice
    public function create($relation = 0, $typrelation = 0)
    {
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('settings_model', 'settings');
		$this->load->model('customers_model', 'customers');
		$this->load->library("Custom");
        $this->load->library("Common");
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		
		$data['typrelation'] = $typrelation;
		$data['relationid'] = $relation;
		$data['tiprelated'] = 0;
		if($relation > 0)
		{
			if($typrelation == 0){
				$data['tiprelated'] = 1;
			}
			$this->load->library("Related");
			$data['docs_origem'][] = $this->related->detailsAfterRelation($relation,$typrelation);
			$data['csd_name'] = $data['docs_origem']['name'];
			$data['csd_tax'] = $data['docs_origem']['taxid'];
			$data['csd_id'] = $data['docs_origem']['id'];
			$data['products'] = $this->related->detailsAfterRelationProducts($relation,$typrelation,0);
		}else{
			$data['csd_name'] = $this->lang->line('Default').": Consumidor Final";
			$data['csd_tax'] = "999999990";
			$data['csd_id'] = "99999999";
			$data['docs_origem'] = [];
		}
		
		////////////////////////Relação entre documentos//////////////////////
		///////////////////////////////////////////////////////////////////////
		$typename = "";
		if($typrelation == 12 || $typrelation == '12')
		{
			$data['type_quote_id'] = 1;
			$typename = "Fatura Pró-Forma ";
			if(count($this->settings->billingterms(10)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$data['terms'] = $this->settings->billingterms(10);
		}else{
			$typename = "Orçamento ";
			if(count($this->settings->billingterms(8)) == 0)
			{
				exit('Deve Inserir pelo menos um Termo para o Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/billing_terms"><i 
													class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
			}
			$data['type_quote_id'] = 0;
			$data['terms'] = $this->settings->billingterms(8);
		}
		
		$data['type_quote'] = $typename;
		
		////////////////////////Relação entre Permissões//////////////////////
		///////////////////////////////////////////////////////////////////////
		$data['autos'] = $this->common->guide_autos_company();
		if($this->aauth->get_user()->loc == 0)
		{
			$discship = $this->settings->online_pay_settings_main();
		}else{
			$discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
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
		$numget = 0;
		if($typrelation == 12)
		{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(10);
		}else{
			$data['typesinvoicesdefault'] = $this->common->default_typ_doc(8);
		}
		$data['seriesinvoiceselect'] = $this->common->default_series($this->aauth->get_user()->loc);
		if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$data['locations'] = $this->settings->company_details(1);
		}else{
			$data['locations'] = $this->settings->company_details2($this->aauth->get_user()->loc);
		}
		
		$data['typesinvoices'] = "";
		if($data['seriesinvoiceselect'] == NULL)
		{
			exit('Deve Inserir pelo menos uma Série no Tipo '.$typename.'. <a class="match-width match-height"  href="'.base_url().'settings/irs_typs"><i 
												class="ft-chevron-right"></i> Click aqui para o Fazer. </a> ');
		}else{
			$seri_did_df = $this->common->default_series_id($this->aauth->get_user()->loc);
			if($typrelation == 12)
			{
				$numget = $this->common->lastdoc(10,$seri_did_df);
				$data['custom_fields'] = [];
			}else{
				$numget = $this->common->lastdoc(8,$seri_did_df);
				$data['custom_fields'] = $this->custom->add_fields(3);
			}
			$head['title'] = "Nova(o) ".$typename;
			$data['lastinvoice'] = $numget;
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
		$data['autos'] = $this->common->guide_autos_company();
        $data['invoice'] = $this->quote->quote_details($tid);
		
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$this->load->library("Related");
		if($data['invoice']['status'] == 'draft'){
			$data['docs_origem'] = $this->related->getRelated($tid,0,1);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,1);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,3,1);
		}else{
			$data['docs_origem'] = $this->related->getRelated($tid,0,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,0);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,3,0);
		}		
		$data['csd_name'] = $data['invoice']['name'];
		$data['csd_tax'] = $data['invoice']['taxid'];
		$data['csd_id'] = $data['invoice']['id'];
		////////////////////////Relação entre documentos//////////////////////
		///////////////////////////////////////////////////////////////////////
		$data['locations'] = $this->settings->company_details2($data['invoice']['loc']);
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
		$type = $this->input->get('ty');
		$typename = "";
		if($type == 1 || $type == '1')
		{
			if (!$this->aauth->premission(136) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$head['title'] = "Gestão de Faturas Pró-Forma";
			$typename = "Fatura Pró-Forma ";
		}else{
			if (!$this->aauth->premission(7) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$head['title'] = "Gestão de Orçamentos";
			$typename = "Orçamento ";
		}
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
		if($type == 1 || $type == '1')
		{
			$this->load->view('quotes/listproform');
		}else{
			$this->load->view('quotes/quotes');
		}
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
			if($typp==0)
			{
				$status = 'draft';
			}else{
				$status = 'pending';
			}
		}else{
			$vers = numberClean($vers)+1;
		}
		$proposal = $this->input->post('propos', true);
		$type_quote = $this->input->post('type_quote', true);
		
		$TipoSave = '';
		if($type_quote == 0){
			$TipoSave = 'Orçamento ';
		}else{
			$TipoSave = 'Fatura Pró-Forma ';
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
		$warehouse = $this->input->post('s_warehouses', true);
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
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$this->load->library("Related");
		$this->load->library("Transport");
		$typrelation = $this->input->post('typrelation');
		$relationid = $this->input->post('relationid');
		////////////////////////Relação entre documentos//////////////////////
		///////////////////////////////////////////////////////////////////////

		$guideddta = $this->input->post('invoicedate', true);
		$guidedate = datefordatabase($guideddta);
		$start_date = $this->input->post('start_date_guide', true);
		$start_date_guide = '';
		if ($start_date == "") {
			$start_date_guide = null;
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
				//$warehouse = $this->aauth->get_user()->loc;
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
		
		$this->load->library("Common");
		$numget = $this->common->lastdoc($invoi_type,$invoi_serie);
		$invocieno = $numget+1;
		$invocieno2 = $invocieno;
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
		'discount' => $discs_come,
		'discount_rate' => $disc_val, 
		'total' => $total,  
		'tax' => $taxas_tota, 
		'notes' => $notes,
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
		'i_class' => $type_quote,
		'loc' => $warehouse,
		'tax_id' => $customer_tax, 
		'serie' => $invoi_serie,
		'version' => $vers,	
		'irs_type' => $invoi_type);		
		
		
		//var_dump($data);
		//exit();
		$this->db->trans_start();
		$transok = true;
		
		if($typp==0 || $typp==1)
		{
			if ($this->db->insert('geopos_quotes', $data)) {
				$invocieno = $this->db->insert_id();
				$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
				$this->db->set('start', "$invocieno2", FALSE);
				$this->db->where($multiClause);
				$this->db->update('geopos_series_ini_typs');
				$typeinv = $this->settings->irs_typ_view($invoi_type);
				$typeinvserie = $this->settings->irs_typ_series_name($invoi_serie);
				//$transok = $this->settings->AssinaDocumento($invocieno, 0, $invoi_type, $typeinv['type'], $invoi_serie, $typeinvserie['serie'], $invocieno2);
				
				$this->db->trans_complete();
			}else {
				echo json_encode(array('status' => 'Error', 'message' => 'Erro ao gravar '.$TipoSave));
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
		
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		$this->load->library("Related");
		$this->load->library("Transport");
		if($status == 'draft'){
			if($relationid > 0){
				$this->related->removeALL($invocieno,$typrelation,1);
				if($type_quote == 0){
					$this->related->add($invocieno,$typrelation,1,$relationid,3);
				}else{
					$this->related->add($invocieno,$typrelation,1,$relationid,12);
				}
			}
			if($start_date_guide != null)
			{
				if($type_quote == 0){
					$this->transport->add($invocieno,3,1,$id_auto_ins,$expeditionid,$start_date_guide,$matricula_aut,$designacao_aut,$loc_guide_comp,$post_guide_comp,$city_guide_comp,$mcustomer_gui_comp,$loc_guide_cos,$post_guide_cos,$city_guide_cos,$mcustomer_gui_cos);
				}else{
					$this->transport->add($invocieno,12,1,$id_auto_ins,$expeditionid,$start_date_guide,$matricula_aut,$designacao_aut,$loc_guide_comp,$post_guide_comp,$city_guide_comp,$mcustomer_gui_comp,$loc_guide_cos,$post_guide_cos,$city_guide_cos,$mcustomer_gui_cos);
				}
				
			}
		}else{
			if($relationid > 0){
				$this->related->removeALL($invocieno,$typrelation,0);
				if($type_quote == 0){
					$this->related->add($invocieno,$typrelation,0,$relationid,3);
				}else{
					$this->related->add($invocieno,$typrelation,0,$relationid,12);
				}
				
			}
			if($start_date_guide != null)
			{
				if($type_quote == 0){
					$this->transport->add($invocieno,3,0,$id_auto_ins,$expeditionid,$start_date_guide,$matricula_aut,$designacao_aut,$loc_guide_comp,$post_guide_comp,$city_guide_comp,$mcustomer_gui_comp,$loc_guide_cos,$post_guide_cos,$city_guide_cos,$mcustomer_gui_cos);
				}else{
					$this->transport->add($invocieno,12,0,$id_auto_ins,$expeditionid,$start_date_guide,$matricula_aut,$designacao_aut,$loc_guide_comp,$post_guide_comp,$city_guide_comp,$mcustomer_gui_comp,$loc_guide_cos,$post_guide_cos,$city_guide_cos,$mcustomer_gui_cos);
				}
				
			}
		}
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
		
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
					$tipoinseee = $TipoSave."atualizado com Sucesso.";
					$striPay .= '<br>Rascunho '.$TipoSave.'Nº (Provisório)'.$invocieno2.' atualizado para o Cliente: '.$customer_name;
				}else if($typp == 3)
				{
					$this->custom->save_fields_data($invocieno, 3);
					$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
					$this->db->set('start', "$invocieno2", FALSE);
					$this->db->where($multiClause);
					$this->db->update('geopos_series_ini_typs');
				
					$this->db->set(array('status' => 'pending'));
					$this->db->where('id', $invocieno);
					$this->db->update('geopos_quotes');
					
					$tipoinseee = $TipoSave."concluído com Sucesso.";
					$striPay .= '<br>'.$TipoSave.'Nº'.$invocieno2.' finalizada para o Cliente: '.$customer_name;
				}else if($typp == 0){
					$tipoinseee = $TipoSave."guardado como Rascunho com Sucesso.";
					$striPay .= '<br>Rascunho '.$TipoSave.'Nº (Provisório)'.$invocieno2.' para o Cliente: '.$customer_name;
				}else{
					$this->custom->save_fields_data($invocieno, 3);
					$multiClause = array('typ_doc' => $invoi_type, 'serie' => $invoi_serie);
					$this->db->set('start', "$invocieno2", FALSE);
					$this->db->where($multiClause);
					$this->db->update('geopos_series_ini_typs');
				
					$this->db->set(array('status' => 'pending'));
					$this->db->where('id', $invocieno);
					$this->db->update('geopos_quotes');
					
					$tipoinseee = $TipoSave."concluído com Sucesso.";
					$striPay .= '<br>'.$TipoSave.'Nº'.$invocieno2.' finalizada para o Cliente: '.$customer_name;
				}
				
				$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $invocieno);
			}
			echo json_encode(array('status' => 'Success', 'message' => $tipoinseee . " <a href='view?id=$invocieno' class='btn btn-primary btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printquote?id=$invocieno' class='btn btn-blue btn-lg' target='_blank'><span class='fa fa-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a>&nbsp; &nbsp; <a href='create' class='btn btn-warning btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>"));
		 }
	}


    public function ajax_list()
    {
		$type = $this->input->get('ty');
        $list = $this->quote->get_datatables($this->limited,$type);
        $data = array();
        $no = $this->input->post('start');
		$this->load->library("Related");
        foreach ($list as $invoices) {
			//$textini = $invoices->type.'-'.$invoices->tid;
			$textini = $invoices->tid;
			if($invoices->status == 'draft')
			{
				$textini .= '<br>(Provisório)';
			}
            $no++;
            $row = array();
			$row['status'] = $invoices->status;
			$row[] = $invoices->serie_name;
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id&type=$invoices->i_class&tid=$invoices->tid") . '">'.$textini.'</a>';
			$row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->name;
            $row[] = $invoices->taxid;
			$row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
			$statt = "";
			$statt2 = "";
			$width = 0;
			$valnow = 0;
			$valrelated = $this->related->getRelated(0,$invoices->tid,0);
			if(count($valrelated) > 0)
			{
				if($valrelated->total == 0 || $valrelated->total == null || $valrelated->total == "" || $invoices->total == 0 || $invoices->total == null || $invoices->total == "")
				{
					$width = round(0*100,2);
					$valnow = 0;
				}else
				{
					$width = round(($valrelated->total/$invoices->total)*100,2);
					$valnow = $valrelated->total;
				}
			}else{
				$width = round(0*100,2);
				$valnow = 0;
			}
			
			$row[] = "<div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$valnow' aria-valuemin='0' aria-valuemax='$invoices->total' style='width:$width%;'>$width%</div></div>";
			
			if($invoices->status == 'draft')
			{
				$statt2 .= "badge st-pending";
				$statt = 'Rascunho';
			}else{
				$statt2 .= "badge st-". $invoices->status;
				if($invoices->status == 'ended'){
					$statt2 .= 'badge st-accepted';
				}
				$statt = $this->lang->line(ucwords($invoices->status));
			}
            $row[] = '<span class="'.$statt2. '">' . $statt . '</span>';
			if($invoices->status == 'draft' || $invoices->status == 'pending' || $invoices->status == 'rejected')
			{
				$option = '<a href="' . base_url("quote/view?id=$invoices->id&type=$invoices->i_class&tid=$invoices->tid") . '" class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
				$option .= '<a data-toggle="modal" data-target="#choise_type_convert" href="#" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm convert-object" title="Converter"><span class="icon-briefcase"></span></a>';
				if($invoices->i_class == 0)
				{
					$option .= '&nbsp;<a href="' . base_url("quote/duplicate?typ=3&id=$invoices->id") . '" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm" title="Duplicar"><span class="ft-target"></span></a>';
				}else{
					$option .= '&nbsp;<a href="' . base_url("quote/duplicate?typ=12&id=$invoices->id") . '" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm" title="Duplicar"><span class="ft-target"></span></a>';
				}
				
				$option .= '&nbsp;<a data-toggle="modal" data-target="#choise_docs_related" href="#" class="btn btn-success btn-sm related-object" title="Documentos Relacionados"><span class="icon-list"></span></a>';
				
				if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
					if($invoices->status == 'draft')
					{
						$option .= '&nbsp;<a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-danger btn-sm delete-object2"><span class="fa fa-trash"></span></a>';
					}else{
						$option .= '&nbsp;<a href="#" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
					}
				}
				
				$row[] = $option;
			}else{
				$option = '<a href="' . base_url("quote/view?id=$invoices->id&type=$invoices->i_class&tid=$invoices->tid") . '" class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>&nbsp;';
				if($invoices->i_class == 0)
				{
					$option .= '<a href="' . base_url("quote/duplicate?typ=3&id=$invoices->id") . '" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm" title="Duplicar"><span class="ft-target"></span></a>&nbsp;';
				}else{
					$option .= '<a href="' . base_url("quote/duplicate?typ=12&id=$invoices->id") . '" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm" title="Duplicar"><span class="ft-target"></span></a>';
				}
				
				if($invoices->status != 'canceled'){
					$option .= '&nbsp;<a data-toggle="modal" data-target="#choise_type_convert" href="#" data-object-type="'.$invoices->irs_type_c.'" data-object-id="' . $invoices->id . '" data-object-tid="' . $invoices->tid . '" class="btn btn-success btn-sm convert-object" title="Converter"><span class="icon-briefcase"></span></a>&nbsp;';
					$option .= '<a data-toggle="modal" data-target="#choise_docs_related" href="#" class="btn btn-success btn-sm related-object" title="Documentos Relacionados"><span class="icon-list"></span></a>';
				}
				
				$row[] = $option;
			}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->quote->count_all($this->limited,$type),
            "recordsFiltered" => $this->quote->count_filtered($this->limited,$type),
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
		$type = "";
		if($data['invoice']['i_class'] == 0)
		{
			if (!$this->aauth->premission(7) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Orçamento ';
		}else{
			if (!$this->aauth->premission(136) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
				exit($this->lang->line('translate19'));
			}
			$type = 'Fatura Pró-Forma ';
		}
		///////////////////////////////////////////////////////////////////////
		////////////////////////Relação entre documentos//////////////////////
				
		$this->load->library("Related");
		if($data['invoice']['status'] == 'draft'){
			$data['docs_origem'] = $this->related->getRelated($tid,0,1);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,1);
			$data['products'] = $this->related->detailsAfterRelationProducts($tid,1);
		}else{
			$data['docs_origem'] = $this->related->getRelated($tid,0,0);
			$data['docs_deu_origem'] = $this->related->getRelated(0,$tid,0);
			if($data['invoice']['i_class'] == 0)
			{
				$data['products'] = $this->related->detailsAfterRelationProducts($tid,3,0);
			}else{
				$data['products'] = $this->related->detailsAfterRelationProducts($tid,12,0);
			}
			
		}
		$data['history'] = $this->common->history($tid,'quote');
        $data['attach'] = $this->quote->attach($tid);
        $data['employee'] = $this->quote->employee($data['invoice']['eid']);
		$data['attach'] = $this->quote->attach($tid);
        $head['usernm'] = $this->aauth->get_user()->username;
		if($data['invoice']['i_class'] == 0)
		{
			$data['custom_fields'] = $this->custom->view_fields_data($tid, 3);
		}else{
			$data['custom_fields'] = [];
		}
		
        $head['title'] = $type."Nº" . $data['invoice']['tid'];
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
		
		$type = "";
		if($data['invoice']['i_class'] == 0)
		{
			$type = $this->lang->line('Quote');
		}else{
			$type = 'Fatura Pró-Forma';
		}
        $data['general'] = array('title' => $type, 'person' => $this->lang->line('Customer'), 'prefix' => $data['invoice']['irs_type_n'], 't_type' => 1);
		$data['invoice']['type'] = $type;
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
		
		
		if($data['invoice']['i_class'] == 0)
		{
			$html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
			$html2 = $this->load->view('print_files/invoice-a4_v' . INVV, $data2, true);
			$html3 = $this->load->view('print_files/invoice-a4_v' . INVV, $data3, true);
			$html4 = $this->load->view('print_files/invoice-a4_v' . INVV, $data4, true);
		}else{
			$html = $this->load->view('print_files/invoice-a4_v1', $data, true);
			$html2 = $this->load->view('print_files/invoice-a4_v1', $data2, true);
			$html3 = $this->load->view('print_files/invoice-a4_v1', $data3, true);
			$html4 = $this->load->view('print_files/invoice-a4_v1', $data4, true);
		}
		
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

        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $type.'_' . $data['invoice']['name'] . '_' . $data['invoice']['tid']);
        if ($this->input->get('d')) {
            $pdf->Output($file_name . '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
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
		
        $html = $this->load->view('quotes/proforma', $data, true);
		$html2 = $this->load->view('quotes/proforma', $data2, true);
		
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
			$this->db->delete('geopos_quotes_items', array('id' => $id));
			$this->db->delete('geopos_quotes', array('id' => $id));
			$this->db->delete('geopos_data_related', array('tid' => $id));
			$this->db->delete('geopos_data_transport', array('tid' => $id));
			$this->db->delete('geopos_log', array('id_c' => $idgu,'type_log' => 'quote'));
			echo json_encode(array('status' => 'Success', 'message' => 'Rascunho removido com Sucesso.'));
		}else{
			$justification = $this->input->post('justification');
			$this->db->set('status', 'canceled');
			$this->db->set('justification_cancel', $justification);
			$this->db->where('id', $id);
			$this->db->update('geopos_quotes');
			
			$ua=$this->aauth->getBrowser();
			$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
			$striPay = '>Colocar documento em estado anulado';
			$striPay .= '<br>Utilizador: '.$this->aauth->get_user()->username;
			$striPay .= '<br>Email: '.$this->aauth->get_user()->email;
			$striPay .= '<br>Ip: '.$this->aauth->get_user()->ip_address;
			$striPay .= '<br>'.$yourbrowser;
			$striPay .= '<br>Observações:'.$justification;
			$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $id);
			echo json_encode(array('status' => 'Success', 'message' => 'Documento Anulado com Sucesso. Atualize a página para verificar as Alterações.'));
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
		$striPay .= '<br>Atualizado o Estado do Documento.';
		$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'quote', $tid);

        echo json_encode(array('status' => 'Success', 'message' => 'Estado do Documento Atualizado com Sucesso. Atualize a página para verificar as Alterações.', 'pstatus' => $status));
    }

    public function convert_q()
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

            echo json_encode(array('status' => 'Success', 'message' => 'Orçaçamento convertido em Fatura com Sucesso.'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
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