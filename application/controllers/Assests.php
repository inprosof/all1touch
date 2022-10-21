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

class Assests extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(95) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
		$this->load->model('assets_model');
		$this->load->model('employee_model', 'employee');
		$this->load->model('products_model', 'products');
		$this->load->library("Custom");
        $this->li_a = "misc";
    }

    public function index()
    {
		if (!$this->aauth->premission(92) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $head['title'] = $this->lang->line("Assets");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/assetss');
        $this->load->view('fixed/footer');
    }
	
	public function add()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(93) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $data['employees'] = $this->employee->list_employee();
		$data['cats'] = $this->assets_model->category_list_completa();
		$data['catTypes'] = $this->assets_model->category_type_list();
        $data['units'] = $this->products->units();
        $data['warehouse'] = $this->assets_model->warehouse_list();
        $head['title'] = "Adicionar novo Ativo";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/assets-add', $data);
        $this->load->view('fixed/footer');
	}
	
	public function addasset()
    {
		$product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat', true);
        $warehouse = $this->input->post('product_warehouse');
		$product_qty = numberClean($this->input->post('product_qty', true));
		$product_desc = $this->input->post('product_desc', true);
		$inspection_date = $this->input->post('inspection_date');
		$insurance_date = $this->input->post('insurance_date');
		$employee_id = $this->input->post('employee_id');
		$image = $this->input->post('image');
		
		$this->load->library("form_validation");
		$rules = array(
            array(
                'field' => 'product_name',
                'label' => 'Nome do Ativo',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o %s.')
            ),
            array(
                'field' => 'product_cat',
                'label' => 'Categoria',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor Selecione uma %s.')
            ),
            array(
                'field' => 'product_desc',
                'label' => 'Descrição',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor insira uma %s.')
            ),
            array(
                'field' => 'product_qty',
                'label' => 'Quantidade',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor insira uma %s.')
            )
        );
		
		$this->form_validation->set_rules($rules);		
		if ($this->form_validation->run())
		{
			$this->assets_model->add($catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id, $image);
		}else{
			echo json_encode(array('status' => 'Dados de Formulário', 'message' => $this->form_validation->error_string()));
		}
    }
	
	public function edit()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(94) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $catid = $this->input->get('id');
		$head['title'] = "Alterar Ativo";
        $data['assests'] = $this->assets_model->assets_details($catid);
		$data['cats'] = $this->assets_model->category_list_completa();
		$data['catTypes'] = $this->assets_model->category_type_list();		
		$data['warehouse'] = $this->assets_model->warehouse_list();
        $data['employees'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/assetss-edit', $data);
        $this->load->view('fixed/footer');
    }
	
	public function editasset()
    {
		if (!$this->aauth->premission(94) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $pid = $this->input->post('aid');
        $product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat', true);
        $warehouse = $this->input->post('product_warehouse', true);
		$product_qty = numberClean($this->input->post('product_qty', true));
		$product_desc = $this->input->post('product_desc', true);
		$inspection_date = $this->input->post('inspection_date');
		$insurance_date = $this->input->post('insurance_date');
		$employee_id = $this->input->post('employee_id', true);
		$image = $this->input->post('image');
		
        if ($pid) {
            $this->assets_model->edit($pid, $catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id, $image);
        }
    }
	
	public function assets_list()
    {
		if (!$this->aauth->premission(68) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		$cid = $this->input->get('id');
        if ($cid > 0) {
            $list = $this->assets_model->get_datatables($cid);
        } else {
            $list = $this->assets_model->get_datatables();
        }
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
			$row[] = $no;
            $row[] = $prd->assest_name.'<br>'.$prd->warehousename;
			$row[] = $prd->cat_name;
			$row[] = $prd->qty;
			$row[] = $prd->product_des;
			$option = '';
			if ($this->aauth->premission(70) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="' . base_url() . 'assests/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>&nbsp;';
			}
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->assets_model->count_all($cid),
            "recordsFiltered" => $this->assets_model->count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
		
	}
	
	
	public function delete_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		$id = intval($this->input->post('deleteid'));
		if ($id) {
			$this->db->delete('geopos_assets', array('id' => $id));
			echo json_encode(array('status' => 'Success', 'message' =>'Foi removido com sucesso!'));
		} else {
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
		}
    }
	
	public function cats()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(95) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $data['cat'] = $this->assets_model->category_list_completa();
        $head['title'] = $this->lang->line("Assets");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/assets', $data);
        $this->load->view('fixed/footer');
		
	}

    public function addc()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(96) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
		$data['catpai'] = [];
		$data['catTypes'] = $this->assets_model->category_type_list();
		$data['cat'] = $this->assets_model->category_list_completa();
        $head['title'] = $this->lang->line("Add New assets Category");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/category_add', $data);
        $this->load->view('fixed/footer');
    }
	
	public function gettyp_cat_asset()
	{
		$catid = $this->input->get('id');
		$this->db->select("geopos_assets_cat_type.id, concat('** ', geopos_assets_cat_type.name,' **') AS name");
        $this->db->from('geopos_assets_cat');
		$this->db->join('geopos_assets_cat_type', 'geopos_assets_cat_type.id = geopos_assets_cat.type', 'left');
        $this->db->where('geopos_assets_cat.id', $catid);
        $query = $this->db->get();
		$result = $query->row_array();
		echo json_encode($result);
	}
	
	public function add_sub()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(96) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
		$catid = $this->input->get('id');
		$data['catpai'] = [];
		if($catid != '' && $catid != null){
			$this->db->select('geopos_assets_cat.*, geopos_assets_cat_type.name as typ_name');
			$this->db->from('geopos_assets_cat');
			$this->db->join('geopos_assets_cat_type', 'geopos_assets_cat_type.id = geopos_assets_cat.type', 'left');
			$this->db->where('geopos_assets_cat.id', $catid);
			$query = $this->db->get();
			$data['catpai'] = $query->row_array();
		}		
        $data['catTypes'] = $this->assets_model->category_type_list();
		$data['cat'] = $this->assets_model->category_list_completa();
        $head['title'] = $this->lang->line("Add New assets Category");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/category_add', $data);
		$this->load->view('fixed/footer');
    }
	
//view for edit

	public function addcat()
    {
		$this->load->library("form_validation");
        $cat_name = $this->input->post('product_catname');
		$extra = $this->input->post('product_catdesc');
        $rel_id = $this->input->post('cat_rel');
		$image = $this->input->post('image');
		$cat_typ = $this->input->post('cat_type_id');
		
		$rules = array(
            array(
                'field' => 'product_catname',
                'label' => 'Nome da Categoria',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            ),
            array(
                'field' => 'product_catdesc',
                'label' => 'Descrição',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            ),
            array(
                'field' => 'cat_type_id',
                'label' => 'Tipo de Ativo',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor Selecione o %s.')
            )
        );
		
		
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run())
		{
			$this->assets_model->addc($cat_name, $extra, $rel_id, $image, $cat_typ);
		}else{
			echo json_encode(array('status' => 'Dados de Formulário', 'message' => $this->form_validation->error_string()));
		}
    }
	
	
	public function editc()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(97) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
		$catid = $this->input->get('id');
		$data['assetcat'] = $this->assets_model->assetscat_details($catid);
		$data['catTypes'] = $this->assets_model->category_type_list();
		$data['cat'] = $this->assets_model->category_list_completa();
        $head['title'] = $this->lang->line("Edit Asset Category");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/assets-cat-edit', $data);
        $this->load->view('fixed/footer');
    }


    public function editcat()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(97) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('catid');
		$cat_name = $this->input->post('product_catname');
		$extra = $this->input->post('product_catdesc');
        $rel_id = $this->input->post('cat_rel');
		$image = $this->input->post('image');
		$cat_typ = $this->input->post('cat_type_id');
		
        if ($cid) {
            $this->assets_model->editc($cid, $cat_name, $extra, $rel_id, $image, $cat_typ);
        }
    }
	
	public function viewc()
    {
		if (!$this->aauth->premission(92) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $data['id'] = $this->input->get('id');
        $data['cat'] = $this->assets_model->category_sub_get($data['id']);
        $head['title'] = "View Assets Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/category_view', $data);
        $this->load->view('fixed/footer');
    }
	
	public function assetscat_list()
    {
		if (!$this->aauth->premission(95) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		
		$cid = $this->input->get('cid');
        $sub = $this->input->get('sub');
        if ($cid > 0) {
            $list = $this->assets_model->get_datatablesc($cid, '', $sub);
        } else {
            $list = $this->assets_model->get_datatablesc();
        }
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
			$row[] = $no;
			$row[] = '<a href="'.base_url("assests/viewc?id=$pid").'" data-object-id="' . $pid . '" class="view-object">' . $prd->title . '</a>';
            $row[] = $prd->cat_name.'<br>'.$prd->type_name;
			if($sub)
			{
				$sumass = $this->assets_model->category_stock($pid,1);
			}else{
				$sumass = $this->assets_model->category_stock($pid,0);
			}
			$row[] = $sumass['pc'];
			$row[] = $sumass['qty'];
			$option = '';
			if ($this->aauth->premission(97) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="' . base_url() . 'assests/editc?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>&nbsp;';
			}
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->assets_model->count_allc($cid),
            "recordsFiltered" => $this->assets_model->count_filteredc($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
		
	}
	
	
	public function deletecat_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		$id = intval($this->input->post('deleteid'));
		if ($id) {
			$this->db->delete('geopos_assets_cat', array('id' => $id));
			$this->db->delete('geopos_assets', array('acat' => $id));
			echo json_encode(array('status' => 'Success', 'message' =>$this->lang->line('Assets category deleted successfully.')));
		} else {
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
		}
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
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/assets/', 'upload_url' => base_url() . 'userfile/assets/'
            ));
        }
    }
}