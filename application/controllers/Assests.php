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
        $this->load->view('assets/assetss', $data);
        $this->load->view('fixed/footer');
    }
	
	public function add()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(93) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $data['employees'] = $this->employee->list_employee();
        $data['cats'] = $this->assets_model->category_list();
        $data['units'] = $this->products->units();
        $data['warehouse'] = $this->assets_model->warehouse_list();
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
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
        $warehouse = $this->input->post('product_warehouse', true);
		$product_qty = numberClean($this->input->post('product_qty', true));
		$product_desc = $this->input->post('product_desc', true);
		$inspection_date = $this->input->post('inspection_date');
		$insurance_date = $this->input->post('insurance_date');
		$employee_id = $this->input->post('employee_id', true);
        if ($catid) {
            $this->assets_model->add($catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id);
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
        $data['cats'] = $this->assets_model->category_list();		
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

        if ($pid) {
            $this->assets_model->edit($pid, $catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id);
        }
    }
	
	
	public function assets_list()
    {
		if (!$this->aauth->premission(68) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->assets_model->get_datatables($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
			$row[] = $no;
            $row[] = $prd->assest_name;
			$row[] = $prd->cat_name;
            $row[] = $prd->warehousename;
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
        $data['cat'] = $this->assets_model->category_stock();
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
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
		$data['catTypes'] = $this->assets_model->category_type_list();
        $head['title'] = $this->lang->line("Add New assets Category");
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('assets/category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function addcat()
    {
		if (!$this->aauth->premission(96) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $cat_name = $this->input->post('assets_catname', true);
        $cat_desc = $this->input->post('asset_cat_type', true);

        if ($cat_name) {

            $this->assets_model->addc($cat_name,$cat_desc);
        }
    }
	
//view for edit

    public function editc()
    {
		$this->li_a = "misc";
		if (!$this->aauth->premission(97) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
		$catid = $this->input->get('id');
		$data['assetcat'] = $this->assets_model->assetscat_details($catid);
		$data['catTypes'] = $this->assets_model->category_type_list();
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

        $product_cat_name = $this->input->post('product_cat_name');
        $asset_cat_type = $this->input->post('asset_cat_type');
        if ($cid) {
            $this->assets_model->editc($cid, $product_cat_name, $asset_cat_type);
        }
    }
	
	public function assetscat_list()
    {
		if (!$this->aauth->premission(95) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->assets_model->get_datatablesc($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
			$row[] = $no;
            $row[] = $prd->title;
			$row[] = $prd->cat_name;
			$sumass = $this->assets_model->assetscat_sum($pid);
			$row[] = $sumass['num_ass'];
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
}