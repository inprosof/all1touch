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

class Extended_invoices_model extends CI_Model
{
    var $table = 'geopos_invoice_items';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoice_items.subtotal', 'geopos_invoice_items.qty', 'geopos_invoice_items.discount','geopos_invoice_items.tax');
    var $column_search = array('geopos_series.serie', 'geopos_customers.name', 'geopos_invoices.invoicedate', 'geopos_invoice_items.subtotal','geopos_invoice_items.qty','geopos_invoice_items.tax');
    var $order = array('geopos_invoices.tid' => 'desc');
	
    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query($opt = '')
    {
        $this->db->select("geopos_invoices.id,geopos_series.serie AS serie_name,geopos_invoices.tid,
		geopos_invoices.invoicedate, geopos_customers.name, geopos_customers.taxid, 
		geopos_invoices.subtotal, 
		geopos_invoices.tax, 
		geopos_invoices.total, 
		geopos_invoices.status, geopos_invoices.pamnt, 
		geopos_invoices.invoiceduedate,
		geopos_irs_typ_doc.type,
		geopos_invoices.discount,
		geopos_invoice_items.qty,
		CASE WHEN geopos_locations.cname = '' OR geopos_locations.cname IS NULL 
			THEN 
				CASE WHEN w2.title is null or w2.title = '' 
					THEN 'Todos' 
				ELSE w2.title 
				END 
			ELSE w1.title 
			END AS loc_cname");
        $this->db->from($this->table);
        //$this->db->where('geopos_invoices.i_class', 1);
        $this->db->where('geopos_invoices.status !=', 'canceled');
		$this->db->where('geopos_invoices.ext', 0);
        if ($opt) {
            $this->db->where('geopos_invoices.eid', $opt);
        }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { 
			$this->db->where('geopos_invoices.loc', 0); }
        $this->db->join('geopos_invoices', 'geopos_invoices.id=geopos_invoice_items.tid', 'left');
		$this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
		$this->db->join('geopos_irs_typ_doc', 'geopos_invoices.irs_type = geopos_irs_typ_doc.id', 'left');
		$this->db->join('geopos_series', 'geopos_series.id = geopos_invoices.serie', 'left');
		$this->db->join('geopos_locations', 'geopos_locations.id = geopos_invoices.loc', 'left');
		$this->db->join('geopos_warehouse as w1', 'geopos_locations.ware=w1.id', 'left');
		$this->db->join('geopos_warehouse as w2', 'geopos_invoices.loc=w2.id', 'left');
		
		
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

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->_get_datatables_query($opt);
        return $this->db->count_all_results();
    }



}