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

class Settings_model extends CI_Model
{
    public function company_details($id)
    {
		$this->db->select("geopos_system.*, geopos_system.cname as name_comp, geopos_countrys.name as country_name, geopos_countrys.name as namecountry,
		CASE WHEN ".WARHOUSE." = '0' THEN 'Todos' ELSE geopos_warehouse.title END AS namewar, ".WARHOUSE." as war");
		$this->db->from('geopos_system');
		$this->db->join('geopos_countrys', 'geopos_system.country = geopos_countrys.prefix', 'left');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = '.WARHOUSE, 'left');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = '.DOCDEFAULT, 'left');
        $query = $this->db->get();
        return $query->row_array();
    }	
	
	public function online_pay_settings_main()
    {
        $this->db->select("geopos_system.*, 
								case when ".POSACCOUNT." = '0' then 0 else co.id end as ac_id_o,
								case when ".DOCSFACCOUNT." = '0' then 0 else cf.id end as ac_id_f,
								case when ".DOCSACCOUNT." = '0' then 0 else cd.id end as ac_id_d, 
								cd.holder as ac_name_d, cd.acn as ac_num_d,
		cf.holder as ac_name_f, cf.acn as ac_num_f,CASE WHEN ".DOCDEFAULT." = 0 THEN 'Fatura' ELSE geopos_irs_typ_doc.description END AS nametipdoc, ".DOCDEFAULT." as doc_default, 
		".EMPS." as emps, ".POSV." as posv, ".PAC." as pac, ".DUALENTRY." as dual_entry");
        $this->db->from('geopos_system');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = '.DOCDEFAULT, 'left');
        $this->db->join('geopos_accounts as co', POSACCOUNT.' = co.id', 'left');
		$this->db->join('geopos_accounts as cd', DOCSACCOUNT.' = cd.id', 'left');
		$this->db->join('geopos_accounts as cf', DOCSFACCOUNT.' = cf.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function online_pay_settings($id)
    {
        $this->db->select("geopos_locations.*, co.id as ac_id_o, co.holder as ac_name_o, co.acn as ac_num_o, cd.id as ac_id_d, cd.holder as ac_name_d, cd.acn as ac_num_d,
		cf.id as ac_id_f, cf.holder as ac_name_f, cf.acn as ac_num_f,
		CASE WHEN geopos_locations.doc_default = 0 THEN 'Fatura' ELSE geopos_irs_typ_doc.description END AS nametipdoc");
        $this->db->from('geopos_locations');
        $this->db->where('geopos_locations.id', $id);
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_locations.doc_default', 'left');
        $this->db->join('geopos_accounts as co', 'geopos_locations.acount_o = co.id', 'left');
		$this->db->join('geopos_accounts as cd', 'geopos_locations.acount_d = cd.id', 'left');
		$this->db->join('geopos_accounts as cf', 'geopos_locations.acount_f = cf.id', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }
	
	
	public function permissions_loc($id)
    {
        $this->db->select("geopos_system_permiss.*");
        $this->db->from('geopos_system_permiss');
        $this->db->where('geopos_system_permiss.loc', $id);
        $query = $this->db->get();
        return $query->row_array();

    }
	
	public function company_details2($id)
    {
        if($this->aauth->get_user()->loc)
		{
			$this->db->select('geopos_locations.*, geopos_locations.cname as name_comp, geopos_countrys.name as country_name, geopos_countrys.name as namecountry');
			$this->db->from('geopos_locations');
			$this->db->join('geopos_countrys', 'geopos_locations.country = geopos_countrys.prefix', 'left');
			$this->db->where('geopos_locations.id', $id);
		}else{
			$this->db->select('geopos_system.*, geopos_system.cname as name_comp, geopos_countrys.name as country_name, geopos_countrys.name as namecountry');
			$this->db->from('geopos_system');
			$this->db->join('geopos_countrys', 'geopos_system.country = geopos_countrys.prefix', 'left');
		}
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_company($id, $name, $phone, $email, $address, $city, $region, $country, $postbox,
                                   $taxid,
                                   $social_security, $annual_vacation, $number_day_work_month,
								   $number_hours_work, $share_capital, $registration, $conservator,$passive_res,
                                   $foundation,$data_share,$rent_ab,$zon_fis)
    {
        $data = array(
            'cname' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'taxid' => $taxid,
            'annual_vacation' => $annual_vacation,
            'social_security' => $social_security,
            'number_day_work_month' => $number_day_work_month,
			'number_hours_work' => $number_hours_work,
			'share_capital' => $share_capital,
			'registration' => $registration,
			'conservator' => $conservator,
			'passive_res' => $passive_res,
            'foundation' => $foundation,
			'rent_ab' => $rent_ab,
			'zon_fis' => $zon_fis
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_system')) {
			$this->aauth->applog("[Company Update] Dados Atualizados", $this->aauth->get_user()->username);
			if ($data_share != BDATA) {
				$config_file_path = APPPATH . "config/constants.php";
				$config_file = file_get_contents($config_file_path);
				$config_file = str_replace("('BDATA', '".BDATA."')", "('BDATA', '$data_share')", $config_file);
				file_put_contents($config_file_path, $config_file);
			}
        }
    }

    public function update_billing($id, $invoiceprefix, $taxid, $taxstatus, $lang)
    {
        $data = array(
            'taxid' => $taxid,
            'tax' => $taxstatus,
            'prefix' => $invoiceprefix,
            'lang' => $lang
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_system')) {
			$this->aauth->applog("[Company Tax] Dados Atualizaos", $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_language($id, $lang)
    {
        $data = array(
            'lang' => $lang
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_system')) {
			$this->aauth->applog("[Company Language] Dados Atualizados", $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function update_dtformat($id, $tzone, $dateformat)
    {
        $data = array(
            'dformat' => $dateformat,
            'zone' => $tzone
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function companylogo($id, $pic)
    {
        $this->db->select('logo');
        $this->db->from('geopos_system');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $data = array(
            'logo' => $pic
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_system')) {
			$this->aauth->applog("[Configurações de negócios->Detalhes da Empresa] Logo Atualizado", $this->aauth->get_user()->username);
			 echo json_encode(array('status' => 'Success', 'message' => 'Logo Atualizado com sucesso.'));
            //unlink(FCPATH . 'userfiles/company/' . $result['logo']);
            //unlink(FCPATH . 'userfiles/company/' . $result['logo']);
        }
    }

    //email

    public function email_smtp()
    {
        $this->db->select('*');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_smtp($host, $port, $auth, $auth_type, $username, $password)
    {
        $data = array(
            'host' => $host,
            'port' => $port,
            'auth' => $auth,
            'auth_type' => $auth_type,
            'username' => $username,
            'password' => $password
        );
        $this->db->set($data);
        $this->db->where('id', 1);
        if ($this->db->update('geopos_smtp')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    private function validate_p($var1, $var2)
    {
		$varapp = base_url();
		$varapp = str_replace('http:', '', $varapp);
		$varapp = str_replace('https:', '', $varapp);
		$varapp = str_replace('\/\/', '', $varapp);
		$varapp = str_replace('//', '', $varapp);
        $var2 .= '&app='.$varapp;
		$variaveis = "var1=".$var1."&var2=".$var2;
		//var_dump(SERVICE);
		//var_dump($variaveis);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SERVICE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $variaveis);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function update_atformat($var1, $var2)
    {
        $output = $this->validate_p($var1, $var2);
        //$this->load->driver('cache');
        //$this->cache->file->save('cache_validation', $output);
		//$reflFunc = new ReflectionFunction('active'); 
		//print $reflFunc->getFileName() . ':' . $reflFunc->getStartLine();
        //active($output);
		$resp = json_decode($output);
		if($resp->stt == "ok"){
            $this->db->where("l_stt","act");
            $r=$this->db->get("geopos_license")->row();
            $now = time();
            $your_date = strtotime($r->l_date);
            $datediff = $now - $your_date;
            $remain	=$r->l_exp - round($datediff / (60 * 60 * 24));
            $remain_your = 0;
            if(numberClean($remain)	> 0 ){
                $remain_your = numberClean($remain);
            }else{
                $remain_your = 0;
            }

            $this->db->update('geopos_license', array("l_stt"=>"exp")) ;
            
			$data = array(
				'l_code' => $var2,
				'l_exp' => (numberClean($resp->data->ds)+numberClean($remain_your)),
				'l_email' => $var1
				);


			$ltxt = "Licensed";
			if($resp->data->ds<20)
				$ltxt = "Licença expira em ".$resp->data->ds." dias"; 
			
			if ($this->db->insert('geopos_license', $data)) {
				echo json_encode(array('status' => 'Success', 'message' => $resp->msg));
				$this->session->set_userdata('license_t', $ltxt);
			}
			else 
				echo json_encode(array('status' => 'Error', 'message' => "error writing to DB"));
		
			
		}else {
			echo json_encode(array('status' => 'Error', 'message' => $resp->msg));
		}
    }

    public function billingterms($id = 0)
    {
        $this->db->select('geopos_terms.id,geopos_terms.title,geopos_irs_typ_doc.id as type');
        $this->db->from('geopos_terms');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_terms.type', 'left');
        $this->db->where('geopos_irs_typ_doc.id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function scaes()
    {
		$name = $this->input->post('name_startsWith');
        $this->db->select("geopos_caes.*, CONCAT('(',geopos_caes.cod,') ',geopos_caes.name) as cae_name");
        $this->db->from('geopos_caes');
		$this->db->where('geopos_caes.status', 0);
		if ($name) {
			$this->db->where('UPPER(geopos_caes.name) LIKE', '%'.strtoupper($name).'%');
		}
		$this->db->order_by('geopos_caes.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function slabs()
    {
		$name = $this->input->post('name_startsWith');
        $this->db->select("geopos_config.*, geopos_countrys.name as country_name");
        $this->db->from('geopos_config');
		$this->db->join('geopos_system', 'geopos_system.country = geopos_config.taxregion', 'left');
		$this->db->join('geopos_countrys', 'geopos_config.taxregion = geopos_countrys.prefix', 'left');
        $this->db->where('geopos_config.type', 2);
		$this->db->where('geopos_system.id', 1);
		if ($name) {
			$this->db->where('UPPER(geopos_config.val1) LIKE', '%'.strtoupper($name).'%');
		}
		$this->db->order_by('geopos_config.val1', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function slabscombo()
    {
        $this->db->select('geopos_config.*, geopos_countrys.name as country_name');
        $this->db->from('geopos_config');
		$this->db->join('geopos_system', 'geopos_system.country = geopos_config.taxregion', 'left');
		$this->db->join('geopos_countrys', 'geopos_config.taxregion = geopos_countrys.prefix', 'left');
        $this->db->where('geopos_config.type', 2);
		$this->db->where('geopos_system.id', 1);
		$this->db->order_by('geopos_config.val1', 'ASC');
        $query = $this->db->get();
		$result = $query->result_array();
		$taxs = '';
		foreach ($result as $row) {
			$taxs .= '<option value="' . $row['id'] . '" data-type="' . $row['val2'] . '" data-tformat="' . $row['taxcode'] . '" data-trate="' . $row['taxregion'] . '">' . $row['val1'] . '</option> ';
			
        }
        return $taxs;
    }
	
	
	public function scaescombo()
    {
        $this->db->select('geopos_caes.*');
		$this->db->from('geopos_caes');
		$this->db->where('geopos_caes.status', 0);
		$this->db->order_by('geopos_caes.name', 'ASC');
        $query = $this->db->get();
		$result = $query->result_array();
		$taxs = '';
		foreach ($result as $row) {
			$taxs .= '<option value="' . $row['id'] . '" data-type="' . $row['cod'].'">'.'('.$row['cod'].') '.$row['name'] . '</option> ';
        }
        return $taxs;
    }
	
	
	public function sexpeditions()
    {
        $this->db->select('geopos_config.*');
        $this->db->from('geopos_config');
        $this->db->where('geopos_config.type', 6);
		$this->db->order_by('geopos_config.val1', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function slabsget($id)
    {
        $this->db->select('geopos_config.*, geopos_countrys.name as country_name');
        $this->db->from('geopos_config');
		$this->db->join('geopos_countrys', 'geopos_config.taxregion = geopos_countrys.prefix', 'left');
        $this->db->where('geopos_config.id', $id);
		$this->db->where('geopos_config.type', 2);
		$this->db->order_by('geopos_config.val1', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function withholdings()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 3);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_withholdings($tname, $trate, $ttype, $tdiscription, $taxcodesend, $taxcode)
    {
        $data = array(
            'type' => 3,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => $ttype,
			'val4' => $taxcodesend,
			'taxcode' => $taxcode,
			'taxregion' => 'PT',
            'taxdescription' => $tdiscription
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='taxwithholdings_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='withholding' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_withholdings($id, $tname, $trate, $ttype, $tdiscription, $taxcodesend, $taxcode)
    {
         $data = array(
            'type' => 3,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => $ttype,
			'val4' => $taxcodesend,
			'taxcode' => $taxcode,
            'taxdescription' => $tdiscription
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='settings/taxwithholdings_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='settings/withholdings' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_withholdings($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 3));
    }
	
	
	
	public function reasons_notes()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 11);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_reasons_notes($tname, $trate)
    {
        $data = array(
            'type' => 11,
            'val1' => $tname,
            'val2' => $trate
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='reasons_notes_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='reasons_notes' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_reasons_notes($id, $tname, $trate)
    {
         $data = array(
            'type' => 11,
            'val1' => $tname,
            'val2' => $trate
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='reasons_notes_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='reasons_notes' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_reasons_notes($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 11));
    }
	
	
	public function method_payment()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 9);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_method_payments($trate, $tname)
    {
        $data = array(
            'type' => 9,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => '',
			'val4' => '',
			'taxcode' => '',
			'taxregion' => '',
            'taxdescription' => ''
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='method_payments_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='method_payments' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_method_payments($id, $trate, $tname)
    {
         $data = array(
            'type' => 9,
            'val1' => $tname,
            'val2' => $trate
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='method_payments_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='method_payments' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_method_payments($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 9));
    }
	
	
	public function method_expedition()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 6);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_method_expeditions($trate, $tname)
    {
        $data = array(
            'type' => 6,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => '',
			'val4' => '',
			'taxcode' => '',
			'taxregion' => '',
            'taxdescription' => ''
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='method_expeditions_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='method_expeditions' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_method_expeditions($id, $trate, $tname)
    {
         $data = array(
            'type' => 6,
            'val1' => $tname,
            'val2' => $trate
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='method_expeditions_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='method_expeditions' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_method_expeditions($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 6));
    }
	
	public function numb_copy()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 8);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_numb_copys($trate, $tname)
    {
        $data = array(
            'type' => 8,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => '',
			'val4' => '',
			'taxcode' => '',
			'taxregion' => '',
            'taxdescription' => ''
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='numb_copys_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='numb_copys' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_numb_copys($id, $trate, $tname)
    {
         $data = array(
            'type' => 8,
            'val1' => $tname,
            'val2' => $trate
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='numb_copys_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='numb_copys' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_numb_copys($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 8));
    }
	
	public function praz_venc()
    {
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 7);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function add_praz_vencs($trate, $tname)
    {
        $data = array(
            'type' => 7,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => '',
			'val4' => '',
			'taxcode' => '',
			'taxregion' => '',
            'taxdescription' => ''
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='praz_vencs_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='praz_vencs' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function edit_praz_vencs($id, $trate, $tname)
    {
         $data = array(
            'type' => 7,
            'val1' => $tname,
            'val2' => $trate
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='praz_vencs_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='praz_vencs' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	public function delete_praz_vencs($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 7));
    }

    public function add_slab($tname, $trate, $ttype, $ttype2, $taxcod, $taxreg, $taxdesc)
    {
        $data = array(
            'type' => 2,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => $ttype,
            'val4' => $ttype2,
			'taxcode' => $taxcod,
			'taxregion' => $taxreg,
			'taxdescription' => $taxdesc
        );
        if ($this->db->insert('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='taxslabs_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a><a href='taxslabs' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	
	public function edit_slab($id, $tname, $trate, $ttype, $ttype2, $taxcod, $taxreg, $taxdesc)
    {
         $data = array(
            'type' => 2,
            'val1' => $tname,
            'val2' => $trate,
            'val3' => $ttype,
            'val4' => $ttype2,
			'taxcode' => $taxcod,
			'taxregion' => $taxreg,
			'taxdescription' => $taxdesc
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_config', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='taxslabs_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a><a href='taxslabs' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	
	public function caesget($id)
    {
        $this->db->select('geopos_caes.*');
        $this->db->from('geopos_caes');
        $this->db->where('geopos_caes.id', $id);
		$this->db->where('geopos_caes.status', 0);
		$this->db->order_by('geopos_caes.name', 'ASC');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	
	public function edit_caes($id, $tname, $tcod)
    {
         $data = array(
            'name' => $tname,
            'cod' => $tcod
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_caes', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='caes_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a><a href='caes' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	
	public function add_caes($tname, $taxcod)
    {
        $data = array(
            'status' => 0,
            'name' => $tname,
            'cod' => $taxcod
        );
        if ($this->db->insert('geopos_caes', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='caes_new' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a><a href='caes' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function add_term($title, $type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term
        );
        if ($this->db->insert('geopos_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='add_term' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a><a href='billing_terms' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function edit_term($id, $title, $type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('UPDATED') . "  <a href='add_term' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span></a>   <a href='billing_terms' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
    public function terms_details($id)
    {
        $this->db->select('geopos_terms.*,geopos_irs_typ_doc.id as idterm, geopos_irs_typ_doc.description as nameterm');
        $this->db->from('geopos_terms');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_terms.type', 'left');
        $this->db->where('geopos_terms.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function theme($tdirection,$menu)
    {
        if ($tdirection != LTR) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace(LTR, $tdirection, $config_file);
            file_put_contents($config_file_path, $config_file);
        }
           if ($menu != MENU) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
             $config_file = str_replace("('MENU', '".MENU."')", "('MENU', '$menu')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

    public function currency()
    {
        $this->db->select('geopos_system.currency,univarsal_api.*');
        $this->db->from('geopos_system');
        $this->db->where('univarsal_api.id', 4);
        $this->db->where('geopos_system.id', 1);
        $this->db->join('univarsal_api', 'geopos_system.id = 1', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function update_currency($id, $currency, $thous_sep, $deci_sep, $decimal, $method, $roundoff = 'Off', $r_precision = 0)
    {
        $data = array(
            'currency' => $currency
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_system');
        $data = array(
            'key1' => $deci_sep,
            'key2' => $thous_sep,
            'url' => $decimal,
            'method' => $method,
            'other' => $roundoff,
            'active' => $r_precision
        );
        $this->db->set($data);
        $this->db->where('id', 4);
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function delete_terms($id)
    {
        $this->db->select('id');
        $this->db->from('geopos_terms');

        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return $this->db->delete('geopos_terms', array('id' => $id));
        } else {
            return false;
        }

    }

    public function delete_slab($id)
    {
        return $this->db->delete('geopos_config', array('id' => $id, 'type' => 2));
    }

    public function update_tax($id, $taxid, $taxstatus, $tdirection)
    {
        $data = array(
            'taxid' => $taxid,
            'tax' => $taxstatus
        );
        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('geopos_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

        if ($tdirection != LTR) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace(GST_INCL, $tdirection, $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function automail()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 56);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_automail($email, $sms)
    {
        $data = array(
            'key1' => $email,
            'key2' => $sms
        );
        $this->db->set($data);
        $this->db->where('id', 56);
        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function logs()
    {
        $this->db->select('*');
        $this->db->from('geopos_log');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(150, 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function zerostock($os)
    {
        $data = array(
            'key1' => $os
        );
        $this->db->set($data);
        $this->db->where('id', 63);
        $this->db->update('univarsal_api');
    }

        public function billing_settings($stock,$serial,$expired)
    {
        $this->zerostock($stock);
        $data = array(
            'key1' => $serial,
             'key2' => $expired

        );
        $this->db->set($data);
        $this->db->where('id', 67);

        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function custom_fields($id = 0)
    {
        if ($id) {
            $this->db->select("*, 
			case when f_module = 1 then 'Clientes'
			when f_module = 2 then 'Faturas'
			when f_module = 3 then 'Orçamentos'
			when f_module = 4 then 'Fornecedores'
			when f_module = 5 then 'Produtos'
			else 'Funcionários' end as f_module_name");
            $this->db->from('geopos_custom_fields');
            $this->db->where('id', $id);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select("*,
			case when f_module = 1 then 'Clientes'
			when f_module = 2 then 'Faturas'
			when f_module = 3 then 'Orçamentos'
			when f_module = 4 then 'Fornecedores'
			when f_module = 5 then 'Produtos'
			else 'Funcionários' end as f_module_name");
            $this->db->from("geopos_custom_fields");
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description)
    {
        $data = array(
            'f_module' => $f_module,
            'f_type' => $f_type,
            'name' => $f_name,
            'placeholder' => $f_placeholder,
            'value_data' => $f_description,
            'f_view' => $f_view,
            'other' => $f_required

        );

        if ($this->db->insert('geopos_custom_fields', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . "  <a href='add_custom_field' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>   <a href='custom_fields' class='btn btn-info btn-lg'><span class='icon-list' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function custom_field_edit($id, $f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description)
    {
        $data = array(
			'f_module' => $f_module,
            'f_type' => $f_type,
            'name' => $f_name,
            'placeholder' => $f_placeholder,
            'value_data' => $f_description,
            'f_view' => $f_view,
            'other' => $f_required

        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_custom_fields')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function printinvoice($posvs)
    {
        if ($posvs != INVV) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);

             $config_file = str_replace("('INVV', '".INVV."')", "('INVV', '$posvs')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

     public function debug($debug)
    {

        if ($debug != ENVIRONMENT) {
            $config_file_path = FCPATH . "index.php";
            $config_file = file_get_contents($config_file_path);
            $str1=  "'".ENVIRONMENT."')";
            $str2= "'$debug')";
            $config_file = str_replace($str1, $str2, $config_file);
            file_put_contents($config_file_path, $config_file);
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

	/*
		Series
	*/
	
	public function list_numcopys()
    {
		$name = $this->input->post('name_startsWith');
		$this->db->select("geopos_config.*");
		$this->db->from('geopos_config');
		$this->db->where('geopos_config.type', 8);
		if ($name) {
			$this->db->where('UPPER(geopos_config.val1) LIKE', '%'.strtoupper($name).'%');
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function list_series()
    {
		$name = $this->input->post('name_startsWith');
        $this->db->select("geopos_series.*, CONCAT(geopos_series.serie, ' - (',geopos_caes.cod,') ',geopos_caes.name) as cae_name");
        $this->db->from('geopos_series');
		$this->db->join('geopos_caes', 'geopos_caes.id = geopos_series.cae');
		$this->db->where('geopos_series.exclued', 0);
		if ($name) {
			$this->db->where('UPPER(geopos_series.serie) LIKE', '%'.strtoupper($name).'%');
		}
        $this->db->order_by('geopos_series.serie', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function edithserie($id, $serie, $cae, $startdate, $enddate, $exclued, $serie_class, $serie_wareh, $serie_pred, $serie_type_com, $iva_caixa)
    {
        $data = array('serie' => $serie, 'cae' => $cae, 'startdate' => $startdate, 'enddate' => $enddate, 'exclued' => $exclued, 'cla' => $serie_class, 'loc' => $serie_wareh, 'predf' => $serie_pred, 'type_com' => $serie_type_com, 'iva_caixa' => $iva_caixa);
		$this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_series');
        return true;
    }
	
	public function serie_view($id)
    {
        $this->db->select("geopos_series.*, CASE WHEN geopos_series.type_com = 0 THEN 'Web Service' WHEN geopos_series.type_com = 1 THEN 'SAFT' WHEN geopos_series.type_com = 2 THEN 'Sem Comunicação' ELSE 'Manual' END as nametype_com,
		CASE WHEN geopos_series.loc = 0 or geopos_series.loc = '0' THEN geopos_system.cname ELSE geopos_locations.cname END as nameloc, geopos_products_class.title as namecla,
		CASE WHEN geopos_series.exclued = 0 THEN 'Não' ELSE 'Sim' END as nameexclude, CASE WHEN geopos_series.iva_caixa = 0 THEN 'Não' ELSE 'Sim' END as nameivacaixa, CASE WHEN geopos_series.predf = 0 THEN 'Não' ELSE 'Sim' END as namepredf, CONCAT('(',geopos_caes.cod,') ',geopos_caes.name) as cae_name");
        $this->db->from('geopos_series');
		$this->db->join('geopos_caes', 'geopos_caes.id = geopos_series.cae');
		$this->db->join('geopos_system', 'geopos_system.id = 1', 'left');
		$this->db->join('geopos_locations', 'geopos_locations.id = geopos_series.loc', 'left');
		$this->db->join('geopos_products_class', 'geopos_products_class.id = geopos_series.cla', 'left');
		
        $this->db->where('geopos_series.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	function addserie($serie, $cae, $startdate, $enddate, $exclued, $serie_class, $serie_wareh, $serie_pred, $serie_type_com, $iva_caixa)
    {
		$data = array('serie' => $serie, 'cae' => $cae, 'startdate' => $startdate, 'enddate' => $enddate, 'exclued' => $exclued, 'cla' => $serie_class, 'loc' => $serie_wareh, 'predf' => $serie_pred, 'type_com' => $serie_type_com, 'iva_caixa' => $iva_caixa);
		return $this->db->insert('geopos_series', $data);
    }

    function deleteserie($id)
    {
        if ($this->db->delete('geopos_series', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    var $acolumn_order_serie = array(null, 'geopos_series.serie', 'geopos_series.startdate', 'nametype_com', 'nameloc', 'namecla',null, null);
    var $acolumn_search_serie = array('geopos_series.serie', 'geopos_series.startdate', 'nametype_com', 'nameloc', 'namecla',);

    function serie_datatables($cid)
    {
        $this->serie_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function serie_datatables_query($cid = 0)
    {
        $this->db->select("geopos_series.*, CONCAT('(',geopos_caes.cod,') ',geopos_caes.name) as cae_name,
		CASE WHEN geopos_series.type_com = 0 THEN 'Web Service' WHEN geopos_series.type_com = 1 THEN 'SAFT' WHEN geopos_series.type_com = 2 THEN 'Sem Comunicação' ELSE 'Manual' END as nametype_com,
		CASE WHEN geopos_series.loc = 0 or geopos_series.loc = '0' THEN geopos_system.cname ELSE geopos_locations.cname END as nameloc, geopos_products_class.title as namecla");
        $this->db->from('geopos_series');
		$this->db->join('geopos_caes', 'geopos_caes.id = geopos_series.cae', 'left');
		$this->db->join('geopos_system', 'geopos_system.id = 1');
		$this->db->join('geopos_locations', 'geopos_locations.id = geopos_series.loc', 'left');
		$this->db->join('geopos_products_class', 'geopos_products_class.id = geopos_series.cla', 'left');
		
		$this->db->order_by('geopos_series.serie', 'ASC');
        $i = 0;
        foreach ($this->acolumn_search_serie as $item) // loop column
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

                if (count($this->acolumn_search_serie) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_serie[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_serie)) {
            $order = $this->acolumn_order_serie;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function serie_count_filtered($cid)
    {
        $this->serie_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function serie_count_all($cid)
    {
        $this->serie_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	
	
	var $acolumn_order_terms = array(null, 'geopos_terms.title', 'nameterm', null, null);
    var $acolumn_search_terms = array('geopos_terms.title', 'nameterm');

    function terms_datatables($cid)
    {
        $this->terms_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	
	
	
    private function terms_datatables_query($cid = 0)
    {
        $this->db->select('geopos_terms.*,geopos_irs_typ_doc.id as idterm, geopos_irs_typ_doc.description as nameterm');
        $this->db->from('geopos_terms');
		$this->db->join('geopos_irs_typ_doc', 'geopos_irs_typ_doc.id = geopos_terms.type', 'inner');
		$this->db->order_by('geopos_terms.title', 'ASC');
        $i = 0;
        foreach ($this->acolumn_search_terms as $item) // loop column
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

                if (count($this->acolumn_search_terms) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_terms[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_terms)) {
            $order = $this->acolumn_order_terms;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function terms_count_filtered($cid)
    {
        $this->terms_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function terms_count_all($cid)
    {
        $this->terms_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	/*
		Countrys
	*/
	
	public function list_countrys()
    {
        $this->db->select('geopos_countrys.*');
        $this->db->from('geopos_countrys');
        $this->db->order_by('geopos_countrys.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function edithcountry($id, $name, $prefix, $cultur, $indicat, $memberue)
    {
        $data = array('name' => $name, 'prefix' => $prefix, 'cultur' => $cultur, 'indicat' => $indicat, 'memberue' => $memberue);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_countrys');
        return true;
    }
	
	public function country_view($id)
    {
        $this->db->select("geopos_countrys.*,CASE WHEN geopos_countrys.memberue = 0 THEN 'Não' ELSE 'Sim' END as memberuename, geopos_culturs.prefix as culturname");
        $this->db->from('geopos_countrys');
        $this->db->where('geopos_countrys.id', $id);
		$this->db->join('geopos_culturs', 'geopos_countrys.cultur = geopos_culturs.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	function addcountry($name, $prefix, $cultur, $indicat, $memberue)
    {
		$data = array('name' => $name, 'prefix' => $prefix, 'cultur' => $cultur, 'indicat' => $indicat, 'memberue' => $memberue);
        return $this->db->insert('geopos_countrys', $data);
    }

    function deletecountry($id)
    {
        if ($this->db->delete('geopos_countrys', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    var $acolumn_order_country = array(null, 'geopos_countrys.name', 'geopos_countrys.prefix', null, null);
    var $acolumn_search_country = array('geopos_countrys.name', 'geopos_countrys.prefix');

    function country_datatables($cid)
    {
        $this->country_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function country_datatables_query($cid = 0)
    {
        $this->db->select('geopos_countrys.*');
        $this->db->from('geopos_countrys');
		$this->db->order_by('geopos_countrys.name', 'ASC');
        $i = 0;
        foreach ($this->acolumn_search_country as $item) // loop column
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

                if (count($this->acolumn_search_country) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_country[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_country)) {
            $order = $this->acolumn_order_country;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function country_count_filtered($cid)
    {
        $this->country_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function country_count_all($cid)
    {
        $this->country_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	
	
	/*
		Culturs
	*/
	
	public function list_culturs()
    {
        $this->db->select('geopos_culturs.*');
        $this->db->from('geopos_culturs');
        $this->db->order_by('geopos_culturs.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function edithcultur($id, $name, $prefix)
    {
        $data = array('name' => $name, 'prefix' => $prefix);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_culturs');
        return true;
    }
	
	public function cultur_view($id)
    {
        $this->db->select("geopos_culturs.*");
        $this->db->from('geopos_culturs');
        $this->db->where('geopos_culturs.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	function addcultur($name, $prefix)
    {
		$data = array('name' => $name, 'prefix' => $prefix);
        return $this->db->insert('geopos_culturs', $data);
    }

    function deletecultur($id)
    {
        if ($this->db->delete('geopos_culturs', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    var $acolumn_order_cultur = array(null, 'geopos_culturs.name', 'geopos_culturs.prefix', null, null);
    var $acolumn_search_cultur = array('geopos_culturs.name', 'geopos_culturs.prefix');

    function cultur_datatables($cid)
    {
        $this->cultur_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function cultur_datatables_query($cid = 0)
    {
        $this->db->select('geopos_culturs.*');
        $this->db->from('geopos_culturs');
		$this->db->order_by('geopos_culturs.name', 'ASC');
        $i = 0;
        foreach ($this->acolumn_search_cultur as $item) // loop column
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

                if (count($this->acolumn_search_cultur) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_cultur[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_cultur)) {
            $order = $this->acolumn_order_cultur;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function cultur_count_filtered($cid)
    {
        $this->cultur_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function cultur_count_all($cid)
    {
        $this->cultur_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

	/*
		Type Documents TAX
	*/
	
	public function list_irs_typ_doc($id = 0)
    {
		if ($id) {
			$this->db->select('geopos_irs_typ_doc.*');
			$this->db->from('geopos_irs_typ_doc');
			$this->db->where('geopos_irs_typ_doc.id', $id);
			$this->db->order_by('geopos_irs_typ_doc.type', 'ASC');
			$query = $this->db->get();
		}
		else {
			$query = $this->db->query("select geopos_irs_typ_doc.* 
			from geopos_irs_typ_doc 
			where geopos_irs_typ_doc.id not in (select geopos_irs_typ.typ_doc from geopos_irs_typ)");
			//$result = $query->result_array();
        }
        return $query->result_array();
    }
	
	public function edithirs_typ_doc($id, $type, $description, $used)
    {
        $data = array('type' => $type, 'description' => $description, 'used' => $used);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_irs_typ_doc');
        return true;
    }
	
	public function irs_typ_doc_view($id)
    {
		$this->db->select("geopos_irs_typ_doc.*,CASE WHEN geopos_irs_typ_doc.used = 0 THEN 'Financeiro' WHEN geopos_irs_typ_doc.used = 1 THEN 'Stocks' ELSE 'Outros' END as nameused");
        $this->db->from('geopos_irs_typ_doc');
        $this->db->where('geopos_irs_typ_doc.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	
	public function irs_typ_series_name($id)
    {
        $this->db->select("geopos_series.serie");
        $this->db->from('geopos_series');
        $this->db->where('geopos_series.id', $id);		
        $query = $this->db->get();
        return $query->row_array();

    }
	
	
	function ClearNull($val)
	{
		if(isset($val))
		{
			return $val;
		}else{
			return "";
		}
	}
    
    function ClearNullInt($val)
	{
		if(isset($val))
		{
			$val = $this->ClearNull($val);
            if($val == "")
            {
                return 0;
            }else
            {
                return $val;
            }
		}else{
			return 0;
		}
	}
    
    function ClearNullBool($val)
	{
		if(isset($val))
		{
            if($val === "true" || $val === true || $val === "t")
            {
                return true;
            }else
            {
                return false;
            }
			return $val;
		}else{
			return false;
		}
	}
	
	function protege_campo($valor, $tamanho_maximo = -1)
    {
        $valor = $this->ClearNull($valor);
        if($valor == "")
        {
            $valor = ".";
        }
        $valor = str_replace("<", "&lt;", $valor);
        $valor = str_replace(">", "&gt;", $valor);
        $valor = str_replace("&", "&amp;", $valor);
        
        if($tamanho_maximo > 0)
        {
            if (strlen($valor) > $tamanho_maximo)
            {
                 substr($valor, 0, $tamanho_maximo);
            }
        }
        return $valor;
    }
	
	/*public function AssinaDocumento($id, $i_cl, $tipo_id, $tipo_name, $serie, $seriename, $numdoc)
	{
		try
        {
			if()
			{
				
				
			}
			
			
			
            $query = "SELECT hash from geopos_invoices WHERE i_class = '$i_cl' and irs_type = '$tipo_id' and serie = '$serie' and tid = ".($numdoc - 1);
            
			
			
			
			
			
			$lasthash = $bd->ClearNull($bd->ExecutaEscalar($query ));

            $query = "SELECT geopos_invoices.tid as numdoc, geopos_invoices.datedoc, replace(geopos_invoices.datedoc, ' ', 'T') as dataregisto , tipodochash, serie, valortotal from fac_faccab WHERE id_factura = $id";
            if (!$bd->Executa($query, array($id)))
            {
				echo json_encode(array('status' => 'Error', 'message' => 'Erro a aceder aos dados do documento!'));
                return false;
            }
            if($bd->NumLinhas() != 1)
            {
				echo json_encode(array('status' => 'Error', 'message' => 'Erro a aceder aos dados do documento!'));
                return false;
            }
            
            $row = $bd->ProxLinha();
            
            $data = $row["datadoc"].";".$row["dataregisto"].";";
            $data .= $row["tipodochash"]." ".$row["serie"]."/".$row["numdoc"].";". str_replace(" ", "", number_format($row["valortotal"], 2, ".", "")).";";
            $invoiceno = $data;
            
            $data .= $lasthash;

            $path = $_SERVER['PHP_SELF'];
            $index = strpos($path, "PHP"); 
            $path = substr($path, 0, $index);

            $nome = $_SERVER['DOCUMENT_ROOT'].$path."PHP/Facturacao/chave.bin.encripted";

            $private_key = file_get_contents($nome);

            if($private_key === false)
            {
                $this->SetErro("Erro a aceder à chave privada");
                return false;
            }
            $binary_signature = "";

            $key_hash = "QA2oIb@£12_902ACvvAUI";

    //$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key_hash), $private_key, MCRYPT_MODE_CBC, md5(md5($key_hash)))); 

            $private_key = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key_hash), base64_decode($private_key), MCRYPT_MODE_CBC, md5(md5($key_hash))), "\0");

            //Debug::write("|".$private_key."|");
            openssl_sign($data, $binary_signature, $private_key, OPENSSL_ALGO_SHA1);


            $this->hash = str_replace("\n", "", base64_encode($binary_signature));
            Debug::write("|".$data."|\n". $this->hash."|");

            $query = "UPDATE fac_faccab SET hash = $1, invoiceno = $2 WHERE id_factura = $3";
            if(!$bd->Executa($query, array($this->hash, $invoiceno, $id)))
            {
                $this->SetErro("Erro a gerar a assinatura digital.");
                return false;
            }
            
            $hash = $this->ClearNull($bd->ExecutaEscalar("SELECT hash from fac_faccab where id_factura = $1", array($id)));
            if($hash != $this->hash)
            {
                $this->SetErro("Assinatura digital não foi gerada correctamente.");
                return false;
            }

        }catch (Exception $e)
        {
            $this->SetErro("Assinatura digital não foi gerada correctamente.");
            Debug::write($e);
            return false;
        }
		return true;
	}*/
	
	function addirs_typ_doc($used)
    {
		$data = array('used' => $used);
        return $this->db->insert('geopos_irs_typ_doc', $data);
    }

    function deleteirs_typ_doc($id)
    {
        if ($this->db->delete('geopos_irs_typ_doc', array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    var $acolumn_order_irs_typ_doc = array(null, 'geopos_irs_typ_doc.type', 'geopos_irs_typ_doc.id', null, null);
    var $acolumn_search_irs_typ_doc = array('geopos_irs_typ_doc.type', 'geopos_irs_typ_doc.description');

    function irs_typ_doc_datatables($cid)
    {
        $this->irs_typ_doc_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function irs_typ_doc_datatables_query($cid = 0)
    {
        $this->db->select("geopos_irs_typ_doc.*,CASE WHEN geopos_irs_typ_doc.used = 0 THEN 'Financeiro' WHEN geopos_irs_typ_doc.used = 1 THEN 'Stocks' ELSE 'Outros' END as nameused");
        $this->db->from('geopos_irs_typ_doc');
		$this->db->order_by('geopos_irs_typ_doc.type', 'ASC');
		if($cid > 0)
		{
			$this->db->where('geopos_irs_typ_doc.id', $cid);
		}
        $i = 0;
        foreach ($this->acolumn_search_irs_typ_doc as $item) // loop column
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

                if (count($this->acolumn_search_irs_typ_doc) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_irs_typ_doc[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_irs_typ_doc)) {
            $order = $this->acolumn_order_irs_typ_doc;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function irs_typ_doc_count_filtered($cid)
    {
        $this->irs_typ_doc_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function irs_typ_doc_count_all($cid)
    {
        $this->irs_typ_doc_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	
	
	/*
		Type TAX
	*/
	
	public function list_irs_typ()
    {
        $this->db->select('geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description');
        $this->db->from('geopos_irs_typ_doc');
        $this->db->order_by('geopos_irs_typ_doc.type', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function edithirs_typ($id, $typ_doc)
    {
        $data = array('typ_doc' => $typ_doc);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_irs_typ');
        return true;
    }
	
	public function irs_typ_view($id = 0)
    {
		$this->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.id as typ_doc, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description as nameused");
		$this->db->from('geopos_irs_typ_doc');
		$this->db->where('geopos_irs_typ_doc.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function list_irs_typ_id()
    {
        $this->db->select('geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description');
        $this->db->from('geopos_irs_typ_doc');
        $this->db->order_by('geopos_irs_typ_doc.description', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function list_irs_typ_id_fact()
    {
        $this->db->select('geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description');
        $this->db->from('geopos_irs_typ_doc');
		$this->db->where('geopos_irs_typ_doc.id', 1);
		$this->db->or_where('geopos_irs_typ_doc.id', 2);
		$this->db->or_where('geopos_irs_typ_doc.id', 3);
        $this->db->order_by('geopos_irs_typ_doc.description', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}