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

class Quote_model extends CI_Model
{
    var $table = 'geopos_quotes';
    var $column_order = array(null, 'geopos_series.serie AS serie_name', 'geopos_quotes.tid', 'geopos_customers.name', 'geopos_quotes.invoicedate', 'geopos_quotes.total', 'geopos_quotes.status', null);
    var $column_search = array('geopos_series.serie AS serie_name', 'geopos_quotes.tid', 'geopos_customers.name', 'geopos_quotes.invoicedate', 'geopos_quotes.total','geopos_quotes.status',);
    var $order = array('geopos_quotes.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
       if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
          if(BDATA)  $this->db->or_where('loc', 0);
        }  elseif(!BDATA) { $this->db->where('loc', 0); }


        $query = $this->db->get();
        return $query->result_array();

    }

	public function quote_details($id)
    {
		if($this->aauth->get_user()->loc == 0)
		{
			$this->db->select("geopos_quotes.*, 
			geopos_data_transport.autoid,
			geopos_data_transport.expedition,
			geopos_data_transport.exp_date,
			geopos_data_transport.exp_mat,
			geopos_data_transport.exp_des,
			geopos_data_transport.charge_address,
			geopos_data_transport.charge_postbox,geopos_data_transport.charge_city,geopos_data_transport.charge_country,geopos_data_transport.discharge_address,
			geopos_data_transport.discharge_postbox,
			geopos_data_transport.discharge_city,
			geopos_data_transport.discharge_country, 
			geopos_quotes.id as iddoc, CASE WHEN geopos_locations.address = '' THEN geopos_system.address ELSE geopos_locations.address END AS loc_name
			, CASE WHEN geopos_locations.address = '' THEN geopos_system.address ELSE geopos_locations.address END AS loc_adress
			, CASE WHEN geopos_locations.postbox = '' THEN geopos_system.postbox ELSE geopos_locations.postbox END AS loc_postbox
			, CASE WHEN geopos_locations.city = '' THEN geopos_system.city ELSE geopos_locations.city END AS loc_city
			, CASE WHEN geopos_locations.country = '' THEN geopos_system.country ELSE geopos_locations.country END AS loc_country,
			CASE WHEN geopos_locations.cname = '' OR geopos_locations.cname IS NULL 
			THEN 
				CASE WHEN w2.title is null or w2.title = '' 
					THEN 'Todos' 
				ELSE w2.title 
				END 
			ELSE w1.title 
			END AS loc_cname,
			CASE WHEN geopos_locations.taxid = '' THEN geopos_system.taxid ELSE geopos_locations.taxid END AS loc_taxid,
			geopos_system.zon_fis AS loc_zon_fis, geopos_system.certification as loc_certification, 
			CASE WHEN geopos_accounts.acn = '' OR geopos_accounts.acn IS NULL THEN 'Sem Informação Disponível' ELSE geopos_accounts.acn END as loc_contabancaria,
			geopos_currencies.code as multiname, geopos_series.serie AS serie_name, geopos_series.atc AS atc_serie, geopos_irs_typ_doc.type AS irs_type_s, geopos_irs_typ_doc.description AS irs_type_n, 
			c1.val2 as expd_t, c1.val1 as expd_name, c2.val1 as propdue_name, geopos_assets.assest_name as autoid_name,l1.name as charge_country_name, l2.name as discharge_country_name,
			SUM(geopos_quotes.shipping + geopos_quotes.ship_tax) AS shipping,geopos_customers.*,
			copys.val2 as numcop,
			geopos_quotes.loc as loc,geopos_quotes.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms");
		}else{
			$this->db->select("geopos_quotes.*, 
			geopos_data_transport.autoid,
			geopos_data_transport.expedition,
			geopos_data_transport.exp_date,
			geopos_data_transport.exp_mat,
			geopos_data_transport.exp_des,
			geopos_data_transport.charge_address,
			geopos_data_transport.charge_postbox,geopos_data_transport.charge_city,geopos_data_transport.charge_country,geopos_data_transport.discharge_address,
			geopos_data_transport.discharge_postbox,
			geopos_data_transport.discharge_city,
			geopos_data_transport.discharge_country,
			geopos_quotes.id as iddoc, CASE WHEN geopos_locations.address = '' THEN geopos_system.address ELSE geopos_locations.address END AS loc_name
			, CASE WHEN geopos_locations.address = '' THEN geopos_system.address ELSE geopos_locations.address END AS loc_adress
			, CASE WHEN geopos_locations.postbox = '' THEN geopos_system.postbox ELSE geopos_locations.postbox END AS loc_postbox
			, CASE WHEN geopos_locations.city = '' THEN geopos_system.city ELSE geopos_locations.city END AS loc_city
			, CASE WHEN geopos_locations.country = '' THEN geopos_system.country ELSE geopos_locations.country END AS loc_country,
			CASE WHEN geopos_locations.cname = '' OR geopos_locations.cname IS NULL 
			THEN 
				CASE WHEN w2.title is null or w2.title = '' 
					THEN 'Todos' 
				ELSE w2.title 
				END 
			ELSE w1.title 
			END AS loc_cname,
			CASE WHEN geopos_locations.taxid = '' THEN geopos_system.taxid ELSE geopos_locations.taxid END AS loc_taxid,
			geopos_locations.zon_fis AS loc_zon_fis, geopos_system.certification as loc_certification, 
			CASE WHEN geopos_accounts.acn = '' OR geopos_accounts.acn IS NULL THEN 'Sem Informação Disponível' ELSE geopos_accounts.acn END as loc_contabancaria,
			geopos_currencies.code as multiname, geopos_series.serie AS serie_name, geopos_series.atc AS atc_serie, geopos_irs_typ_doc.type AS irs_type_s, geopos_irs_typ_doc.description AS irs_type_n, 
			c1.val2 as expd_t, c1.val1 as expd_name, c2.val1 as propdue_name, geopos_assets.assest_name as autoid_name,l1.name as charge_country_name, l2.name as discharge_country_name,
			SUM(geopos_quotes.shipping + geopos_quotes.ship_tax) AS shipping,geopos_customers.*,
			copys.val2 as numcop,
			geopos_quotes.loc as loc,geopos_quotes.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms");
		}
		$this->db->from($this->table);
		$this->db->join('geopos_data_transport', 'geopos_quotes.id=geopos_data_transport.tid', 'left');
		$this->db->join('geopos_assets', 'geopos_data_transport.autoid = geopos_assets.id', 'left');
		$this->db->join('geopos_countrys as l1', 'geopos_data_transport.charge_country = l1.prefix', 'left');
		$this->db->join('geopos_countrys as l2', 'geopos_data_transport.discharge_country = l2.prefix', 'left');
		$this->db->join('geopos_config as c1', 'c1.id = geopos_data_transport.expedition', 'left');
		$this->db->join('geopos_accounts', "geopos_accounts.loc = geopos_quotes.loc and geopos_accounts.payonline = 'Yes'", 'left');
		$this->db->join('geopos_system', 'geopos_system.id = 1', 'left');
		$this->db->join('geopos_locations', 'geopos_locations.id = geopos_quotes.loc', 'left');
		$this->db->join('geopos_warehouse as w1', 'geopos_locations.ware=w1.id', 'left');
		$this->db->join('geopos_warehouse as w2', 'geopos_quotes.loc=w2.id', 'left');
		$this->db->join('geopos_currencies', 'geopos_currencies.id = geopos_quotes.multi', 'left');
		$this->db->join('geopos_irs_typ_doc', 'geopos_quotes.irs_type = geopos_irs_typ_doc.id', 'left');
		$this->db->join('geopos_documents_copys', 'geopos_quotes.loc = geopos_documents_copys.loc and geopos_quotes.irs_type = geopos_documents_copys.typ_doc', 'inner');
		$this->db->join('geopos_config as copys', 'geopos_documents_copys.copy = copys.id', 'left');
		$this->db->join('geopos_series', 'geopos_series.id = geopos_quotes.serie', 'left');
        $this->db->join('geopos_customers', 'geopos_quotes.csd = geopos_customers.id', 'left');
        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_quotes.term', 'left');
		$this->db->join('geopos_config as c2', 'c2.id = geopos_quotes.prop_due', 'left');
		$this->db->where('geopos_series.predf', 1);
        $this->db->where('geopos_quotes.id', $id);
        $query = $this->db->get();
        return $query->row_array();

    }

    public function quote_products($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_quotes_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function quote_delete($id)
    {
        $this->db->trans_start();
          if ($this->aauth->get_user()->loc) {
                $res = $this->db->delete('geopos_quotes', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));
        }
        else {
            if (BDATA) {
                    $res = $this->db->delete('geopos_quotes', array('id' => $id));

            } else {
                    $res = $this->db->delete('geopos_quotes', array('id' => $id,'loc' => 0));
            }
        }
        if ($this->db->affected_rows()) $this->db->delete('geopos_quotes_items', array('tid' => $id));
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query($opt,$typ)
    {
        $this->db->select('geopos_quotes.id,geopos_series.serie AS serie_name,geopos_quotes.tid,geopos_quotes.invoicedate,geopos_quotes.i_class,
		geopos_quotes.invoiceduedate,geopos_quotes.total,geopos_assets.assest_name as viatura,geopos_quotes.status,geopos_customers.name, geopos_customers.taxid, geopos_irs_typ_doc.type');
        $this->db->from($this->table);
		$this->db->where('geopos_quotes.i_class', $typ);
		if ($opt) {
            $this->db->where('geopos_quotes.eid', $opt);
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) 
		{
			$this->db->where('geopos_quotes.loc', 0); 
		}
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_quotes.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_quotes.invoicedate) <=', datefordatabase($this->input->post('end_date')));
        }
		
		$this->db->join('geopos_data_transport', 'geopos_quotes.id=geopos_data_transport.tid', 'left');
		$this->db->join('geopos_assets', 'geopos_data_transport.autoid=geopos_assets.id', 'left');
        $this->db->join('geopos_customers', 'geopos_quotes.csd=geopos_customers.id', 'left');
		$this->db->join('geopos_irs_typ_doc', 'geopos_quotes.irs_type = geopos_irs_typ_doc.id', 'left');
		$this->db->join('geopos_series', 'geopos_series.id = geopos_quotes.serie', 'left');
		
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

    function get_datatables($opt = '', $typ = 0)
    {
        $this->_get_datatables_query($opt,$typ);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($opt = '', $typ = 0)
    {
        $this->_get_datatables_query($opt,$typ);
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '', $typ = 0)
    {
		$this->_get_datatables_query($opt,$typ);
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_quotes.loc', $this->aauth->get_user()->loc);
        }  elseif(!BDATA) { $this->db->where('geopos_quotes.loc', 0); }
        return $this->db->count_all_results();
    }

    public function employee($id)
    {
        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid,geopos_hrm.val1 as depart_employee');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
		$this->db->join('geopos_hrm', 'geopos_hrm.id = geopos_employees.dept', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function convert($id)
    {
        $invoice = $this->quote_details($id);
        $products = $this->quote_products($id);
        $this->db->trans_start();
        $this->db->select('tid');
        $this->db->from('geopos_invoices');
        $this->db->where('i_class', 0);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;
        if($invoice['loc']==$this->aauth->get_user()->loc) {
            $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $invoice['csd'], 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term'],'multi' => $invoice['multi'], 'loc' => $invoice['loc']);
            $this->db->insert('geopos_invoices', $data);
            $iid = $this->db->insert_id();
            foreach ($products as $row) {
                $amt = $row['qty'];
                $data = array(
                    'tid' => $iid,
                    'pid' => $row['pid'],
                    'product' => $row['product'],
                    'code' => $row['code'],
                    'qty' => $amt,
                    'price' => $row['price'],
                    'tax' => $row['tax'],
                    'discount' => $row['discount'],
                    'subtotal' => $row['subtotal'],
                    'totaltax' => $row['totaltax'],
                    'totaldiscount' => $row['totaldiscount'],
                    'product_des' => $row['product_des'],
                    'unit' => $row['unit']
                );
                $productlist[$prodindex] = $data;
                $prodindex++;
                $this->db->set('qty', "qty-$amt", FALSE);
                $this->db->where('pid', $row['pid']);
                $this->db->update('geopos_products');
            }


            $this->db->insert_batch('geopos_invoice_items', $productlist);


            //profit calculation
            $t_profit = 0;
            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
            $this->db->where('geopos_invoice_items.tid', $iid);
            $query = $this->db->get();
            $pids = $query->result_array();
            foreach ($pids as $profit) {
                $t_cost = $profit['fproduct_price'] * $profit['qty'];
                $s_cost = $profit['price'] * $profit['qty'];
                $t_profit += $s_cost - $t_cost;
            }
            $data = array('type' => 9, 'rid' => $iid, 'col1' => rev_amountExchange_s($t_profit, $invoice['multi'], $this->aauth->get_user()->loc), 'd_date' => $invoice['invoicedate']);

            $this->db->insert('geopos_metadata', $data);

            if ($this->db->trans_complete()) {
                $this->db->set('status', 'accepted');
                $this->db->where('id', $id);
                $this->db->update('geopos_quotes');
                return true;
            } else {
                return false;
            }
        }else{
                return false;
        }

    }

    public function convert_po($id,$person)
    {
        $invoice = $this->quote_details($id);
        $products = $this->quote_products($id);
        $this->db->trans_start();
        $this->db->select('tid');
        $this->db->from('geopos_purchase');
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;
        if($invoice['loc']==$this->aauth->get_user()->loc) {
            $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $person, 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term'],'multi' => $invoice['multi'], 'ext' => 0, 'loc' => $invoice['loc']);
            $this->db->insert('geopos_purchase', $data);
            $iid = $this->db->insert_id();
            foreach ($products as $row) {
                $amt = $row['qty'];
                $data = array(
                    'tid' => $iid,
                    'pid' => $row['pid'],
                    'product' => $row['product'],
                    'code' => $row['code'],
                    'qty' => $amt,
                    'price' => $row['price'],
                    'tax' => $row['tax'],
                    'discount' => $row['discount'],
                    'subtotal' => $row['subtotal'],
                    'totaltax' => $row['totaltax'],
                    'totaldiscount' => $row['totaldiscount'],
                    'product_des' => $row['product_des'],
                    'unit' => $row['unit']
                );
                $productlist[$prodindex] = $data;
                $prodindex++;
                //$this->db->set('qty', "qty+$amt", FALSE);
                //$this->db->where('pid', $row['pid']);
                //$this->db->update('geopos_products');
            }
            $this->db->insert_batch('geopos_purchase_items', $productlist);
            if ($this->db->trans_complete()) {
                $this->db->set('status', 'accepted');
                $this->db->where('id', $id);
                $this->db->update('geopos_quotes');
                return true;
            } else {
                return false;
            }
        }else{

                return false;

        }

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

    public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('geopos_metadata', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('geopos_metadata.*');
        $this->db->from('geopos_metadata');
        $this->db->where('geopos_metadata.type', 2);
        $this->db->where('geopos_metadata.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id, $type, $name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }


}