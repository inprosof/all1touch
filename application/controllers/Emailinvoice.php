<?php
/**
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above PCTECKSERV notice.
 *  *
 *  *
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Emailinvoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tools_model', 'tools');
        $this->load->model('templates_model', 'templates');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library('parser');

    }

    //todo section

    public function template()
    {
        $id = $this->input->post('invoiceid');
        $ttype = $this->input->post('ttype');
        $itype = $this->input->post('itype');

        switch ($ttype) {
            case 'quote':
                $this->load->model('quote_model', 'quote');
                $invoice = $this->quote->quote_details($id);
                $validtoken = hash_hmac('ripemd160', 'q' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/quoteview?id=' . $id . '&token=' . $validtoken);
                break;
            case 'purchase':
                $this->load->model('purchase_model', 'purchase');
                $invoice = $this->purchase->purchase_details($id);
                $validtoken = hash_hmac('ripemd160', 'p' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken);
                break;
            case 'stock':
                $this->load->model('stockreturn_model', 'stockreturn');
                $invoice = $this->stockreturn->purchase_details($id);
                $validtoken = hash_hmac('ripemd160', 's' . $id, $this->config->item('encryption_key'));
                $link = base_url('billing/stockreturn?id=' . $id . '&token=' . $validtoken);
                break;
            default :
                $this->load->model('invoices_model', 'invoices');
                $invoice = $this->invoices->invoice_details($id);
                $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $id . '&token=' . $validtoken);
                break;
        }

        switch ($ttype) {
            case 'notification':
                $template = $this->templates->template_info(6);
                break;
            case 'reminder':
                $template = $this->templates->template_info(7);
                break;
            case 'refund':
                $template = $this->templates->template_info(8);
                break;
            case 'received':
                $template = $this->templates->template_info(9);
                break;
            case 'overdue':
                $template = $this->templates->template_info(10);
                break;
            case 'quote':
                $template = $this->templates->template_info(11);
                break;
            case 'purchase':
                $template = $this->templates->template_info(12);
                $invoice['multi'] = 0;
                break;
            case 'stock':
                $template = $this->templates->template_info(13);
                $invoice['multi'] = 0;
                break;
        }
		
		$mailfromtilte = '';
		$mailfrom = '';
		
		$this->db->select("emailo_remet, email_app");
		$this->db->from('geopos_system_permiss');
		if($this->aauth->get_user()->loc > 0){
			$this->db->where('loc', $this->aauth->get_user()->loc);
		}else{
			$this->db->where('loc', 0);
		}
		$query = $this->db->get();
		$vals = $query->row_array();
		$mailfromtilte = $vals['emailo_remet'];
		if($mailfromtilte == '')
		{
			$mailfromtilte = $this->config->item('ctitle');
		}
		$mailfrom = $vals['email_app'];
		
        $data = array(
            'Company' => $mailfromtilte,
            'BillNumber' => $invoice['tid']
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);


        $data = array(
            'Company' => $mailfromtilte,
            'BillNumber' => $invoice['tid'],
            'URL' => "<a href='$link'>$link</a>",
            'Name' => $invoice['name'],
            'CompanyDetails' => '<h6><strong>' . $mailfromtilte . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),
            'DueDate' => dateformat($invoice['invoiceduedate']),
            'Amount' => amountExchange($invoice['total'], $invoice['multi'], $invoice['loc'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        echo json_encode(array('subject' => $subject, 'message' => $message));
    }


}


