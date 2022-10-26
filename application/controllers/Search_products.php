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

class Search_products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('search_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit($this->lang->line('translate19'));
        }
    }
	
//search product in invoice
	public function searchtax()
    {
		$pid = $this->input->post('pid', true);
		$query = $this->db->query("SELECT geopos_products_taxs.* FROM geopos_products_taxs WHERE geopos_products_taxs.p_id = '$pid'");
		$out = array();
		$result = array();
		$result = $query->result_array();
		foreach ($result as $row) {
			$name = array($row['t_id'], $row['t_name'], $row['t_val'], $row['t_como'], $row['t_cod'], $row['t_per']);
			array_push($out, $name);
		}
		echo json_encode($out);
	}
	
    public function search()
    {
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $join2 = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid';
            $qw .= '(geopos_product_serials.status=0) AND ';
        }

        if ($name) {
            if ($billing_settings['key1'] == 2) {
                $e .= ',geopos_product_serials.serial';
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ $e  FROM geopos_product_serials LEFT JOIN geopos_products ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "(UPPER(geopos_product_serials.serial) LIKE '" . strtoupper($name) . "%')  LIMIT 6");
            } else {
                $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ $e  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%') LIMIT 6");
            }

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'], amountFormat_general($row['qty']), $row['verif_typ'], @$row['serial']);
                array_push($out, $name);
            }
            echo json_encode($out);
        }

    }

    public function puchase_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "(geopos_products.warehouse='$wid' ) AND ";
        }
        $join = '';
        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_products.pid,
			geopos_products.product_name,geopos_products.product_code,geopos_products.fproduct_price,geopos_products.taxrate,geopos_products.disrate,geopos_products.product_des,geopos_products.unit,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ FROM geopos_products $join WHERE " . $qw . "UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();
            foreach ($result as $row) {
                $name = array($row['product_name'], amountExchange_s($row['fproduct_price'], 0, $this->aauth->get_user()->loc), $row['pid'], amountFormat_general($row['taxrate']), amountFormat_general($row['disrate']), $row['product_des'], $row['unit'], $row['product_code'], $row_num);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }
	
	public function csearchguide()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) 
				$whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
		
		$whr = $whr. 'id <>  99999999 AND';
        if ($name) {
            $query = $this->db->query("SELECT geopos_customers.*,CONCAT('(', geopos_customers.company, ') - ', geopos_customers.name) AS namecompany FROM geopos_customers inner join geopos_countrys on geopos_customers.country = geopos_countrys.prefix WHERE id = 99999999 UNION SELECT geopos_customers.*,CONCAT('(', geopos_customers.company, ') - ', geopos_customers.name) AS namecompany FROM geopos_customers inner join geopos_countrys on geopos_customers.country = geopos_countrys.prefix WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomerGuide('" . $row['id'] . "','" . $row['postbox'] . "','" . $row['country']. "','" . $row['company']. "','" . $row['namecompany']. "','" . $row['name']. " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . amountFormat_general($row['discount_c']) . "','" . $row['taxid'] ."')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function csearch()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (geopos_customers.loc=' . $this->aauth->get_user()->loc . ' OR geopos_customers.loc=0) AND ';
            if (!BDATA) $whr = ' (geopos_customers.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (geopos_customers.loc=0) AND ';
        }
		$whr .= 'geopos_customers.id <>  99999999 AND';
		$whr .= ' geopos_customers.inactive = 0 AND';
        if ($name) {
			$querybusca = "SELECT geopos_countrys.name contry_name, geopos_customers.id,geopos_customers.name,geopos_customers.address,geopos_customers.city,geopos_customers.phone,geopos_customers.email,geopos_customers.discount_c,geopos_customers.taxid,geopos_customers.postbox FROM geopos_customers inner join geopos_countrys on geopos_customers.country = geopos_countrys.prefix WHERE geopos_customers.id = 99999999 UNION SELECT geopos_countrys.name contry_name, geopos_customers.id,geopos_customers.name,geopos_customers.address,geopos_customers.city,geopos_customers.phone,geopos_customers.email,geopos_customers.discount_c,geopos_customers.taxid,geopos_customers.postbox FROM geopos_customers inner join geopos_countrys on geopos_customers.country = geopos_countrys.prefix WHERE $whr (UPPER(geopos_customers.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_customers.phone) LIKE '" . strtoupper($name) . "%') LIMIT 6";
			$query = $this->db->query($querybusca);
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['contry_name'] . "','" . $row['postbox'] . "','". $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . amountFormat_general($row['discount_c']) . "','" . $row['taxid'] ."')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function party_search()
    {
        $result = array();
        $out = array();
        $tbl = 'geopos_customers';
        $name = $this->input->get('keyword', true);
        $ty = $this->input->get('ty', true);
		$query = "";
        $whr = '';
		
		if ($ty){
			if ($this->aauth->get_user()->loc) {
				$whr = ' (geopos_supplier.loc=' . $this->aauth->get_user()->loc . ' OR geopos_supplier.loc=0) AND ';
				if (!BDATA) $whr = ' (geopos_supplier.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
			} elseif (!BDATA) {
				$whr = ' (geopos_supplier.loc=0) AND ';
			}
			$whr .= ' geopos_customers.inactive = 0 AND ';
			$query = $this->db->query("SELECT geopos_countrys.name contry_name, geopos_supplier.id,geopos_supplier.name,geopos_supplier.address,geopos_supplier.city,geopos_supplier.phone,geopos_supplier.email,geopos_supplier.taxid,geopos_supplier.postbox FROM geopos_supplier inner join geopos_countrys on geopos_supplier.country = geopos_countrys.prefix WHERE $whr (UPPER(geopos_supplier.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_supplier.phone) LIKE '" . strtoupper($name) . "%') LIMIT 6");
		}else{
			if ($this->aauth->get_user()->loc) {
				$whr = ' (geopos_customers.loc=' . $this->aauth->get_user()->loc . ' OR geopos_customers.loc=0) AND ';
				if (!BDATA) $whr = ' (geopos_customers.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
			} elseif (!BDATA) {
				$whr = ' (geopos_customers.loc=0) AND ';
			}
			$whr .= ' geopos_customers.inactive = 0 AND ';
			$query = $this->db->query("SELECT geopos_countrys.name contry_name, geopos_customers.id,geopos_customers.name,geopos_customers.address,geopos_customers.city,geopos_customers.phone,geopos_customers.email,geopos_customers.discount_c,geopos_customers.taxid,geopos_customers.postbox FROM geopos_customers inner join geopos_countrys on geopos_customers.country = geopos_countrys.prefix WHERE $whr (UPPER(geopos_customers.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_customers.phone) LIKE '" . strtoupper($name) . "%') LIMIT 6");
		}
		
        if ($name) {
			//$query = $this->db->query("SELECT id,name,address,city,phone,email,taxid,postbox FROM $tbl  WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['contry_name'] . "','" . $row['postbox'] . "','". $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . " ','" . amountFormat_general(0) . "','" . $row['taxid'] ."')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function pos_c_search()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);
        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
		$whr .= 'id <>  99999999 AND';
		$whr .= ' geopos_customers.inactive = 0 AND';
        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c,taxid FROM geopos_customers WHERE id = 99999999 UNION SELECT id,name,address,city,phone,email,discount_c,taxid FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"PselectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general(0) . "','" . $row['taxid'] ."')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }


    public function supplier()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);

        $whr = '';
        if ($this->aauth->get_user()->loc) {
            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';
            if (!BDATA) $whr = ' (loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $whr = ' (loc=0) AND ';
        }
        if ($name) {
			$query = $this->db->query("SELECT geopos_countrys.name contry_name, geopos_supplier.id,geopos_supplier.name,geopos_supplier.address,geopos_supplier.city,geopos_supplier.phone,geopos_supplier.email,geopos_supplier.taxid,geopos_supplier.postbox FROM geopos_supplier inner join geopos_countrys on geopos_supplier.country = geopos_countrys.prefix WHERE $whr (UPPER(geopos_supplier.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_supplier.phone) LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {
                echo "<li onClick=\"selectSupplier('" . $row['id'] . "','" . $row['contry_name'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . $row['taxid']."')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function pos_search()
    {
        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);
        $enable_bar = $this->input->post('bar', true);
		$flag_p=false;

        $qw = '';

        if ($wid > 0) {
            $qw .= "(geopos_products.warehouse='$wid') AND ";
        }
        if ($billing_settings['key2']) $qw .= "(geopos_products.expiry IS NULL OR DATE (geopos_products.expiry)<" . date('Y-m-d') . ") AND ";
        if ($cid > 0) {
            $qw .= "(geopos_products.pcat='$cid') AND ";
        }
        $join = '';

        if ($this->aauth->get_user()->loc) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid ';
            $qw .= '(geopos_product_serials.status=0) AND  ';
        }

        $bar = '';
		$p_class='select_pos_item';
        if ($enable_bar=='true' AND is_numeric($name) AND strlen($name)>8) {
			$flag_p=true;
            $bar = " (geopos_products.barcode = '" . (substr($name, 0, -1)) . "' OR geopos_products.barcode LIKE '" . $name . "%')";
               $query = "SELECT geopos_products.*,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ  FROM geopos_products $join WHERE " . $qw . "$bar AND (geopos_products.qty>0 OR geopos_products.b_id != 66) ORDER BY geopos_products.product_name LIMIT 6";
               $p_class='select_pos_item_bar';

        } elseif ($enable_bar=='false' OR !$enable_bar ) {
            $flag_p=true;
            if ($billing_settings['key1'] == 2) {
                $query = "SELECT geopos_products.*,geopos_product_serials.serial,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ FROM geopos_product_serials LEFT JOIN geopos_products ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (geopos_products.qty>0 OR geopos_products.b_id != 66) LIMIT 18";
            } else {
                $query = "SELECT geopos_products.*,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (geopos_products.qty>0 OR geopos_products.b_id != 66) ORDER BY geopos_products.product_name LIMIT 18";
            }
        }
		
		if($flag_p) {
			$query = $this->db->query($query);
			$result = $query->result_array();
			$i = 0;
			$out = '<div class="row match-height">';
			foreach ($result as $row) {
				if ($bar) $bar = $row['barcode'];
				$out .= '    <div class="col-2 border mb-1"  ><div class=" rounded" >
										 <a  id="posp' . $i . '"  class="' . $p_class . ' round"  data-disc="' . $row['product_des'] . '" data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '" data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '" data-stock="' . amountFormat_general($row['qty']) . '" data-verif_typ="' . $row['verif_typ'] . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '" data-bar="' . $bar . '">
												<img class="round"
													 src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
												<div class="text-center" style="margin-top: 4px;">
													<small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>
												</div></a>
										</div></div>';
				$i++;
			}


			$out .= '</div>';
			echo $out;
		}
    }

    public function group_pos_search()
    {
        $out = '';
        $this->load->model('plugins_model', 'plugins');
        $billing_settings = $this->plugins->universal_api(67);
        $name = $this->input->post('name', true);
        $cid = $this->input->post('cid', true);
        $wid = $this->input->post('wid', true);


        $qw = '';

        if ($wid > 0) {
            $qw .= "(geopos_product_groups.warehouse='$wid') AND ";
        }

        $join = '';

        if ($this->aauth->get_user()->loc) {
             $qw .= "(geopos_product_groups.loc='".$this->aauth->get_user()->loc."') AND ";
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            if (BDATA) $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND '; else $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' ) AND ';
        } elseif (!BDATA) {
            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';
            $qw .= '(geopos_warehouse.loc=0) AND ';
        }

        $e = '';
        if ($billing_settings['key1'] == 1) {
            $e .= ',geopos_product_serials.serial';
            $join .= 'LEFT JOIN geopos_product_serials ON geopos_product_serials.product_id=geopos_products.pid ';
            $qw .= '(geopos_product_serials.status=0) AND  ';
        }

        $bar = '';

        if (is_numeric($name)) {
            $b = array('-', '-', '-');
            $c = array(3, 4, 11);
            $barcode = $name;
            for ($i = count($c) - 1; $i >= 0; $i--) {
                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);
            }
            //    echo(substr($barcode, 0, -1));
            $bar = " OR (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) . "%' OR geopos_products.barcode LIKE '" . $name . "%')";
            //  $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . " $bar AND (geopos_products.qty>0 OR geopos_products.b_id != 66) LIMIT 16";
        }
        if ($billing_settings['key1'] == 2) {

            $query = "SELECT geopos_products.*,
			geopos_product_serials.serial,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ FROM geopos_product_serials  LEFT JOIN geopos_products  ON geopos_products.pid=geopos_product_serials.product_id $join WHERE " . $qw . "geopos_product_serials.serial LIKE '" . strtoupper($name) . "%'  AND (geopos_products.qty>0 OR geopos_products.b_id != 66) LIMIT 18";

        } else {
            $query = "SELECT geopos_products.*,case when geopos_products.b_id != 66 then 0 else 1 end as verif_typ $e FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND (geopos_products.qty>0 OR geopos_products.b_id != 66) ORDER BY geopos_products.product_name LIMIT 18";
        }

        $query = $this->db->query($query);
        $result = $query->result_array();
        $i = 0;
        echo '<div class="row match-height">';
        foreach ($result as $row) {

            $out .= '    <div class="col-2 border mb-1"  ><div class=" rounded" >
                                 <a  id="posp' . $i . '"  class="select_pos_item round"   data-name="' . $row['product_name'] . '"  data-price="' . amountExchange_s($row['product_price'], 0, $this->aauth->get_user()->loc) . '"  data-tax="' . amountFormat_general($row['taxrate']) . '"  data-discount="' . amountFormat_general($row['disrate']) . '" data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . amountFormat_general($row['qty']) . '" data-verif_typ="' . $row['verif_typ'] . '" data-unit="' . $row['unit'] . '" data-serial="' . @$row['serial'] . '">
                                        <img class="round"
                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 100%;max-width: 100%">
                                        <div class="text-center" style="margin-top: 4px;">
                                       
                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>

                                            
                                        </div></a>
                                  
                                </div></div>';

            $i++;

        }

        echo $out;

    }

}