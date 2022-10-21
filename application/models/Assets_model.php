<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Assets_model extends CI_Model
{
    var $table = 'geopos_assets';
    var $column_order = array(null, 'geopos_assets.assest_name', 'cat_name', 'warehousename', 'geopos_assets.qty', 'geopos_assets.product_des');
    var $column_search = array('geopos_assets.id', 'geopos_assets.assest_name', 'cat_name', 'warehousename', 'geopos_assets.qty', 'geopos_assets.product_des');
    var $order = array('geopos_assets.assest_name' => 'desc');
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	
	public function assets_details($id, $eid = '')
    {
		$query = "";
		if($eid == '')
		{
			$query = $this->db->query("SELECT a.*, case when a.employee_id = 0 then 'Empresa' else eee.name end as employe, b.title as cat_name, 
										c.name as type_name, c.id as acattype, case when t.title is null then 'Empresa' else t.title end as warehouse_name 
										FROM geopos_assets as a 
										left join geopos_employees as eee on a.employee_id = eee.id
										inner join geopos_assets_cat as b on b.id = a.acat 
										inner join geopos_assets_cat_type as c on c.id = b.type 
										left join geopos_warehouse as t on a.warehouse = t.id where a.id=".$id);
		}else{
			$query = $this->db->query("SELECT a.*, case when a.employee_id = 0 then 'Empresa' else eee.name end as employe, b.title as cat_name, 
										c.name as type_name, c.id as acattype, case when t.title is null then 'Empresa' else t.title end as warehouse_name 
										FROM geopos_assets as a 
										left join geopos_employees as eee on a.employee_id = eee.id
										inner join geopos_assets_cat as b on b.id = a.acat 
										inner join geopos_assets_cat_type as c on c.id = b.type 
										left join geopos_warehouse as t on a.warehouse = t.id where a.id=".$id." and a.employee_id = ".$eid);
		}
		
		return $query->row_array();
	}

    public function get_assest(){
		$query = "";
		if($this->aauth->get_user()->loc == 0)
		{
			$query = $this->db->query("SELECT  a.*,b.title as cat_name, c.name as type_name, case when t.title is null then 'Empresa' else t.title end as warehousename 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										inner join geopos_assets_cat_type as c on c.id = b.type 
										left join geopos_warehouse as t on a.warehouse = t.id");
		}else{
			$query = $this->db->query("SELECT  a.*,b.title as cat_name, c.name as type_name, case when t.title is null then 'Empresa' else t.title end as warehousename 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										inner join geopos_assets_cat_type as c on c.id = b.type 
										left join geopos_warehouse as t on a.warehouse = t.id where t.loc =".$this->aauth->get_user()->loc);
		}
        return $query->result_array();
    }
    private function _get_datatables_query($cat = '')
    {
        $this->db->select("geopos_assets.id, geopos_assets_cat.image, geopos_assets.assest_name, geopos_assets_cat_type.name as type_name, geopos_assets_cat.title as cat_name, case when geopos_warehouse.title is null then 'Empresa' else geopos_warehouse.title end as warehousename, geopos_assets.qty, geopos_assets.product_des");
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_assets.warehouse', 'left');
		$this->db->join('geopos_assets_cat', 'geopos_assets_cat.id = geopos_assets.acat', 'left');
		$this->db->join('geopos_assets_cat_type', 'geopos_assets_cat_type.id = geopos_assets_cat.type', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
		
		if ($cat) {
            $this->db->where("geopos_assets.acat=$cat");
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

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	
    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all($opt = '')
    {
        $this->_get_datatables_query($opt);
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
        return $this->db->count_all_results();
    }



    public function add($catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id, $image) {
	   $data = array(
				'acat' => $catid,
				'warehouse' => $warehouse,
				'assest_name' => $product_name,
				'qty' => $product_qty,
				'product_des' => $product_desc,
				'inspection_date' => $inspection_date,
				'insurance_date' => $insurance_date,
				'employee_id' => $employee_id,
				'image' => $image
			);

		if ($this->db->insert('geopos_assets', $data)) {
			//$this->aauth->applog("[Assets Created] $product_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
			echo json_encode(array('status' => 'Success', 'message' =>
				$this->lang->line('ADDED') . "  <a href='add' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='index' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>"));
		} else {

			echo json_encode(array('status' => 'Error', 'message' =>

				$this->lang->line('ERROR')));
		}
    }

    public function edit($pid, $catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id, $image) {
		   $data = array(
				'acat' => $catid,
				'warehouse' => $warehouse,
				'assest_name' => $product_name,
				'qty' => $product_qty,
				'product_des' => $product_desc,
				'inspection_date' => $inspection_date,
				'insurance_date' => $insurance_date,
				'employee_id' => $employee_id,
				'image' => $image
			);

			$this->db->set($data);
			$this->db->where('id', $pid);
			$url = $this->lang->line('UPDATED')."<a href='index' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        
			if ($this->db->update('geopos_assets')) {
				//$this->aauth->applog("[Assets Edited] $product_name ID " . $pid, $this->aauth->get_user()->username);
				echo json_encode(array('status' => 'Success', 'message' => $url));
			} else {
				echo json_encode(array('status' => 'Error', 'message' =>
					$this->lang->line('ERROR')));
			}
    }
	
	///////Categorias.
	
	public $arrglobal = [];
	public $arrglobalfalta = [];
	function category_list_completa()
    {
        $query = $this->db->query("SELECT geopos_assets_cat.id, geopos_assets_cat.title, geopos_assets_cat.rel_id, geopos_assets_cat.type
		FROM geopos_assets_cat 
		ORDER BY geopos_assets_cat.id,geopos_assets_cat.rel_id DESC");
		$resultd = $query->result_array();
		
		global $arrglobal;
		global $arrglobalfalta;
		
		$i = 0;
		foreach ($resultd as $prd) {
			if($resultd[$i]['rel_id'] == 0){
				$row = array();
				$row['id'] = $prd['id'];
				$row['title'] = $prd['title'];
				$row['type'] = $prd['type'];
				$row['rel_id'] = 0;
				$row['pai'] = 0;
				$row2['num'] = 0;
				$row['filhos'] = [];
				$arrglobal[] = $row;
			}else{
				$enco1 = $this->getpaiiglobal($resultd[$i],0);
				if(!$enco1)
				{
					$enco2 = $this->getpaiiglobal($resultd[$i],1);
					if(!$enco2)
					{
						$enco3 = $this->getpaiiglobal($resultd[$i],2);
					}
				}
			}
			
			$i++;
		}
		
		if($arrglobalfalta != null){
			for($iz = 0; $iz < count($arrglobalfalta); $iz++)
			{
				$enco1 = $this->getpaiiglobal($arrglobalfalta[$iz],0);
				if(!$enco1)
				{
					$enco2 = $this->getpaiiglobal($arrglobalfalta[$iz],1);
					if(!$enco2)
					{
						$enco3 = $this->getpaiiglobal($arrglobalfalta[$iz],2);
					}
				}
			}
		}
		
		
		$classi = '';
		if(!is_null($arrglobal)){
			for($ico = 0; $ico < count($arrglobal); $ico++)
			{
				$classi .= '<option value="'.$arrglobal[$ico]['id'].'" data-type="'.$arrglobal[$ico]['type'].'">'.$arrglobal[$ico]['title'].'</option>';
				for($it = 0; $it < count($arrglobal[$ico]['filhos']); $it++)
				{
					$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['id'].'" data-type="'.$arrglobal[$ico]['filhos'][$it]['type'].'">->'.$arrglobal[$ico]['filhos'][$it]['title'].'</option>';
					for($ite = 0; $ite < count($arrglobal[$ico]['filhos'][$it]['filhos']); $ite++)
					{
						$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['id'].'" data-type="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['type'].'">-->'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['title'].'</option>';
						for($itef = 0; $itef < count($arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos']); $itef++)
						{
							$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos'][$itef]['id'].'" data-type="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos'][$itef]['type'].'">--->'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos'][$itef]['title'].'</option>';
						}
					}
				}
			}
		}
		
        return $classi;
    }
	
	
	public function getpaiiglobal($objpesq, $val = 0)
	{
		global $arrglobal;
		global $arrglobalfalta;
		$encontrei = false;
		if($val == 0)
		{
			for($i = 0; $i < count($arrglobal); $i++)
			{
				if($arrglobal[$i]['id'] == $objpesq['rel_id'])
				{
					$row2 = array();
					$row2['id'] = $objpesq['id'];
					$row2['title'] = $objpesq['title'];
					$row2['pai'] = $objpesq['rel_id'];
					$row2['type'] = $objpesq['type'];
					$row2['filhos'] = [];
					$arrglobal[$i]['filhos'][] = $row2;
					$encontrei = true;
					break;
				}else if($arrglobal[$i]['pai'] == $objpesq['rel_id'])
				{
					$row2 = array();
					$row2['id'] = $objpesq['id'];
					$row2['title'] = $objpesq['title'];
					$row2['type'] = $objpesq['type'];
					$row2['pai'] = $objpesq['rel_id'];
					$row2['filhos'] = [];
					$arrglobal[$i]['filhos'][] = $row2;
					$encontrei = true;
				}
			}
		}else if($val == 1)
		{
			for($i2 = 0; $i2 < count($arrglobal); $i2++)
			{
				for($i3 = 0; $i3 < count($arrglobal[$i2]['filhos']); $i3++)
				{
					if($arrglobal[$i2]['filhos'][$i3]['id'] == $objpesq['rel_id'])
					{
						$row2 = array();
						$row2['id'] = $objpesq['id'];
						$row2['title'] = $objpesq['title'];
						$row2['type'] = $objpesq['type'];
						$row2['pai'] = $objpesq['rel_id'];
						$row2['filhos'] = [];
						$arrglobal[$i2]['filhos'][$i3]['filhos'][] = $row2;
						$encontrei = true;
					}else if($arrglobal[$i2]['filhos'][$i3]['pai'] == $objpesq['rel_id'])
					{
						$row2 = array();
						$row2['id'] = $objpesq['id'];
						$row2['title'] = $objpesq['title'];
						$row2['type'] = $objpesq['type'];
						$row2['pai'] = $objpesq['rel_id'];
						$row2['filhos'] = [];
						$arrglobal[$i2]['filhos'][$i3]['filhos'][] = $row2;
						$encontrei = true;
					}
				}
			}
		}else if($val == 2)
		{
			for($i4 = 0; $i4 < count($arrglobal); $i4++)
			{
				for($i5 = 0; $i5 < count($arrglobal[$i4]['filhos']); $i5++)
				{
					for($i6 = 0; $i6 < count($arrglobal[$i4]['filhos'][$i5]['filhos']); $i6++)
					{
						if($arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['id'] == $objpesq['rel_id'])
						{
							$row2 = array();
							$row2['id'] = $objpesq['id'];
							$row2['title'] = $objpesq['title'];
							$row2['type'] = $objpesq['type'];
							$row2['pai'] = $objpesq['rel_id'];
							$row2['filhos'] = [];
							$arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['filhos'][] = $row2;
							$encontrei = true;
							break;
						}else if($arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['pai'] == $objpesq['rel_id'])
						{
							$row2 = array();
							$row2['id'] = $objpesq['id'];
							$row2['title'] = $objpesq['title'];
							$row2['type'] = $objpesq['type'];
							$row2['pai'] = $objpesq['rel_id'];
							$row2['filhos'] = [];
							$arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['filhos'][] = $row2;
							$encontrei = true;
						}
					}
				}
			}
			
			if(!$encontrei)
			{
				$arrglobalfalta[] = $objpesq;
			}
		}
		
		return $encontrei;
	}
	
	public function assetscat_sum($id, $eid = '')
    {
		$query = $this->db->query("SELECT sum(r.qty) as num_ass FROM geopos_assets as r inner join geopos_assets_cat as y on r.acat = y.id where r.acat=".$id);
		return $query->row_array();
	}
	
	public function assetscat_details($id, $eid = '')
    {
		$query = $this->db->query("SELECT r.*, case when b.rel_id = 0 || b.rel_id is null then 'Sem Pai Definido' else b.title end as cat_name, c.name as type_name
		FROM geopos_assets_cat as r 
		left join geopos_assets_cat as b on b.id = r.rel_id 
		inner join geopos_assets_cat_type as c on c.id = r.type 
		where r.id=".$id);
		return $query->row_array();
	}
	
	
	public function category_type_list()
    {
        $query = $this->db->query("SELECT id, name FROM geopos_assets_cat_type ORDER BY name ASC");
        return $query->result_array();
    }
	
	
	public function warehouse_list()
    {
        $where = '';
        if (!BDATA) $where = "WHERE  (loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }
        $query = $this->db->query("SELECT id,title FROM geopos_warehouse $where ORDER BY id DESC");
        return $query->result_array();
    }
	
	public function addc($cat_name, $extra, $rel_id, $image, $type)
    {
        $data = array(
            'title' => $cat_name,
			'extra' => $extra,
			'rel_id' => $rel_id,
			'type' => $type,
			'image' => $image
        );
		
		$url = "<a href='addc' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='cats' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        if ($this->db->insert('geopos_assets_cat', $data)) {
            //$this->aauth->applog("[Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	
	public function editc($catid, $cat_name, $extra, $rel_id, $image, $type)
    {
        $data = array(
            'title' => $cat_name,
			'extra' => $extra,
			'rel_id' => $rel_id,
			'type' => $type,
			'image' => $image
        );

        $this->db->set($data);
        $this->db->where('id', $catid);
		$url = $this->lang->line('UPDATED')."<a href='cats' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        
        if ($this->db->update('geopos_assets_cat')) {
            //$this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' => $url));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	
	
	var $table1 = 'geopos_assets_cat';
    var $column_order1 = array(null, 'geopos_assets_cat.title', 'cat_name');
    var $column_search1 = array('geopos_assets_cat.id', 'geopos_assets_cat.title', 'cat_name');
    var $order1 = array('geopos_assets_cat.title' => 'desc');
	
	public function category_stock($id = 0, $typ = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) 
				$whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }
		
		$queryte = '';
		if($typ > 0)
		{
			$queryte = "SELECT case when p.pc is null then '0' else p.pc end as pc,case when p.qty is null then '0' else p.qty end as qty,p.acat 
					FROM geopos_assets_cat AS c 
					LEFT JOIN (SELECT geopos_assets.acat,COUNT(geopos_assets.id) AS pc,
					SUM(geopos_assets.qty) AS qty FROM geopos_assets 
					LEFT JOIN geopos_warehouse ON geopos_assets.warehouse=geopos_warehouse.id $whr GROUP BY geopos_assets.acat ) AS p ON c.id=p.acat 
					WHERE c.rel_id='$id'";
		}else{
			$queryte = "SELECT case when p.pc is null then '0' else p.pc end as pc,case when p.qty is null then '0' else p.qty end as qty,p.acat 
					FROM geopos_assets_cat AS c 
					LEFT JOIN (SELECT geopos_assets.acat,COUNT(geopos_assets.id) AS pc,
					SUM(geopos_assets.qty) AS qty FROM geopos_assets 
					LEFT JOIN geopos_warehouse ON geopos_assets.warehouse=geopos_warehouse.id $whr GROUP BY geopos_assets.acat ) AS p ON c.id=p.acat 
					WHERE c.id='$id'";
		}
        $query = $this->db->query($queryte);
        return $query->row_array();
    }
	
	
	
	public function category_sub_get($id = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) 
				$whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }
		
		$queryte = "SELECT c.*, case when c.rel_id = 0 || c.rel_id is null then 'Sem Pai Definido' else cc.title end as cat_name, geopos_assets_cat_type.name as type_name,
					case when p.pc is null then '0' else p.pc end as pc,case when p.qty is null then '0' else p.qty end as qty,case when p.acat is null then '0' else p.acat end as acat 
					FROM geopos_assets_cat AS c 
					LEFT JOIN geopos_assets_cat as cc on c.rel_id = cc.id 
					LEFT JOIN geopos_assets_cat_type on geopos_assets_cat_type.id = cc.type 
					LEFT JOIN (SELECT geopos_assets.acat,COUNT(geopos_assets.id) AS pc, 
					SUM(geopos_assets.qty) AS qty FROM geopos_assets 
					LEFT JOIN geopos_warehouse ON geopos_assets.warehouse=geopos_warehouse.id $whr GROUP BY geopos_assets.acat ) AS p ON c.id=p.acat 
					WHERE c.rel_id='$id'";
        $query = $this->db->query($queryte);
        return $query->result_array();
    }
	
	
	private function _get_datatables_queryc($id = '', $sub = '')
    {
        $this->db->select("geopos_assets_cat.id, geopos_assets_cat.image, geopos_assets_cat.title, case when geopos_assets_cat.rel_id = 0 || geopos_assets_cat.rel_id is null then 'Sem Pai Definido' else cc.title end as cat_name, geopos_assets_cat_type.name as type_name");
        $this->db->from($this->table1);
		$this->db->join('geopos_assets_cat as cc', 'geopos_assets_cat.rel_id = cc.id', 'left');
        $this->db->join('geopos_assets_cat_type', 'geopos_assets_cat_type.id = geopos_assets_cat.type', 'left');
		$this->db->where('geopos_assets_cat.rel_id', 0);
		
		if ($sub) {
			$this->db->where("geopos_assets_cat.rel_id=$sub");
		}else {
			if ($id > 0) {
				$this->db->where("geopos_assets_cat.id = $id");
			}
		}
		
        $i = 0;
        foreach ($this->column_search1 as $item) // loop column 
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
				
                if (count($this->column_search1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order1[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order1;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatablesc($opt = '', $sub = '')
    {
        $this->_get_datatables_queryc($opt, $sub);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	
    function count_filteredc($opt = '', $sub = '')
    {
        $this->_get_datatables_queryc($opt, $sub);
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_allc($opt = '', $sub = '')
    {
        $this->_get_datatables_queryc($opt, $sub);
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
        return $this->db->count_all_results();
    }
	
	
	
}