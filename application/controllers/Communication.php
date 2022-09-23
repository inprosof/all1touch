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
require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Endroid\QrCode\QrCode;

class Communication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function send_invoice()
    {
		if (!$this->aauth->premission(1) || !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');

        $message = $this->input->post('message');
        $att = $this->input->post('attach');
        $attachmenttrue = false;
        $attachment = '';
        if ($att) {
            $tid = $this->input->post('tid');
            $attachmenttrue = true;
            $attach = $this->mail_attach($tid);
            $attachment = FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf';
        }

        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
        if ($att) {
            unlink(FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf');
        }
    }
	
	public function send_general_s()
    {
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('suppliername');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
    }
	
    public function send_general()
    {
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
    }


    private function mail_attach($tid)
    {
        $this->load->model('invoices_model', 'invocies');
        $this->load->library("Custom");
        $data['id'] = $tid;
		$token = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
        $data['invoice'] = $this->invocies->invoice_details($tid);
        $data['title'] = $this->lang->line('Invoice')." " . $data['invoice']['tid'];
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        if (CUSTOM) $data['c_custom_fields'] = $this->custom->view_fields_data($data['invoice']['cid'], 1, 1);

        $data['round_off'] = $this->custom->api_config(4);
        if ($data['invoice']['i_class'] == 1) {
            $pref = prefix(7);
        } elseif ($data['invoice']['i_class'] > 1) {
            $pref = prefix(3);
        } else {
            $pref = $this->config->item('prefix');
        }
		
		$data['invoice']['type'] = $this->lang->line('Invoice');
		
		$data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_.png';
		$static_q = $data['qrc'];
		$qrCode = new QrCode(base_url('billing/card?id=' . $tid . '&itype=inv&token=' . $token));
		$qrCode->writeFile(FCPATH . 'userfiles/pos_temp/' . $data['qrc']);
		
		$data['Tipodoc'] = "Original";
		$data2 = $data;
		$data2['Tipodoc'] = "Duplicado";
		
        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
			$html2 = $this->load->view('print_files/invoice-a4_v' . INVV, $data2, true);
        }
		
		
        $data['general'] = array('title' => $this->lang->line('Invoice'), 'person' => $this->lang->line('Customer'), 'prefix' => $pref, 't_type' => 0);
        ini_set('memory_limit', '64M');
        $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');
        $pdf->WriteHTML($html);
		$pdf->AddPage();
		$pdf->WriteHTML($html2);

        return $pdf->Output(FCPATH . DIRECTORY_SEPARATOR . 'userfiles' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'Invoice_' . $tid . '.pdf', 'F');
        //   return $pdf->Output('Invoice_' . $data['invoice']['tid'] . '.pdf', 'S');


    }


}