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



class Products extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        if (!$this->aauth->premission(2)) {

            exit($this->lang->line('translate19'));

        }

        $this->load->model('products_model', 'products');

        $this->load->model('categories_model');

        $this->load->library("Custom");

        $this->li_a = 'stock';



    }



    public function index()

    {

        $head['title'] = "Products";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/products');

        $this->load->view('fixed/footer');

    }



    public function cat()

    {

        $head['title'] = "Product Categories";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/cat_productlist');

        $this->load->view('fixed/footer');



    }


    public function add()
    {
        $data['cat'] = $this->categories_model->category_list_completa();
        $data['units'] = $this->products->units();
		$data['p_cla'] = $this->products->proclasses();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['custom_fields'] = $this->custom->add_fields(4);
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-add', $data);
        $this->load->view('fixed/footer');
    }





    public function product_list()
    {
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');
        if ($catid > 0) {

            $list = $this->products->get_datatables($catid, '', $sub);

        } else {

            $list = $this->products->get_datatables();

        }

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $prd) {

            $no++;

            $row = array();

            $row[] = $no;

            $pid = $prd->pid;

            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline"><img src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span>&nbsp;' . $prd->product_name . '</a>';

            $row[] = +$prd->qty;

            $row[] = $prd->product_code;

            $row[] = $prd->c_title;

            $row[] = $prd->title;

            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);

            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> 

<div class="btn-group">

                                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>  ' . $this->lang->line('Print') . '</button>

                                    <div class="dropdown-menu">

                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a><div class="dropdown-divider"></div> <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a> <div class="dropdown-divider"></div>

                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $pid . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a><div class="dropdown-divider"></div>

                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $pid . '" target="_blank"> Label - Compact</a></div></div><a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $pid . '" target="_blank"> <span class="fa fa-pie-chart"></span> ' . $this->lang->line('Reports') . '</a> <div class="btn-group">

                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>

                                    <div class="dropdown-menu">

&nbsp;<a href="' . base_url() . 'products/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>

                                    </div>

                                </div>';

            $data[] = $row;

        }

        $output = array(

            "draw" => $this->input->post('draw'),

            "recordsTotal" => $this->products->count_all($catid, '', $sub),

            "recordsFiltered" => $this->products->count_filtered($catid, '', $sub),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }



    public function addproduct()
    {
        $product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat');
        $warehouse = $this->input->post('product_warehouse', true);
		$pclas = $this->input->post('product_class', true);
        $product_code = $this->input->post('product_code');
        $product_price = numberClean($this->input->post('product_price'));
        $factoryprice = numberClean($this->input->post('fproduct_price'));
        $taxrate = 0;
        $disrate = numberClean($this->input->post('product_disc', true));
        $product_qty = numberClean($this->input->post('product_qty', true));
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $product_desc = $this->input->post('product_desc', true);
        $image = $this->input->post('image');
        $unit = $this->input->post('unit', true);
        $barcode = $this->input->post('barcode');
        $v_type = $this->input->post('v_type');
        $v_stock = $this->input->post('v_stock');
        $v_alert = $this->input->post('v_alert');
        $w_type = $this->input->post('w_type');
        $w_stock = $this->input->post('w_stock');
        $w_alert = $this->input->post('w_alert');
        $wdate = datefordatabase($this->input->post('wdate'));
        $code_type = $this->input->post('code_type');
        $sub_cat = $this->input->post('sub_cat');
        $brand = $this->input->post('brand');
        $serial = $this->input->post('product_serial');
		
		$taxlist = array();
		$prodindex = 0;
		$idprodut = $this->db->insert_id();
		$s_id = $this->input->post('pid');
		$tax_id = $this->input->post('pid');
		$tax_n = $this->input->post('tax_n', true);
		$tax_val = $this->input->post('tax_val', true);
		$tax_como = $this->input->post('tax_como');
		$pcodid = $this->input->post('pcodid');
		$pperid = $this->input->post('pperid');
		
		foreach ($s_id as $key => $value) {
			$data = array(
				'p_id' => 0,
				't_id' => $tax_id[$key],
				't_name' => $tax_n[$key],
				't_val' => $tax_val[$key],
				't_como' => $tax_como[$key],
				't_cod' => $pcodid[$key],
				't_per' => $pperid[$key]
			);
			$taxlist[$prodindex] = $data;
			$prodindex++;
		}
		
		
		
		$supplielist = array();
		$prodsindex = 0;
		$sup_id = $this->input->post('supliid');
		$supliid = $this->input->post('supliid');
		$supli_n = $this->input->post('supli_n', true);
		$supli_ref = $this->input->post('supli_ref', true);
		$supli_pr_c = $this->input->post('supli_pr_c', true);
		$supli_des_c = $this->input->post('supli_des_c');
		$supli_des_g = $this->input->post('supli_des_g');
		$supli_pr_c_d = $this->input->post('supli_pr_c_d');
		$supli_marg_e = $this->input->post('supli_marg_e');
		$supli_marg_p = $this->input->post('supli_marg_p');
		
		foreach ($sup_id as $key => $value) {
			$data = array(
				'p_id' => 0,
				't_id' => $supliid[$key],
				'supli_n' => $supli_n[$key],
				'supli_ref' => $supli_ref[$key],
				'supli_pr_c' => $supli_pr_c[$key],
				'supli_des_c' => $supli_des_c[$key],
				'supli_des_g' => $supli_des_g[$key],
				'supli_pr_c_d' => $supli_pr_c_d[$key],
				'supli_marg_e' => $supli_marg_e[$key],
				'supli_marg_p' => $supli_marg_p[$key]
			);
			$supplielist[$prodsindex] = $data;
			$prodsindex++;
		}
		
		var_dump($taxlist);
		var_dump($supplielist);
		return;
        if ($catid) {
            $this->products->addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand, $serial, $pclas, $taxlist, $supplielist);
        }
    }



    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_products', array('pid' => $id));
				$this->db->delete('geopos_products_suppliers', array('pid' => $id));
				$this->db->delete('geopos_products_taxs', array('pid' => $id));
                $this->db->delete('geopos_products', array('sub' => $id, 'merge' => 1));
                $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                $this->db->set('merge', 0);
                $this->db->where('sub', $id);
                $this->db->update('geopos_products');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }



    public function edit()
    {
		if (!$this->aauth->premission(17)) {
			exit($this->lang->line('translate19'));	
		}
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
        if ($data['product']['merge'] > 0) {
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('merge', 1);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_var'] = $query->result_array();
            $this->db->select('*');
            $this->db->from('geopos_products');
            $this->db->where('merge', 2);
            $this->db->where('sub', $pid);
            $query = $this->db->get();
            $data['product_ware'] = $query->result_array();
        }
		$data['p_cla'] = $this->products->proclasses();
        $data['units'] = $this->products->units();
        $data['serial_list'] = $this->products->serials($data['product']['pid']);
		
		$data['irs_produts'] = $this->products->irs_produts($data['product']['pid']);
		$data['suppliers_produts'] = $this->products->suppliers_produts($data['product']['pid']);
		
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['cat_sub'] = $this->categories_model->sub_cat_curr($data['product']['sub_id']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['product']['pcat']);
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['cat'] = $this->categories_model->category_list_completa();
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 4);
        $head['title'] = "Edit Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-edit', $data);
        $this->load->view('fixed/footer');
    }



    public function editproduct()
    {
        $pid = $this->input->post('pid');
        $product_name = $this->input->post('product_name', true);
        $catid = $this->input->post('product_cat');
		$pclas = $this->input->post('product_class', true);
        $warehouse = $this->input->post('product_warehouse', true);
        $product_code = $this->input->post('product_code');
        $product_price = numberClean($this->input->post('product_price'));
        $factoryprice = numberClean($this->input->post('fproduct_price'));
        $taxrate = 0;
        $disrate = numberClean($this->input->post('product_disc'));
        $product_qty = numberClean($this->input->post('product_qty'));
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $product_desc = $this->input->post('product_desc', true);
        $image = $this->input->post('image');
        $unit = $this->input->post('unit');
        $barcode = $this->input->post('barcode');
        $code_type = $this->input->post('code_type');
        $sub_cat = $this->input->post('sub_cat');
        if (!$sub_cat) $sub_cat = 0;
        $brand = $this->input->post('brand');
        $vari = array();
        $vari['v_type'] = $this->input->post('v_type');
        $vari['v_stock'] = $this->input->post('v_stock');
        $vari['v_alert'] = $this->input->post('v_alert');
        $vari['w_type'] = $this->input->post('w_type');
        $vari['w_stock'] = $this->input->post('w_stock');
        $vari['w_alert'] = $this->input->post('w_alert');
        $serial = array();
        $serial['new'] = $this->input->post('product_serial');
        $serial['old'] = $this->input->post('product_serial_e');
		
		$taxlist = array();
		$prodindex = 0;
		$idprodut = $this->db->insert_id();
		$s_id = $this->input->post('pid');
		$tax_id = $this->input->post('pid');
		$tax_n = $this->input->post('tax_n', true);
		$tax_val = $this->input->post('tax_val', true);
		$tax_como = $this->input->post('tax_como');
		$pcodid = $this->input->post('pcodid');
		$pperid = $this->input->post('pperid');
		
		foreach ($s_id as $key => $value) {
			$data = array(
				'p_id' => 0,
				't_id' => $tax_id[$key],
				't_name' => $tax_n[$key],
				't_val' => $tax_val[$key],
				't_como' => $tax_como[$key],
				't_cod' => $pcodid[$key],
				't_per' => $pperid[$key]
			);
			$taxlist[$prodindex] = $data;
			$prodindex++;
		}
		
		
		
		$supplielist = array();
		$prodsindex = 0;
		$sup_id = $this->input->post('supliid');
		$supliid = $this->input->post('supliid');
		$supli_n = $this->input->post('supli_n', true);
		$supli_ref = $this->input->post('supli_ref', true);
		$supli_pr_c = $this->input->post('supli_pr_c', true);
		$supli_des_c = $this->input->post('supli_des_c');
		$supli_des_g = $this->input->post('supli_des_g');
		$supli_pr_c_d = $this->input->post('supli_pr_c_d');
		$supli_marg_e = $this->input->post('supli_marg_e');
		$supli_marg_p = $this->input->post('supli_marg_p');
		
		foreach ($sup_id as $key => $value) {
			$data = array(
				'p_id' => 0,
				't_id' => $supliid[$key],
				'supli_n' => $supli_n[$key],
				'supli_ref' => $supli_ref[$key],
				'supli_pr_c' => $supli_pr_c[$key],
				'supli_des_c' => $supli_des_c[$key],
				'supli_des_g' => $supli_des_g[$key],
				'supli_pr_c_d' => $supli_pr_c_d[$key],
				'supli_marg_e' => $supli_marg_e[$key],
				'supli_marg_p' => $supli_marg_p[$key]
			);
			$supplielist[$prodsindex] = $data;
			$prodsindex++;
		}
        if ($pid) {
            $this->products->edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat, $brand, $vari, $serial, $pclas, $taxlist, $supplielist);
        }
    }

    public function warehouseproduct_list()
    {
        $catid = $this->input->get('id');
        $list = $this->products->get_datatables($catid, true);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $no++;

            $row = array();

            $row[] = $no;

            $pid = $prd->pid;

            $row[] = $prd->product_name;

            $row[] = +$prd->qty;

            $row[] = $prd->product_code;

            $row[] = $prd->c_title;

            $row[] = amountExchange($prd->product_price, 0, $this->aauth->get_user()->loc);

            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span> ' . $this->lang->line('Delete') . '</a>';

            $data[] = $row;

        }

        $output = array(

            "draw" => $this->input->post('draw'),

            "recordsTotal" => $this->products->count_all($catid, true),

            "recordsFiltered" => $this->products->count_filtered($catid, true),

            "data" => $data,

        );

        echo json_encode($output);

    }



    public function prd_stats()
    {
        $this->products->prd_stats();
    }


    public function stock_transfer_products()
    {
        $wid = $this->input->get('wid');
        $customer = $this->input->post('product');
        $terms = @$customer['term'];
        $result = $this->products->products_list($wid, $terms);
        echo json_encode($result);
    }


    public function sub_cat()
    {
        $wid = $this->input->get('id');
        $result = $this->categories_model->category_list(1, $wid);
        echo json_encode($result);
    }

    public function stock_transfer()
    {
        if ($this->input->post()) {

            $products_l = $this->input->post('products_l');

            $from_warehouse = $this->input->post('from_warehouse');

            $to_warehouse = $this->input->post('to_warehouse');

            $qty = $this->input->post('products_qty');

            $this->products->transfer($from_warehouse, $products_l, $to_warehouse, $qty);

        } else {

            $data['cat'] = $this->categories_model->category_list_completa();

            $data['warehouse'] = $this->categories_model->warehouse_list();

            $head['title'] = "Stock Transfer";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/stock_transfer', $data);

            $this->load->view('fixed/footer');

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

                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));

        }

    }



    public function barcode()

    {

        $pid = $this->input->get('id');

        if ($pid) {

            $this->db->select('product_name,barcode,code_type');

            $this->db->from('geopos_products');

            //  $this->db->where('warehouse', $warehouse);

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $resultz = $query->row_array();

            $data['name'] = $resultz['product_name'];

            $data['code'] = $resultz['barcode'];

            $data['ctype'] = $resultz['code_type'];

            $html = $this->load->view('barcode/view', $data, true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->WriteHTML($html);

            $pdf->Output($data['name'] . '_barcode.pdf', 'I');



        }

    }



    public function posbarcode()

    {

        $pid = $this->input->get('id');

        if ($pid) {

            $this->db->select('product_name,barcode,code_type');

            $this->db->from('geopos_products');

            //  $this->db->where('warehouse', $warehouse);

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $resultz = $query->row_array();

            $data['name'] = $resultz['product_name'];

            $data['code'] = $resultz['barcode'];

            $data['ctype'] = $resultz['code_type'];

            $html = $this->load->view('barcode/posbarcode', $data, true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load_thermal();

            $pdf->WriteHTML($html);

            $pdf->Output($data['name'] . '_barcode.pdf', 'I');



        }

    }



    public function view_over()

    {

        $pid = $this->input->post('id');

        $this->db->select('geopos_products.*,geopos_warehouse.title');

        $this->db->from('geopos_products');

        $this->db->where('geopos_products.pid', $pid);

        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->group_start();

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

            $this->db->group_end();

        } elseif (!BDATA) {

            $this->db->where('geopos_warehouse.loc', 0);

        }



        $query = $this->db->get();

        $data['product'] = $query->row_array();



        $this->db->select('geopos_products.*,geopos_warehouse.title');

        $this->db->from('geopos_products');

        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->group_start();

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

            $this->db->group_end();

        } elseif (!BDATA) {

            $this->db->where('geopos_warehouse.loc', 0);

        }

        $this->db->where('geopos_products.merge', 1);

        $this->db->where('geopos_products.sub', $pid);

        $query = $this->db->get();

        $data['product_variations'] = $query->result_array();



        $this->db->select('geopos_products.*,geopos_warehouse.title');

        $this->db->from('geopos_products');

        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->group_start();

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

            $this->db->group_end();

        } elseif (!BDATA) {

            $this->db->where('geopos_warehouse.loc', 0);

        }

        $this->db->where('geopos_products.sub', $pid);

        $this->db->where('geopos_products.merge', 2);

        $query = $this->db->get();

        $data['product_warehouse'] = $query->result_array();





        $this->load->view('products/view-over', $data);





    }





    public function label()

    {

        $pid = $this->input->get('id');

        if ($pid) {

            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');

            $this->db->from('geopos_products');

            //  $this->db->where('warehouse', $warehouse);

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $resultz = $query->row_array();



            $html = $this->load->view('barcode/label', array('lab' => $resultz), true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->WriteHTML($html);

            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');



        }

    }





    public function poslabel()

    {

        $pid = $this->input->get('id');

        if ($pid) {

            $this->db->select('product_name,product_price,product_code,barcode,expiry,code_type');

            $this->db->from('geopos_products');

            //  $this->db->where('warehouse', $warehouse);

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $resultz = $query->row_array();

            $html = $this->load->view('barcode/poslabel', array('lab' => $resultz), true);

            ini_set('memory_limit', '64M');

            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load_thermal();

            $pdf->WriteHTML($html);

            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');

        }

    }



    public function report_product()

    {

        $pid = intval($this->input->post('id'));



        $r_type = intval($this->input->post('r_type'));

        $s_date = datefordatabase($this->input->post('s_date'));

        $e_date = datefordatabase($this->input->post('e_date'));



        if ($pid && $r_type) {
            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_invoices.tid) as tid,geopos_invoice_items.qty, geopos_invoice_items.price,CONCAT(geopos_invoices.invoicedate, ' - ', geopos_invoice_items.product) as invoicedate 
					FROM geopos_invoice_items 
					LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pcat 
					LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_invoices.serie WHERE geopos_invoice_items.pid='$pid' AND geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
                case 2 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_purchase.tid) as tid,geopos_purchase_items.qty, geopos_purchase_items.price,CONCAT(geopos_purchase.invoicedate, ' - ', geopos_purchase_items.product) as invoicedate
					FROM geopos_purchase_items 
					LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid 
					LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat 
					LEFT JOIN geopos_irs_typ_doc ON geopos_purchase.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_purchase.serie WHERE geopos_purchase_items.pid='$pid' AND geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
                case 3 :

                    $query = $this->db->query("SELECT rid2 AS qty, DATE(d_time) AS  invoicedate,note FROM geopos_movers  WHERE geopos_movers.d_type='1' AND rid1='$pid'  AND (DATE(d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");

                    $result = $query->result_array();

                    break;

            }



            $this->db->select('*');

            $this->db->from('geopos_products');

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $product = $query->row_array();



            $cat_ware = $this->categories_model->cat_ware($pid, $this->aauth->get_user()->loc);



//if(!$cat_ware) exit();

            $html = $this->load->view('products/statementpdf-ltr', array('report' => $result, 'product' => $product, 'cat_ware' => $cat_ware, 'r_type' => $r_type), true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->WriteHTML($html);

            $pdf->Output($pid . 'report.pdf', 'I');

        } else {

            $pid = intval($this->input->get('id'));

            $this->db->select('*');

            $this->db->from('geopos_products');

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $product = $query->row_array();

            $head['title'] = "Product Sales";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/statement', array('id' => $pid, 'product' => $product));

            $this->load->view('fixed/footer');

        }

    }



    public function custom_label()

    {

        if ($this->input->post()) {

            require APPPATH . 'third_party/barcode/autoload.php';

            $width = $this->input->post('width');

            $height = $this->input->post('height');

            $padding = $this->input->post('padding');

            $store_name = $this->input->post('store_name');

            $warehouse_name = $this->input->post('warehouse_name');

            $product_price = $this->input->post('product_price');

            $product_code = $this->input->post('product_code');

            $bar_height = $this->input->post('bar_height');

            $bar_width = $this->input->post('bar_width');

            $label_width = $this->input->post('label_width');

            $label_height = $this->input->post('label_height');

            $product_name = $this->input->post('product_name');

            $font_size = $this->input->post('font_size');

            $max_char = $this->input->post('max_char');

            $b_type = $this->input->post('b_type');

            $total_rows = $this->input->post('total_rows');

            $items_per_rows = $this->input->post('items_per_row');

            $products = array();

            if(!$this->input->post('products_l')) exit('No Product Selected!');

            foreach ($this->input->post('products_l') as $row) {

                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');

                $this->db->from('geopos_products');

                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');



                if ($this->aauth->get_user()->loc) {

                    $this->db->group_start();

                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);



                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

                    $this->db->group_end();

                } elseif (!BDATA) {

                    $this->db->where('geopos_warehouse.loc', 0);

                }



                //  $this->db->where('warehouse', $warehouse);

                $this->db->where('geopos_products.pid', $row);

                $query = $this->db->get();

                $resultz = $query->row_array();



                $products[] = $resultz;



            }





            $loc = location($resultz['loc']);





            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows, 'bar_width' => $bar_width, 'label_width' => $label_width, 'label_height' => $label_height, 'product_name' => $product_name, 'font_size' => $font_size, 'max_char' => $max_char, 'b_type' => $b_type);





            $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design));



            /*

                        $html = $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design), true);

                        ini_set('memory_limit', '64M');



                        //PDF Rendering

                        $this->load->library('pdf');

                        $pdf = $this->pdf->load_en();

                        $pdf->WriteHTML($html);

                        $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');

            */



        } else {

            $data['cat'] = $this->categories_model->category_list_completa();

            $data['warehouse'] = $this->categories_model->warehouse_list();

            $head['title'] = "Custom Label";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/custom_label', $data);

            $this->load->view('fixed/footer');

        }

    }



    public function custom_label_old()

    {

        if ($this->input->post()) {

            $width = $this->input->post('width');

            $height = $this->input->post('height');

            $padding = $this->input->post('padding');

            $store_name = $this->input->post('store_name');

            $warehouse_name = $this->input->post('warehouse_name');

            $product_price = $this->input->post('product_price');

            $product_code = $this->input->post('product_code');

            $bar_height = $this->input->post('bar_height');

            $total_rows = $this->input->post('total_rows');

            $items_per_rows = $this->input->post('items_per_row');

            $products = array();





            foreach ($this->input->post('products_l') as $row) {

                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');

                $this->db->from('geopos_products');

                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');



                if ($this->aauth->get_user()->loc) {

                    $this->db->group_start();

                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);



                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

                    $this->db->group_end();

                } elseif (!BDATA) {

                    $this->db->where('geopos_warehouse.loc', 0);

                }



                //  $this->db->where('warehouse', $warehouse);

                $this->db->where('geopos_products.pid', $row);

                $query = $this->db->get();

                $resultz = $query->row_array();



                $products[] = $resultz;



            }





            $loc = location($resultz['loc']);



            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);





            $html = $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design), true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load_en();

            $pdf->WriteHTML($html);

            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');





        } else {

            $data['cat'] = $this->categories_model->category_list_completa();

            $data['warehouse'] = $this->categories_model->warehouse_list();

            $head['title'] = "Custom Label";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/custom_label', $data);

            $this->load->view('fixed/footer');

        }

    }



    public function standard_label()

    {

        if ($this->input->post()) {

            $width = $this->input->post('width');

            $height = $this->input->post('height');

            $padding = $this->input->post('padding');

            $store_name = $this->input->post('store_name');

            $warehouse_name = $this->input->post('warehouse_name');

            $product_price = $this->input->post('product_price');

            $product_code = $this->input->post('product_code');

            $bar_height = $this->input->post('bar_height');

            $total_rows = $this->input->post('total_rows');

            $items_per_rows = $this->input->post('items_per_row');

            $standard_label = $this->input->post('standard_label');

            $products = array();





            foreach ($this->input->post('products_l') as $row) {

                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_products.code_type,geopos_warehouse.title,geopos_warehouse.loc');

                $this->db->from('geopos_products');

                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');



                if ($this->aauth->get_user()->loc) {

                    $this->db->group_start();

                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);



                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);

                    $this->db->group_end();

                } elseif (!BDATA) {

                    $this->db->where('geopos_warehouse.loc', 0);

                }



                //  $this->db->where('warehouse', $warehouse);

                $this->db->where('geopos_products.pid', $row);

                $query = $this->db->get();

                $resultz = $query->row_array();



                $products[] = $resultz;



            }





            $loc = location($resultz['loc']);



            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);



            switch ($standard_label) {

                case 'eu30019' :

                    $html = $this->load->view('standard_label/eu30019', array('products' => $products, 'style' => $design), true);

                    break;

            }





            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load_en();

            $pdf->WriteHTML($html);

            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');





        } else {

            $data['cat'] = $this->categories_model->category_list_completa();

            $data['warehouse'] = $this->categories_model->warehouse_list();

            $head['title'] = "Stock Transfer";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/standard_label', $data);

            $this->load->view('fixed/footer');

        }

    }

	

	

	

	

	

	

	

	

	//Classes



    public function classes()

    {

        if (!$this->aauth->premission(6)) {

            exit($this->lang->line('translate19'));

        }

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Product Classes';

        $this->load->view('fixed/header', $head);

        $this->load->view('products/classes');

        $this->load->view('fixed/footer');

    }





    public function classes_load_list()

    {

        if (!$this->aauth->premission(2)) {

            exit($this->lang->line('translate19'));

        }

        $list = $this->products->class_datatables();

        $data = array();

        $no = 0;

        foreach ($list as $cla) {

            $row = array();

            $no++;

            $row[] = $no;

            $row[] = $cla->title;

			

            $row[] = '<a href="editclass?id=' . $cla->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $cla->id . '"> <i class="fa fa-trash"></i> </a>';

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->products->class_count_all(),

            "recordsFiltered" => $this->products->class_count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

    }



    public function addclasses()
    {

        if (!$this->aauth->premission(2)) {

            exit($this->lang->line('translate19'));
        }

        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);

            if ($this->products->addclassesmod($title)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " <a href='addclasses' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='classes' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Adicionar Classe';

            $this->load->view('fixed/header', $head);

            $this->load->view('products/classadd');

            $this->load->view('fixed/footer');

        }



    }



    public function editclass()

    {

        if (!$this->aauth->premission(2)) {

            exit($this->lang->line('translate19'));

        }

        if ($this->input->post('title')) {

            $id = $this->input->post('id');

            $title = $this->input->post('title', true);



            if ($this->products->editclass($id, $title)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='classes' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $id = $this->input->get('id');

            $data['classep'] = $this->products->class_v($id);

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Alterar Classe';

            $this->load->view('fixed/header', $head);

            $this->load->view('products/classedit', $data);

            $this->load->view('fixed/footer');

        }



    }





    public function deleteclass()

    {

        if (!$this->aauth->premission(11)) {

            exit($this->lang->line('translate19'));

        }

        $id = $this->input->post('deleteid');



        if ($this->products->deleteclass($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





}