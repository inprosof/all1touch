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

class Dashboard_model extends CI_Model
{
    public function todayInvoice($today)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->where($where);
        $this->db->from('geopos_invoices');
		$this->db->where('ext', 0);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        return $this->db->count_all_results();

    }
	
	public function tot_artigos()
    {
		$this->db->select('id');
        $this->db->from('geopos_products');
		$this->db->join('geopos_warehouse', 'geopos_warehouse.loc = geopos_products.warehouse', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
		return $this->db->count_all_results();
	}
	
	public function tot_invoice()
    {
		$this->db->select('id');
        $this->db->from('geopos_invoices');
		$this->db->where('geopos_invoices.i_class', 0);
		$this->db->where('geopos_invoices.ext', 0);
		$this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_invoices.loc', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
		return $this->db->count_all_results();
	}	

	public function tot_pos_invoice()
    {
		$this->db->select('id');
        $this->db->from('geopos_invoices');
		$this->db->where('geopos_invoices.i_class', 1);
		$this->db->where('geopos_invoices.ext', 0);
		$this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_invoices.loc', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_warehouse.loc', 0);
        }
		return $this->db->count_all_results();
	}

	public function tot_employees()
    {
		$this->db->select('id');
        $this->db->from('geopos_employees');
		$this->db->where('geopos_employees.system', 0);
		$this->db->join('geopos_users', 'geopos_users.username = geopos_employees.username', 'left');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_users.loc', 0);
        }
		return $this->db->count_all_results();
	}
	
	public function tot_supliers()
    {
		$this->db->select('id');
        $this->db->from('geopos_supplier');
		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_supplier.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_supplier.loc', 0);
        }
		return $this->db->count_all_results();
	}
	
	public function tot_projects()
    {
		$this->db->select('id');
        $this->db->from('geopos_projects');

		if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_projects.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_projects.loc', 0);
        }
		return $this->db->count_all_results();
	}
	
	public function get_ativ_saft()
	{
		if ($this->aauth->get_user()->loc) {
			$query1 = "select CASE WHEN docs IS NULL THEN '0' WHEN docs = '' THEN '0' WHEN docs = '0' THEN '0' ELSE docs_date END AS data_saft_docs,
								CASE WHEN guides IS NULL THEN '0' WHEN guides = '' THEN '0' WHEN guides = '0' THEN '0' ELSE guides_date END AS data_saft_transporte
								from geopos_saft_autentications where loc = ".$this->aauth->get_user()->loc."";
			
		}else{
			$query1 = "select CASE WHEN docs IS NULL THEN '0' WHEN docs = '' THEN '0' WHEN docs = '0' THEN '0' ELSE docs_date END AS data_saft_docs,
								CASE WHEN guides IS NULL THEN '0' WHEN guides = '' THEN '0' WHEN guides = '0' THEN '0' ELSE guides_date END AS data_saft_transporte
								from geopos_saft_autentications where loc=0";
		}
		$query = $this->db->query($query1);
		$result =$query->row_array();
		if(empty($result)){
			$result['data_saft_docs'] = '';
			$result['data_saft_transporte'] = '';
		}		
        return $result;
	}
	
	public function get_caixa_activ()
	{
		if ($this->aauth->get_user()->loc) {
			$query1 = "select CASE WHEN caixa_vat4 IS NULL THEN '0' WHEN caixa_vat4 = '' THEN '0' ELSE caixa_date END AS data_activ_caixa_iva
								from geopos_saft_autentications where loc= ".$this->aauth->get_user()->loc."";
		}else{
			$query1 = "select CASE WHEN caixa_vat4 IS NULL THEN '0' WHEN caixa_vat4 = '' THEN '0' ELSE caixa_date END AS data_activ_caixa_iva
								from geopos_saft_autentications where loc=0";
		}
		$query = $this->db->query($query1);
		$result =$query->row_array();
		if(empty($result)){
			$result['data_activ_caixa_iva'] = '';
		}
        return $result;
	}
	
	public function get_all_info_done()
    {
		$query1 = "";
		if ($this->aauth->get_user()->loc) {
			$query1 = "select acc.n_accounts, 
					caes.n_cae, negoc.n_emp_email, negoc.n_emp_nif, negoc.n_emp_conta_d, negoc.n_emp_conta_o, negoc.n_emp_conta_f, negoc.n_emp_armazem, empp.n_emp_registration, empp.n_emp_conservator, negoc.n_emp_logo, negoc.n_emp_phone,
					series.n_series, cronss.n_cron_num, emails.n_email_host, emails.n_email_username, emails.n_email_password, warehouses.n_warehouse,
					permiss.n_grafics, permiss.n_email_app,permiss.n_emailo_remet,permiss.n_email_stock
					from(select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_accounts from geopos_accounts where loc = ".$this->aauth->get_user()->loc.") as acc
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_cae from geopos_caes) as caes on 1=1
					left join (select CASE WHEN email_app IS NULL or email_app = '' THEN '0' ELSE email_app END AS n_email_app,
										CASE WHEN emailo_remet IS NULL or emailo_remet = '' THEN '0' ELSE emailo_remet END AS n_emailo_remet,
										CASE WHEN email_stock IS NULL or email_stock = '' THEN '0' ELSE email_stock END AS n_email_stock,grafics AS n_grafics from geopos_system_permiss where loc = ".$this->aauth->get_user()->loc.") as permiss on 1=1
					left join (select CASE WHEN registration IS NULL THEN 0 WHEN registration = '' THEN '0' ELSE registration END AS n_emp_registration,
										CASE WHEN conservator IS NULL THEN 0 WHEN conservator = '' THEN '0' ELSE conservator END AS n_emp_conservator from geopos_system) as empp on 1=1
					left join (select CASE WHEN geopos_locations.email IS NULL THEN 0 WHEN geopos_locations.email = '' THEN '0' ELSE geopos_locations.email END AS n_emp_email,
										CASE WHEN geopos_locations.taxid IS NULL THEN 0 WHEN geopos_locations.taxid = '' THEN '0' ELSE geopos_locations.taxid END AS n_emp_nif,
										CASE WHEN geopos_locations.ware IS NULL THEN 0 WHEN geopos_locations.ware = '' THEN '0' ELSE geopos_locations.ware END AS n_emp_armazem,
										CASE WHEN geopos_locations.acount_o IS NULL THEN 0 WHEN geopos_locations.acount_o = '' THEN 0 ELSE geopos_locations.acount_o END AS n_emp_conta_d,
										CASE WHEN geopos_locations.acount_d IS NULL THEN 0 WHEN geopos_locations.acount_d = '' THEN 0 ELSE geopos_locations.acount_d END AS n_emp_conta_o,
										CASE WHEN geopos_locations.acount_f IS NULL THEN 0 WHEN geopos_locations.acount_f = '' THEN 0 ELSE geopos_locations.acount_f END AS n_emp_conta_f,
										CASE WHEN geopos_locations.logo IS NULL THEN 0 WHEN geopos_locations.logo = '' THEN '0' ELSE geopos_locations.logo END AS n_emp_logo,
										CASE WHEN geopos_locations.phone IS NULL THEN 0 WHEN geopos_locations.phone = '+351900000000' THEN 0 ELSE geopos_locations.phone END AS n_emp_phone 
										from geopos_locations where geopos_locations.id = ".$this->aauth->get_user()->loc.") as negoc on 1=1
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_series from geopos_series where loc = ".$this->aauth->get_user()->loc.") as series on 1=1
					left join (select CASE WHEN key1 = '0' THEN '0' ELSE key1 END AS n_cron_num from univarsal_api where id = 55) as cronss on 1=1
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_warehouse from geopos_warehouse where geopos_warehouse.loc = ".$this->aauth->get_user()->loc.") as warehouses on 1=1
					left join (select CASE WHEN geopos_smtp.host IS NULL THEN '0' WHEN geopos_smtp.host = 'inserirhost' THEN '0' ELSE geopos_smtp.host END AS n_email_host,
										CASE WHEN geopos_smtp.username IS NULL THEN '0' WHEN geopos_smtp.username = 'inserirutilizador' THEN '0' ELSE geopos_smtp.username END AS n_email_username,
										CASE WHEN geopos_smtp.password IS NULL THEN '0' WHEN geopos_smtp.password = 'inserirsenha' THEN '0' ELSE geopos_smtp.password END AS n_email_password from geopos_smtp) as emails on 1=1";
		}else{
			$query1 = "select acc.n_accounts, 
					caes.n_cae, empp.n_emp_email, empp.n_emp_nif, empp.n_emp_conta_d, empp.n_emp_conta_o, empp.n_emp_conta_f, empp.n_emp_armazem, empp.n_emp_registration, empp.n_emp_conservator, empp.n_emp_logo, empp.n_emp_phone,
					series.n_series, cronss.n_cron_num, emails.n_email_host, emails.n_email_username, emails.n_email_password, warehouses.n_warehouse,
					permiss.n_grafics, permiss.n_email_app,permiss.n_emailo_remet,permiss.n_email_stock
					from(select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_accounts from geopos_accounts where loc = 0) as acc
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_cae from geopos_caes) as caes on 1=1
					left join (select CASE WHEN email_app IS NULL or email_app = '' THEN '0' ELSE email_app END AS n_email_app,
										CASE WHEN emailo_remet IS NULL or emailo_remet = '' THEN '0' ELSE emailo_remet END AS n_emailo_remet,
										CASE WHEN email_stock IS NULL or email_stock = '' THEN '0' ELSE email_stock END AS n_email_stock,grafics AS n_grafics from geopos_system_permiss where loc = 0) as permiss on 1=1
					left join (select CASE WHEN email IS NULL THEN '0' WHEN email = '' THEN '0' ELSE email END AS n_emp_email,
										CASE WHEN taxid IS NULL THEN '0' WHEN taxid = '' THEN '0' ELSE taxid END AS n_emp_nif,
										'".DOCSACCOUNT."' as n_emp_conta_d,
										'".POSACCOUNT."' as n_emp_conta_o,
										'".DOCSFACCOUNT."' as n_emp_conta_f,
										'1' as n_emp_armazem,
										CASE WHEN registration IS NULL THEN '0' WHEN registration = '' THEN '0' ELSE registration END AS n_emp_registration,
										CASE WHEN conservator IS NULL THEN '0' WHEN conservator = '' THEN '0' ELSE conservator END AS n_emp_conservator,
										CASE WHEN logo IS NULL THEN '0' WHEN logo = '' THEN '0' ELSE logo END AS n_emp_logo,
										CASE WHEN phone IS NULL THEN '0' WHEN phone = '+351900000000' THEN '0' ELSE phone END AS n_emp_phone from geopos_system) as empp on 1=1
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_warehouse from geopos_warehouse where geopos_warehouse.loc = 0) as warehouses on 1=1
					left join (select CASE WHEN count(id) IS NULL THEN '0' ELSE count(id) END AS n_series from geopos_series where loc = 0) as series on 1=1
					left join (select CASE WHEN key1 = '0' THEN '0' ELSE key1 END AS n_cron_num from univarsal_api where id = 55) as cronss on 1=1
					left join (select CASE WHEN geopos_smtp.host IS NULL THEN '0' WHEN geopos_smtp.host = 'inserirhost' THEN '0' ELSE geopos_smtp.host END AS n_email_host,
										CASE WHEN geopos_smtp.username IS NULL THEN '0' WHEN geopos_smtp.username = 'inserirutilizador' THEN '0' ELSE geopos_smtp.username END AS n_email_username,
										CASE WHEN geopos_smtp.password IS NULL THEN '0' WHEN geopos_smtp.password = 'inserirsenha' THEN '0' ELSE geopos_smtp.password END AS n_email_password from geopos_smtp) as emails on 1=1";
			
		}
		
		//var_dump($query1);
		//exit();
		$query = $this->db->query($query1);
		//var_dump($this->db->error());
		//exit();
        return $query->row_array();
	}
	
	
	
	
    public function todaySales($today)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
		$this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function todayInexp($today)
    {
		$this->db->select('SUM(debit) as debit,SUM(credit) as credit', FALSE);
        $this->db->where("DATE(date) ='$today'");
        $this->db->where("type!='Transfer'");
                if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recent_payments()
    {
		$this->db->select('geopos_transactions.*, geopos_config.val1 as methodname');
        $this->db->limit(13);
        $this->db->order_by('geopos_transactions.id', 'DESC');
              if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_transactions.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_transactions.loc', 0);
        }
        $this->db->from('geopos_transactions');
		$this->db->join('geopos_config', 'geopos_transactions.method = geopos_config.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function stock()
    {
        $whr = ' AND geopos_products.alert > 0';
        if ($this->aauth->get_user()->loc) {
			$whr .= ' AND (geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
			$whr .= ' AND (geopos_warehouse.loc=0)';
        }
        $query = $this->db->query("SELECT geopos_products.*,geopos_warehouse.title FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id  WHERE (geopos_products.qty<=geopos_products.alert) $whr ORDER BY geopos_products.product_name ASC LIMIT 10");
        return $query->result_array();
    }

    public function todayItems($today)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('geopos_invoices');
              if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
		$this->db->where('geopos_invoices.ext', 0);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->items;
    }

    public function todayProfit($today)
    {
        $where = "DATE(geopos_metadata.d_date) ='$today'";
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where($where);
		$this->db->where('geopos_invoices.ext', 0);
        $this->db->where('geopos_metadata.type', 9);
               if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->col1;
    }

    public function incomeChart($today, $month, $year)
    {
        $whr = '';
             if ($this->aauth->get_user()->loc) {
         $whr = ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
         $whr = ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT SUM(credit) AS total,date FROM geopos_transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND '$today') AND type='Income')  $whr GROUP BY date ORDER BY date DESC");
        return $query->result_array();
    }

    public function expenseChart($today, $month, $year)
    {
        $whr = '';
                   if ($this->aauth->get_user()->loc) {
         $whr = ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
         $whr = ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM geopos_transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND '$today') AND type='Expense')  $whr GROUP BY date ORDER BY date DESC");
        return $query->result_array();
    }

    public function countmonthlyChart()
    {
        $today = date('Y-m-d');
        $whr = ' AND ext = 0';
        if ($this->aauth->get_user()->loc) {
			$whr .= ' AND (loc=' . $this->aauth->get_user()->loc . ')';
        } elseif (!BDATA) {
			$whr .= ' AND (loc=0)';
        }
        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM geopos_invoices WHERE (DATE(invoicedate) BETWEEN '$today' - INTERVAL 30 DAY AND '$today')  $whr GROUP BY DATE(invoicedate) ORDER BY date DESC");
        return $query->result_array();
    }


    public function monthlyInvoice($month, $year)
    {
        $today = date('Y-m-d');
		$days=date("t", strtotime($today));
        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-$days' AND ext = 0";
        $this->db->where($where);
        $this->db->from('geopos_invoices');
              if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        return $this->db->count_all_results();

    }

    public function monthlySales($month, $year)
    {
        $today = date('Y-m-d');
		$days=date("t", strtotime($today));
        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-$days' AND ext = 0";
        $this->db->select_sum('total');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
              if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->total;
    }


    public function recentInvoices()
    {
        $whr = 'WHERE geopos_invoices.ext = 0';
		if ($this->aauth->get_user()->loc) {
			$whr .= ' AND (geopos_invoices.loc=' . $this->aauth->get_user()->loc . ') ';
        } elseif (!BDATA) {
			$whr .= ' AND (geopos_invoices.loc=0) ';
        }
        $query = $this->db->query("select geopos_invoices.id, geopos_invoices.i_class, geopos_series.serie AS serie_name,geopos_invoices.tid,geopos_invoices.invoicedate, 
		geopos_customers.name, geopos_customers.taxid, geopos_invoices.subtotal, geopos_invoices.tax, geopos_invoices.total, geopos_invoices.status, geopos_invoices.pamnt, geopos_invoices.invoiceduedate, geopos_irs_typ_doc.type,
		CASE WHEN geopos_locations.cname = '' OR geopos_locations.cname IS NULL 
			THEN 
				CASE WHEN w2.title is null or w2.title = '' 
					THEN 'Todos' 
				ELSE w2.title 
				END 
			ELSE w1.title 
			END AS loc_cname
		FROM geopos_invoices
		LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id
		LEFT JOIN geopos_irs_typ_doc ON geopos_invoices.irs_type = geopos_irs_typ_doc.id
		LEFT JOIN geopos_series ON geopos_series.id = geopos_invoices.serie
		LEFT JOIN geopos_locations ON geopos_locations.id = geopos_invoices.loc
		LEFT JOIN geopos_warehouse as w1 ON geopos_locations.ware=w1.id
		LEFT JOIN geopos_warehouse as w2 ON geopos_invoices.loc=w2.id
		$whr ORDER BY geopos_invoices.id DESC LIMIT 10");
        return $query->result_array();
    }

     public function recentBuyers()
    {
        $this->db->trans_start();
        $whr = '';
                if ($this->aauth->get_user()->loc) {
         $whr = ' WHERE (i.loc=' . $this->aauth->get_user()->loc . ') ';
        } elseif (!BDATA) {
           $whr = ' WHERE (i.loc=0) ';
        }
        $query = $this->db->query("SELECT MAX(i.id) AS iid,i.csd,SUM(i.total) AS total, c.cid,MAX(c.picture) as picture ,MAX(c.name) as name,MAX(i.status) as status FROM geopos_invoices AS i LEFT JOIN (SELECT geopos_customers.id AS cid, geopos_customers.picture AS picture, geopos_customers.name AS name FROM geopos_customers) AS c ON c.cid=i.csd $whr GROUP BY i.csd ORDER BY iid DESC LIMIT 10;");
        $result= $query->result_array();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
{
        return 'sql';
}
        else
        {
            return $result;
        }

    }

    public function tasks($id)
    {
        $query = $this->db->query("select * from geopos_todolist where eid = $id and (status = 'Progress' or status = 'Due') order by DATE(duedate), 'ASC' limit 10");
        $result = $query->result_array();
        return $result;
    }

    public function clockin($id)
    {
        $this->db->select('clock');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();
        if (!$emp['clock']) {
            $data = array(
                'clock' => 1,
                'clockin' => time(),
                'clockout' => 0
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockIn]  ID $id", $this->aauth->get_user()->username);
        }
        return true;
    }

    public function clockout($id)
    {

        $this->db->select('clock,clockin');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();

        if ($emp['clock']) {

            $data = array(
                'clock' => 0,
                'clockin' => 0,
                'clockout' => time()
            );

            $total_time = time() - $emp['clockin'];


            $this->db->set($data);
            $this->db->where('id', $id);

            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockOut]  ID $id", $this->aauth->get_user()->username);

            $today = date('Y-m-d');

            $this->db->select('id,adate');
            $this->db->where('emp', $id);
            $this->db->where('DATE(adate)', date('Y-m-d'));
            $this->db->from('geopos_attendance');
            $query = $this->db->get();
            $edate = $query->row_array();
            if ($edate['adate']) {


                $this->db->set('actual_hours', "actual_hours+$total_time", FALSE);
                $this->db->set('tto', date('H:i:s'));
                $this->db->where('id', $edate['id']);
                $this->db->update('geopos_attendance');


            } else {
                $data = array(
                    'emp' => $id,
                    'adate' => date('Y-m-d'),
                    'tfrom' => gmdate("H:i:s", $emp['clockin']),
                    'tto' => date('H:i:s'),
                    'note' => 'Self Attendance',
                    'actual_hours' => $total_time
                );


                $this->db->insert('geopos_attendance', $data);
            }

        }
        return true;
    }


}