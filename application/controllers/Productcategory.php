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

class Productcategory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model', 'products_cat');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(25) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $this->li_a = 'stock';
    }

    public function index()
    {
		if (!$this->aauth->premission(25) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category', $data);
        $this->load->view('fixed/footer');
    }

    public function warehouse()
    {
		if (!$this->aauth->premission(28) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		
        $data['cat'] = $this->products_cat->warehouse();
        $head['title'] = "Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
		if (!$this->aauth->premission(25) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['id'] = $this->input->get('id');
        $data['sub'] = $this->input->get('sub');
        $data['cat'] = $this->products_cat->category_sub_stock($data['id']);
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }

    public function viewwarehouse()
    {
		if (!$this->aauth->premission(28) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['cat'] = $this->products_cat->warehouse();
        $head['title'] = "View Product Warehouses";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse_view', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
		if (!$this->aauth->premission(26) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['cat'] = $this->products_cat->category_list_completa();
        $this->load->model('locations_model');
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function add_sub()
    {
		if (!$this->aauth->premission(26) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
		
		$catid = $this->input->get('id');
		if($catid != '' && $catid != null){
			$this->db->select('*');
			$this->db->from('geopos_product_cat');
			$this->db->where('id', $catid);
			$query = $this->db->get();
			$data['catpai'] = $query->row_array();
		}		
        $data['cat'] = $this->products_cat->category_list_completa();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add', $data);
        $this->load->view('fixed/footer');
    }

    public function addwarehouse()
    {
		if (!$this->aauth->premission(29) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $cat_name = $this->input->post('product_catname');
            $cat_desc = $this->input->post('product_catdesc');
            $lid = $this->input->post('lid');
            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 or $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }

            if ($cat_name) {

                $this->products_cat->addwarehouse($cat_name, $cat_desc, $lid);
            }
        } else {
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $data['cat'] = $this->products_cat->category_list_completa();
            $head['title'] = "Add Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/warehouse_add', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function addcat()
    {
		$this->load->library("form_validation");
        $cat_name = $this->input->post('product_catname');
        $cat_desc = $this->input->post('product_catdesc');
		$cat_rel = $this->input->post('cat_rel');
		$image = $this->input->post('image');
		$vis_pos = 0;
		if(filter_has_var(INPUT_POST,'vis_pos')) {
			$vis_pos = 1;
		}else{
			$vis_pos = 0;
		}
		
		$fav_pos = 0;
		if(filter_has_var(INPUT_POST,'fav_pos')) {
			$fav_pos = 1;
		}else{
			$fav_pos = 0;
		}
		$rules = array(
            array(
                'field' => 'product_catname',
                'label' => 'Sub Nome da Categoria',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            ),
            array(
                'field' => 'product_catdesc',
                'label' => 'Descrição',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            )
        );
		
		$this->form_validation->set_rules($rules);		
		if ($this->form_validation->run())
		{
			$this->products_cat->addnew($cat_name, $cat_desc, $cat_rel, $image, $vis_pos, $fav_pos);
		}else{
			echo json_encode(array('status' => 'Dados de Formulário', 'message' => $this->form_validation->error_string()));
		}
    }

    public function delete_i()
    {
		if (!$this->aauth->premission(121)){
            exit($this->lang->line('translate19'));
        }
        $id = intval($this->input->post('deleteid'));
        if ($id) {
			$query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON  geopos_products.pcat=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");
			$this->db->delete('geopos_products', array('pcat' => $id));
			$this->db->delete('geopos_product_cat', array('id' => $id));
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
		} else {
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
		}
    }

    public function delete_i_sub()
    {
		if (!$this->aauth->premission(121)){
            exit($this->lang->line('translate19'));
        }
		$id = intval($this->input->post('deleteid'));
		if ($id) {

			$query = $this->db->query("DELETE geopos_movers FROM geopos_movers LEFT JOIN geopos_products ON  geopos_movers.rid1=geopos_products.pid LEFT JOIN geopos_product_cat ON geopos_products.pcat=geopos_product_cat.id WHERE geopos_product_cat.id='$id' AND  geopos_movers.d_type='1'");

			$this->db->delete('geopos_products', array('sub_id' => $id));
			$this->db->delete('geopos_product_cat', array('id' => $id));
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
		} else {
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
		}
    }

    public function delete_warehouse()
    {
		if (!$this->aauth->premission(121)){
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');
		if ($id) {
			$this->db->delete('geopos_products', array('warehouse' => $id));
			$this->db->delete('geopos_warehouse', array('id' => $id));
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Warehouse with products')));
		} else {
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
		}
    }

//view for edit
    public function edit()
    {
		if (!$this->aauth->premission(27) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $catid = $this->input->get('id');
        $this->db->select("geopos_product_cat.*, case when geopos_product_cat.rel_id = 0 then 'Sem Pai Definido' else pai.title end as painame");
        $this->db->from('geopos_product_cat');
		$this->db->join('geopos_product_cat as pai', 'geopos_product_cat.rel_id = pai.id', 'left');
        $this->db->where('geopos_product_cat.id', $catid);
        $query = $this->db->get();
        $data['productcat'] = $query->row_array();
        $data['cat'] = $this->products_cat->category_list_completa();
        $head['title'] = "Edit Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-cat-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editwarehouse()
    {
		if (!$this->aauth->premission(30) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $cid = $this->input->post('catid');
            $cat_name = $this->input->post('product_cat_name', true);
            $cat_desc = $this->input->post('product_cat_desc', true);
            $lid = $this->input->post('lid');

            if ($this->aauth->get_user()->loc) {
                if ($lid == 0 or $this->aauth->get_user()->loc == $lid) {

                } else {
                    exit();
                }
            }
            if ($cat_name) {

                $this->products_cat->editwarehouse($cid, $cat_name, $cat_desc, $lid);
            }
        } else {
            $catid = $this->input->get('id');
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $catid);
            $query = $this->db->get();
            $data['warehouse'] = $query->row_array();
            $this->load->model('locations_model');
            $data['locations'] = $this->locations_model->locations_list2();
            $head['title'] = "Edit Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/product-warehouse-edit', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function editcat()
    {
        $cid = $this->input->post('catid');
        $product_cat_name = $this->input->post('product_cat_name',true);
        $product_cat_desc = $this->input->post('product_cat_desc');
        $cat_rel = $this->input->post('cat_rel', true);
        $image = $this->input->post('image');
		$vis_pos = 0;
		if(filter_has_var(INPUT_POST,'vis_pos')) {
			$vis_pos = 1;
		}else{
			$vis_pos = 0;
		}
		
		$fav_pos = 0;
		if(filter_has_var(INPUT_POST,'fav_pos')) {
			$fav_pos = 1;
		}else{
			$fav_pos = 0;
		}
		
		$rules = array(
            array(
                'field' => 'product_catname',
                'label' => 'Sub Nome da Categoria',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            ),
            array(
                'field' => 'product_catdesc',
                'label' => 'Descrição',
                'rules' => 'required',
				'errors' => array('required' => 'Por favor preencha o Campo %s.')
            )
        );
        if ($cid) {
            $this->products_cat->edit($cid, $product_cat_name, $product_cat_desc, $cat_rel, $image, $vis_pos, $fav_pos);
        }
    }


    public function report_product()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));
        $sub_date = $this->input->post('sub');
		$filter = 'pcat';
        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }


            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_invoices.tid) as tid,geopos_invoice_items.qty, geopos_invoice_items.price,CONCAT(geopos_invoices.invoicedate, ' - ', geopos_invoice_items.product) as invoicedate 
					FROM geopos_invoice_items 
					LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pcat 
					LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_invoices.serie $qj WHERE geopos_invoices.status!='canceled' AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_purchase.tid) as tid,geopos_purchase_items.qty, geopos_purchase_items.price,CONCAT(geopos_purchase.invoicedate, ' - ', geopos_purchase_items.product) as invoicedate
					FROM geopos_purchase_items 
					LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid 
					LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat 
					LEFT JOIN geopos_irs_typ_doc ON geopos_purchase.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_purchase.serie WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.$filter='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name   FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.$filter='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/cat_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $sub = $this->input->get('sub');
            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/cat_statement', array('id' => $pid, 'product' => $product, 'sub' => $sub));
            $this->load->view('fixed/footer');
        }
    }

    public function warehouse_report()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }
            switch ($r_type) {
                case 1 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_invoices.tid) as tid,geopos_invoice_items.qty, geopos_invoice_items.price,CONCAT(geopos_invoices.invoicedate, ' - ', geopos_invoice_items.product) as invoicedate 
					FROM geopos_invoice_items 
					LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid $qj 
					LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_invoices.serie 
					WHERE geopos_invoices.status!='canceled'  AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.warehouse='$pid' $wr");
                    $result = $query->result_array();
                    break;
                case 2 :
                    $query = $this->db->query("SELECT CONCAT(geopos_irs_typ_doc.type, ' ',geopos_series.serie, '/', geopos_purchase.tid) as tid,geopos_purchase_items.qty, geopos_purchase_items.price,CONCAT(geopos_purchase.invoicedate, ' - ', geopos_purchase_items.product) as invoicedate 
					FROM geopos_purchase_items 
					LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid 
					LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid 
					LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat 
					LEFT JOIN geopos_irs_typ_doc ON geopos_purchase.irs_type = geopos_irs_typ_doc.id 
					LEFT JOIN geopos_series ON geopos_series.id = geopos_purchase.serie 
					WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.pcat='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3 :
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name  FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.warehouse='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/ware_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');


            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Product Sales";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/ware_statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }


}