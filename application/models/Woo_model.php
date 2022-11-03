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

use Automattic\WooCommerce\Client;

defined('BASEPATH') or exit('No direct script access allowed');


class Woo_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    private function woo_connect()
    {
        require APPPATH . 'third_party/woo/vendor/autoload.php';

        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 57);
        $query = $this->db->get();
        $keys = $query->row_array();
        try {
            $woocommerce = new Client(
                $keys['url'], // Your store URL
                $keys['key1'], // Your consumer key
                $keys['key2'], // Your consumer secret
                [
                    'wp_api' => true, // Enable the WP REST API integration
                    'version' => 'wc/v3' // WooCommerce WP REST API version
                ]
            );
        } catch (\Automattic\WooCommerce\HttpClient\HttpClientException $e) {

            return array('status' => 'Error', 'message' =>
                $e->getMessage());
        }
        return $woocommerce;
    }


    private function woo_image_importer($url)
    {
        $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $user_agent = 'php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function woocom_orders()
    {

        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 57);
        $query = $this->db->get();
        $keys = $query->row_array();
        $date_l = '2012-01-01T02:07:48';
        $message = '';

        try {

            $woocommerce = $this->woo_connect();


            $last_run = $keys['other'];
            $eid = $keys['method'];
            $this->db->select('id,loc');
            $this->db->from('geopos_users');
            $this->db->where('id', $eid);
            $query = $this->db->get();
            $empl = $query->row_array();


            if (!isset($empl['id'])) {
                return array('status' => 'Error', 'message' =>
                    'Invalid Employee for store invoices! ');
            }


           // $last_run = 0;

            if (!$last_run) $last_run = $date_l;

            $orders = $woocommerce->get('orders', array('after' => $last_run, 'per_page' => 100, 'order' => 'asc', 'orderby' => 'id'));

            if ($orders) {

                foreach ($orders as $order) {

                    $date_created = date('Y-m-d', strtotime($order->date_created));

                    $message .= $order->number . '<br>';

                    $sbutotal = $order->total + $order->discount_total - $order->total_tax - $order->shipping_total - $order->shipping_tax;
                    $email = $order->billing->email;
                    $this->db->select('id');
                    $this->db->from('geopos_customers');
                    $this->db->where('email', $email);
                    $query = $this->db->get();
                    $c_data = $query->row_array();
                    if ($c_data && $c_data['id']) {
                        $cid = $c_data['id'];
                    } else {
                        $data = array(
                            'name' => $order->billing->first_name . ' ' . $order->billing->last_name,
                            'company' => $order->billing->company,
                            'phone' => $order->billing->phone,
                            'email' => $order->billing->email,
                            'address' => $order->billing->address_1 . ' ' . $order->billing->address_2,
                            'city' => $order->billing->city,
                            'region' => $order->billing->state,
                            'country' => $order->billing->country,
                            'postbox' => $order->billing->postcode,
                            'gid' => 1,
                            'taxid' => '',
                            'name_s' => $order->shipping->first_name . ' ' . $order->shipping->last_name,
                            'phone_s' => $order->shipping->postcode,
                            'email_s' => $order->shipping->postcode,
                            'address_s' => $order->shipping->address_1 . ' ' . $order->shipping->address_2,
                            'city_s' => $order->shipping->city,
                            'region_s' => $order->shipping->state,
                            'country_s' => $order->shipping->country,
                            'postbox_s' => $order->shipping->postcode
                        );

                        $this->db->insert('geopos_customers', $data);
                        $cid = $this->db->insert_id();
                        $temp_password = rand(200000, 999999);
                        $pass = password_hash($temp_password, PASSWORD_DEFAULT);
                        $data2 = array(
                            'users_id' => null,
                            'user_id' => 1,
                            'status' => 'active',
                            'is_deleted' => 0,
                            'name' => $order->billing->first_name . ' ' . $order->billing->last_name,
                            'password' => $pass,
                            'email' => $order->billing->email,
                            'profile_pic' => '',
                            'user_type' => 'Member',
                            'cid' => $cid
                        );

                        $this->db->insert('users', $data2);

                    }
                    $total_tax = 0;
                    $total_discount = 0;
                    $itc = 0;

                    $create_data = array('id' => null, 'tid' => $order->number, 'invoicedate' => $date_created, 'invoiceduedate' => $date_created, 'subtotal' => $sbutotal, 'shipping' => $order->shipping_total, 'ship_tax' => $order->shipping_tax, 'ship_tax_type' => 'excl', 'discount' => $order->discount_total, 'tax' => $order->total_tax, 'total' => $order->total, 'notes' => $order->customer_note, 'csd' => $cid, 'eid' => $empl['id'], 'items' => $order->number, 'taxstatus' => 'yes', 'discstatus' => 'yes', 'format_discount' => '%', 'refer' => $order->number, 'term' => $order->number, 'multi' => 0, 'i_class' => 0, 'loc' => $empl['loc']);
                    $this->db->insert('geopos_invoices', $create_data);
                    $iid = $this->db->insert_id();

                    foreach ($order->line_items as $product_row) {
                        $data_p = array(
                            'tid' => $iid,
                            'pid' => $product_row->product_id,
                            'product' => $product_row->name,
                            'code' => $product_row->sku,
                            'qty' => $product_row->quantity,
                            'price' => $product_row->price,
                            'tax' => $product_row->total_tax,
                            'discount' => 0,
                            'subtotal' => $product_row->total,
                            'totaltax' => $product_row->total_tax,
                            'totaldiscount' => 0,
                            'product_des' => null,
                            'unit' => null,

                        );
                        $this->db->insert('geopos_invoice_items', $data_p);
                        $total_tax += $product_row->total_tax;
                        $itc += $product_row->quantity;
                    }
                    $status = 'due';
                    if ($order->date_paid) {
                        $status = 'paid';
                        $this->paynow($iid, $order->total, 'Via WooCommerce', 'Cash', $date_created);
                    }
                    $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'status' => $status, 'items' => $itc));
                    $this->db->where('id', $iid);
                    $this->db->update('geopos_invoices');

                }

                if (isset($order->date_created)) {
                    $this->db->set('other', $order->date_created);
                    $this->db->where('id', 57);
                    $this->db->update('univarsal_api');
                }
            }
            return array('status' => 'Success', 'message' => $message);
        } catch (\Exception $e) {
            return array('status' => 'Error', 'message' =>
                $e->getMessage());
        }
    }

    public function paynow($tid, $amount, $note, $pmethod, $date = '')
    {
        $this->db->select('geopos_accounts.id,geopos_accounts.holder,');
        $this->db->from('univarsal_api');
        $this->db->where('univarsal_api.id', 54);
        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id', 'left');

        $query = $this->db->get();
        $account = $query->row_array();

        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_customers.id AS cid');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.id', $tid);
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $query = $this->db->get();
        $invoice = $query->row_array();

        // print_r($invoice);


        $data = array(
            'acid' => $account['id'],
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $invoice['name'],
            'payerid' => $invoice['csd'],
            'method' => $pmethod,
            'date' => $date,
            'eid' => $invoice['eid'],
            'tid' => $tid,
            'note' => $note,
            'loc' => $invoice['loc']
        );
        $this->db->trans_start();
        $this->db->insert('geopos_transactions', $data);
        $this->db->insert_id();


        $totalrm = $invoice['total'] - $invoice['pamnt'];

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('id', $tid);
            $this->db->update('geopos_invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->update('geopos_accounts');

        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('id', $tid);
            $this->db->update('geopos_invoices');
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->update('geopos_accounts');

        }
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///  PRODUCTS
    ///
    //customer wop

    public function woocom_products()
    {
        $date_l = '2012-01-01T02:07:48';
        $message = '<br>';
        try {
            $woocommerce = $this->woo_connect();
			
            $this->db->select('other');
            $this->db->from('univarsal_api');
            $this->db->where('id', 56);
            $query = $this->db->get();
            $keys_c = $query->row_array();
            $last_run = $keys_c['other'];
            //$last_run = 0;
            if (!$last_run) $last_run = $date_l;

            $this->db->select('other');
            $this->db->from('univarsal_api');
            $this->db->where('id', 57);
            $query = $this->db->get();
            $settings = $query->row_array();
            $extra_config = json_decode($settings['other'], true);


            $products = $woocommerce->get('products', array('after' => $last_run, 'per_page' => 100, 'order' => 'asc', 'orderby' => 'id', 'status' => $extra_config['filter']));
            $this->db->select('id');
            $this->db->from('geopos_product_cat');
            $this->db->where('id', $extra_config['category']);
            $query = $this->db->get();
            $pc = $query->row_array();

            $this->db->select('id');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $extra_config['warehouse']);
            $query = $this->db->get();
            $wc = $query->row_array();

            if (!isset($pc['id']) or !isset($wc['id'])) {
                return array('status' => 'Error', 'message' =>
                    'Invalid Product Category Or Product warehouse! ');
            }

            if ($products) {
                $r = 0;
                foreach ($products as $product) {
                    if ($product->sku) {
                        $date_created = date('Y-m-d', strtotime($product->date_created));
                        $message .= $product->name . '<br>';
                        $id = $product->id;
                        $this->db->select('pid');
                        $this->db->from('geopos_products');
                        $this->db->where('pid', $id);
                        $query = $this->db->get();
                        $c_data = $query->row_array();
						$cid = 0;
						if($c_data != null){
							if ($c_data['pid']) {
								$cid = $c_data['pid'];
							}
						}
						
						
                        if ($cid > 0) {
                            $cid = $c_data['pid'];
                        } else {
                            $qtty = 0;
                            if ($product->manage_stock) $qtty = $product->stock_quantity;
                            if (!$qtty) $qtty = 1;
                            $barcode = rand(100, 999) . '' . rand(0, 9) . '' . rand(1000000, 9999999) . '' . rand(0, 9);

                            if ($extra_config['images'] == 'Yes') {
                                $imgurl = $product->images[0]->src;
                                $imagename = basename($imgurl);
                                if (!file_exists(FCPATH . 'userfiles/product/' . $imagename)) {
                                    $image = $this->woo_image_importer($imgurl);
                                    file_put_contents(FCPATH . 'userfiles/product/' . $imagename, $image);
                                    file_put_contents(FCPATH . 'userfiles/product/thumbnail/' . $imagename, $image);
                                }

                            } else {
                                $imagename = 'default.png';
                            }
							
							$temunit = 0;
							if($product->manage_stock == true){
								$temunit = 1;
							}
							
							$unity = 'UN';
							$typadd = 66;
							$p_claas = 6;
							/*if($product->type != 'simple'){
								$unity = 'SR';
								$typadd = 67;
								$p_claas = 8;
							}*/
							
							
							$short_description = str_replace("<p>", "", $product->short_description);
							$short_description = str_replace("</p>", "", $short_description);
							$short_description = str_replace("<strong>", "", $short_description);
							$short_description = str_replace("</strong>", "", $short_description);
							$short_description = str_replace("<h2>", "", $short_description);
							$short_description = str_replace("</h2>", "", $short_description);
							$short_description = str_replace("<h3>", "", $short_description);
							$short_description = str_replace("</h3>", "", $short_description);
							$short_description = str_replace("<div>", "", $short_description);
							$short_description = str_replace("</div>", "", $short_description);
							
							
							$short_description = substr($short_description, 0, 250);
                            $data = array(
                                'pid' => $product->id,
                                'pcat' => $extra_config['category'],
                                'warehouse' => $extra_config['warehouse'],
                                'product_name	' => $product->name,
                                'product_code' => $product->sku,
                                'product_price' => $product->price,
                                'fproduct_price' => $product->regular_price,
                                'taxrate' => 0.00,
                                'disrate' => $extra_config['discount'],
                                'qty' => $qtty,
                                'product_des' => $short_description,
                                'alert' => 1,
                                'unit' => $unity,
								'sub_id' => 0,
								'p_cla' => $p_claas,
								'b_id' => $typadd,
								'tem_stock' => $temunit,
                                'barcode' => $barcode,
                                'image' => $imagename
                            );
							
							if ($this->db->insert('geopos_products', $data)) {
								$id_auto_produ = $this->db->insert_id();
								if($product->tax_status == 'taxable'){
									$this->db->select('*');
									$this->db->from('geopos_config');
									$this->db->where('id', $extra_config['tax']);
									$query = $this->db->get();
									$tax = $query->row_array();
									
									$valtax = (numberClean($product->price)*(numberClean($tax['val2'])/100));
									$datatax = array(
										'p_id' => $product->id,
										't_id' => $tax['id'],
										't_name' => $tax['val1'],
										't_val	' => $valtax,
										't_como' => 0,
										't_cod' => $tax['taxcode'],
										't_per' => $tax['val2']
									);
									
									$this->db->insert('geopos_products_taxs', $datatax);
								}
							}
                        }

                        $r++;
                    }
                }
                if($r > 0)
                {
                    $last = $r - 1;
                    $message .= $product->name . '---last date is ' . end($products)->date_created;
                    $this->db->set('other', $products[$last]->date_created);
                    $this->db->where('id', 56);

                    $this->db->update('univarsal_api');
                }else{
                    $message = "No Product to import!";
                }
                


            } else {
                $message .= ' All products are imported!';
            }

            return array('status' => 'Success', 'message' => $message);
        } catch (\Exception $e) {
            return array('status' => 'Error', 'message' =>
                $e->getMessage());
        }
    }

    public function woocom_products_syn()
    {
        $message = '';
        $date_l = '2012-01-01T02:07:48';


        try {

            $woocommerce = $this->woo_connect();


            $this->db->select('other');
            $this->db->from('univarsal_api');
            $this->db->where('id', 56);
            $query = $this->db->get();
            $keys_c = $query->row_array();
            $last_run = $keys_c['other'];

            $this->db->select('other');
            $this->db->from('univarsal_api');
            $this->db->where('id', 57);
            $query = $this->db->get();
            $settings = $query->row_array();
            $extra_config = json_decode($settings['other'], true);
            if (!$last_run) $last_run = $date_l;
            $products = $woocommerce->get('products', array('per_page' => 100, 'order' => 'asc', 'orderby' => 'id', 'status' => $extra_config['filter']));


            $lastResponse = $woocommerce->http->getResponse();
            $headers = $lastResponse->getHeaders();
            $totalPages = $headers['X-WP-TotalPages'];
            $totalProducts = $headers['X-WP-Total'];

            $message .= 'Total Products ' . $totalProducts . ' <br>';

            $message .= 'Total Pages ' . $totalPages . ' <br>';;

            for ($z = 1; $z <= $totalPages; $z++) {
                $products_s = $woocommerce->get('products', array('page' => $z, 'per_page' => 100, 'order' => 'asc', 'orderby' => 'id', 'status' => $extra_config['filter']));
                $message .= 'Page--- ' . $z . '---<br>';


                if ($products_s) {

                    $r = 0;
                    foreach ($products_s as $product) {

                        $date_created = date('Y-m-d', strtotime($product->date_created));
                        $message .= $r . '#' . $product->name . '<br>';
                        $sku = $product->sku;

                        $qtty = 0;
                        if ($product->manage_stock) $qtty = $product->stock_quantity;
                        if (!$qtty) $qtty = 1;

                        $data = array(
                            'product_name	' => $product->name,
                            'product_code' => $product->sku,
                            'product_price' => $product->price,
                            'fproduct_price' => $product->regular_price,
                            'qty' => $qtty,
                            'product_des' => strip_tags($product->short_description)
                        );
                        $this->db->set($data);
                        $this->db->where('product_code', $sku);
                        $this->db->update('geopos_products');
                        $r++;
                    }


                }


            }
            return array('status' => 'Success', 'message' =>
                $message);
        } catch (\Exception $e) {
            return array('status' => 'Error', 'message' =>
                $e->getMessage());
        }
    }

}