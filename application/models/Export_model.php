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
 ************************************************************************
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Export_model extends CI_Model
{
    public function customers()
    {
        $this->db->select('*');

        $this->db->from('geopos_customers');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    // This is the function for the geting the product data start by Eyno 

    public function getProductDataByTid($tid = null) {
        $this->db->select('geopos_order_stock.*');
        $this->db->from('geopos_order_stock');
        $this->db->where('geopos_order_stock.tid',$tid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    // This is the function for the getting the product data end by eyno


    // This is the function for the getting the product type name start by the eyno

    public function getProductTypeBycatid($cat_id = null){
      $this->db->select('geopos_product_cat.title');
      $this->db->from('geopos_product_cat');
      $this->db->where('geopos_product_cat.id',$cat_id);
      $query = $this->db->get();
      if ($query->num_rows()>0) {
      $ret = $query->row();
      return $ret->title;
     // echo $ret->title;
      } 
    }

    // This is the function for the getting the product type name ends by the eyno


    // This is the function for the getting invoice data start by the eyno 

    public function getInvoiceDataById($id = null) {
      $this->db->select('*');
      $this->db->from('geopos_invoices');
      $this->db->where('geopos_invoices.id',$id);
      $query = $this->db->get();
      $result = $query->result_array();
      if(!empty($result)){
      $i = 0;
      foreach ($result as $invoice) {
        $result1[$i]['csd'] = !empty($invoice['csd']) ? $invoice['csd'] : 'Unknown';
        $result1[$i]['refer'] = !empty($invoice['refer']) ? $invoice['refer'] : 'Unknown';
        $result1[$i]['invoicedate'] = !empty($invoice['invoicedate']) ? $invoice['invoicedate'] : 'Unknown';
        $result1[$i]['status'] = !empty($invoice['status']) ? $invoice['status'] : 'Unknown';
        $result1[$i]['tax_status'] = !empty($invoice['taxstatus']) ? $invoice['taxstatus'] : 'off';
        $result1[$i]['pmethod'] = !empty($invoice['pmethod']) ? $invoice['pmethod'] : 'Unknown';
        $result1[$i]['total'] = !empty($invoice['total']) ? $invoice['total'] : '0.00';
        $result1[$i]['net_total'] = $invoice['total'] - ($invoice['total'] * ($invoice['withholdings'] / 100));
        $result1[$i]['pamnt'] = !empty($invoice['pamnt']) ? $invoice['pamnt'] : '0.00';
        $result1[$i]['tax'] = !empty($invoice['tax']) ? $invoice['tax'] : '0.00';
       }
      } else  {
        $result1[0]['csd'] = 'Unknown';
        $result1[0]['refer'] = 'Unknown';
        $result1[0]['invoicedate'] = 'Unknown';
        $result1[0]['status'] = 'Unknown';
        $result1[0]['tax_status'] = 'off';
        $result1[0]['pmethod'] = 'Unknown';
        $result1[0]['total'] = '0.00';
        $result1[0]['net_total'] = '0.00';
        $result1[0]['pamnt'] = '0.00';
        $result1[0]['tax'] = '0.00';
       }
      return $result1[0];
  }

    // This is the function for the getting the invoice data end by the eyno
    // This is the function for the getting the customer data starts

    public function getCustomerDataById($id = null) {
      $this->db->select('*,geopos_customers.id as customer_id,geopos_customers.loc as customer_loc');
      $this->db->from('geopos_customers');
      $this->db->where('geopos_customers.id',$id);
      $query = $this->db->get();
      $result = $query->result_array();
      if(!empty($result))
      {
        $i = 0;
        foreach ($result as $value) {
          $result1[$i]['id'] = !empty($value['id']) ? $value['id'] : 'Unknown';
          $result1[$i]['name'] = !empty($value['name']) ? $value['name'] : 'Unknown';
          $result1[$i]['phone'] = !empty($value['phone']) ? $value['phone'] : 'Unknown';
          $result1[$i]['address'] = !empty($value['address']) ? $value['address'] : 'Unknown';
          $result1[$i]['city'] = !empty($value['city']) ? $value['city'] : 'Unknown';
          $result1[$i]['region'] = !empty($value['region']) ? $value['region'] : 'Unknown';
          $result1[$i]['country'] = !empty($value['country']) ? $value['country'] : 'Unknown';
          $result1[$i]['postbox'] = !empty($value['postbox']) ? $value['postbox'] : 'Unknown';
          $result1[$i]['email'] = !empty($value['email']) ? $value['email'] : 'Unknown';
          $result1[$i]['picture'] = !empty($value['picture']) ? $value['picture'] : 'Unknown';
          $result1[$i]['gid'] = !empty($value['gid']) ? $value['gid'] : 'Unknown';
          $result1[$i]['company'] = !empty($value['company']) ? $value['company'] : 'Unknown';
          $result1[$i]['taxid'] = !empty($value['taxid']) ? $value['taxid'] : 'Unknown';
          $result1[$i]['name_s'] = !empty($value['name_s']) ? $value['name_s'] : 'Unknown';
          $result1[$i]['phone_s'] = !empty($value['phone_s']) ? $value['phone_s'] : 'Unknown';
          $result1[$i]['email_s'] = !empty($value['email_s']) ? $value['email_s'] : 'Unknown';
          $result1[$i]['address_s'] = !empty($value['address_s']) ? $value['address_s'] : 'Unknown';
          $result1[$i]['city_s'] = !empty($value['city_s']) ? $value['city_s'] : 'Unknown';
          $result1[$i]['region_s'] = !empty($value['region_s']) ? $value['region_s'] : 'Unknown';
          $result1[$i]['country_s'] = !empty($value['country_s']) ? $value['country_s'] : 'Unknown';
          $result1[$i]['postbox_s'] = !empty($value['postbox_s']) ? $value['postbox_s'] : 'Unknown';
          $result1[$i]['balance'] = !empty($value['balance']) ? $value['balance'] : 'Unknown';
          $result1[$i]['loc'] = !empty($value['loc']) ? $value['loc'] : 'Unknown';
          $result1[$i]['docid'] = !empty($value['docid']) ? $value['docid'] : 'Unknown';
          $result1[$i]['custom1'] = !empty($value['custom1']) ? $value['custom1'] : 'Unknown';
          $result1[$i]['discount_c'] = !empty($value['discount_c']) ? $value['discount_c'] : 'Unknown';
          $result1[$i]['reg_date'] = !empty($value['reg_date']) ? $value['reg_date'] : 'Unknown';
          $result1[$i]['customer_id'] = !empty($value['customer_id']) ? $value['customer_id'] : 'Unknown';
          $result1[$i]['customer_loc'] = !empty($value['customer_loc']) ? $value['customer_loc'] : 'Unknown';
        }
      } else {
          $result1[0]['id'] = 'Unknown';
          $result1[0]['name'] = 'Unknown';
          $result1[0]['phone'] = 'Unknown';
          $result1[0]['address'] = 'Unknown';
          $result1[0]['city'] = 'Unknown';
          $result1[0]['region'] = 'Unknown';
          $result1[0]['country'] = 'Unknown';
          $result1[0]['postbox'] = 'Unknown';
          $result1[0]['email'] = 'Unknown';
          $result1[0]['picture'] = 'Unknown';
          $result1[0]['gid'] = 'Unknown';
          $result1[0]['company'] = 'Unknown';
          $result1[0]['taxid'] = 'Unknown';
          $result1[0]['name_s'] = 'Unknown';
          $result1[0]['phone_s'] = 'Unknown';
          $result1[0]['email_s'] = 'Unknown';
          $result1[0]['address_s'] = 'Unknown';
          $result1[0]['city_s'] = 'Unknown';
          $result1[0]['region_s'] = 'Unknown';
          $result1[0]['country_s'] = 'Unknown';
          $result1[0]['postbox_s'] = 'Unknown';
          $result1[0]['balance'] = 'Unknown';
          $result1[0]['loc'] = 'Unknown';
          $result1[0]['docid'] = 'Unknown';
          $result1[0]['custom1'] = 'Unknown';
          $result1[0]['discount_c'] = 'Unknown';
          $result1[0]['reg_date'] = 'Unknown';
          $result1[0]['customer_id'] = 'Unknown';
          $result1[0]['customer_loc'] = 'Unknown';
      }
      return $result1[0];
    }

    // This is the fucntion for the gettign the customer data ends 

  // Get Invoice items by id 

    public function getInvoiveItemsById($tid = null){
      $this->db->select('*');
      $this->db->from('geopos_invoice_items');
      $this->db->where('geopos_invoice_items.tid',$tid);
      $query = $this->db->get();
      $result = $query->result_array();


        if(!empty($result)) {
               $i = 0;
              foreach ($result as $value) {
                $invoice_result[$i]['line_number'] = $i+1;
                $invoice_result[$i]['product_code'] = !empty($value['code']) ? $value['code'] : 'Unknown';
                $invoice_result[$i]['product_des'] = !empty($value['product_des']) ? $value['product_des'] : 'Unknown';
                $invoice_result[$i]['qty'] = !empty($value['qty']) ? $value['qty'] : 'Unknown';
                $invoice_result[$i]['unit'] = !empty($value['unit']) ? $value['unit'] : 'Unknown';
                $invoice_result[$i]['price'] = !empty($value['price']) ? $value['price'] : '0.00';
                $invoice_result[$i]['tax_point_date'] = 'Unknown';
                $invoice_result[$i]['description'] = !empty($value['product_des']) ? $value['product_des'] : 'Unknown';
                $invoice_result[$i]['creditamount'] = !empty($value['subtotal']) ? $value['subtotal'] : '0.00';
                $invoice_result[$i]['tax_type'] = 'VAT';
                $invoice_result[$i]['tax_country_region'] = 'PT';
                $invoice_result[$i]['tax_code'] = 'NOR';
                $invoice_result[$i]['tax_percentage'] = !empty($value['tax']) ? $value['tax'] : 'Unknown';
                $i++;
              }
          }
      else{
          $invoice_result[0]['line_number'] = 0;
          $invoice_result[0]['product_code'] = 'Unknown';
          $invoice_result[0]['product_des'] = 'Unknown';
          $invoice_result[0]['qty'] = '0';
          $invoice_result[0]['unit'] = 'Unknown';
          $invoice_result[0]['price'] = '0.00';
          $invoice_result[0]['tax_point_date'] = 'Unknown';
          $invoice_result[0]['description'] = 'Unknown';
          $invoice_result[0]['creditamount'] = '0.00';
          $invoice_result[0]['tax_type'] = 'VAT';
          $invoice_result[0]['tax_country_region'] = 'PT';
          $invoice_result[0]['tax_code'] = 'NOR';
          $invoice_result[0]['tax_percentage'] = !empty($value['tax']) ? $value['tax'] : '0';
       }
      return $invoice_result;
     }

  // Get invoice items by the id 


   // This is the fucntion for the xml generation by the Eyno 

	public $SAFT_VERSION = "1.03_01";
    public $sdate;
    public $edate;
	public $locdefine;
    public $simplificado = true;
    public $taxas = array();
    public function xmldata($data = null ) {
		$this->load->model('settings_model', 'settings');
		
		global $locdefine;
		global $SAFT_VERSION;
		global $sdate;
		global $edate;
		
        $this->load->dbutil();
        $this->load->helper('download');

        if($data['version'] == '0'){
            $SAFT_VERSION = '1.03_01';
        }
        if($data['version'] == '1'){
            $SAFT_VERSION = '1.04_01';
        }
		
		$locdefine = $data['pay_acc'];
        $sdate = $data['sdate'];
        $nsdate = explode('-', $sdate);
        $sdate = $nsdate[2].'-'.$nsdate[1].'-'.$nsdate[0];

        $edate = $data['edate'];
        $nedate = explode('-',$edate);
        $edate = $nedate[2].'-'.$nedate[1].'-'.$nedate[0];
		
		$xmldata = '';
		$querytun = "";
		if($locdefine == 0)
		{
			$querytun = "select geopos_system.cname as nome, geopos_system.taxid as nif, ";
			$querytun .= " geopos_system.address as morada, geopos_system.city as freguesia, ";
			$querytun .= " geopos_system.postbox as codpostal,";
			$querytun .= " geopos_system.phone as tlf, geopos_system.email as email, geopos_system.productversion, geopos_system.certification, geopos_system.productid, geopos_system.certificationtaxidcompany";
			$querytun .= " from geopos_system";
			$querytun .= " where geopos_system.id = 1";
		}else{
			$querytun = "select geopos_locations.cname as nome, geopos_locations.taxid as nif, ";
			$querytun .= " geopos_locations.address as morada, geopos_locations.city as freguesia, ";
			$querytun .= " geopos_locations.postbox as codpostal,";
			$querytun .= " geopos_locations.phone as tlf, geopos_locations.email as email, geopos_system.productversion, geopos_system.certification, geopos_system.productid, geopos_system.certificationtaxidcompany";
			$querytun .= " from geopos_locations";
			$querytun .= " inner join geopos_system on 1=1";
			$querytun .= " where geopos_locations.id = ".$locdefine;
		}
		$query = $this->db->query($querytun);
		$empresa = $query->row_array();
		$xmldata .= $this->saft_header($empresa);
	
		$xmldata .= "<MasterFiles>\n";
		$xmldata .= $this->saft_clientes();
		/*if(!$this->simplificado)
		{
			$xml .= $this->saft_produtos();
		}*/
		
		$xmldata .= $this->saft_produtos();
		$xmldata .= $this->saft_taxasiva();
		
		$xmldata .= "</MasterFiles>\n";
		
		$xmldata .= "<SourceDocuments>\n";
		$xmldata .= $this->saft_salesinvoices();
		$xmldata .= "</SourceDocuments>\n";
		$xmldata .= '</AuditFile>';

        // Suppliers Data Starts From Here ---------------------------------------------------------------------------//

        $this->db->select('geopos_supplier.*');
        $this->db->from('geopos_supplier');
        $this->db->where('geopos_supplier.loc',$locdefine);
        $query_supplier = $this->db->get();
        $supplier_result = $query_supplier->result_array();


        $p=0;
        foreach ($supplier_result as $value) {
			$supplier[$p]['id'] = !empty($value['id']) ? $value['id'] : 'Unknown';
			$supplier[$p]['name'] = !empty($value['name']) ? $value['name'] : 'Unknown';
			$supplier[$p]['phone'] = !empty($value['phone']) ? $value['phone'] : 'Unknown';
			$supplier[$p]['address'] = !empty($value['address']) ? $value['address'] : 'Unknown';
			$supplier[$p]['city'] = !empty($value['city']) ? $value['city'] : 'Unknown';
			$supplier[$p]['region'] = !empty($value['region']) ? $value['region'] : 'Unknown';
			$supplier[$p]['country'] = !empty($value['country']) ? $value['country'] : 'Unknown';
			$supplier[$p]['postbox'] = !empty($value['postbox']) ? $value['postbox'] : 'Unknown';
			$supplier[$p]['email'] = !empty($value['email']) ? $value['email'] : 'Unknown';
			$supplier[$p]['gid'] = !empty($value['gid']) ? $value['gid'] : 'Unknown';
			$supplier[$p]['company'] = !empty($value['company']) ? $value['company'] : 'Unknown';
			$supplier[$p]['taxid'] = !empty($value['taxid']) ? $value['taxid'] : 'Unknown';
			$p++;
        }


       // Transaction data Starts From Here --------------------------------------------------------------------------/

        $this->db->select('geopos_transactions.*');
        $this->db->from('geopos_transactions');
        $this->db->where('geopos_transactions.loc',$locdefine);
        $this->db->where('geopos_transactions.date >=', $sdate);
        $this->db->where('geopos_transactions.date <=', $edate);
        $query_trans = $this->db->get();
        $trans_result = $query_trans->result_array();

        $total_tran_no = count($trans_result);
        $j = 0;
        $tr_result = [];
        foreach ($trans_result as $value_trac) {
			$tr_result[$j]['tran_id'] = !empty($value_trac['id']) ? $value_trac['id'] : 'Unknown';
			$tr_result[$j]['acid'] = !empty($value_trac['acid']) ? $value_trac['acid'] : 'Unknown';
			$tr_result[$j]['account'] = !empty($value_trac['account']) ? $value_trac['account'] : 'Unknown';
			$tr_result[$j]['type'] = !empty($value_trac['type']) ? $value_trac['type'] : 'Unknown';
			$tr_result[$j]['cat'] = !empty($value_trac['cat']) ? $value_trac['cat'] : 'Unknown';
			$tr_result[$j]['debit'] = !empty($value_trac['debit']) ? $value_trac['debit'] : '0.00';
			$tr_result[$j]['credit'] = !empty($value_trac['credit']) ? $value_trac['credit'] : '0.00';
			$tr_result[$j]['payer'] = !empty($value_trac['payer']) ? $value_trac['payer'] : 'Unknown';
			$tr_result[$j]['payerid'] = !empty($value_trac['payerid']) ? $value_trac['payerid'] : 'Unknown';
			$tr_result[$j]['method'] = !empty($value_trac['method']) ? $value_trac['method'] : 'Unknown';
			$tr_result[$j]['date'] = !empty($value_trac['date']) ? $value_trac['date'] : 'Unknown';
			$tr_result[$j]['tid'] = !empty($value_trac['tid']) ? $value_trac['tid'] : 'Unknown';
			$tr_result[$j]['eid'] = !empty($value_trac['eid']) ? $value_trac['eid'] : 'Unknown';
			$tr_result[$j]['note'] = !empty($value_trac['note']) ? $value_trac['note'] : 'Unknown';
			$tr_result[$j]['ext'] = !empty($value_trac['ext']) ? $value_trac['ext'] : 'Unknown';
			$tr_result[$j]['loc'] = !empty($value_trac['loc']) ? $value_trac['loc'] : 'Unknown';
			$tr_result[$j]['invoice_result'] = $this->getInvoiceDataById($value_trac['tid']);
			$tr_result['total_debit'] += !empty($value_trac['debit']) ? $value_trac['debit'] : '0';
			$tr_result['total_credit'] += !empty($value_trac['credit']) ? $value_trac['credit'] : '0';
			$j++;
        }

      // Config Data Ends Here --------------------------------------------------------------------------------------//

      // Accounts Data 

      $this->db->select('geopos_accounts.*');
      $this->db->from('geopos_accounts');
      $this->db->where('geopos_accounts.loc',$data['pay_acc']);
	  
      $config_account = $this->db->get();
      $config_accounts_result = $config_account->result_array();

      if(!empty($config_accounts_result))
      {
      	$q = 0;
      	foreach ($config_accounts_result as $acc_result) 
      	{
      		$acc_data[$q]['account_id'] = $acc_result['id'];
      		$acc_data[$q]['account_desc'] = 'Unknown';
      		$acc_data[$q]['openingDebitBalance'] = '0';
      		$acc_data[$q]['openingCreditBalance'] = '0';
      		$acc_data[$q]['closingDebitBalance'] = '0';
      		$acc_data[$q]['closingCreditBalance'] = '0';
      		$acc_data[$q]['grouping_cat'] = $acc_result['account_type'];
      		$q++;
      	}
      }
	  return $xmldata;
    }
	
	
	// Header Data Starts From Here --------------------------------------------------------------------------//
	function saft_header($empresa) 
    {
		global $locdefine;
		global $SAFT_VERSION;
		global $sdate;
		global $edate;
		
        $xml = '<?xml version="1.0" encoding="Windows-1252"?>'."\n";
		if($SAFT_VERSION == "1.04_01")
		{
			$xml .= '<AuditFile xmlns="urn:OECD:StandardAuditFile-Tax:PT_'.$SAFT_VERSION.'">'."\n";
		}else
		{
			$xml .= '<AuditFile xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:OECD:StandardAuditFile-Tax:PT_'.$SAFT_VERSION.'" xsi:schemaLocation="urn:OECD:StandardAuditFile-Tax:PT_'.$this->SAFT_VERSION.' ../schemas/SAF-T.xsd" xmlns:doc="urn:schemas-basda-org:schema-extensions:documentation">'."\n";
		}
        $xml .= "<Header>\n";
        $xml .= "\t<AuditFileVersion>$SAFT_VERSION</AuditFileVersion>\n";
        $xml .= "\t<CompanyID>" . $empresa['nif'] . "</CompanyID>\n";

        $xml .= "\t<TaxRegistrationNumber>" . $empresa['nif'] . "</TaxRegistrationNumber>\n";


        $xml .= "\t<TaxAccountingBasis>F</TaxAccountingBasis>\n";
        $xml .= "\t<CompanyName>" . $empresa['nome'] . "</CompanyName>\n";
        $xml .= "\t<CompanyAddress>\n";
        $xml .= "\t\t<AddressDetail>" . $empresa['morada'] . "</AddressDetail>\n";
        $xml .= "\t\t<City>" . $empresa['freguesia'] . "</City>\n";
        $xml .= "\t\t<PostalCode>" . $empresa['codpostal'] . "</PostalCode>\n";
        $xml .= "\t\t<Country>PT</Country>\n";
        $xml .= "\t</CompanyAddress>\n";


        $date = date("Y", strtotime($sdate));
        $xml .= "\t<FiscalYear>$date</FiscalYear>\n";

        $xml .= "\t<StartDate>" . $sdate . "</StartDate>\n";
        $xml .= "\t<EndDate>" . $edate . "</EndDate>\n";

        $xml .= "\t<CurrencyCode>EUR</CurrencyCode>\n";

        // Todays date. The date of the SAFT-PT xml file.
        $xml .= "\t<DateCreated>" . date("Y-m-d") . "</DateCreated>\n";

        $xml .= "\t<TaxEntity>Global</TaxEntity>\n";
        $xml .= "\t<ProductCompanyTaxID>".$empresa['certificationtaxidcompany']."</ProductCompanyTaxID>\n";
        $xml .= "\t<SoftwareCertificateNumber>".$empresa['certification']."</SoftwareCertificateNumber>\n";
        $xml .= "\t<ProductID>".$empresa['productid']."</ProductID>\n";
        $xml .= "\t<ProductVersion>".$empresa['productversion']."</ProductVersion>\n";
        
        //$xml .= "\t<Telephone>" . $empresa['tlf'] . "</Telephone>\n";
        //$xml .= "\t<Fax></Fax>\n";
        //$xml .= "\t<Email>" . $empresa['email'] . "</Email>\n";
        $xml .= "</Header>\n";
        return $xml; 
    }
	
	
	// Customer Data Starts From Here --------------------------------------------------------------------------//
	function saft_clientes() 
    {
		global $locdefine;
		global $sdate;
		global $edate;
		
		$this->db->select('geopos_customers.*,geopos_customers.id as customer_id');
        $this->db->from('geopos_invoices');
		$this->db->join('geopos_customers','geopos_customers.id = geopos_invoices.csd');		
        $this->db->where('geopos_invoices.loc',$locdefine);
        //$this->db->where('geopos_invoices.status','paid');
		$this->db->where('geopos_invoices.i_class',0);
		$this->db->or_where('geopos_invoices.i_class', 2);
		$this->db->where('geopos_invoices.ext',0);
        $this->db->where('geopos_invoices.invoicedate >=', $sdate);
        $this->db->where('geopos_invoices.invoicedate <=', $edate);
		$this->db->group_by('geopos_customers.id');
		
        $query_cust = $this->db->get();
        $customer_data = $query_cust->result_array();
		
		$o = 0;
		$xml = "";
        foreach ($customer_data as $customer) {
			$xml .= "\t<Customer>\n";
            $xml .= "\t\t<CustomerID>" . $customer['id'] . "</CustomerID>\n";
            $xml .= "\t\t<AccountID>Desconhecido</AccountID>\n";
			
            if(trim($customer['nif']) == "999999990")
            {
                $customer['name'] = "Consumidor final";
                $customer['address'] = "Desconhecido";
                $customer['city'] = "Desconhecido";
                $customer['postbox'] = "Desconhecido";
            }
			
			if(trim($customer['taxid']) == "")
            {
                $customer['taxid'] = "999999990";
                $customer['address'] = "Desconhecido";
                $customer['city'] = "Desconhecido";
                $customer['postbox'] = "Desconhecido";
            }
			$xml .= "\t\t<CustomerTaxID>" . $customer['taxid'] . "</CustomerTaxID>\n";
            $xml .= "\t\t<CompanyName>" . $this->settings->protege_campo($customer['name'], 100) . "</CompanyName>\n";
            $xml .= "\t\t<BillingAddress>\n";
            $xml .= "\t\t\t<AddressDetail>" . $this->settings->protege_campo($customer['address'], 100) . "</AddressDetail>\n";
            $xml .= "\t\t\t<City>" . $this->settings->protege_campo($customer['city'], 50) . "</City>\n";
            if(trim($customer['codpostal']) == "-")
            {
                $customer['codpostal'] = "0000-000";
            }
            $xml .= "\t\t\t<PostalCode>" . trim($customer['postbox']) . "</PostalCode>\n";
            $xml .= "\t\t\t<Country>".$customer['country']."</Country>\n";
            $xml .= "\t\t</BillingAddress>\n";
            $xml .= "\t\t<SelfBillingIndicator>0</SelfBillingIndicator>\n";
            $xml .= "\t</Customer>\n";
			$o++;
		}
		
        return $xml;
    }
	
	
	function saft_produtos() 
    {
		global $locdefine;
		global $sdate;
		global $edate;
		$this->db->select('geopos_products.*,geopos_warehouse.*, geopos_product_cat.cod');
        $this->db->from('geopos_products');
		$this->db->join('geopos_warehouse','geopos_warehouse.id = geopos_products.warehouse');
        $this->db->join('geopos_product_cat','geopos_product_cat.id = geopos_products.pcat');
        $this->db->where('geopos_warehouse.loc',$locdefine);
        $query_prod = $this->db->get();
        $product_result = $query_prod->result_array();

        $z = 0;
		$xml = "";
        foreach ($product_result as $product) {
			$xml .= "\t<Product>\n";
            $xml .= "\t\t<ProductType>" . $product['cod'] . "</ProductType>\n";
            $xml .= "\t\t<ProductCode>" . $product['product_code'] . "</ProductCode>\n";
            $xml .= "\t\t<ProductDescription>" . $this->settings->protege_campo($product['product_des'], 200) . "</ProductDescription>\n";
            $xml .= "\t\t<ProductNumberCode>" . $product['pid'] . "</ProductNumberCode>\n";
            $xml .= "\t</Product>\n";
          $z++;
        }
		
        return $xml;
    }
	
	
	function saft_taxasiva() 
    {
		// Connfig Data Starts From Here ------------------------------------------------------------------------------/

        $this->db->select('geopos_config.*');
        $this->db->from('geopos_config');
        $this->db->where('geopos_config.type','2');
        $config_query = $this->db->get();
        $config_final_result = $config_query->result_array();
        $k = 0;
		
		$xml = "\t<TaxTable>\n";
        
        foreach ($config_final_result as $tax) 
        {
            $xml .= "\t\t<TaxTableEntry>\n";
            $xml .= "\t\t\t<TaxType>IVA</TaxType>\n";;
            $xml .= "\t\t\t<TaxCountryRegion>".$tax['taxregion']."</TaxCountryRegion>\n";
            $xml .= "\t\t\t<TaxCode>".$tax['taxcode']."</TaxCode>\n";
            $xml .= "\t\t\t<Description>".$this->settings->protege_campo($tax['taxdescription'])."</Description>\n";
            $xml .= "\t\t\t<TaxPercentage>" . intval($tax['val2']) . "</TaxPercentage>\n";
            $xml .= "\t\t</TaxTableEntry>\n";
            
            $this->taxas[intval($tax['val2'])] = $tax['taxcode'];
			$k++;
        }

        $xml .= "\t</TaxTable>\n";
        
        return $xml;
    }
	
	function saft_taxas_transitions_invoices($invo)
	{
		global $tot_credit;
		global $tot_debit;
		$this->db->select('sum(geopos_transactions.credit) as credit, sum(geopos_transactions.debit) as debit');
        $this->db->from('geopos_transactions');
        $this->db->where('geopos_transactions.tid',$invo);
        $query_trans = $this->db->get();
        $trans_result = $query_trans->row_array();
		$xml = "";
		if($trans_result['debit'] > $trans_result['credit'])
		{
			$xml = "\t\t\t\t<DebitAmount>" . number_format (abs($trans_result['debit']), 2, '.', '') . "</DebitAmount>\n";
			$tot_debit += abs($trans_result['debit']);
		}else
		{
			$xml .= "\t\t\t\t<CreditAmount>" . number_format ($trans_result['credit'], 2, '.', '') . "</CreditAmount>\n";
			$tot_credit += $trans_result['credit'];
		}
		return $xml;
	}
	function saft_taxas_produtcs_invoices($invo, $invdatdoc)
	{
		global $tot_credit;
		global $tot_debit;
		
		$querypp = "select 
			geopos_invoice_items.pid,
			geopos_invoice_items.code,
			geopos_invoice_items.qty,
			geopos_invoice_items.product,
			geopos_invoice_items.product_des,
			geopos_invoice_items.totaldiscount,
			geopos_invoice_items.unit,
			case when geopos_invoice_items.serial is null then '0' when geopos_invoice_items.serial = '' then '0' else geopos_invoice_items.serial end as serial,
			geopos_invoice_items.price,
			geopos_invoice_items.taxaname,
			geopos_invoice_items.taxacod,
			geopos_invoice_items.taxaperc,
			geopos_invoice_items.taxavals,
			geopos_invoice_items.taxacomo
		from 
			geopos_invoice_items
		where
			geopos_invoice_items.tid = $invo";
		
		$query = $this->db->query($querypp);
		$productstax = $query->result_array();
		$xml = "";
		foreach ($productstax as $row) {
			$arrtudo = [];
			$xml .= "\t\t\t<Line>\n";
			$xml .= "\t\t\t\t<LineNumber>" . $row['pid'] . "</LineNumber>\n";
			$xml .= "\t\t\t\t<ProductCode>" . $row['code'] . "</ProductCode>\n";
			$xml .= "\t\t\t\t<ProductDescription>" . $this->settings->protege_campo($row['product'], 200) . "</ProductDescription>\n";
			$xml .= "\t\t\t\t<Quantity>" . $row['qty'] . "</Quantity>\n";
			$xml .= "\t\t\t\t<UnitOfMeasure>" . $row['unit'] . "</UnitOfMeasure>\n";
			$xml .= "\t\t\t\t<UnitPrice>" . $row['price'] . "</UnitPrice>\n";
			$xml .= "\t\t\t\t<TaxPointDate>" . $invdatdoc . "</TaxPointDate>\n";
			$xml .= "\t\t\t\t<Description>" . $this->settings->protege_campo($row['product_des'], 200) . "</Description>\n";
			
			if($row['serial'] != '0' && $row['serial'] != 0)
			{
				$xml .= "\t\t\t\t<ProductSerialNumber>\n";
				$xml .= "\t\t\t\t\t<SerialNumber>" . $row['serial'] . "</SerialNumber>\n";
				$xml .= "\t\t\t\t</ProductSerialNumber>\n";
			}
			
			$myArraytaxid = explode(";", $row['taxavals']);
			$myArraytaxperc = explode(";", $row['taxaperc']);
			$myArraytaxcomo = explode(";", $row['taxacomo']);
			$myArraytaxname = explode(";", $row['taxaname']);
			$myArraytaxcod = explode(";", $row['taxacod']);
			$myArraytaxvals = explode(";", $row['taxavals']);
			for($i = 0; $i < count($myArraytaxname); $i++)
			{
				$jatem = false;
				for($oo = 0; $oo < count($arrtudo); $oo++)
				{
					if($arrtudo[$oo]['title'] == $myArraytaxname[$i])
					{
						$arrtudo[$oo]['val'] = ($arrtudo[$oo]['val']+$myArraytaxvals[$i]);
						$jatem = true;
						break;
					}
				}
				
				if(!$jatem)
				{
					$stack = array('title'=>$myArraytaxname[$i], 'val'=>$myArraytaxvals[$i], 'cod'=>$myArraytaxcod[$i], 'perc'=>$myArraytaxperc[$i], 'como'=>$myArraytaxcomo[$i]);
					array_push($arrtudo, $stack);
				}
			}
			
			$taxaisent = 0;
			for($r = 0; $r < count($arrtudo); $r++)
			{
				$xml .= "\t\t\t\t<Tax>\n";
				$xml .= "\t\t\t\t\t<TaxType>IVA</TaxType>\n";
				$xml .= "\t\t\t\t\t<TaxCountryRegion>PT</TaxCountryRegion>\n";
				$xml .= "\t\t\t\t\t<TaxCode>".$arrtudo[$r]['cod']."</TaxCode>\n";
				$xml .= "\t\t\t\t\t<TaxPercentage>" . $arrtudo[$r]['perc'] . "</TaxPercentage>\n";
				
				if($arrtudo[$r]['cod'] == 'ISE')
				{
					$taxaisent = $arrtudo[$r]['como'];
				}else{
					$xml .= "\t\t\t\t</Tax>\n";
				}
			}
			
			$isentname = [];
			if($taxaisent > 0)
			{
				$this->db->select('geopos_config.val1, geopos_config.taxcode');
				$this->db->from('geopos_config');
				$this->db->where('geopos_config.id',$taxaisent);
				$query = $this->db->get();
				$isentname = $query->row_array();
				$xml .= "\t\t\t\t</Tax>\n";
			}			
			
			if($taxaisent > 0)
			{
				$xml .= "\t\t\t\t<TaxExemptionReason>".$isentname['val1'] ."</TaxExemptionReason>\n";
				$xml .= "\t\t\t\t<TaxExemptionCode>".$isentname['taxcode'] ."</TaxExemptionCode>\n";
			}
			
			if($row['totaldiscount'] != 0 && $row['totaldiscount'] != '0.00')
			{
			   $xml .= "\t\t\t\t<SettlementAmount>".number_format($row['totaldiscount'], 3, '.', '') ."</SettlementAmount>\n";  
			}
			$xml .= $this->saft_taxas_transitions_invoices($invo);
			$xml .= "\t\t\t</Line>\n";
		}
		return $xml;
	}
	
	
	
	function saft_getpaymentsinvoice($invo)
	{
		$this->db->select('geopos_transactions.credit, geopos_transactions.date, geopos_config.val2 as mechanism');
        $this->db->from('geopos_transactions');
		$this->db->join('geopos_config', 'geopos_config.id = geopos_transactions.method', 'left');
        $this->db->where('geopos_transactions.tid',$invo);
        $query_trans = $this->db->get();
        $trans_result = $query_trans->result_array();
		
		$xml = "";
		foreach ($trans_result as $row) {
			$xml .= "\t\t\t\t<Payment>\n";
			$xml .= "\t\t\t\t\t<PaymentMechanism>".$row['mechanism']."</PaymentMechanism>\n";
			$xml .= "\t\t\t\t\t<PaymentAmount>".$row['credit']."</PaymentAmount>\n";
			$xml .= "\t\t\t\t\t<PaymentDate>".$row['date']."</PaymentDate>\n";
			$xml .= "\t\t\t\t</Payment>\n";
		}
		return $xml;
	}
	
	private $tot_credit = 0;
    private $tot_debit = 0;
	function saft_salesinvoices() 
    {
		global $locdefine;
		global $sdate;
		global $edate;
		
        $dump = '';
        global $tot_credit;
        global $tot_debit;
        $n_entries = 0;
        $taxas = array();        
        $valores = array();
		$xml = '';
		// Invoice data start from here ------------------------------------------------------------------------------//

        $querypass = "select geopos_invoices.*, geopos_invoices.id as invoice_id, geopos_currencies.code as multiname, 
		case when geopos_invoices.factura_manual = true then 'M' when geopos_invoices.factura_duplicada = true then 'M' else 'P' end as sourcebilling,
		case when un_dupli.Reference is null then geopos_irs_typ_doc.type || ' ' || geopos_series.serie || '/' || geopos_invoices.tid else un_dupli.Reference end as Reference,
		geopos_irs_typ_doc.type as tipodoc,
		case when geopos_invoices.hash = '' then 'reideus' when geopos_invoices.hash is null then 'reideus' else geopos_invoices.hash end as hash,
		geopos_series.serie AS serie,
		geopos_invoices.status,
		geopos_invoices.i_class,
		geopos_invoices.notes,
		geopos_invoices.tid AS numdoc,
		case when geopos_irs_typ_doc.type = 'NC' then -1 else round(geopos_invoices.total, 2) end as valor,
		replace(geopos_invoices.datedoc, ' ', 'T') as systementrydate,
		geopos_employees.name as utilizador, geopos_invoices.id as id_factura,
		case when geopos_invoices.factura_manual = true then '1-' || geopos_irs_typ_doc.type || 'M ' || coalesce(geopos_series.serie, '0') || '/' || coalesce(geopos_invoices.tid, '0')
        when geopos_invoices.factura_duplicada = true then '1-' || un_dupli.tipodoc || 'D ' || coalesce(un_dupli.serie_name, '0') || '/' || coalesce(un_dupli.tid, '0')
        else '2' end as hashcontrol
		from geopos_invoices
		left join geopos_currencies on geopos_currencies.id = geopos_invoices.multi
		left join geopos_irs_typ_doc on geopos_irs_typ_doc.id = geopos_invoices.irs_type
		left join geopos_series on geopos_series.id = geopos_invoices.serie
		left join geopos_employees on geopos_employees.id = geopos_invoices.eid
		left join (select 
					g.id, 
					g.tid,
					geopos_irs_typ_doc.type as tipodoc,
					geopos_series.serie AS serie_name,
					g.factura_origem,
					geopos_irs_typ_doc.type || ' ' || geopos_series.serie || '/' || g.tid as Reference
					from 
						geopos_invoices as g
					inner join
						geopos_irs_typ_doc on geopos_irs_typ_doc.id = g.irs_type
					inner join
						geopos_series on geopos_series.id = g.serie) as un_dupli on un_dupli.factura_origem = geopos_invoices.id
		where 
			geopos_invoices.loc = $locdefine and
			(geopos_invoices.i_class = 0 or geopos_invoices.i_class = 2) and
			geopos_invoices.ext = 0 and 
			geopos_invoices.invoicedate >= '$sdate' and geopos_invoices.invoicedate <= '$edate'
		order by 
			geopos_invoices.invoicedate, geopos_invoices.tid";
		
		//print_r($querypass);
		$query = $this->db->query($querypass);
        $invoice_data = $query->result_array();
        $total_invoice = !empty($invoice_data) ? count($invoice_data) : '0';
        $l = 0;
        $invoice_total_amt = 0;
		array_push($valores, $this->data_ini);
		array_push($valores, $this->data_fim);
        
		if(empty($invoice_data)) {
            return "";
        }
		
        $last_fac = "";
        $totais = [];
        
        $lista = array();
        $valores_totais = array();
		
        foreach ($invoice_data as $ivalue)
        {
            if(!isset($valores_totais[$ivalue['id_factura']]))
            {
                $valores_totais[$ivalue['id_factura']] = 0;
            }
            $valor = $ivalue['valor'];
            $valores_totais[$ivalue['id_factura']] = $valores_totais[$ivalue['id_factura']] + $valor;
            
            if($ivalue['items'] <> 0)
            {
                $ivalue['preco'] = round(abs($valor) / abs($ivalue['items']), 5);
            }
            $ivalue['items'] = abs($ivalue['items']);
            
            array_push($lista, $ivalue);
        }
        
        $count = count($totais);
        
        for ($x = 0; $x < $count; $x++)
        {
            $valores_totais[$x] = round($valores_totais[x], 2);
        }
        foreach ($lista as $invoice) 
        {
            if($last_fac == "" || $invoice['id_factura'] != $last_fac)
            {
                if($last_fac != "")
                {
                    $xml .= $totais;
                    
                    $xml .= "\t\t</Invoice>\n";
                }
                
                $xml .= "\t\t<Invoice>\n";
                $xml .= "\t\t\t<InvoiceNo>" . $invoice['tipodoc'] . " ".  $invoice['serie'] . "/".$invoice['numdoc'] . "</InvoiceNo>\n";
				$xml .= "\t\t\t<ATCUD>0</ATCUD>\n";
				
                $last_fac = $invoice['id_factura']; 

                $xml .= "\t\t\t<DocumentStatus>\n";
				
				//R para Documento de resumo doutros documentos criados noutras aplicacoes e gerado nesta aplicacao, 
				//F para Documento faturado </xs:documentation>
				
				if($invoice['status'] == 'canceled')
				{
					$xml .= "\t\t\t\t<InvoiceStatus>A</InvoiceStatus>\n";
				}else if($invoice['i_class'] == 2)
				{
					$xml .= "\t\t\t\t<InvoiceStatus>S</InvoiceStatus>\n";
				}else{
					$xml .= "\t\t\t\t<InvoiceStatus>N</InvoiceStatus>\n";
				}
                
                $xml .= "\t\t\t\t<InvoiceStatusDate>" . $invoice['systementrydate'] . "</InvoiceStatusDate>\n";
                $xml .= "\t\t\t\t<SourceID>".$invoice['utilizador']."</SourceID>\n";
                $xml .= "\t\t\t\t<SourceBilling>".$invoice['sourcebilling']."</SourceBilling>\n";
                $xml .= "\t\t\t</DocumentStatus>\n";
                
                $xml .= "\t\t\t<Hash>" . $invoice['hash'] . "</Hash>\n";
                $xml .= "\t\t\t<HashControl>" . $invoice['hashcontrol'] . "</HashControl>\n";
                  
                $xml .= "\t\t\t<InvoiceDate>" . $invoice['invoicedate'] . "</InvoiceDate>\n";
                $xml .= "\t\t\t<InvoiceType>" . $invoice['tipodoc'] . "</InvoiceType>\n";
                $xml .= "\t\t\t<SpecialRegimes>\n";
                $xml .= "\t\t\t\t<SelfBillingIndicator>0</SelfBillingIndicator>\n";
                $xml .= "\t\t\t\t<CashVATSchemeIndicator>0</CashVATSchemeIndicator>\n";
                $xml .= "\t\t\t\t<ThirdPartiesBillingIndicator>0</ThirdPartiesBillingIndicator>\n";
                $xml .= "\t\t\t</SpecialRegimes>\n";
				
                $xml .= "\t\t\t<SourceID>".$invoice['utilizador']."</SourceID>\n";
                $xml .= "\t\t\t<SystemEntryDate>" . $invoice['systementrydate'] . "</SystemEntryDate>\n";
                $xml .= "\t\t\t<CustomerID>" . $invoice['csd']. "</CustomerID>\n";
                
                $totais = "\t\t\t<DocumentTotals>\n";
                $totais .= "\t\t\t\t<TaxPayable>" . number_format($invoice['tax'], 2, '.', '') . "</TaxPayable>\n";
                $totais .= "\t\t\t\t<NetTotal>" . number_format($invoice['total'] - $invoice['tax'], 2, '.', '') . "</NetTotal>\n";
                $totais .= "\t\t\t\t<GrossTotal>" . number_format($invoice['total'], 2, '.', '') . "</GrossTotal>\n";
				$totais .= $this->saft_getpaymentsinvoice($invoice['id_factura']);
                $totais .= "\t\t\t</DocumentTotals>\n";
				$diff = abs($valores_totais[$invoice['id_factura']]) - round($invoice['total'] - $invoice['tax'], 2);
                if($invoice['valor'] < 0)
                {
                    $diff *= -1;
                }
                $invoice['valor'] -= $diff;
                
                if($invoice['items'] <> 0)
                {
                    $invoice['preco'] = number_format (abs($invoice['valor']) / abs($invoice['items']), 8, '.', '');
                }
                $n_entries++;
            }

            $xml .= $this->saft_taxas_produtcs_invoices($invoice['id_factura'],$invoice['invoicedate']);
			
			if($invoice['tipodoc'] == "NC")
			{
			   $xml .= "\t\t\t\t<References>\n";
			   $xml .= "\t\t\t\t\t<Reference>" . $invoice['Reference'] . "</Reference>\n";
			   $xml .= "\t\t\t\t</References>\n"; 
			}
        }
        if($last_fac != "")
        {
            $xml .= $totais;

            $xml .= "\t\t</Invoice>\n";
        }
                
        $dump .= "\t<SalesInvoices>\n";
        $dump .= "\t\t<NumberOfEntries>$n_entries</NumberOfEntries>\n";
        $dump .= "\t\t<TotalDebit>" . number_format($tot_debit, 2, '.', '') . "</TotalDebit>\n";
        $dump .= "\t\t<TotalCredit>" . number_format($tot_credit, 2, '.', '') . "</TotalCredit>\n";
        $dump .= $xml;
        $dump .= "\t</SalesInvoices>\n";
        
        return $dump;
    }
	

    public function addActivateVal($iddocsaft, $bill_doc, $trans_doc, $username, $password, $date, $location, $actdateidoc)
    {
		$data2 = array('type' => 4, 'id' => $iddocsaft);
        $this->db->delete('geopos_config', $data2);
		
		// now try it
		$ua=$this->aauth->getBrowser();
		$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
		
		$striPay = "[UPDATE]Utilizador: ".$this->aauth->get_user()->username;
		$striPay = $striPay.'<br>'.$yourbrowser;
		$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
		$striPay = $striPay.'<br>Saft, Ativação ou Alteração';
		$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'saft', 0);
        $data = array(
			'type' => 4,
            'val1' => $bill_doc,
            'val2' => $trans_doc,
            'val3' => $username,
            'val4' => $password,
			'taxregion' => $actdateidoc,
            'taxcode' => $date,
			'other' => $location
        );
        return $this->db->insert('geopos_config', $data);
    }

    public function getactivateVal($location)
    {
		$this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 4);
		$this->db->where('other', $location);
        $query = $this->db->get();
        $result = $query->row_array();
		if(!empty($result)){
			$result['idsaftdocs'] = $query->row_array()['id'];
			$result['saft11'] = $query->row_array()['val1'];
			$result['saft12'] = $query->row_array()['val2'];
			$result['saft13'] = $query->row_array()['val3'];
			$result['saft14'] = $query->row_array()['val4'];
			$result['saft15'] = $query->row_array()['taxcode'];
			$result['saft16'] = $query->row_array()['taxregion'];
			$result['location'] = $query->row_array()['other'];
		}else{
			$result['idsaftdocs'] = '';
			$result['saft11'] = '';
			$result['saft12'] = '';
			$result['saft13'] = '';
			$result['saft14'] = '';
			$result['saft15'] = '';
			$result['saft16'] = '';
			$result['location'] = '';
		}
        return $result;
    }
	
	
	public function addActivateValCaixa($iddoccaixa, $caixa_1, $caixa_2, $caixa_3, $caixa_4, $location, $dateActiv)
    {
		$data2 = array('type' => 5, 'id' => $iddoccaixa);
        $this->db->delete('geopos_config', $data2);
		
		// now try it
		$ua=$this->aauth->getBrowser();
		$yourbrowser= "Navegador/Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
		
		$striPay = "[UPDATE]Utilizador: ".$this->aauth->get_user()->username;
		$striPay = $striPay.'<br>'.$yourbrowser;
		$striPay = $striPay.'<br>Ip: '.$this->aauth->get_user()->ip_address;
		$striPay = $striPay.'<br>Iva Caixa, Ativação ou Alteração';
		$this->aauth->applog($striPay, $this->aauth->get_user()->username, 'ivacaixa', 0);
		
        $data = array(
			'type' => 5,
            'val1' => $caixa_1,
            'val2' => $caixa_2,
            'val3' => $caixa_3,
            'val4' => $caixa_4,
			'taxcode' => $dateActiv,
			'other' => $location
        );
        return $this->db->insert('geopos_config', $data);
    }
	
	
	public function getactivateValCaixa($location)
    {
		$this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('type', 5);
		$this->db->where('other', $location);
		
        $query = $this->db->get();
        $result = $query->row_array();
		if(!empty($result)){
			$result['idsaftcaixa'] = $query->row_array()['id'];
			$result['saft18'] = $query->row_array()['val1'];
			$result['saft20'] = $query->row_array()['val2'];
			$result['saft22'] = $query->row_array()['val3'];
			$result['saft25'] = $query->row_array()['val4'];
			$result['saft26'] = $query->row_array()['taxcode'];
			$result['location'] = $query->row_array()['other'];
		}else{
			$result['idsaftcaixa'] = '';
			$result['saft18'] = '';
			$result['saft20'] = '';
			$result['saft22'] = '';
			$result['saft25'] = '';
			$result['saft26'] = '';
			$result['location'] = '';
		}
        return $result;
    }
}