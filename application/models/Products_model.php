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



defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CI_Model
{
    var $table = 'geopos_products';
    var $column_order = array(null, 'geopos_products.product_name', 'geopos_products.qty', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_products.product_price', null); //set column field database for datatable orderable
    var $column_search = array('geopos_products.product_name', 'geopos_products.product_code', 'geopos_product_cat.title', 'geopos_warehouse.title'); //set column field database for datatable searchable
    var $order = array('geopos_products.pid' => 'desc'); // default order
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id = '', $w = '', $sub = '', $forn = '')
    {
		$this->db->select('geopos_products.*,geopos_product_cat.title AS c_title,geopos_warehouse.title');
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
		$this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');
		if ($forn) {
			$this->db->join('geopos_products_suppliers', 'geopos_products_suppliers.p_id = geopos_products.pid');
			if ($this->aauth->get_user()->loc) {
				$this->db->group_start();
				$this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
				if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
				$this->db->group_end();
			} elseif (!BDATA) {
				$this->db->where('geopos_warehouse.loc', 0);
			}
			$this->db->where('geopos_products_suppliers.t_id', $forn);
		}else if ($sub) {
            if ($this->input->post('group') != 'yes') 
				$this->db->where('geopos_products.merge', 0);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) 
					$this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }
            $this->db->where("geopos_product_cat.rel_id=$sub");
        } else {
            if ($w) {
                if ($w > 0) {
                    $this->db->where("geopos_warehouse.id = $w");
                    // $this->db->where('geopos_products.sub_id', 0);
                }
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) 
						$this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
            } else {
                if ($this->input->post('group') != 'yes') 
					$this->db->where('geopos_products.merge', 0);
                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                    if (BDATA) 
						$this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }
				
                if ($id > 0) {
                    $this->db->where("geopos_products.pcat = $id");
                    $this->db->where('geopos_product_cat.c_type', 0);
                }
            }
        }
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }
				
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function get_datatables($id = '', $w = '', $sub = '', $forn = '')
    {
        if ($forn > 0) {
            $this->_get_datatables_query('', '', '', $forn);
        }else if ($id > 0) {
            $this->_get_datatables_query($id, $w, '', '');
        }else if ($sub > 0) {
            $this->_get_datatables_query($id, $w, $sub, '');
        } else {
            $this->_get_datatables_query();
        }

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();

        return $query->result();

    }



    function count_filtered($id, $w = '', $sub = '', $forn = '')
    {
        if ($forn > 0) {
            $this->_get_datatables_query('', '', '', $forn);
        }else if ($id > 0) {
            $this->_get_datatables_query($id, $w, '', '');
        }else if ($sub > 0) {
            $this->_get_datatables_query($id, $w, $sub, '');
        } else {
            $this->_get_datatables_query();
        }

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->num_rows();
    }



    public function count_all($id, $w = '', $sub = '', $forn = '')
    {
		if ($forn > 0) {
            $this->_get_datatables_query('', '', '', $forn);
        }else if ($id > 0) {
            $this->_get_datatables_query($id, $w, '', '');
        }else if ($sub > 0) {
            $this->_get_datatables_query($id, $w, $sub, '');
        } else {
            $this->_get_datatables_query();
        }
        return $this->db->count_all_results();
    }


	public function irs_produts($id)
    {
		$this->db->select("*, geopos_config.val1 as withhold");
        $this->db->from('geopos_products_taxs');
		$this->db->join('geopos_config', 'geopos_config.id = geopos_products_taxs.t_como', 'left');
        $this->db->where('geopos_products_taxs.p_id', $id);
        $query = $this->db->get();
		return $query->result_array();
    }
	
	
	public function suppliers_produts($id)
    {
		$this->db->select("*");
        $this->db->from('geopos_products_suppliers');
        $this->db->where('geopos_products_suppliers.p_id', $id);
        $query = $this->db->get();
		return $query->result_array();
    }

	public function getlastref()
	{
		$query = $this->db->query("select case when geopos_products.pid IS NULL THEN '0000000001' ELSE geopos_products.product_code END as product_code
		from geopos_products
		inner join (select max(pid) as maxref from geopos_products) as pp on geopos_products.pid = pp.maxref");
        return $query->row_array();
	}

    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type = '', $w_stock = '', $w_alert = '', $sub_cat = '', $b_id = '', $serial = '', $pclas, $taxlist, $supplielist,$tem_stock, $fav_pos, $coust_unit)
    {
        $ware_valid = $this->valid_warehouse($warehouse);
        if (!$sub_cat) 
			$sub_cat = 0;
        if (!$b_id) 
			$b_id = 0;
        $datetime1 = new DateTime(date('Y-m-d'));
        $datetime2 = new DateTime($wdate);
        $difference = $datetime1->diff($datetime2);
        if (!$difference->d > 0) {

            $wdate = null;
        }
		
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => $code_type,
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
						'tem_stock' => $tem_stock,
						'fav_pos' => $fav_pos,
						'coust_unit' => $coust_unit,
						'p_cla' => $pclas
                    );
                } else {
                    $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
                    $data = array(
                        'pcat' => $catid,
                        'warehouse' => $warehouse,
                        'product_name' => $product_name,
                        'product_code' => $product_code,
                        'product_price' => $product_price,
                        'fproduct_price' => $factoryprice,
                        'taxrate' => $taxrate,
                        'disrate' => $disrate,
                        'qty' => $product_qty,
                        'product_des' => $product_desc,
                        'alert' => $product_qty_alert,
                        'unit' => $unit,
                        'image' => $image,
                        'barcode' => $barcode,
                        'expiry' => $wdate,
                        'code_type' => 'EAN13',
                        'sub_id' => $sub_cat,
                        'b_id' => $b_id,
						'tem_stock' => $tem_stock,
						'fav_pos' => $fav_pos,
						'coust_unit' => $coust_unit,
						'p_cla' => $pclas
                    );
                }

                $this->db->trans_start();

                if ($this->db->insert('geopos_products', $data)) {
					$pid = $this->db->insert_id();
                    $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('ADDED') . "<a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
                }
				
				$datatax = array();
				$prodstax = 0;
				foreach ($taxlist as $obj) {
					$row = array();
					$row['p_id'] = $pid;
					$row['t_id'] = $taxlist[$prodstax]['t_id'];
					$row['t_name'] = $taxlist[$prodstax]['t_name'];
					$row['t_val'] = $taxlist[$prodstax]['t_val'];
					$row['t_como'] = $taxlist[$prodstax]['t_como'];
					$row['t_cod'] = $taxlist[$prodstax]['t_cod'];
					$row['t_per'] = $taxlist[$prodstax]['t_per'];
					$datatax[] = $row;
					$prodstax++;
				}
				
				$datasuppl = array();
				$prodsupp = 0;
				foreach ($supplielist as $prd) {
					$row = array();
					$row['p_id'] = $pid;
					$row['t_id'] = $supplielist[$prodsupp]['t_id'];
					$row['supli_n'] = $supplielist[$prodsupp]['supli_n'];
					$row['supli_ref'] = $supplielist[$prodsupp]['supli_ref'];
					$row['supli_pr_c'] = $supplielist[$prodsupp]['supli_pr_c'];
					$row['supli_des_c'] = $supplielist[$prodsupp]['supli_des_c'];
					$row['supli_des_g'] = $supplielist[$prodsupp]['supli_des_g'];
					$row['supli_pr_c_d'] = $supplielist[$prodsupp]['supli_pr_c_d'];
					$row['supli_marg_e'] = $supplielist[$prodsupp]['supli_marg_e'];
					$row['supli_marg_p'] = $supplielist[$prodsupp]['supli_marg_p'];
					$datasuppl[] = $row;
					$prodsupp++;
				}
				
				if(count($datasuppl) > 0)
				{
					$this->db->insert_batch('geopos_products_suppliers', $datasuppl);
				}
				
				if(count($datatax) > 0)
				{
					$this->db->insert_batch('geopos_products_taxs', $datatax);
				}
					
                if ($serial) {
                    $serial_group = array();
                    foreach ($serial as $key => $value) {
                         if($value) $serial_group[] = array('product_id' => $pid, 'serial' => $value);
                    }
                    $this->db->insert_batch('geopos_product_serials', $serial_group);
                }

                if ($v_type) {
                    foreach ($v_type as $key => $value) {
                        if ($v_type[$key] && numberClean($v_stock[$key]) > 0.00) {
                            $this->db->select('u.id,u.name,u2.name AS variation');
                            $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                            $this->db->where('u.id', $v_type[$key]);
                            $query = $this->db->get('geopos_units u');
                            $r_n = $query->row_array();
                            $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                            $data['qty'] = numberClean($v_stock[$key]);
                            $data['alert'] = numberClean($v_alert[$key]);
                            $data['merge'] = 1;
                            $data['sub'] = $pid;
                            $data['vb'] = $v_type[$key];
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                            $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }

                if ($w_type) {
                    foreach ($w_type as $key => $value) {
                        if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                            $data['product_name'] = $product_name;
                            $data['warehouse'] = $w_type[$key];
                            $data['qty'] = numberClean($w_stock[$key]);
                            $data['alert'] = numberClean($w_alert[$key]);
                            $data['merge'] = 2;
                            $data['sub'] = $pid;
                            $data['vb'] = $w_type[$key];
                            $this->db->insert('geopos_products', $data);
                            $pidv = $this->db->insert_id();
                            $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                            $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                        }
                    }
                }
                $this->db->trans_complete();
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            if (strlen($barcode) > 5 AND is_numeric($barcode)) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
					'tem_stock' => $tem_stock,
					'fav_pos' => $fav_pos,
					'coust_unit' => $coust_unit,
					'p_cla' => $pclas
                );
            } else {
                $barcode = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'expiry' => $wdate,
                    'code_type' => 'EAN13',
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
					'tem_stock' => $tem_stock,
					'fav_pos' => $fav_pos,
					'coust_unit' => $coust_unit,
					'p_cla' => $pclas
                );
            }

            $this->db->trans_start();

            if ($this->db->insert('geopos_products', $data)) {
                $pid = $this->db->insert_id();
				$this->custom->save_fields_data($pid, 5);
                $this->movers(1, $pid, $product_qty, 0, 'Stock Initialized');
                $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('ADDED') . "<a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
			
			$datatax = array();
			$prodstax = 0;
			foreach ($taxlist as $obj) {
				$row = array();
				$row['p_id'] = $pid;
				$row['t_id'] = $taxlist[$prodstax]['t_id'];
				$row['t_name'] = $taxlist[$prodstax]['t_name'];
				$row['t_val'] = $taxlist[$prodstax]['t_val'];
				$row['t_como'] = $taxlist[$prodstax]['t_como'];
				$row['t_cod'] = $taxlist[$prodstax]['t_cod'];
				$row['t_per'] = $taxlist[$prodstax]['t_per'];
				$datatax[] = $row;
				$prodstax++;
			}
			
			$datasuppl = array();
			$prodsupp = 0;
			foreach ($supplielist as $prd) {
				$row = array();
				$row['p_id'] = $pid;
				$row['t_id'] = $supplielist[$prodsupp]['t_id'];
				$row['supli_n'] = $supplielist[$prodsupp]['supli_n'];
				$row['supli_ref'] = $supplielist[$prodsupp]['supli_ref'];
				$row['supli_pr_c'] = $supplielist[$prodsupp]['supli_pr_c'];
				$row['supli_des_c'] = $supplielist[$prodsupp]['supli_des_c'];
				$row['supli_des_g'] = $supplielist[$prodsupp]['supli_des_g'];
				$row['supli_pr_c_d'] = $supplielist[$prodsupp]['supli_pr_c_d'];
				$row['supli_marg_e'] = $supplielist[$prodsupp]['supli_marg_e'];
				$row['supli_marg_p'] = $supplielist[$prodsupp]['supli_marg_p'];
				$datasuppl[] = $row;
				$prodsupp++;
			}
			
			if(count($datasuppl) > 0)
			{
				$this->db->insert_batch('geopos_products_suppliers', $datasuppl);
			}
			
			if(count($datatax) > 0)
			{
				$this->db->insert_batch('geopos_products_taxs', $datatax);
			}

            if ($serial) {
                $serial_group = array();
                foreach ($serial as $key => $value) {
                     if($value)  $serial_group[] = array('product_id' => $pid, 'serial' => $value);
                }
                $this->db->insert_batch('geopos_product_serials', $serial_group);
            }
			
            if ($v_type) {
                foreach ($v_type as $key => $value) {
                    if ($v_type[$key] && numberClean($v_stock[$key]) > 0.00) {
                        $this->db->select('u.id,u.name,u2.name AS variation');
                        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                        $this->db->where('u.id', $v_type[$key]);
                        $query = $this->db->get('geopos_units u');
                        $r_n = $query->row_array();
                        $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                        $data['qty'] = numberClean($v_stock[$key]);
                        $data['alert'] = numberClean($v_alert[$key]);
                        $data['merge'] = 1;
                        $data['sub'] = $pid;
                        $data['vb'] = $v_type[$key];
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }

            if ($w_type) {
                foreach ($w_type as $key => $value) {
                    if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                        $data['product_name'] = $product_name;
                        $data['warehouse'] = $w_type[$key];
                        $data['qty'] = numberClean($w_stock[$key]);
                        $data['alert'] = numberClean($w_alert[$key]);
                        $data['merge'] = 2;
                        $data['sub'] = $pid;
                        $data['vb'] = $w_type[$key];
                        $this->db->insert('geopos_products', $data);
                        $pidv = $this->db->insert_id();
                        $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                        $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    }
                }
            }
            $this->custom->save_fields_data($pid, 5);
            $this->db->trans_complete();
        }
    }



    public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $code_type, $sub_cat = '', $b_id = '', $vari = null, $serial = null, $pclas, $taxlist, $supplielist, $tem_stock, $fav_pos)
    {
        $this->db->select('qty');
        $this->db->from('geopos_products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $r_n = $query->row_array();
        $ware_valid = $this->valid_warehouse($warehouse);
        $this->db->trans_start();
        if ($this->aauth->get_user()->loc) {
            if ($ware_valid['loc'] == $this->aauth->get_user()->loc OR $ware_valid['loc'] == '0' OR $warehouse == 0) {
                $data = array(
                    'pcat' => $catid,
                    'warehouse' => $warehouse,
                    'product_name' => $product_name,
                    'product_code' => $product_code,
                    'product_price' => $product_price,
                    'fproduct_price' => $factoryprice,
                    'taxrate' => $taxrate,
                    'disrate' => $disrate,
                    'qty' => $product_qty,
                    'product_des' => $product_desc,
                    'alert' => $product_qty_alert,
                    'unit' => $unit,
                    'image' => $image,
                    'barcode' => $barcode,
                    'code_type' => $code_type,
                    'sub_id' => $sub_cat,
                    'b_id' => $b_id,
					'tem_stock' => $tem_stock,
					'fav_pos' => $fav_pos,
					'p_cla' => $pclas
                );
                $this->db->set($data);
                $this->db->where('pid', $pid);
                if ($this->db->update('geopos_products')) {
					$this->custom->edit_save_fields_data($pid, 5);
                    if ($r_n['qty'] != $product_qty) {
                        $m_product_qty = $product_qty - $r_n['qty'];
                        $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                    }
                    $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $this->lang->line('ERROR')));
                }
            } else {

                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }
        } else {

            $data = array(
                'pcat' => $catid,
                'warehouse' => $warehouse,
                'product_name' => $product_name,
                'product_code' => $product_code,
                'product_price' => $product_price,
                'fproduct_price' => $factoryprice,
                'taxrate' => $taxrate,
                'disrate' => $disrate,
                'qty' => $product_qty,
                'product_des' => $product_desc,
                'alert' => $product_qty_alert,
                'unit' => $unit,
                'image' => $image,
                'barcode' => $barcode,
                'code_type' => $code_type,
                'sub_id' => $sub_cat,
                'b_id' => $b_id,
				'tem_stock' => $tem_stock,
				'fav_pos' => $fav_pos,
				'p_cla' => $pclas
            );
            $this->db->set($data);
            $this->db->where('pid', $pid);
            if ($this->db->update('geopos_products')) {
				$this->custom->edit_save_fields_data($pid, 5);
                if ($r_n['qty'] != $product_qty) {
                    $m_product_qty = $product_qty - $r_n['qty'];
                    $this->movers(1, $pid, $m_product_qty, 0, 'Stock Changes');
                }
                $this->aauth->applog("[Update Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='" . base_url('products/edit?id=' . $pid) . "' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a> <a href='" . base_url('products') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));

            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
		
		$this->db->delete('geopos_products_suppliers', array('p_id' => $pid));
		$this->db->delete('geopos_products_taxs', array('p_id' => $pid));
		$datatax = array();
		$prodstax = 0;
		foreach ($taxlist as $obj) {
			$row = array();
			$row['p_id'] = $pid;
			$row['t_id'] = $taxlist[$prodstax]['t_id'];
			$row['t_name'] = $taxlist[$prodstax]['t_name'];
			$row['t_val'] = $taxlist[$prodstax]['t_val'];
			$row['t_como'] = $taxlist[$prodstax]['t_como'];
			$row['t_cod'] = $taxlist[$prodstax]['t_cod'];
			$row['t_per'] = $taxlist[$prodstax]['t_per'];
			$datatax[] = $row;
			$prodstax++;
		}
		
		$datasuppl = array();
		$prodsupp = 0;
		foreach ($supplielist as $prd) {
			$row = array();
			$row['p_id'] = $pid;
			$row['t_id'] = $supplielist[$prodsupp]['t_id'];
			$row['supli_n'] = $supplielist[$prodsupp]['supli_n'];
			$row['supli_ref'] = $supplielist[$prodsupp]['supli_ref'];
			$row['supli_pr_c'] = $supplielist[$prodsupp]['supli_pr_c'];
			$row['supli_des_c'] = $supplielist[$prodsupp]['supli_des_c'];
			$row['supli_des_g'] = $supplielist[$prodsupp]['supli_des_g'];
			$row['supli_pr_c_d'] = $supplielist[$prodsupp]['supli_pr_c_d'];
			$row['supli_marg_e'] = $supplielist[$prodsupp]['supli_marg_e'];
			$row['supli_marg_p'] = $supplielist[$prodsupp]['supli_marg_p'];
			$datasuppl[] = $row;
			$prodsupp++;
		}
		
		if(count($datasuppl) > 0)
		{
			$this->db->insert_batch('geopos_products_suppliers', $datasuppl);
		}
		if(count($datatax) > 0)
		{
			$this->db->insert_batch('geopos_products_taxs', $datatax);
		}
        if (isset($serial['old'])) {
            $serial_group = array();
            foreach ($serial['old'] as $key => $value) {
                if($value) 
					$serial_group[] = array('product_id' => $pid, 'serial' => $value);
            }
            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }

        if (isset($serial['new'])) {
            $serial_group = array();
            foreach ($serial['new'] as $key => $value) {
                 if($value)  $serial_group[] = array('product_id' => $pid, 'serial' => $value,'status'=>0);
            }
            $this->db->insert_batch('geopos_product_serials', $serial_group);
        }
        $this->custom->edit_save_fields_data($pid, 5);
        $v_type = @$vari['v_type'];
        $v_stock = @$vari['v_stock'];
        $v_alert = @$vari['v_alert'];
        $w_type = @$vari['w_type'];
        $w_stock = @$vari['w_stock'];
        $w_alert = @$vari['w_alert'];
        if (isset($v_type)) {
            foreach ($v_type as $key => $value) {
                if ($v_type[$key] && numberClean($v_stock[$key]) > 0.00) {
                    $this->db->select('u.id,u.name,u2.name AS variation');
                    $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');
                    $this->db->where('u.id', $v_type[$key]);
                    $query = $this->db->get('geopos_units u');
                    $r_n = $query->row_array();
                    $data['product_name'] = $product_name . '-' . $r_n['variation'] . '-' . $r_n['name'];
                    $data['qty'] = numberClean($v_stock[$key]);
                    $data['alert'] = numberClean($v_alert[$key]);
                    $data['merge'] = 1;
                    $data['sub'] = $pid;
                    $data['vb'] = $v_type[$key];
                    $this->db->insert('geopos_products', $data);
                    $pidv = $this->db->insert_id();
                    $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        if (isset($w_type)) {
            foreach ($w_type as $key => $value) {
                if ($w_type[$key] && numberClean($w_stock[$key]) > 0.00 && $w_type[$key] != $warehouse) {
                    $data['product_name'] = $product_name;
                    $data['warehouse'] = $w_type[$key];
                    $data['qty'] = numberClean($w_stock[$key]);
                    $data['alert'] = numberClean($w_alert[$key]);
                    $data['merge'] = 2;
                    $data['sub'] = $pid;
                    $data['vb'] = $w_type[$key];
                    $this->db->insert('geopos_products', $data);
                    $pidv = $this->db->insert_id();
                    $this->movers(1, $pidv, $data['qty'], 0, 'Stock Initialized');
                    $this->aauth->applog("[New Product] -$product_name  -Qty-$product_qty ID " . $pid, $this->aauth->get_user()->username);
                }
            }
        }
        $this->db->trans_complete();
    }



    public function prd_stats()
    {
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
            if (BDATA) $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;
        } elseif (!BDATA) {
            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0';
        }
        $query = $this->db->query("SELECT
		COUNT(IF( geopos_products.qty > 0, geopos_products.qty, NULL)) AS instock,
		COUNT(IF( geopos_products.qty <= 0, geopos_products.qty, NULL)) AS outofstock,
		COUNT(geopos_products.qty) AS total
		FROM geopos_products $whr");
        echo json_encode($query->result_array());
    }

    public function products_list($id, $term = '')

    {

        $this->db->select('geopos_products.*');

        $this->db->from('geopos_products');

        $this->db->where('geopos_products.warehouse', $id);

        if ($this->aauth->get_user()->loc) {

            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

        } elseif (!BDATA) {

            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

            $this->db->where('geopos_warehouse.loc', 0);

        }

        if ($term) {

            $this->db->where("geopos_products.product_name LIKE '%$term%'");

            $this->db->or_where("geopos_products.product_code LIKE '$term%'");

        }

        $query = $this->db->get();

        return $query->result_array();



    }





    public function units()

    {

        $this->db->select('*');

        $this->db->from('geopos_units');

        $this->db->where('type', 0);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function serials($pid)

    {

        $this->db->select('*');

        $this->db->from('geopos_product_serials');

        $this->db->where('product_id', $pid);



        $query = $this->db->get();

        return $query->result_array();





    }



    public function transfer($from_warehouse, $products_l, $to_warehouse, $qty)

    {

        $updateArray = array();

        $move = false;

        $qtyArray = explode(',', $qty);

        $this->db->select('title');

        $this->db->from('geopos_warehouse');

        $this->db->where('id', $to_warehouse);

        $query = $this->db->get();

        $to_warehouse_name = $query->row_array()['title'];



        $i = 0;

        foreach ($products_l as $row) {

            $qty = 0;

            if (array_key_exists($i, $qtyArray)) $qty = $qtyArray[$i];



            $this->db->select('*');

            $this->db->from('geopos_products');

            $this->db->where('pid', $row);

            $query = $this->db->get();

            $pr = $query->row_array();

            $pr2 = $pr;

            $c_qty = $pr['qty'];

            if ($c_qty - $qty < 0) {



            } elseif ($c_qty - $qty == 0) {





                if ($pr['merge'] == 2) {



                    $this->db->select('pid,product_name');

                    $this->db->from('geopos_products');

                    $this->db->where('pid', $pr['sub']);

                    $this->db->where('warehouse', $to_warehouse);

                    $query = $this->db->get();

                    $pr = $query->row_array();



                } else {

                    $this->db->select('pid,product_name');

                    $this->db->from('geopos_products');

                    $this->db->where('merge', 2);

                    $this->db->where('sub', $row);

                    $this->db->where('warehouse', $to_warehouse);

                    $query = $this->db->get();

                    $pr = $query->row_array();

                }





                $c_pid = $pr['pid'];

                $product_name = $pr['product_name'];



                if ($c_pid) {



                    $this->db->set('qty', "qty+$qty", FALSE);

                    $this->db->where('pid', $c_pid);

                    $this->db->update('geopos_products');

                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty ID " . $c_pid, $this->aauth->get_user()->username);

                    $this->db->delete('geopos_products', array('pid' => $row));

                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));



                } else {

                    $updateArray[] = array(

                        'pid' => $row,

                        'warehouse' => $to_warehouse

                    );

                    $move = true;

                    $product_name = $pr2['product_name'];

                    $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $row));



                    $this->movers(1, $row, $qty, 0, 'Stock Transferred & Initialized W- ' . $to_warehouse_name);

                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty W- $to_warehouse_name PID " . $pr2['pid'], $this->aauth->get_user()->username);

                }





            } else {

                $data['product_name'] = $pr['product_name'];

                $data['pcat'] = $pr['pcat'];

                $data['warehouse'] = $to_warehouse;

                $data['product_name'] = $pr['product_name'];

                $data['product_code'] = $pr['product_code'];

                $data['product_price'] = $pr['product_price'];

                $data['fproduct_price'] = $pr['fproduct_price'];

                $data['taxrate'] = $pr['taxrate'];

                $data['disrate'] = $pr['disrate'];

                $data['qty'] = $qty;

                $data['product_des'] = $pr['product_des'];

                $data['alert'] = $pr['alert'];

                $data['	unit'] = $pr['unit'];

                $data['image'] = $pr['image'];

                $data['barcode'] = $pr['barcode'];

                $data['merge'] = 2;

                $data['sub'] = $row;

                $data['vb'] = $to_warehouse;

                if ($pr['merge'] == 2) {

                    $this->db->select('pid,product_name');

                    $this->db->from('geopos_products');

                    $this->db->where('pid', $pr['sub']);

                    $this->db->where('warehouse', $to_warehouse);

                    $query = $this->db->get();

                    $pr = $query->row_array();

                } else {

                    $this->db->select('pid,product_name');

                    $this->db->from('geopos_products');

                    $this->db->where('merge', 2);

                    $this->db->where('sub', $row);

                    $this->db->where('warehouse', $to_warehouse);

                    $query = $this->db->get();

                    $pr = $query->row_array();

                }





                $c_pid = $pr['pid'];

                $product_name = $pr2['product_name'];



                if ($c_pid) {



                    $this->db->set('qty', "qty+$qty", FALSE);

                    $this->db->where('pid', $c_pid);

                    $this->db->update('geopos_products');



                    $this->movers(1, $c_pid, $qty, 0, 'Stock Transferred W ' . $to_warehouse_name);

                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty W $to_warehouse_name  ID " . $c_pid, $this->aauth->get_user()->username);





                } else {

                    $this->db->insert('geopos_products', $data);

                    $pid = $this->db->insert_id();

                    $this->movers(1, $pid, $qty, 0, 'Stock Transferred & Initialized W ' . $to_warehouse_name);

                    $this->aauth->applog("[Product Transfer] -$product_name  -Qty-$qty  W $to_warehouse_name ID " . $pr2['pid'], $this->aauth->get_user()->username);



                }



                $this->db->set('qty', "qty-$qty", FALSE);

                $this->db->where('pid', $row);

                $this->db->update('geopos_products');

                $this->movers(1, $row, -$qty, 0, 'Stock Transferred WID ' . $to_warehouse_name);

            }





            $i++;

        }



        if ($move) {

            $this->db->update_batch('geopos_products', $updateArray, 'pid');

        }



        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('UPDATED')));





    }



    public function meta_delete($name)

    {

        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {

            return true;

        }

    }



    public function valid_warehouse($warehouse)

    {

        $this->db->select('id,loc');

        $this->db->from('geopos_warehouse');

        $this->db->where('id', $warehouse);

        $query = $this->db->get();

        $row = $query->row_array();

        return $row;

    }





    public function movers($type = 0, $rid1 = 0, $rid2 = 0, $rid3 = 0, $note = '')

    {

        $data = array(

            'd_type' => $type,

            'rid1' => $rid1,

            'rid2' => $rid2,

            'rid3' => $rid3,

            'note' => $note

        );

        $this->db->insert('geopos_movers', $data);

    }

	

	

	

	//Classes

	var $classcolumn_order = array(null, 'title');

    var $classcolumn_search = array('id', 'title');

    private function _class_datatables_query()

    {

        $this->db->from('geopos_products_class');

        $i = 0;



        foreach ($this->classcolumn_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->classcolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function class_datatables()
    {
        $this->_class_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function class_count_filtered()
    {
        $this->_class_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function class_count_all()
    {
        $this->_class_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }


    function addclassesmod($title)
    {
        $data = array('title' => $title);
        return $this->db->insert('geopos_products_class', $data);
    }

    public function class_v($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_products_class');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

	public function editclass($id, $title)
    {
        $data = array(
            'title' => $title
        );
        $data = array('title' => $title);
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_products_class')) {
            return true;
        } else {
            return false;
        }
    }



    function deleteclass($id)
    {
        return $this->db->delete('geopos_products_class', array('id' => $id));
    }
	
	
	public function proclassesprodutos()
    {
		$name = $this->input->post('name_startsWith');
        $this->db->select('*');
        $this->db->from('geopos_product_cat_type');
		if ($name) {
			$this->db->where('UPPER(geopos_product_cat_type.title) LIKE', '%'.strtoupper($name).'%');
		}
        $query = $this->db->get();
        return $query->result_array();
    }

	public function proclasses()
    {
		$name = $this->input->post('name_startsWith');
        $this->db->select('*');
        $this->db->from('geopos_products_class');
		if ($name) {
			$this->db->where('UPPER(geopos_products_class.title) LIKE', '%'.strtoupper($name).'%');
		}
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getProductDataByTid($tid = null){

        $tid_data = "this is the tid".$tid;
        return $tid_data;
    }
}