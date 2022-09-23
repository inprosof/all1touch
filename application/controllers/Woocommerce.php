<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Woocommerce extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('cronjob_model', 'cronjob');
        $this->load->model('woo_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }


    public function index()
    {
        $this->load->model('cronjob_model', 'cronjob');
        $corn = $this->cronjob->config();
        $data['cornkey'] = $corn['cornkey'];

        if ($this->input->post()) {
            $key1 = $this->input->post('key1');
            $key2 = $this->input->post('key2');
            $url = $this->input->post('url');
            $emp = $this->input->post('emp');

            $p_cat = $this->input->post('p_cat');
            $p_warehouse = $this->input->post('p_warehouse');
            $images = $this->input->post('images');
            $p_status = $this->input->post('p_status');
            $discount = $this->input->post('discount');
            $tax = $this->input->post('tax');

            $group_p = array("category" => $p_cat, "warehouse" => $p_warehouse, "images" => $images, "filter" => $p_status, "discount" => $discount, "tax" => $tax);
            $group_p_store = json_encode($group_p);

            $this->db->set('other', $group_p_store);
            $this->db->where('id', 60);
            $this->db->update('univarsal_api');

            $this->plugins->m_update_api(57, $key1, $key2, $url, $emp);


        } else {
            $this->load->model('categories_model');
            $this->load->model('employee_model', 'employee');
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'WooCommerce Integration';
            $data['universal'] = $this->plugins->universal_api(57);
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouses'] = $this->categories_model->warehouse_list();

            $extra_config = $this->plugins->universal_api(60);

            $data['config'] = json_decode($extra_config['other'], true);


            $this->db->select('*');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $data['config']['category']);
            $query = $this->db->get();
            $data['productcat'] = $query->row_array();


            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $data['config']['warehouse']);
            $query = $this->db->get();
            $data['warehouse'] = $query->row_array();


            $this->load->view('fixed/header', $head);
            $this->load->view('plugins/woocommerce', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function woo_orders()
    {

        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];
        if (!$cornkey = $this->input->get('token')) {
            exit("---------------Error! Invalid Token! -------------------------\n");
        }
        $result = $this->woo_model->woocom_orders();

        echo json_encode($result);


    }

    public function woo_products()
    {
        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];
        if (!$cornkey = $this->input->get('token')) {
            exit("---------------Error! Invalid Token! -------------------------\n");
        }
        $result = $this->woo_model->woocom_products();

        echo json_encode($result);

    }

    public function woo_products_sync()
    {

        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];
        if (!$cornkey = $this->input->get('token')) {
            exit("---------------Error! Invalid Token! -------------------------\n");
        }
        $result = $this->woo_model->woocom_products_syn();
        echo json_encode($result);

    }


}


