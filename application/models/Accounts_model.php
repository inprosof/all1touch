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


class Accounts_model extends CI_Model
{
    var $table = 'geopos_accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function accountslist($l=true,$lid=0)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($l) {
			if($this->aauth)
			{
				if($this->aauth->get_user())
				{
					if ($this->aauth->get_user()->loc) {
						$this->db->where('loc', $this->aauth->get_user()->loc);
						if (BDATA) $this->db->or_where('loc', 0);
					} else {
						if (!BDATA) $this->db->where('loc', 0);
					}
				}else{
					if (!BDATA) $this->db->where('loc', 0);
				}
			}else{
				if (!BDATA) $this->db->where('loc', 0);
			}
		} else {
            $this->db->where('loc', $lid);
        }

        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function getCurrency()
    {
        $this->db->select('geopos_currencies.id, geopos_currencies.code');
        $this->db->from('geopos_currencies');
		$this->db->join('geopos_locations', 'geopos_locations.cur = geopos_currencies.id', 'left');
		if($this->aauth->get_user()->loc > 0)
		{
			$this->db->where('geopos_locations.ext', $this->aauth->get_user()->loc);
		}
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function getacccountincome()
    {
        $this->db->select('geopos_accounts.id, geopos_accounts.holder');
        $this->db->from('geopos_accounts');
		$this->db->join('geopos_locations', 'geopos_locations.ext = geopos_accounts.id', 'left');
        $this->db->where('geopos_locations.ext', $this->aauth->get_user()->loc);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function details($acid, $trtt = true)
    {
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $acid);
		if($trtt)
		{
			if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if(BDATA)  
				$this->db->or_where('loc', 0);
				$this->db->group_end();
			}
		}
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addnew($accno, $holder, $intbal, $acode, $lid,$account_type)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'adate' => date('Y-m-d H:i:s'),
            'lastbal' => $intbal,
            'code' => $acode,
            'loc' => $lid,
            'account_type'=>$account_type
        );

        if ($this->db->insert('geopos_accounts', $data)) {
            $this->aauth->applog("[Account Created] $accno - $intbal ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED'). "  <a href='".base_url('accounts')."' class='btn btn-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a> <a href='add' class='btn btn-info btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($acid, $accno, $holder, $acode, $lid, $account_equity='', $account_type)
    {
        if($account_equity){
               $data = array(
				'acn' => $accno,
				'holder' => $holder,
				'code' => $acode,
				'loc' => $lid,
				'lastbal'=>$account_equity,
				'account_type'=>$account_type
			);
        }
        else{
               $data = array(
				'acn' => $accno,
				'holder' => $holder,
				'code' => $acode,
				'loc' => $lid,
				'account_type'=>$account_type
			);
        }

        $this->db->set($data);
        $this->db->where('id', $acid);
         if ($this->aauth->get_user()->loc) {
           $this->db->where('loc', $this->aauth->get_user()->loc);
         }

        if ($this->db->update('geopos_accounts')) {
            $this->aauth->applog("[Account Edited] $accno - ID " . $acid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	
	var $column_order = array(null, 'geopos_accounts.acn', 'geopos_accounts.holder', 'geopos_accounts.lastbal', 'geopos_accounts.account_type', null);
    var $column_search = array('geopos_accounts.id', 'geopos_accounts.acn', 'geopos_accounts.holder', 'geopos_accounts.lastbal', 'geopos_accounts.account_type', 'geopos_accounts.adate');
    var $order = array('geopos_accounts.acn' => 'DESC');
	
	private function _get_datatables_query()
    {
		$this->db->select('geopos_accounts.id, geopos_accounts.acn, geopos_accounts.holder, geopos_accounts.lastbal, geopos_accounts.account_type, geopos_accounts.adate');
        $this->db->from($this->table);
        if($this->aauth)
		{
			if($this->aauth->get_user())
			{
				if ($this->aauth->get_user()->loc) {
					$this->db->where('loc', $this->aauth->get_user()->loc);
					if (BDATA) $this->db->or_where('loc', 0);
				} else {
					if (!BDATA) $this->db->where('loc', 0);
				}
			}else{
				if (!BDATA) $this->db->where('loc', 0);
			}
		}else{
			if (!BDATA) $this->db->where('loc', 0);
		}
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function acco_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_accounts.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_accounts.loc', 0); }
        $query = $this->db->get();
        return $query->result();
    }

    function acco_count_filtered($eid)
    {
        $this->_get_datatables_query();
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_accounts.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_accounts.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function acco_count_all($eid)
    {
        $this->db->select('geopos_accounts.id');
        $this->db->from($this->table);
         if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_accounts.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_accounts.loc', 0); }
        if ($eid) $this->db->where('geopos_accounts.eid', $eid);
        return $this->db->count_all_results();
    }
	
		
    public function account_stats()
    {
        $whr = ' ';
        if ($this->aauth->get_user()->loc) {
            $whr = ' WHERE loc=' . $this->aauth->get_user()->loc;
             if(BDATA) $whr .= 'OR loc=0 ';
        }

        $query = $this->db->query("SELECT SUM(lastbal) AS balance,COUNT(id) AS count_a FROM geopos_accounts $whr");

        $result = $query->row_array();
        echo json_encode(array(0 => array('balance' => amountExchange($result['balance'], 0, $this->aauth->get_user()->loc), 'count_a' => $result['count_a'])));

    }

}