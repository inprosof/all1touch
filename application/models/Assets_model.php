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
			$query = $this->db->query("SELECT a.*,b.title as cat_name, b.type as acattype, case when t.title is null then 'Empresa' else t.title end as warehouse_name 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										left join geopos_warehouse as t on a.warehouse = t.id where a.id=".$id);
		}else{
			$query = $this->db->query("SELECT a.*,b.title as cat_name, b.type as acattype, case when t.title is null then 'Empresa' else t.title end as warehouse_name 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										left join geopos_warehouse as t on a.warehouse = t.id where a.id=".$id." and a.employee_id = ".$eid);
		}
		
		return $query->row_array();
	}

    public function get_assest(){
		$query = "";
		if($this->aauth->get_user()->loc == 0)
		{
			$query = $this->db->query("SELECT  a.*,b.title as cat_name, case when t.title is null then 'Empresa' else t.title end as warehousename 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										left join geopos_warehouse as t on a.warehouse = t.id");
		}else{
			$query = $this->db->query("SELECT  a.*,b.title as cat_name, case when t.title is null then 'Empresa' else t.title end as warehousename 
										FROM geopos_assets as a 
										inner join geopos_assets_cat as b on b.id = a.acat 
										left join geopos_warehouse as t on a.warehouse = t.id where t.loc =".$this->aauth->get_user()->loc);
		}
        return $query->result_array();
    }
    private function _get_datatables_query($id = '', $w = '')
    {
        $this->db->select("geopos_assets.id, geopos_assets.assest_name, geopos_assets_cat.title as cat_name, case when geopos_warehouse.title is null then 'Empresa' else geopos_warehouse.title end as warehousename, geopos_assets.qty, geopos_assets.product_des");
        $this->db->from($this->table);
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_assets.warehouse', 'left');
		$this->db->join('geopos_assets_cat', 'geopos_assets_cat.id = geopos_assets.acat', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
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
        $this->_get_datatables_query($opt = '');
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	
    function count_filtered($opt = '')
    {
        $this->_get_datatables_query();
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all($opt = '')
    {
        $this->_get_datatables_query();
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
        return $this->db->count_all_results();
    }



    public function add($catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id) {
	   $data = array(
				'acat' => $catid,
				'warehouse' => $warehouse,
				'assest_name' => $product_name,
				'qty' => $product_qty,
				'product_des' => $product_desc,
				'inspection_date' => $inspection_date,
				'insurance_date' => $insurance_date,
				'employee_id' => $employee_id
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

    public function edit($pid, $catid, $warehouse, $product_name, $product_qty, $product_desc, $inspection_date, $insurance_date, $employee_id) {
		   $data = array(
				'acat' => $catid,
				'warehouse' => $warehouse,
				'assest_name' => $product_name,
				'qty' => $product_qty,
				'product_des' => $product_desc,
				'inspection_date' => $inspection_date,
				'insurance_date' => $insurance_date,
				'employee_id' => $employee_id
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
	
	public function assetscat_sum($id, $eid = '')
    {
		$query = $this->db->query("SELECT sum(r.qty) as num_ass FROM geopos_assets as r inner join geopos_assets_cat as y on r.acat = y.id where r.acat=".$id);
		return $query->row_array();
	}
	
	public function assetscat_details($id, $eid = '')
    {
		$query = $this->db->query("SELECT r.*, y.name as type_name FROM geopos_assets_cat as r inner join geopos_assets_cat_type as y on r.type = y.id where r.id=".$id);
		return $query->row_array();
	}
	
	public function category_list($type = 0, $rel = 0)
    {
        $query = $this->db->query("SELECT id,title,type FROM geopos_assets_cat");
        return $query->result_array();
    }

	public function category_type_list($type = 0, $rel = 0)
    {
        $query = $this->db->query("SELECT id,name FROM geopos_assets_cat_type");
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



    public function category_stock()
    {
		$query = $this->db->query("SELECT id,title FROM geopos_assets_cat");
        return $query->result_array();
    }
	
	public function addc($cat_name,$cat_ty_name)
    {
        $data = array(
            'title' => $cat_name,
			'type' => $cat_ty_name,
        );
		
		$url = "<a href='addc' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='cats' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        if ($this->db->insert('geopos_assets_cat', $data)) {
            //$this->aauth->applog("[Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	
	public function editc($catid, $product_cat_name, $asset_cat_type)
    {
        $data = array(
            'title' => $product_cat_name,
			'type' => $asset_cat_type,
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
	
	
	private function _get_datatables_queryc($id = '')
    {
        $this->db->select("geopos_assets_cat.id, geopos_assets_cat.title, geopos_assets_cat_type.name as cat_name");
        $this->db->from($this->table1);
        $this->db->join('geopos_assets_cat_type', 'geopos_assets_cat_type.id = geopos_assets_cat.type', 'left');
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

    function get_datatablesc($opt = '')
    {
        $this->_get_datatables_queryc();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	
    function count_filteredc($opt = '')
    {
        $this->_get_datatables_queryc();
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_allc($opt = '')
    {
        $this->db->from($this->table1);
		if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
        return $this->db->count_all_results();
    }
	
	
	
}