<?php

class Common
{
    function __construct()
    {
        $this->PI = &get_instance();
    }

    function taxlist($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case -1:
                $tax_list .= '<option value="yes" data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case -2:
                $tax_list .= '<option value="inclusive"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case -3:
                ##$tax_list .= '<option value="' . GST_INCL . '" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case -4:
                ##$tax_list .= '<option value="' . GST_INCL . '"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 0:
                $tax_list .= '<option value="off" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        /*if ($id > 0) {
            $this->PI->db->where('id', $id);
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'ASC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_list .= '<option value="' . $row1['val4'] . '" data-tformat="' . $row1['val3'] . '" data-trate="' . $row1['val2'] . '">' . $row1['val1'] . '</option> ';
        }*/
        $tax_list .= '<option value="yes" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
                                            <option value="inclusive"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
                                            <option value="off" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>';

		##'<option value="' . GST_INCL . '" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
        ##<option value="' . GST_INCL . '" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';
        /*$this->PI->db->where('type', 2);
        $this->PI->db->order_by('id', 'ASC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['val4'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }*/
        return $tax_list;
    }
	
	public function history($id, $tip)
    {
        $this->PI->db->select('geopos_log.*');
        $this->PI->db->from('geopos_log');
        $this->PI->db->where('geopos_log.type_log', $tip);
        $this->PI->db->where('geopos_log.id_c', $id);
        $query = $this->PI->db->get();
        return $query->result_array();
    }

    function disclist()
    {
        $this->PI->db->where('id', 61);
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        $disclist = '<option value="' . $row1['key1'] . '">--' . $row1['other'] . '--</option> ';
        #$disclist .= '<option value="%">' . $this->PI->lang->line('% Discount') . ' ' . $this->PI->lang->line('After TAX') . '</option>
        #                                        <option value="flat">' . $this->PI->lang->line('Flat Discount') . ' ' . $this->PI->lang->line('After TAX') . '</option>
        #                                          <option value="b_p">' . $this->PI->lang->line('% Discount') . ' ' . $this->PI->lang->line('Before TAX') . '</option>
        #                                        <option value="bflat">' . $this->PI->lang->line('Flat Discount') . ' ' . $this->PI->lang->line('Before TAX') . '</option> ';
        return $disclist;
    }

    function disc_status()
    {
        $this->PI->db->where('id', 61);
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        return array('disc_format' => $row1['key1'], 'ship_tax' => $row1['url'], 'ship_rate' => $row1['key2']);
    }

    function taxsettings($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case -1:
                ##$tax_list .= '<option value="-1" data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case -2:
                ##$tax_list .= '<option value="-2"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case -3:
                ##$tax_list .= '<option value="-3" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case -4:
                ##$tax_list .= '<option value="-4"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 0:
                ##$tax_list .= '<option value="0" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        if ($id > 0) {
            $this->PI->db->where('id', $id);
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'ASC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_list .= '<option value="' . $row1['id'] . '" data-tformat="' . $row1['val3'] . '" data-trate="' . $row1['val2'] . '">' . $row1['val1'] . '</option> ';
        }
        #$tax_list .= '<option value="-1" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
         #                                  <option value="-2"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
         #                                  <option value="0" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>';
											##<option value="-3" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
											##<option value="-4" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';
                                            

        $this->PI->db->where('type', 2);
        $this->PI->db->order_by('id', 'ASC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['id'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $tax_list;
    }

    function taxlist_edit($id = 0)
    {
        $tax_list = '';
        switch ($id) {
            case 'yes':
                ##$tax_list .= '<option value="yes"  data-tformat="yes" selected>&raquo;' . $this->PI->lang->line('On') . '</option>';
                break;
            case 'incl':
                ##$tax_list .= '<option value="inclusive"  data-tformat="incl" selected>&raquo;' . $this->PI->lang->line('Inclusive') . '</option>';
                break;
            case 'cgst':
                ##$tax_list .= '<option value="' . GST_INCL . '" data-tformat="cgst" selected>&raquo;' . $this->PI->lang->line('GST1') . '</option>';
                break;
            case 'igst':
                ##$tax_list .= '<option value="' . GST_INCL . '"  data-tformat="igst" selected>&raquo;' . $this->PI->lang->line('IGST') . '</option>';
                break;
            case 'no':
                ##$tax_list .= '<option value="off" selected>&raquo;' . $this->PI->lang->line('Off') . '</option>';
                break;
        }
        #$tax_list .= '<option value="yes" data-tformat="yes">' . $this->PI->lang->line('On') . '</option>
         #                                   <option value="inclusive"  data-tformat="incl">' . $this->PI->lang->line('Inclusive') . '</option>
         #                                   <option value="off" data-tformat="off">' . $this->PI->lang->line('Off') . '</option>';
											#<option value="' . GST_INCL . '" data-tformat="cgst">' . $this->PI->lang->line('GST1') . '</option>
                                            #<option value="' . GST_INCL . '" data-tformat="igst">' . $this->PI->lang->line('IGST') . '</option> ';

        $this->PI->db->where('type', 2);
        $this->PI->db->order_by('id', 'ASC');
        $query = $this->PI->db->get('geopos_config');
        $result = $query->result_array();
        foreach ($result as $row) {
            $tax_list .= '<option value="' . $row['val4'] . '" data-tformat="' . $row['val3'] . '" data-trate="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $tax_list;
    }

    function taxdetail()
    {
        $tax_name = '';
        if ($this->PI->config->item('tax') > 0) {
            $this->PI->db->where('id', $this->PI->config->item('tax'));
            $this->PI->db->where('type', 2);
            $this->PI->db->order_by('id', 'ASC');
            $query = $this->PI->db->get('geopos_config');
            $row1 = $query->row_array();
            $tax_f = $row1['val3'];
            $tax_name = '%';
        }
        return array('format' => $tax_f, 'handle' => $tax_name);
    }

    function taxhandle_edit($ty = '')
    {
        switch ($ty) {
            case 'yes':
                $tax_name = '%';
                break;
            default:
                $tax_name = '%';
                break;
        }
        return $tax_name;
    }
	
	function languagesSystem()
    {
        $lang = '<option value="english">English</option><option value="french">French</option><option value="german">German</option><option value="italian">Italian</option><option value="portuguese">Portuguese</option>';
        return $lang;
    }
	
    function languages($id = 0)
    {
        if ($id) {
            $this->PI->db->select('lang');
            $this->PI->db->from('geopos_locations');
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
            $out = $query->row_array();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_system');
            $this->PI->db->where('id', 1);
            $query = $this->PI->db->get();
            $out = $query->row_array();
        }
        $lang = '<option value="' . $out['lang'] . '">--' . $out['lang'] . '--</option>'.$this->languagesSystem();
        return $lang;
    }
	
	function countrys($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_countrys');
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_countrys');
            $query = $this->PI->db->get();
        }
		$result = $query->result_array();
		foreach ($result as $row) {
            $country .= '<option value="' . $row['prefix'] . '">' . $row['name'] . '</option> ';
        }
        return $country;
    }
	
	
	function snum_copys($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 8);
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 8);
            $query = $this->PI->db->get();
        }
		$result = $query->result_array();
		foreach ($result as $row) {
            $country .= '<option value="' . $row['id'] . '" data-type="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $country;
    }
	
	
	function stermos($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_irs_typ_doc');
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
			$query = $this->PI->db->query("select geopos_irs_typ_doc.* from geopos_irs_typ_doc left join geopos_terms on geopos_irs_typ_doc.id = geopos_terms.type where geopos_irs_typ_doc.id not in (select type from geopos_terms)");
        }
		
		$result = $query->result_array();
		
		foreach ($result as $row) {
            $country .= '<option value="' . $row['id'] . '" data-type="' . $row['type'] . '">' . $row['description'] . '</option> ';
        }
        return $country;
    }
	
	function smetopagamentoname($id = 0)
    {
		$query = "";
		$this->PI->db->select('*');
		$this->PI->db->from('geopos_config');
		$this->PI->db->where('geopos_config.type', 9);
		$this->PI->db->where('id', $id);
		$query = $this->PI->db->get();
		$result = $query->result_array();
		$country = "";
		foreach ($result as $row) {
            $country =  $row['val1'];
        }
        return $country;
    }
	
	
	function smetopagamento($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 9);
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 9);
            $query = $this->PI->db->get();
        }
		$result = $query->result_array();
		foreach ($result as $row) {
            $country .= '<option value="' . $row['id'] . '" data-serie="' . $row['id']. '" data-type="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $country;
    }
	
	
	function sprazovencimento($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 7);
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 7);
            $query = $this->PI->db->get();
        }
		$result = $query->result_array();
		foreach ($result as $row) {
            $country .= '<option value="' . $row['id'] . '" data-serie="' . $row['id']. '" data-type="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $country;
    }

	
	
	
	function sexpeditions($id = 0)
    {
		$query = "";
		$country = '';
        if ($id) {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 6);
            $this->PI->db->where('id', $id);
            $query = $this->PI->db->get();
        } else {
            $this->PI->db->select('*');
            $this->PI->db->from('geopos_config');
			$this->PI->db->where('geopos_config.type', 6);
            $query = $this->PI->db->get();
        }
		$result = $query->result_array();
		foreach ($result as $row) {
            $country .= '<option value="' . $row['id'] . '" data-type="' . $row['val2'] . '">' . $row['val1'] . '</option> ';
        }
        return $country;
    }

    function current_language($lang = '')
    {
        $lang = '<option value="' . $lang . '">--' . $lang . '--</option><option value="english">English</option> <option value="arabic">Arabic</option><option value="bengali">Bengali</option>
                       <option value="czech">Czech</option><option value="chinese-simplified">Chinese-simplified</option> <option value="chinese-traditional">Chinese-traditional</option> <option value="dutch">Dutch</option><option value="filipino">Filipino</option><option value="french">French</option><option value="german">German</option><option value="greek">Greek</option><option value="hebrew">Hebrew</option><option value="hindi">Hindi</option><option value="indonesian">Indonesian</option>  <option value="italian">Italian</option><option value="japanese">Japanese</option><option value="javanese">Javanese</option><option value="khmer">Khmer</option><option value="korean">Korean</option> <option value="polish">Polish</option><option value="portuguese">Portuguese</option> <option value="russian">Russian</option> <option value="romanian">Romanian</option> <option value="swedish">Swedish</option><option value="spanish">Spanish</option><option value="thai">Thai</option><option value="turkish">Turkish</option><option value="vietnamese">Vietnamese</option><option value="urdu">Urdu</option>';
        return $lang;
    }
	
	public function irs_typ_combo()
    {
		$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, geopos_irs_typ_doc.type as type_n, geopos_irs_typ_doc.description as nameused");
		$this->PI->db->from('geopos_irs_typ_doc');
		$this->PI->db->order_by('id', 'ASC');
		$this->PI->db->limit(3);
        $query = $this->PI->db->get();
		$result = $query->result_array();
		$wr = "";
		foreach ($result as $row) {
            $wr .= '<option value="' . $row['id'] . '" data-serie="' . $row['type_n'] . '">' . $row['nameused'] . '</option>';
        }
        
		return $wr;
    }
	

    public function default_warehouse()
    {
		$wr = "";
        if ($this->PI->aauth->get_user()->loc) {
            $this->PI->db->select('geopos_locations.ware,geopos_warehouse.title');
            $this->PI->db->from('geopos_locations');
            $this->PI->db->join('geopos_warehouse', 'geopos_locations.ware=geopos_warehouse.id', 'left');
            $this->PI->db->where('geopos_locations.id', $this->PI->aauth->get_user()->loc);
            $query = $this->PI->db->get();
            $result = $query->row_array();
            if ($result['title'])
			{
				$wr .= '<option value="' . $result['ware'] . '">*' . $result['title'] . '*</option>';
				$wr .= '<option value="0">' . $this->PI->lang->line('All') . '</option>';
			}else{
				$wr = '<option value="0">*' . $this->PI->lang->line('All') .'*</option>';
			}
        } else {
            $this->PI->db->select('univarsal_api.key1,geopos_warehouse.title');
            $this->PI->db->from('univarsal_api');
            $this->PI->db->join('geopos_warehouse', 'univarsal_api.key1=geopos_warehouse.id', 'left');
            $this->PI->db->where('univarsal_api.id', 60);
            $query = $this->PI->db->get();
            $result = $query->row_array();
            if ($result['title'])
			{
				$wr .= '<option value="' . $result['key1'] . '">*' . $result['title'] . '*</option>';
				$wr .= '<option value="0">' . $this->PI->lang->line('All') . '</option>';
			}else{
				$wr = '<option value="0">*' . $this->PI->lang->line('All') . '*</option>';
			}
        }
		return $wr;
    }
	
	public function default_series_id($id)
    {
		$wr = 0;
		$this->PI->db->select("geopos_irs_typ_series.*,geopos_series.id as serie_id, CONCAT(geopos_series.serie,' - ',geopos_config.val1) as seriename, CASE WHEN geopos_irs_typ_series.predf = 0 THEN 'Não' ELSE 'Sim' END as predfname, CASE WHEN geopos_irs_typ_series.taxs = 0 THEN 'Não' ELSE 'Sim' END as taxsname, CASE WHEN geopos_irs_typ_series.type_com = 0 THEN 'Web Service' WHEN geopos_irs_typ_series.type_com = 1 THEN 'SAFT' WHEN geopos_irs_typ_series.type_com = 2 THEN 'Sem Comunicação' ELSE 'Manual' END as type_comname, geopos_warehouse.title as warehousename, geopos_products_class.title as claname");
        $this->PI->db->from('geopos_irs_typ_series');
		$this->PI->db->join('geopos_irs_typ', 'geopos_irs_typ_series.irs_type = geopos_irs_typ.id');
		$this->PI->db->join('geopos_irs_typ_doc', 'geopos_irs_typ.typ_doc = geopos_irs_typ_doc.id');
        $this->PI->db->where('geopos_irs_typ_doc.id', $id);
		$this->PI->db->where('geopos_irs_typ_series.predf', 1);
		$this->PI->db->join('geopos_series', 'geopos_series.id = geopos_irs_typ_series.serie', 'left');
		$this->PI->db->join('geopos_config', 'geopos_config.id = geopos_series.cae', 'left');
		$this->PI->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_irs_typ_series.warehouse', 'left');
		$this->PI->db->join('geopos_products_class', 'geopos_products_class.id = geopos_irs_typ_series.cla', 'left');
        $query = $this->PI->db->get();
		$result = $query->row_array();
		if ($result['serie_id'])
			$wr = $result['serie_id'];
        return $wr;
    }
	
	public function default_series($id)
    {
		$this->PI->db->select("geopos_irs_typ_series.*,geopos_series.id as serie_id, CONCAT(geopos_series.serie,' - ',geopos_config.val1) as seriename, CASE WHEN geopos_irs_typ_series.predf = 0 THEN 'Não' ELSE 'Sim' END as predfname, CASE WHEN geopos_irs_typ_series.taxs = 0 THEN 'Não' ELSE 'Sim' END as taxsname, CASE WHEN geopos_irs_typ_series.type_com = 0 THEN 'Web Service' WHEN geopos_irs_typ_series.type_com = 1 THEN 'SAFT' WHEN geopos_irs_typ_series.type_com = 2 THEN 'Sem Comunicação' ELSE 'Manual' END as type_comname, geopos_warehouse.title as warehousename, geopos_products_class.title as claname");
        $this->PI->db->from('geopos_irs_typ_series');
		$this->PI->db->join('geopos_irs_typ', 'geopos_irs_typ_series.irs_type = geopos_irs_typ.id');
		$this->PI->db->join('geopos_irs_typ_doc', 'geopos_irs_typ.typ_doc = geopos_irs_typ_doc.id');
        $this->PI->db->where('geopos_irs_typ_doc.id', $id);
		$this->PI->db->where('geopos_irs_typ_series.predf', 1);
		$this->PI->db->join('geopos_series', 'geopos_series.id = geopos_irs_typ_series.serie', 'left');
		$this->PI->db->join('geopos_config', 'geopos_config.id = geopos_series.cae', 'left');
		$this->PI->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_irs_typ_series.warehouse', 'left');
		$this->PI->db->join('geopos_products_class', 'geopos_products_class.id = geopos_irs_typ_series.cla', 'left');
        $query = $this->PI->db->get();
		$result = $query->row_array();
		if ($result['serie_id'])
			$wr = '<option value="' . $result['serie_id'] . '">' . $result['seriename'] . '</option>';
		else
			$wr = $result;
        return $wr;
    }

	public function default_typ_doc_list_ini()
    {
		$quer = "select geopos_irs_typ_doc.id, geopos_irs_typ_doc.description as typ_name, '0' as start, '1' as ver
		from geopos_irs_typ_doc order by typ_name";
		$query = $this->PI->db->query($quer);
		$result = $query->result_array();		
		return $result;
	}
	
	
	public function default_typ_doc_list($serie)
    {
		$quer = "select 
						geopos_series_ini_typs.typ_doc as id, 
						geopos_irs_typ_doc.description as typ_name, 
						geopos_series_ini_typs.start, 
						CASE WHEN geopos_series_ini_typs.start = 0 then '1' else '0' end as ver
					from geopos_series_ini_typs
					inner join geopos_irs_typ_doc on geopos_series_ini_typs.typ_doc = geopos_irs_typ_doc.id
					where geopos_series_ini_typs.serie = '$serie'
			UNION ALL
					select 
						geopos_irs_typ_doc.id, 
						geopos_irs_typ_doc.description as typ_name, 
						'0' as start, 
						'1' as ver
					from geopos_irs_typ_doc 
					where geopos_irs_typ_doc.id not in (select typ_doc from geopos_series_ini_typs where serie = '$serie')
			order by typ_name";
		$query = $this->PI->db->query($quer);
		$result = $query->result_array();
		
		return $result;
	}
	
	public function default_typ_id_doc($tipdoc)
    {
		$id_typ_doc = 0;
		
		if($tipdoc == 4)
		{
			if ($this->PI->aauth->get_user()->loc)
			{
				$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, CONCAT(geopos_irs_typ_doc.type,' - ',geopos_irs_typ_doc.description) as nameused");
				$this->PI->db->from('geopos_irs_typ_doc');
				$this->PI->db->join('geopos_locations', 'geopos_locations.doc_default = geopos_irs_typ_doc.id');
				$this->PI->db->where('geopos_locations.id', $this->PI->aauth->get_user()->loc);
				$wr = '';
				$query = $this->PI->db->get();
				$result = $query->row_array();
				if ($result['id']) 
					$id_typ_doc = $result['id'];
				else{
					$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, CONCAT(geopos_irs_typ_doc.type,' - ',geopos_irs_typ_doc.description) as nameused");
					$this->PI->db->from('geopos_irs_typ_doc');
					$this->PI->db->where('geopos_irs_typ_doc.id', 2);
					$query = $this->PI->db->get();
					$result = $query->row_array();
					if ($result['id'])
						$id_typ_doc = $result['id'];
				}
			}else{
				$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, CONCAT(geopos_irs_typ_doc.type,' - ',geopos_irs_typ_doc.description) as nameused");
				$this->PI->db->from('geopos_irs_typ_doc');
				$this->PI->db->where('geopos_irs_typ_doc.id', 2);
				$query = $this->PI->db->get();
				$result = $query->row_array();
				if ($result['id'])
					$id_typ_doc = $result['id'];
			}
			
		}else{
				$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, CONCAT(geopos_irs_typ_doc.type,' - ',geopos_irs_typ_doc.description) as nameused");
				$this->PI->db->from('geopos_irs_typ_doc');
				$this->PI->db->where('geopos_irs_typ_doc.id', $tipdoc);
				$query = $this->PI->db->get();
				$result = $query->row_array();
				if ($result['id'])
					$id_typ_doc = $result['id'];
		}
		return $id_typ_doc;
    }
	
	public function default_typ_doc($tipdoc)
    {
		$wr = '';
        if($tipdoc == 4)
		{
			if ($this->PI->aauth->get_user()->loc)
			{
				$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, geopos_irs_typ_doc.description as nameused");
				$this->PI->db->from('geopos_irs_typ_doc');
				$this->PI->db->join('geopos_locations', 'geopos_locations.doc_default = geopos_irs_typ_doc.id');
				$this->PI->db->where('geopos_locations.id', $this->PI->aauth->get_user()->loc);
				$query = $this->PI->db->get();
				$result = $query->row_array();
				if ($result['id']) 
					$wr = '<option value="' . $result['id'] . '" data-serie="' . $result['type'] . '">' . $result['nameused'] . '</option>';
				else{
					$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, geopos_irs_typ_doc.description as nameused");
					$this->PI->db->from('geopos_irs_typ_doc');
					$this->PI->db->where('geopos_irs_typ_doc.id', 2);
					$query = $this->PI->db->get();
					$result = $query->row_array();
					if ($result['id'])
						$wr = '<option value="' . $result['id'] . '" data-serie="' . $result['type'] . '">' . $result['nameused'] . '</option>';
				}
			}else{
				$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, geopos_irs_typ_doc.description as nameused");
				$this->PI->db->from('geopos_irs_typ_doc');
				$this->PI->db->where('geopos_irs_typ_doc.id', 2);
				$query = $this->PI->db->get();
				$result = $query->row_array();
				if ($result['id'])
					$wr = '<option value="' . $result['id'] . '" data-serie="' . $result['type'] . '">' . $result['nameused'] . '</option>';
			}
		}else{
			$this->PI->db->select("geopos_irs_typ_doc.id, geopos_irs_typ_doc.type, geopos_irs_typ_doc.description, geopos_irs_typ_doc.description as nameused");
			$this->PI->db->from('geopos_irs_typ_doc');
			$this->PI->db->where('geopos_irs_typ_doc.id', $tipdoc);
			$query = $this->PI->db->get();
			$result = $query->row_array();
			if ($result['id'])
				$wr = '<option value="' . $result['id'] . '" data-serie="' . $result['type'] . '">' . $result['nameused'] . '</option>';
		}
		return $wr;
    }
	
	
	public function lastdoc($typ_inv,$ser_inv)
    {
        $this->PI->db->select('start');
        $this->PI->db->from('geopos_series_ini_typs');
		$this->PI->db->where('typ_doc', $typ_inv);
		$this->PI->db->where('serie', $ser_inv);
		$this->PI->db->limit(1);
        $query = $this->PI->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->start;
        } else {
            return 0;
        }
    }
	
    function zero_stock()
    {
        $this->PI->db->where('id', 63);
        $query = $this->PI->db->get('univarsal_api');
        $row1 = $query->row_array();
        return $row1['key1'];
    }

}