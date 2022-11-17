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

class Locations_model extends CI_Model
{


    public function locations_list()
    {
        $query = $this->db->query("SELECT * FROM geopos_locations ORDER BY id DESC");
        return $query->result_array();
    }

    public function locations_list2()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) $where = 'WHERE id=' . $this->aauth->get_user()->loc . '';
        $query = $this->db->query("SELECT * FROM geopos_locations $where ORDER BY id DESC");
        return $query->result_array();
    }
	
	public function locations_list3()
    {
        $where = '';
		$query = '';
        if ($this->aauth->get_user()->loc == 0 || $this->aauth->get_user()->loc == "0")
		{
			$query = $this->db->query("SELECT * FROM geopos_system where id=1");
		}else{
			$where = 'WHERE id=' . $this->aauth->get_user()->loc . '';
			$query = $this->db->query("SELECT * FROM geopos_locations $where ORDER BY id DESC");
		}
		
		//$query = $this->db->query("SELECT * FROM geopos_system where id=1");
		return $query->result_array();
    }


    public function view($id)
    {
		$this->db->select("geopos_locations.*, geopos_countrys.name as country_name, geopos_countrys.name as namecountry, 
		CASE WHEN geopos_locations.ware = 0 THEN 'Todos' ELSE geopos_warehouse.title END AS namewar");
        $this->db->from('geopos_locations');
		$this->db->join('geopos_countrys', 'geopos_locations.country = geopos_countrys.prefix', 'left');
		$this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_locations.ware', 'left');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_locations.doc_default', 'left');
        $this->db->where('geopos_locations.id', $id);
        $query = $this->db->get();
		$result = $query->row_array();  
        return $result;
    }

    public function create($name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id, $ac_id, $acd_id, $acf_id, $wid, $typ_do_id, $rent_ab, $zon_fis)
    {
        $data = array(
            'cname' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
            'email' => $email,
            'taxid' => $taxid,
            'logo' => $image,
            'acount_o' => $ac_id,
			'acount_d' => $acd_id,
			'acount_f' => $acf_id,
            'cur' => $cur_id,
			'doc_default' => $typ_do_id,
            'ware' => $wid,
			'rent_ab' => $rent_ab,
			'zon_fis' => $zon_fis,
			'dual_entry' => 0,
			'posv' => 1,
			'emps' => 0,
			'pac' => 0,
			'prazo_ve' => 0,
			'metod_pag' => 0,
			'metod_exp' => 0
        );
		return $this->db->insert('geopos_locations', $data);
    }
	
	
	public function createpermissions($loc, $name, $email)
    {
		$data = array(
            'loc' => $loc,
            'grafics' => 1,
            'products_inactiv_show' => 0,
            'clients_inactiv_show' => 0,
            'docs_email' => 0,
            'docs_del_email' => 0,
            'trans_email' => 0,
            'trans_del_email' => 0,
            'email_stock' => '',
            'email_app' => $email,
			'emailo_remet' => $name,
			'stock_min' => 0,
			'stock_sem' => 0
        );
		return $this->db->insert('geopos_system_permiss', $data);
	}
	
	public function editpermissions1($loc, $grafics, $products_inactiv_show, $clients_inactiv_show)
    {
		$data = array(
            'grafics' => $grafics,
            'products_inactiv_show' => $products_inactiv_show,
            'clients_inactiv_show' => $clients_inactiv_show
        );
		$this->db->set($data);
        $this->db->where('loc', $loc);
		return $this->db->update('geopos_system_permiss');
	}
	
	public function editpermissions2($loc, $docs_email, $docs_del_email, $trans_email, $trans_del_email, $email_stock, $email_app, $emailo_remet, $stock_min, $stock_sem)
    {
		$data = array(
            'docs_email' => $docs_email,
            'docs_del_email' => $docs_del_email,
            'trans_email' => $trans_email,
            'trans_del_email' => $trans_del_email,
            'email_stock' => $email_stock,
            'email_app' => $email_app,
			'emailo_remet' => $emailo_remet,
			'stock_min' => $stock_min,
			'stock_sem' => $stock_sem
        );
		$this->db->set($data);
        $this->db->where('loc', $loc);
		return $this->db->update('geopos_system_permiss');
	}
	

    public function edit($id, $name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id)
    {
		//, $ac_id, $acd_id, $acf_id, $wid, $typ_do_id, $rent_ab, $zon_fis, $dual_entry, $posv, $emps, $pac
        $data = array(
            'cname' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
            'email' => $email,
            'taxid' => $taxid,
            'logo' => $image,
            'cur' => $cur_id
        );
		
		/*'doc_default' => $typ_do_id,
		'ware' => $wid,
		'rent_ab' => $rent_ab,
		'zon_fis' => $zon_fis,
		'dual_entry' => $dual_entry,
		'posv' => $posv,
		'emps' => $emps,
		'pac' => $pac,
		'acount_o' => $ac_id,
		'acount_d' => $acd_id,
		'acount_f' => $acf_id,*/
			
        $this->db->set($data);
        $this->db->where('id', $id);
		return $this->db->update('geopos_locations');
    }
	
	 public function edit2($id, $ac_id, $acd_id, $acf_id, $wid, $typ_do_id, $dual_entry, $posv, $emps, $pac, $n_praz_venc, $n_met_pag, $n_met_exp)
    {
        $data = array(
            'acount_o' => $ac_id,
			'acount_d' => $acd_id,
			'acount_f' => $acf_id,
			'doc_default' => $typ_do_id,
            'ware' => $wid,
			'dual_entry' => $dual_entry,
			'posv' => $posv,
			'emps' => $emps,
			'pac' => $pac,
			'prazo_ve' => $n_praz_venc,
			'metod_pag' => $n_met_pag,
			'metod_exp' => $n_met_exp
        );
		
        $this->db->set($data);
        $this->db->where('id', $id);
		return $this->db->update('geopos_locations');
    }

    public function currencies()
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');

        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
            $this->db->or_where('loc', 0);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function online_pay_settings($id)
    {
        $this->db->select("geopos_locations.*, co.id as ac_id_o, co.holder as ac_name_o, co.acn as ac_num_o, cd.id as ac_id_d, cd.holder as ac_name_d, cd.acn as ac_num_d,
		cf.id as ac_id_f, cf.holder as ac_name_f, cf.acn as ac_num_f,
		CASE WHEN geopos_locations.doc_default = 0 THEN 'Fatura' ELSE geopos_irs_typ_doc.description END AS nametipdoc,
		CASE WHEN geopos_locations.prazo_ve = 0 THEN 'Escolha uma Opção' ELSE cofp.val1 END AS prazo_ve_name,
		CASE WHEN geopos_locations.metod_exp = 0 THEN 'Escolha uma Opção' ELSE cofme.val1 END AS metod_exp_name,
		CASE WHEN geopos_locations.metod_pag = 0 THEN 'Escolha uma Opção' ELSE cofmp.val1 END AS metod_pag_name");
        $this->db->from('geopos_locations');
        $this->db->where('geopos_locations.id', $id);
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_locations.doc_default', 'left');
        $this->db->join('geopos_accounts as co', 'geopos_locations.acount_o = co.id', 'left');
		$this->db->join('geopos_accounts as cd', 'geopos_locations.acount_d = cd.id', 'left');
		$this->db->join('geopos_accounts as cf', 'geopos_locations.acount_f = cf.id', 'left');
		$this->db->join('geopos_config as cofp', 'geopos_locations.prazo_ve = cofp.id', 'left');
		$this->db->join('geopos_config as cofme', 'geopos_locations.metod_exp = cofme.id', 'left');
		$this->db->join('geopos_config as cofmp', 'geopos_locations.metod_pag = cofmp.id', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


}