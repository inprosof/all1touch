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

class Clientgroup_model extends CI_Model
{
    public function details($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_cust_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recipients($id)
    {
        $this->db->select('id,name,email');
        $this->db->from('geopos_customers');
        $this->db->where('gid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );

        if ($this->db->insert('geopos_cust_group', $data)) {
            //$this->aauth->applog("[Group Created] $group_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function editgroupupdate($gid, $group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );
        $this->db->set($data);
        $this->db->where('id', $gid);
        if ($this->db->update('geopos_cust_group')) {
            //$this->aauth->applog("[Group updated] $group_name ID " . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function editgroupdiscountupdate($gid, $disc_rate)
    {
        $data = array(
            'disc_rate' => $disc_rate
        );
        $this->db->set($data);
        $this->db->where('id', $gid);
        if ($this->db->update('geopos_cust_group')) {

            $data = array(
                'discount_c' => $disc_rate
            );
            $this->db->set($data);
            $this->db->where('gid', $gid);
            $this->db->update('geopos_customers');

            //$this->aauth->applog("[Group discount updated] %" . $disc_rate . " GID-" . $gid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	
	public function grup_clin_sum($id, $eid = '')
    {
		$query = $this->db->query("SELECT count(r.id) as num_cli FROM geopos_customers as r inner join geopos_cust_group as y on r.gid = y.id where r.gid=".$id);
		return $query->row_array();
	}
	
	var $table = 'geopos_cust_group';
    var $column_order = array(null, 'geopos_cust_group.title','geopos_cust_group.summary, geopos_cust_group.disc_rate');
    var $column_search = array('geopos_cust_group.id', 'geopos_cust_group.title','geopos_cust_group.summary, geopos_cust_group.disc_rate');
    var $order = array('geopos_cust_group.title' => 'desc');
	
	private function _get_datatables_query($id = '', $w = '')
    {
        $this->db->select("geopos_cust_group.id, geopos_cust_group.title, geopos_cust_group.summary, case when geopos_cust_group.disc_rate is null then '0.00' else geopos_cust_group.disc_rate end disc_rate");
        $this->db->from($this->table);
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
}