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

class Locations extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit($this->lang->line('translate19'));

        }
        $this->li_a = 'company';
        $this->load->library("Common");
        $this->load->model('locations_model', 'locations');
    }

    public function index()
    {
        $head['title'] = "Locations";
        $data['locations'] = $this->locations->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('locations/index', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $taxid = $this->input->post('taxid', true);
            $image = $this->input->post('image', true);
            $cur_id = $this->input->post('cur_id', true);
            $ac_id = $this->input->post('account', true);
			$acd_id = $this->input->post('account_d', true);
			$acf_id = $this->input->post('account_f', true);
			$typ_doc = $this->input->post('type_doc');
            $wid = $this->input->post('wid');
			$rent_ab = 0;
			if(filter_has_var(INPUT_POST,'rent_ab')) {
				$rent_ab = 1;
			}else{
				$rent_ab = 0;
			}
			$zon_fis = $this->input->post('zon_fis');
			if ($this->locations->create($name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id, $ac_id, $acd_id, $acf_id, $wid, $typ_doc,$rent_ab,$zon_fis)) {
				$seriid = $this->db->insert_id();
				$this->load->model('saft_model', 'saft');
				$this->saft->createautentications($seriid);
				$this->locations->createpermissions($seriid,$name,$email);
				
				$typs_id = $this->input->post('pid');
				$pcopyid = $this->input->post('pcopyid');
				$typslist = array();
				$prodindex = 0;
				foreach ($typs_id as $key => $value) {
					$data = array(
						'loc' => $seriid,
						'typ_doc' => $typs_id[$key],
						'copy' => $pcopyid[$key]);
					$typslist[$prodindex] = $data;
					$prodindex++;
				}
				$this->db->insert_batch('geopos_documents_copys', $typslist);
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='create' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='index' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
			} else {
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
        } else {

			$this->load->library("Common");
            $head['title'] = "Add Location";
			$data['countrys'] = $this->common->countrys();
			$data['irs_typ'] = $this->common->irs_typ_combo();
            $data['currency'] = $this->locations->currencies();
            $data['warehouse'] = $this->locations->warehouses();
            $data['accounts'] = $this->locations->accountslist();
			$data['docs_copy_ini'] = $this->common->default_typ_pref_doc_list($this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('locations/create', $data);
            $this->load->view('fixed/footer');
        }
    }

	public function geral_emails()
    {
		if ($this->input->post()) {
			$id = $this->input->post('id', true);
			$email_app = $this->input->post('emails_notifica', true);
			$emailo_remet = $this->input->post('emailo_remet', true);
			$email_stock = $this->input->post('email_stock', true);
			
			$docs_email = 0;
			if(filter_has_var(INPUT_POST,'docs_email')) {
				$docs_email = 1;
			}else{
				$docs_email = 0;
			}
			
			$docs_del_email = 0;
			if(filter_has_var(INPUT_POST,'docs_del_email')) {
				$docs_del_email = 1;
			}else{
				$docs_del_email = 0;
			}
			
			$trans_email = 0;
			if(filter_has_var(INPUT_POST,'trans_email')) {
				$trans_email = 1;
			}else{
				$trans_email = 0;
			}
			
			$trans_del_email = 0;
			if(filter_has_var(INPUT_POST,'trans_del_email')) {
				$trans_del_email = 1;
			}else{
				$trans_del_email = 0;
			}
			
			$stock_min = 0;
			if(filter_has_var(INPUT_POST,'stock_min')) {
				$stock_min = 1;
			}else{
				$stock_min = 0;
			}
			
			$stock_sem = 0;
			if(filter_has_var(INPUT_POST,'stock_sem')) {
				$stock_sem = 1;
			}else{
				$stock_sem = 0;
			}
			if ($this->locations->editpermissions2($id, $docs_email, $docs_del_email, $trans_email, $trans_del_email, $email_stock, $email_app, $emailo_remet, $stock_min, $stock_sem)) {
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED').' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
			}else{
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
        }
	}
	public function geral_configs()
    {
        if ($this->input->post()) {
			$id = $this->input->post('id', true);
			$grafic = 0;
			if(filter_has_var(INPUT_POST,'grafic_show')) {
				$grafic = 1;
			}else{
				$grafic = 0;
			}
			
			$products = 0;
			if(filter_has_var(INPUT_POST,'products_show')) {
				$products = 1;
			}else{
				$products = 0;
			}
			
			$clients = 0;
			if(filter_has_var(INPUT_POST,'clients_show')) {
				$clients = 1;
			}else{
				$clients = 0;
			}
			
			$ac_id = $this->input->post('account', true);
			$acd_id = $this->input->post('account_d', true);
			$acf_id = $this->input->post('account_f', true);
			$typ_doc = $this->input->post('type_doc');
			$pstyle = $this->input->post('pstyle', true);
			$assign = $this->input->post('assign', true);
			$pos_list = $this->input->post('pos_list', true);
			$dual_entry = $this->input->post('dual_entry', true);
            $wid = $this->input->post('wid');
			
			if ($this->locations->editpermissions1($id, $grafic, $products, $clients)) {
				if ($this->locations->edit2($id, $ac_id, $acd_id, $acf_id, $wid, $typ_doc, $dual_entry, $pstyle, $assign, $pos_list)) {
					echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED').' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
				}else{
					echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
				}
			}else{
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
        }
    }
	
	
    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $taxid = $this->input->post('taxid', true);
            $image = $this->input->post('image', true);
            $cur_id = $this->input->post('cur_id', true);
			$rent_ab = 0;
			if(filter_has_var(INPUT_POST,'rent_ab')) {
				$rent_ab = 1;
			}else{
				$rent_ab = 0;
			}
			
			if ($this->locations->edit($id, $name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id)) {
				$this->db->delete('geopos_documents_copys', array('loc' => $id));
				$typs_id = $this->input->post('pid');
				$pcopyid = $this->input->post('pcopyid');
				$typslist = array();
				$prodindex = 0;
				foreach ($typs_id as $key => $value) {
					$data = array(
						'loc' => $id,
						'typ_doc' => $typs_id[$key],
						'copy' => $pcopyid[$key]);
					$typslist[$prodindex] = $data;
					$prodindex++;
				}
				$this->db->insert_batch('geopos_documents_copys', $typslist);
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')." <a href='index' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
			} else {
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
            
        } else {
			$this->load->library("Common");
			$this->load->model('saft_model', 'saft');
            $head['title'] = "Edit Location";
			$data = $this->locations->view($this->input->get('id'));
			$id = $this->input->get('param');
			if($id != null)
			{
				$data['param'.$id] = $id;
			}else{
				$id = 0;
				$data['param1'] = 1;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}
			
			if($id == 1 || $id == 0)
			{
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 2)
			{
				$data['param1'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 3)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 4)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 44)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 5)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 6)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param7'] = 0;
				$data['param77'] = 0;
			}else if($id == 7)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param77'] = 0;
			}else if($id == 77)
			{
				$data['param1'] = 0;
				$data['param2'] = 0;
				$data['param3'] = 0;
				$data['param4'] = 0;
				$data['param44'] = 0;
				$data['param5'] = 0;
				$data['param6'] = 0;
				$data['param7'] = 0;
			}
			
			$data['activation'] = $this->saft->getsaftautenticationloc($this->input->get('id'));
			$data['company_permiss'] = $this->saft->getpermissionsystem($this->input->get('id'));
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['currency'] = $this->locations->currencies();
			$data['countrys'] = $this->common->countrys();
			$data['irs_typ'] = $this->common->irs_typ_combo();
            $data['accounts'] = $this->locations->accountslist();
			$data['docs_copy_ini'] = $this->common->default_typ_pref_doc_list($this->input->get('id'));
            $data['warehouse'] = $this->locations->warehouses();
            $data['online_pay'] = $this->locations->online_pay_settings($this->input->get('id'));
            $this->load->view('fixed/header', $head);
            $this->load->view('locations/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

	public function autority_pt()
	{
        if ($this->input->post()) {
			$this->load->model('saft_model', 'saft');
			$id = $this->input->post('id');
			$bill_doc = 0;
			$trans_doc = 0;
			
			if(filter_has_var(INPUT_POST,'billing_doc')) {
				$bill_doc = 1;
			}else{
				$bill_doc = 0;
			}
			
			if(filter_has_var(INPUT_POST,'transport_doc')) {
				$trans_doc = 1;
			}else{
				$trans_doc = 0;
			}
			
			$databddocs = "";
			if($bill_doc == 1)
			{
				if($this->input->post('date_docs') == "")
				{
					$databddocs = date('d-m-Y');
				}else{
					$databddocs = $this->input->post('date_docs');
				}
			}
			
			$databdtrans = "";
			if($trans_doc == 1)
			{
				if($this->input->post('date_docs_guide') == "")
				{
					$databdtrans = date('d-m-Y');
				}else{
					$databdtrans = $this->input->post('date_docs_guide');
				}
			}
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($username == "") {
				echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir o seu Utilizador.'));
				return;
			}
			
			if ($password == "") {
				echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir a sua Senha.'));
				return;
			}
			if ($this->saft->editat($id,$bill_doc,$databddocs,$trans_doc,$databdtrans,$username,$password)) {
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED').' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
			}else{
				echo json_encode(array('status' => 'Success', 'message' => 'Erro a guardar informações AT.'));
			}
		}
	}
	
	public function reg_iva()
	{
		if ($this->input->post()) {
			$this->load->model('saft_model', 'saft');
			$id = $this->input->post('id');
			$caixa_1 = 0;
			$caixa_2 = 0;
			$caixa_3 = 0;
			$caixa_4 = 0;
			
			if(filter_has_var(INPUT_POST,'caixa_1')) {
				$caixa_1 = 1;
			}
			
			if(filter_has_var(INPUT_POST,'caixa_2')) {
				$caixa_2 = 1;
			}
			
			if(filter_has_var(INPUT_POST,'caixa_3')) {
				$caixa_3 = 1;
			}
			
			if(filter_has_var(INPUT_POST,'caixa_4')) {
				$caixa_4 = 1;
			}
			
			$dateActiv = "";
			if($caixa_1 == 1 && $caixa_2 == 1 && $caixa_3 == 1)
			{
				if($caixa_4 == 1){
					if($this->input->post('caixa_doc_date') == "")
					{
						$dateActiv = date('d-m-Y');
					}else{
						$dateActiv = $this->input->post('caixa_doc_date');
					}
				}
			}
			if ($this->saft->editcaixa($id,$caixa_1,$caixa_2,$caixa_3,$caixa_4,$dateActiv)) {
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED').' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
			}else{
				echo json_encode(array('status' => 'Success', 'message' => 'Erro a guardar informações Caixa IVA.'));
			}
		}
	}

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_locations', array('id' => $id));
			$this->db->delete('geopos_documents_copys', array('loc' => $id));
			$this->db->delete('geopos_saft_autentications', array('loc' => $id));
			$this->db->delete('geopos_system_permiss', array('loc' => $id));

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function load_list()
    {
        $list = $this->promo->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $promo) {
            $no++;
            switch ($promo->active) {
                case 0 :
                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';
                    break;
                case 1 :
                    $promo_status = '<span class="st-partial">' . $this->lang->line('Used') . '</a>';
                    break;
                case 2 :
                    $promo_status = '<span class="st-due">' . $this->lang->line('Expired') . '</a>';
                    break;
            }
            $row = array();
            $row[] = $no;
            $row[] = $promo->code;
            $row[] = $promo->amount;
            $row[] = $promo->valid;
            $row[] = $promo_status;
            $row[] = $promo->available . ' (' . $promo->qty . ')';
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $promo->id . '" data-stat="0"> SET </a> <a href="#" data-object-id="' . $promo->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->promo->count_all(),
            "recordsFiltered" => $this->promo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function promo_stats()
    {

        $this->promo->promo_stats();


    }

    public function set_status()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->promo->set_status($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            if ($this->products->meta_delete($name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/', 'upload_url' => base_url() . 'userfile/company/'
            ));


        }


    }


}