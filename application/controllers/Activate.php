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

class Activate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('products_model', 'products');
        $this->li_a = 'settings';

        $this->load->library("Aauth");
        $this->load->model('settings_model', 'settings');
    }
	
	public function activate()
    {
		if (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $code = $this->input->post('code', true);
            $this->settings->update_atformat($email, $code);
        } else {
            $head['title'] = $this->lang->line('Software Activation');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/active');
            $this->load->view('fixed/footer');
        }
    }
}