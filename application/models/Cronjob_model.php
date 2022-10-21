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


class Cronjob_model extends CI_Model
{
    var $table = 'geopos_accounts';

    public function __construct()
    {
        parent::__construct();

    }

    public function config()
    {
        $this->db->select('key1 AS cornkey, key2 AS rec_email,url AS email,method AS rec_due,other AS recemail');
        $this->db->from('univarsal_api');
        $this->db->where('id', 55);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function generate()
    {

        $random = rand(11111111, 99999999);
        $data = array(
            'key1' => $random

        );
        $this->db->set($data);
        $this->db->where('id', 55);


        if ($this->db->update('univarsal_api')) {
            return true;
        } else {
            return false;

        }

    }


    public function due_mail()
    {

        $duedate = date('Y-m-d');

        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_customers.email');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(geopos_invoices.invoiceduedate)<=', $duedate);
        $this->db->where('geopos_invoices.status', 'due');
        $this->db->join('geopos_customers', 'geopos_customers.id=geopos_invoices.csd', 'left');
        $query = $this->db->get();
        return $query->result_array();


    }


    public function reports()
    {

        $year = date('Y');

        $this->db->delete('geopos_reports', array('year' => $year));


        $query = $this->db->query("SELECT MONTH(invoicedate) AS month,YEAR(invoicedate) AS year,COUNT(tid) AS invoices,SUM(total) AS sales,SUM(items) AS items FROM geopos_invoices WHERE (YEAR(invoicedate)='$year') GROUP BY MONTH(invoicedate)");
        $arrayA = $query->result_array();

        $query = $this->db->query("SELECT MONTH(date) AS month,YEAR(date) AS year,SUM(credit) AS income,SUM(debit) AS expense FROM geopos_transactions WHERE (YEAR(date)='$year') GROUP BY MONTH(date)");
        $arrayB = $query->result_array();
        $output = array();

        $arrayAB = array_merge($arrayA, $arrayB);


        foreach ($arrayAB as $value) {
            $id = $value['month'];
            if (!isset($output[$id])) {
                $output[$id] = array();
            }
            $output[$id] = array_merge($output[$id], $value);
        }


        uasort($output, array_compare('month'));


        $batch = array();
        $i = 0;
        foreach ($output as $row) {

            $batch[$i] = array('month' => $row['month'], 'year' => $row['year'], 'invoices' => @$row['invoices'], 'sales' => @$row['sales'], 'items' => @$row['items'], 'income' => @$row['income'], 'expense' => @$row['expense']);
            $i++;
        }

        $this->db->insert_batch('geopos_reports', $batch);

        return true;


    }

    public function exchange_rate($base, $exchangeRates = '')
    {

        $updateData = array();
        //$cindex = 0;
        $this->db->select('id,code,rate');
        $this->db->from('geopos_currencies');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $key => $value) {

            $index = $base . $value['code'];
            $updateData[] = array('id' => $value['id'], 'rate' => $exchangeRates[$index]);
            //  print_r($value);

        }
//print_r($updateData);
        $this->db->update_batch('geopos_currencies', $updateData, 'id');


    }

    public function subs()
    {
        $last = 1;
        $last_id = 1;
        //$this->db->select('method AS rec_due');
        // $this->db->from('univarsal_api');
        //  $query1 = $this->db->get();
        // $this->db->where('id', 55);
        //  $result = $query1->row_array();
        //  $config = $result['rec_due'];
		$this->load->model('locations_model', 'locations');
		$this->load->model('accounts_model');
		$this->load->model('plugins_model', 'plugins');
		$this->load->library("Common");
        $config = 0;

		$this->db->select('id,tid');       
        $this->db->from('geopos_invoices');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query_id = $this->db->get();
		$result_id = $query_id->row_array();
		$last_id = $result_id['id'];

        $this->db->select('id,tid');
        $this->db->where('i_class >', 1);
		$this->db->where('i_class <', 3);
        $this->db->from('geopos_invoices');

        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        $result_t = $query->row_array();
        $last = $result_t['tid'];
		
        if ($config == 0) {
            $duedate = date('Y-m-d');
			
            $this->db->from('geopos_invoices');
            $this->db->where('DATE(invoiceduedate)<=', $duedate);
			//$this->db->where('geopos_invoices.id', 142);
            $this->db->where('i_class', 2);
            $query = $this->db->get();
            $result = $query->result_array();
            $invoice_list = array();
            $old_invoice_list = array();
            $inv_index = 0;
			$last_id_old = 0;
            foreach ($result as $row) {

                $last++;
                $last_id++;
				$total_tax = $row['total'];
                $ndate = date("Y-m-d", strtotime($row['invoiceduedate'] . " +" . $row['r_time'] . 's'));
                $data = array('id' => $last_id, 
				'tid' => $last, 
				'invoicedate' => $row['invoiceduedate'], 
				'invoiceduedate' => $ndate, 
				'subtotal' => $row['subtotal'], 
				'shipping' => $row['shipping'],
				'ship_tax' => $row['ship_tax'],
				'ship_tax_type' => $row['ship_tax_type'],				
				'discount' => $row['discount'],
				'discount_rate' => $row['discount_rate'],
				'tax' => $row['tax'], 
				'total' => $row['total'], 
				'notes' => $row['notes'], 
				'csd' => $row['csd'], 
				'eid' => $row['eid'],
				'status' => 'due',
				'pamnt' => '0.00',				
				'items' => $row['items'], 
				'taxstatus' => $row['taxstatus'], 
				'total_discount_tax' => $row['total_discount_tax'], 
				'format_discount' => $row['format_discount'], 
				'refer' => $row['refer'],
				'ref_enc_orc' => $row['ref_enc_orc'],
				'term' => $row['term'], 
				'multi' => $row['multi'], 
				'pmethod' => (((integer)$row['pmethod'])+1), 
				'i_class' => 2, 
				'loc' => $row['loc'], 
				'tax_id' => $row['tax_id'],
				'serie' => $this->common->default_series_id($this->common->default_typ_id_doc(15)),
				'irs_type' => $this->common->default_typ_id_doc(15),
				'r_time' => $row['r_time']);
				
				$last_id_old = $row['id'];
				$data2 = array('id' => $row['id'], 'i_class' => 3, 'pamnt' => $row['total'], 'status' => 'paid');
                $invoice_list[$inv_index] = $data;
                $old_invoice_list[$inv_index] = $data2;
                $inv_index++;
                $this->db->from('geopos_invoice_items');
                $this->db->where('tid', $row['id']);
                $query = $this->db->get();
                $result_p = $query->result_array();
                $productlist_p = array();
                $prodindex_p = 0;
				foreach ($result_p as $rowp) {
					$data_p = array(
						'tid' => $last_id,
                        'pid' => $rowp['pid'],
                        'product' => $rowp['product'],
                        'qty' => $rowp['qty'],
                        'price' => $rowp['price'],
                        'tax' => $rowp['tax'],
                        'discount' => $rowp['discount'],
                        'subtotal' => $rowp['subtotal'],
                        'totaltax' => $rowp['totaltax'],
                        'totaldiscount' => $rowp['totaldiscount'],
                        'product_des' => $rowp['product_des'],
                        'unit' => $rowp['unit'],
						'taxaname' => $rowp['taxaname'],
						'taxaid' => $rowp['taxaid'],
						'taxacod' => $rowp['taxacod'],
						'taxaperc' => $rowp['taxaperc'],
						'taxavals' => $rowp['taxavals'],
						'taxacomo' => $rowp['taxacomo']
					);
					
                    $productlist_p[$prodindex_p] = $data_p;
                    $prodindex_p++;
                    $amt = $rowp['qty'];
                    if ($rowp['pid'] > 0) {
                        $this->db->set('qty', "qty-$amt", FALSE);
                        $this->db->where('pid', $rowp['pid']);
                        $this->db->update('geopos_products');
                    }
                }
                $this->db->insert_batch('geopos_invoice_items', $productlist_p);
				$mesAv = date("m");
				$mesTexto = "";
				if($mesAv == 0)
				{
					$mesTexto = "Dezembro";
				}else if($mesAv == 1)
				{
					$mesTexto = "Janeiro";
				}else if($mesAv == 2)
				{
					$mesTexto = "Fevereiro";
				}else if($mesAv == 3)
				{
					$mesTexto = "Março";
				}else if($mesAv == 4)
				{
					$mesTexto = "Abril";
				}else if($mesAv == 5)
				{
					$mesTexto = "Maio";
				}else if($mesAv == 6)
				{
					$mesTexto = "Junho";
				}else if($mesAv == 7)
				{
					$mesTexto = "Julho";
				}else if($mesAv == 8)
				{
					$mesTexto = "Agosto";
				}else if($mesAv == 9)
				{
					$mesTexto = "Setembro";
				}else if($mesAv == 10)
				{
					$mesTexto = "Outubro";
				}else if($mesAv == 11)
				{
					$mesTexto = "Novembro";
				}
				//$tnote = '#' . $last_id . '- Mês: '.$mesTexto.' /'.(((integer)$row['pmethod'])+1);
				$tnote = '#Mês: '.$mesTexto.' /'.(((integer)$row['pmethod'])+1);
				$t_data = array(
					'type' => 'Subscription',
					'cat' => 5,
					'payerid' => $row['csd'],
					'method' => 62,
					'credit' => 0,
					'debit' => $total_tax,
					'note' => $tnote,
					'date' => $duedate,
					'eid' =>$row['eid'],
					'tid' => $last_id,
					'loc' =>$row['loc']
				);
				
				
				$discship = $this->plugins->universal_api(65);
				if($row['loc'] == 0)
				{
					$t_data['acid'] = $discship['key2'];
					$t_data['account'] = "Conta Por Defeito";
				}else{
					$accountin = $this->accounts_model->details($discship['key2'],false);
					$accountincome = ((integer)$accountin['id']);
					$accountincomename = $accountin['holder'];
					$t_data['acid'] = $accountincome;
					$t_data['account'] = $accountincomename;
				}
				$this->load->library("Aauth");
				$this->db->insert('geopos_transactions', $t_data);
				//account update
				$this->db->set('lastbal', "lastbal+$total_tax", FALSE);
				$this->db->where('id', $t_data['acid']);
				$this->db->update('geopos_accounts');
				
				// now try it
				$striPay = 'Sistema Automático';
				$striPay = $striPay.'<br>Adição Avença: Balanço do Cliente';
				$this->aauth->applog($striPay, 'Sistema Automático', 'subs', $last_id);
				
                //profit calculation
                $t_profit = 0;
                $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
                $this->db->from('geopos_invoice_items');
                $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
                $this->db->where('geopos_invoice_items.tid', $last_id);
                $query = $this->db->get();
                $pids = $query->result_array();
                foreach ($pids as $profit) {
                    $t_cost = $profit['fproduct_price'] * $profit['qty'];
                    $s_cost = $profit['price'] * $profit['qty'];

                    $t_profit += $s_cost - $t_cost;
                }
                $data = array('type' => 9, 'rid' => $last_id, 'col1' => $t_profit, 'd_date' => date('Y-m-d'));
                $this->db->insert('geopos_metadata', $data);
            }

            if ($result) {
                $this->db->insert_batch('geopos_invoices', $invoice_list);
				// now try it
				$striPay = 'Sistema Automático';
				$striPay = $striPay.'<br>Finalização de Avença: Balanço do Cliente';
				$this->aauth->applog($striPay, 'Sistema Automático', 'subs', $last_id_old);
				
                if ($this->db->update_batch('geopos_invoices', $old_invoice_list, 'id')) {
                    return true;
                } else {
                    return false;

                }
            }
        }
    }

    public function stock($idloc)
    {
		$query = $this->db->query("SELECT geopos_products.product_name,geopos_products.product_price,geopos_products.qty,geopos_products.unit 
		FROM geopos_products 
		INNER JOIN geopos_warehouse on geopos_products.warehouse = geopos_warehouse.id 
		WHERE geopos_products.qty <= geopos_products.alert and geopos_products.alert > 0 and geopos_warehouse.loc = $idloc
		ORDER BY geopos_products.product_name");
        $result = $query->result_array();
        $html_table = '<h2>Product Stock Alert</h2><p>Prezado Empresário, Você tem alguns produtos em falta.</p><table><tr><th>Produto</th><th>Qtd.</th><th>Preço</th></tr>';
        foreach ($result as $row) {
            $html_table .= '<tr><td>' . $row['product_name'] . '</td><td>' . amountFormat_general($row['qty']) . ' ' . $row['unit'] . '</td><td>' . amountExchange($row['product_price'], $invoice['multi'], $this->aauth->get_user()->loc). '</td></tr>';
        }
        $html_table .= '</table>';
        return $html_table;
    }
	
	
	public function stock_sold_off($idloc)
    {
        $query = $this->db->query("SELECT geopos_products.product_name,geopos_products.product_price,geopos_products.qty,geopos_products.unit 
		FROM geopos_products 
		INNER JOIN geopos_warehouse on geopos_products.warehouse = geopos_warehouse.id 
		WHERE geopos_products.qty = 0 and geopos_products.alert > 0 and geopos_warehouse.loc = $idloc
		ORDER BY geopos_products.product_name");
        $result = $query->result_array();
        $html_table = '<h2>Product Stock Alert</h2><p>Prezado Empresário, Você tem alguns produtos em falta/esgotado.</p><table><tr><th>Produto</th><th>Qtd.</th><th>Preço</th></tr>';
        foreach ($result as $row) {
            $html_table .= '<tr><td>' . $row['product_name'] . '</td><td>' . amountFormat_general($row['qty']) . ' ' . $row['unit'] . '</td><td>' . amountExchange($row['product_price'], $invoice['multi'], $this->aauth->get_user()->loc). '</td></tr>';
        }
        $html_table .= '</table>';
        return $html_table;
    }

    public function expiry()
    {

        $query = $this->db->query("SELECT product_name,product_price,qty,unit,expiry FROM geopos_products WHERE DATE(expiry)<='" . date('Y-m-d') . "' ORDER BY product_name");
        $result = $query->result_array();
        $html_table = '<h2>Product Expiry Alert</h2><p>Dear Business Owner, You have some products near to expire.</p><table><tr><th>Product Name</th><th>Qty</th><th>Price</th></tr>';
        foreach ($result as $row) {

            $html_table .= '<tr><td>' . $row['product_name'] . '</td><td>' . $row['qty'] . ' ' . $row['unit'] . '</td><td>' . $row['product_price'] . '</td></tr>';

        }
        $html_table .= '</table>';

        return $html_table;


    }

        public function customer_mail($limit=100,$start=1)
    {

        $this->db->select('id,name,email,phone');
        $this->db->from('geopos_customers');
        if($limit && $start) $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();


    }


}