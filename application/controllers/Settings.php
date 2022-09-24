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

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('products_model', 'products');
        $this->li_a = 'settings';

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit($this->lang->line('translate19'));

        }

        $this->load->model('settings_model', 'settings');
    }

    public function company()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $taxid = $this->input->post('taxid', true);
            $social_security = $this->input->post('social_security', true);
            $annual_vacation = $this->input->post('annual_vacation', true);
            $number_day_work_month = $this->input->post('number_day_work_month', true);
			$number_hours_work = $this->input->post('number_hours_work', true);
			$share_capital = $this->input->post('share_capital', true);
			$registration = $this->input->post('registration', true);
			$conservator = $this->input->post('conservator', true);
			$passive_res = 0;
			if(filter_has_var(INPUT_POST,'passive_res')) {
				$passive_res = 1;
			}else{
				$passive_res = 0;
			}
			$rent_ab = 0;
			if(filter_has_var(INPUT_POST,'rent_ab')) {
				$rent_ab = 1;
			}else{
				$rent_ab = 0;
			}
			$zon_fis = $this->input->post('zon_fis');
			
            $foundation = datefordatabase($this->input->post('foundation', true));
			$data_share = $this->input->post('data_share');
			
            $this->settings->update_company(1, $name, $phone, $email, $address, $city,
                $region, $country, $postbox, $taxid, $social_security, $annual_vacation, $number_day_work_month, $number_hours_work, $share_capital, $registration, $conservator, $passive_res, $foundation, $data_share,$rent_ab,$zon_fis);

        } else {
			$this->load->library("Common");
			$data['countrys'] = $this->common->countrys();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('company_settings');
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/company', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function currency()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $currency = $this->input->post('currency', true);
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');
            $decimal = $this->input->post('decimal');
            $spost = $this->input->post('spos');
            $roundoff = $this->input->post('roundoff');
            $r_precision = $this->input->post('r_precision');

            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost, $roundoff, $r_precision);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Currency Settings');
            $data['currency'] = $this->settings->currency();

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/currency', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function dtformat()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tzone = $this->input->post('tzone');
            $dateformat = $this->input->post('dateformat');
            $this->settings->update_dtformat(1, $tzone, $dateformat);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Date Time Settings');
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/timeformat', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function companylogo()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->settings->companylogo($id, $img);
        }
    }

    //tax


    public function email()
    {
        $this->li_a = 'misc_settings';
        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
            $auth = $this->input->post('auth');
            $auth_type = $this->input->post('auth_type');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $sender = $this->input->post('sender');

            $this->load->library('ultimatemailer');

            $test = $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $sender, ' Test', $sender, ' Test', ' SMTP Test', 'Hi, This is a  SMTP Test! Working Perfectly', false, '');

            if ($test) {
                $this->settings->update_smtp($host, $port, $auth, $auth_type, $username, $password, $sender);
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('smtperrorport')));
            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('SMTP Config');
            $data['email'] = $this->settings->email_smtp();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/email', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing_terms()
    {
        $this->li_a = 'billing';
		$this->load->library("Common");
		$data['terms'] = $this->common->stermos();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/terms', $data);
        $this->load->view('fixed/footer');
    }

    public function about()
    {
        $this->li_a = 'misc_settings';
        $head['title'] = $this->lang->line('About');

        $this->load->view('fixed/header', $head);
        $this->load->view('settings/about');
        $this->load->view('fixed/footer');
    }

    public function add_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');

            $this->settings->add_term($title, $type, $term);

        } else {
			$this->load->library("Common");
            $head['title'] = $this->lang->line('Add Billing Term');
			$head['terms'] = $this->common->stermos();
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/add_terms');
            $this->load->view('fixed/footer');
        }
    }


    public function edit_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');
            $this->settings->edit_term($id, $title, $type, $term);
        } else {
            $id = $this->input->get('id');
			$this->load->library("Common");
			$data['term'] = $this->settings->terms_details($id);
			$data['terms'] = $this->common->stermos();
            $head['title'] = $this->lang->line('Edit Billing Term');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_terms', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_terms()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_terms($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }

    public function activate()
    {
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

    public function theme()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tdirection = $this->input->post('tdirection', true);
            $menu = $this->input->post('menu', true);
            $this->settings->theme($tdirection, $menu);
        } else {
            $head['title'] = $this->lang->line('Theme Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/theme');
            $this->load->view('fixed/footer');
        }
    }

    public function themelogo()
    {
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'
        ));
    }

    public function tickets()
    {
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $service = $this->input->post('service', true);
            $email = $this->input->post('email', true);
            $support = $this->input->post('support', true);
            $sign = $this->input->post('signature');
            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Support Ticket Settings');
            $data['support'] = $this->plugins->universal_api(3);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/ticket', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function language()
    {
        $this->li_a = 'localisation';
        $this->load->library("Common");
        if ($this->input->post()) {
            $lang = $this->input->post('language', true);
            $this->settings->update_language(1, $lang);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Billing & TAX Settings');
            $data['company'] = $this->settings->company_details(1);
            $data['langs'] = $this->common->languages();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function automail()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $sms = $this->input->post('sms');
            $this->settings->update_automail($email, $sms);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Auto Email SMS Settings');
            $data['auto'] = $this->settings->automail();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function taxslabs()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->slabs();
        $head['title'] = $this->lang->line('TAX Slabs');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/slabs', $data);
        $this->load->view('fixed/footer');
    }

    public function taxslabs_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
			$tcode = $this->input->post('taxcode', true);
			$tregion = $this->input->post('taxcountryregion', true);
			$tdesc = $this->input->post('taxdescription');
            $trate = $this->input->post('trate');
            $ttype = "yes";
            $ttype2 = "yes";
			//$ttype = $this->input->post('ttype');
            //$ttype2 = $this->input->post('ttype2');
            $this->settings->add_slab($tname, $trate, $ttype, $ttype2,$tcode,$tregion,$tdesc);

        } else {
			$this->load->library("Common");
			$data['countrys'] = $this->common->countrys();
            $data['catlist'] = $this->settings->slabs();
            $head['title'] = $this->lang->line('Add TAX Slabs');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_create', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	public function caes()
    {
        $this->li_a = 'company';
        $data['caes'] = $this->settings->scaes();
        $head['title'] = 'C.A.E s da Empresa';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/cae_list', $data);
        $this->load->view('fixed/footer');
    }

    public function caes_new()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
			$tcode = $this->input->post('tcod', true);
            $this->settings->add_caes($tname, $tcode);
        } else {
            $head['title'] = 'Adicionar novo C.A.E';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cae_create');
            $this->load->view('fixed/footer');
        }
    }
	
	public function caes_edit()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
			$id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
			$tcode = $this->input->post('tcod', true);
            $this->settings->edit_caes($id, $tname, $tcode);

        } else {
			$caeid = $this->input->get('id');
			$data['caes'] = $this->settings->caesget($caeid);
            $head['title'] = 'Alteração do C.A.E '.$data['caes']['val1'];
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cae_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function caes_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
			$data = array(
				'other' => 1
			);
			$this->db->set($data);
			$this->db->where('id', $id);
			if ($this->db->update('geopos_config', $data)) {
				echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
			}else {
				echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
			}
        }
    }
	
	
	public function taxslabs_edit()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
			$id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
			$tcode = $this->input->post('taxcode', true);
			$tregion = $this->input->post('taxcountryregion', true);
			$tdesc = $this->input->post('taxdescription');
            $trate = $this->input->post('trate');
            $ttype = "yes";
            $ttype2 = "yes";
			//$ttype = $this->input->post('ttype');
            //$ttype2 = $this->input->post('ttype2');
            $this->settings->edit_slab($id, $tname, $trate, $ttype, $ttype2,$tcode,$tregion,$tdesc);

        } else {
			$catid = $this->input->get('id');
			$this->load->library("Common");
			$data['countrys'] = $this->common->countrys();
			$data['slabs'] = $this->settings->slabsget($catid);
            $data['catlist'] = $this->settings->slabs();
            $head['title'] = $this->lang->line('Edit TAX Slabs');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxslabs_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_slab($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }
	
	public function withholdingsoptions()
    {
		//$pid = $this->input->post('pid', true);
		$query = $this->db->query("SELECT geopos_config.* FROM geopos_config WHERE geopos_config.type = 3");
		$out = array();
		$result = array();
		$result = $query->result_array();
		foreach ($result as $row) {
			$name = array($row['id'], $row['val2'], $row['taxcode'], $row['taxregion'], $row['val1']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
	
	
	public function withholding()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->withholdings();
        $head['title'] = $this->lang->line('Withholding');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/withholdings', $data);
        $this->load->view('fixed/footer');
    }

    public function taxwithholdings_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate' , true);
            $ttype = $this->input->post('ttype' , true);
			$tother = $this->input->post('tcodesend' , true);
			$ttaxcode = $this->input->post('tcode' , true);
			$tdiscription = $this->input->post('tdiscription' , true);
            $this->settings->add_withholdings($tname, $trate, $ttype, $tdiscription, $tother, $ttaxcode);

        } else {

            $data['catlist'] = $this->settings->withholdings();
            $head['title'] = $this->lang->line('Add').' '.$this->lang->line('Withholding');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/withholdings_create', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	public function taxwithholdings_edit()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
			$id = $this->input->post('id');
			$tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate' , true);
            $ttype = $this->input->post('ttype' , true);
			$tother = $this->input->post('tcodesend' , true);
			$ttaxcode = $this->input->post('tcode' , true);
			$tdiscription = $this->input->post('tdiscription' , true);
			$this->settings->edit_withholdings($id, $tname, $trate, $ttype, $tdiscription, $tother, $ttaxcode);
        } else {
			$catid = $this->input->get('id');
			$query = $this->db->query("SELECT * FROM geopos_config where id=".$catid." and type=3");
			$data['slabs'] = $query->row_array();
            $data['catlist'] = $this->settings->withholdings();
            $head['title'] = $this->lang->line('Withholding').' '.$this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/withholdings_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxwithholdings_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_slab($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }

    }
	
	function smetopagamento($id = 0)
    {
		$query = "";
		$this->db->select('*');
		$this->db->from('geopos_config');
		$this->db->where('geopos_config.type', 9);
		$query = $this->db->get();
		$out = array();
		$result = array();
		$result = $query->result_array();
		foreach ($result as $row) {
			$name = array($row['id'], $row['val2'], $row['val1']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }

    public function logdata()
    {
        $this->li_a = 'advance';
        $data['acts'] = $this->settings->logs();
        $head['title'] = $this->lang->line('App Log');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/logs', $data);
        $this->load->view('fixed/footer');
    }


    public function warehouse()
    {
        $this->li_a = 'billing';
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $wid = $this->input->post('wid');

            $this->plugins->update_api(60, $wid, '', 1, '', '');

        } else {

            $this->db->select('*');
            $this->db->from('geopos_warehouse');

            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', 0);
                $this->db->or_where('loc', $this->aauth->get_user()->loc);
            }


            $query = $this->db->get();
            $data['warehouses'] = $query->result_array();

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('DefaultWarehouse');
            $data['ware'] = $this->plugins->universal_api(60);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/warehouse', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function discship()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(61);
        if ($this->input->post()) {
            $discstatus = $this->input->post('discstatus');
            $shiptax_type = $this->input->post('shiptax_type');
            $shiptax_rate = $this->input->post('shiptax_rate');
            switch ($discstatus) {


                case 'flat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX');
                    break;
                case 'b_p' :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                case 'bflat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                default :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');
                    break;
            }
            $this->plugins->update_api(61, $discstatus, $shiptax_rate, 0, $shiptax_type, $discstatus_name);


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Discount & Shipping Settings');
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/discship', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function pos_style()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $assign = $this->input->post('assign', true);
            $this->settings->posstyle($tdirection);
			$pos_list = $this->input->post('pos_list');
			$type_doc = $this->input->post('assign', true);
			$this->plugins->m_update_api(69, $assign, $type_doc, 0, 0, 0, 0, false);
			if ($pos_list != PAC) {
                $config_file_path = APPPATH . "config/constants.php";
                $config_file = file_get_contents($config_file_path);
                $config_file = str_replace("('PAC', '" . PAC . "')", "('PAC', '$pos_list')", $config_file);
                file_put_contents($config_file_path, $config_file);
            }
			$wid = $this->input->post('wid', true);
            $this->plugins->update_api(60, $wid, '', 1, '', '',false);
        } else {
			$this->load->library("Common");
			$this->load->model('accounts_model');
			$this->db->select('*');
            $this->db->from('geopos_warehouse');

            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
                //$this->db->or_where('loc', 0);
            }
            $query = $this->db->get();
            $data['warehouses'] = $query->result_array();
			$data['ware'] = $this->plugins->universal_api(60);
            $head['title'] = "POS e Loja Por Defeito";
			$data['irs_typ'] = $this->common->irs_typ_combo();
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['current'] = $this->plugins->universal_api_pos();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/posstyle', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function zero_stock()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $tdirection = $this->input->post('stock', true);
            $expired = $this->input->post('expired', true);
            $this->settings->zerostock($tdirection);
        } else {
            $data['current'] = $this->plugins->universal_api(63);
            $head['title'] = $this->lang->line('Product As Service Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/zerostock', $data);
            $this->load->view('fixed/footer');


        }
    }

    public function registration()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $register = $this->input->post('register', true);
            $email_confrim = $this->input->post('email_conf', true);
            $auto_mail = $this->input->post('automail', true);
            $this->plugins->m_update_api(64, $register, 0, $email_confrim, 0, $auto_mail);
        } else {
            $data['current'] = $this->plugins->universal_api(64);
            $head['title'] = $this->lang->line('CRMSettings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/selfregistration', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function custom_fields()
    {
        $this->li_a = 'advance';
        $data['customfields'] = $this->settings->custom_fields();
        $head['title'] = $this->lang->line('Custom Form Fields Settings');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/custom_field', $data);
        $this->load->view('fixed/footer');
    }

    public function add_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $this->settings->custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $head['title'] = $this->lang->line('Add Custom Form Fields Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_add');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
			$f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_name = $this->input->post('f_name', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $id = $this->input->post('fid');
            $this->settings->custom_field_edit($id, $f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $id = $this->input->get('id');
            $data['customfields'] = $this->settings->custom_fields($id);
            $head['title'] = $this->lang->line('Edit Custom Form Fields Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_custom_field()
    {
        $id = $this->input->post('deleteid');

        if ($this->db->delete('geopos_custom_fields', array('id' => $id))) {
            $this->db->delete('geopos_custom_data', array('field_id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function print_invoice()
    {
        $this->li_a = 'templates';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $this->settings->printinvoice($tdirection);
        } else {
            $head['title'] = $this->lang->line('Print Invoice Style Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/printinvoice');
            $this->load->view('fixed/footer');
        }
    }

    public function dual_entry()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist($this->aauth->get_user()->loc);
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
       
        if ($this->input->post()) {
            $dual = $this->input->post('dual');
            $dual_inv = $this->input->post('dual_inv');
            $dual_pur = $this->input->post('dual_pur');
			$dual_pursupl = $this->input->post('dual_pursupl');
            $this->plugins->m_update_api(65, $dual, $dual_inv, $dual_pur,0,$dual_pursupl);
        } else {
			$data['discship'] = $this->plugins->universal_api(65);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Dual Entry Settings');
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/dual_entry', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function misc_automail()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $td_email = $this->input->post('td_email');
            $id_email = $this->input->post('id_email');
            $send_email = $this->input->post('send');
            $this->plugins->m_update_api(66, $email, $td_email, $send_email, $id_email);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Auto Email Settings');
            $data['auto'] = $this->plugins->universal_api(66);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/misc_automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function allow_custom()
    {
        $enable = $this->input->post('enable');
        if ($enable != CUSTOM) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('CUSTOM', '" . CUSTOM . "')", "('CUSTOM', '$enable')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function debug()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $debug = $this->input->post('debug', true);
            $this->settings->debug($debug);
        } else {
            $head['title'] = $this->lang->line('App Debug Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/debug');
            $this->load->view('fixed/footer');
        }
    }

    public function server()
    {
        phpinfo();
    }

    public function db_error()
    {
        $query = $this->db->query("SELECT i.id, SUM(i.total) AS total,i.status,i.i_class,c.name,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id GROUP BY  i.csd ORDER BY  i.id  LIMIT 10");
        $error = $this->db->error();
        if (@$error['code']) {
            echo $this->lang->line('errosql1');
            print_r($error);
        } else {
            echo $this->lang->line('errosql2');
        }
        $result = $query->result_array();
    }

    public function switch_location()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'loc' => $id
        );
        $this->db->set($data);
        $this->db->where('id', $this->aauth->get_user()->id);
        $this->db->update('geopos_users');
        redirect(base_url('dashboard'));
    }

    public function billing_settings()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $stock = $this->input->post('stock', true);
            $serial = $this->input->post('serial', true);
            $expired = $this->input->post('expired', true);
            $this->settings->billing_settings($stock, $serial, $expired);
        } else {
            $data['zero_stock'] = $this->plugins->universal_api(63);
            $data['billing_settings'] = $this->plugins->universal_api(67);
            $head['title'] = $this->lang->line('BillingSettings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing_settings', $data);
            $this->load->view('fixed/footer');


        }
    }

	/*
		Series for documents
	*/

	public function series()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Series';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/serie_list');
        $this->load->view('fixed/footer');
    }
	
	public function serie()
    {
        if ($this->input->post()) {
            $serie = $this->input->post('serie', true);
            $cae = $this->input->post('cae');
			$startdate = datefordatabase($this->input->post('startdate'));
			$enddate = datefordatabase($this->input->post('enddate'));
            $inacti = $this->input->post('exclued');

            if ($this->settings->addserie($serie, $cae, $startdate, $enddate, $inacti)) {
				$seriid = $this->db->insert_id();
				$typs_id = $this->input->post('pid');
				$start_doc = $this->input->post('start_doc',true);
				$typslist = array();
				$prodindex = 0;
				foreach ($typs_id as $key => $value) {
					$data = array(
						'serie' => $seriid,
						'typ_doc' => $typs_id[$key],
						'start' => $start_doc[$key]);
					$typslist[$prodindex] = $data;
					$prodindex++;
				}
				$this->db->insert_batch('geopos_series_ini_typs', $typslist);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='serie' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='series' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
			$this->load->library("Common");
            $head['usernm'] = $this->aauth->get_user()->username;
			$data['caes'] = $this->settings->scaescombo();
			$data['docs_ini'] = $this->common->default_typ_doc_list_ini();
            $head['title'] = 'New Serie';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/serie', $data);
            $this->load->view('fixed/footer');
        }

    }
	
	
	 public function sre_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->serie_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->serie;
			$row[] = $obj->cae_name;
            $row[] = dateformat($obj->startdate);
			if($obj->enddate == null)
			{
				$row[] = "Sem Data Fim";
			}else{
				$row[] = dateformat($obj->enddate);
			}
			$row[] = "<a href='" . base_url("settings/edserie?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->serie_count_all($cid),
            "recordsFiltered" => $this->settings->serie_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_serie()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
		$this->aauth->applog("[Delete] Serie-$id" . $id, $this->aauth->get_user()->username);
		
		$id = $this->input->post('deleteid');
		$data = array(
			'status' => 1
		);
		$this->db->set($data);
		$this->db->where('id', $id);
		if ($this->db->update('geopos_series', $data)) {
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
	}
	
	
	public function edserie()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
			$serie = $this->input->post('serie',true);
            $cae = $this->input->post('cae');
            $exclued = $this->input->post('exclued');
			
			$this->db->delete('geopos_series_ini_typs', array('serie' => $id));
			
			$typs_id = $this->input->post('pid');
			$start_doc = $this->input->post('start_doc',true);
			$typslist = array();
			$prodindex = 0;
			foreach ($typs_id as $key => $value) {
				$data = array(
					'serie' => $id,
					'typ_doc' => $typs_id[$key],
					'start' => $start_doc[$key]);
				$typslist[$prodindex] = $data;
				$prodindex++;
			}
			
			$this->db->insert_batch('geopos_series_ini_typs', $typslist);
			$startdate = datefordatabase($this->input->post('startdate'));
			$enddate = datefordatabase($this->input->post('enddate'));
            $exclued = $this->input->post('exclued');

            if ($this->settings->edithserie($id, $serie, $cae, $inicial, $ended, $startdate, $enddate, $exclued)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='serie' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='series' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
			$this->load->library("Common");
            $data['id'] = $this->input->get('id');
            $data['serie'] = $this->settings->serie_view($data['id']);
			$data['docs_ini'] = $this->common->default_typ_doc_list($data['id']);
            $head['usernm'] = $this->aauth->get_user()->username;
			$data['caes'] = $this->settings->scaescombo();
            $head['title'] = 'Edit Serie';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editserie', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	/*
		Countrys
	*/

	public function countrys()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Countrys';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/country_list');
        $this->load->view('fixed/footer');
    }
	
	public function country()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name',true);
            $prefix = $this->input->post('prefix',true);
			$cultur = $this->input->post('culturs',true);
			$indicat = $this->input->post('indicat');
            $memberue = $this->input->post('memberue');

            if ($this->settings->addcountry($name, $prefix, $cultur, $indicat, $memberue)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='country' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='countrys' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
			$data['culturs'] = $this->settings->list_culturs();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Country';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/country', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	public function terms_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->terms_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->title;
			$row[] = $obj->nameterm;
			$row[] = "<a href='" . base_url("settings/edit_term?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->terms_count_all($cid),
            "recordsFiltered" => $this->settings->terms_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	
	
	public function ctr_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->country_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
			$row[] = $obj->prefix;
			$row[] = $obj->indicat;
			$row[] = "<a href='" . base_url("settings/edcountry?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->country_count_all($cid),
            "recordsFiltered" => $this->settings->country_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_country()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
		
        $id = $this->input->post('deleteid');

        if ($this->settings->deletecountry($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
		
	}
	
	
	public function edcountry()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
			$name = $this->input->post('name',true);
            $prefix = $this->input->post('prefix',true);
			$cultur = $this->input->post('culturs',true);
			$indicat = $this->input->post('indicat');
            $memberue = $this->input->post('memberue');

            if ($this->settings->edithcountry($id, $name, $prefix, $cultur, $indicat, $memberue)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='country' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='countrys' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['country'] = $this->settings->country_view($data['id']);
			$data['culturs'] = $this->settings->list_culturs();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Country';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editcountry', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	
	/*
		Culturs
	*/

	public function culturs()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Culturs';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/cultur_list');
        $this->load->view('fixed/footer');
    }
	
	public function cultur()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name',true);
            $prefix = $this->input->post('prefix',true);
            if ($this->settings->addcultur($name, $prefix)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='cultur' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='culturs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Cultur';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cultur', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	 public function cltu_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->cultur_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
			$row[] = $obj->prefix;
			$row[] = "<a href='" . base_url("settings/edcultur?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->cultur_count_all($cid),
            "recordsFiltered" => $this->settings->cultur_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_cultur()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
		
        $id = $this->input->post('deleteid');

        if ($this->settings->deletecultur($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
		
	}
	
	
	public function edcultur()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
			$name = $this->input->post('name',true);
            $prefix = $this->input->post('prefix',true);

            if ($this->settings->edithcultur($id, $name, $prefix)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='cultur' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='culturs' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['cultur'] = $this->settings->cultur_view($data['id']);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Cultur';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editcultur', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	/*
		Type Documents TAX
	*/

	public function irs_typ_docs()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Types Docs Tax';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/irs_typ_doc_list');
        $this->load->view('fixed/footer');
    }
	
	public function irs_typ_doc()
    {
        if ($this->input->post()) {
            $type = $this->input->post('type',true);
            $description = $this->input->post('description',true);
			$used = $this->input->post('used',true);
            if ($this->settings->addirs_typ_doc($type, $description, $used)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='irs_typ_doc' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typ_docs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Type Doc Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/irs_typ_doc', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	 public function sirs_typ_doc_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->irs_typ_doc_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->type;
			$row[] = $obj->description;
			$row[] = $obj->nameused;
			$row[] = "<a href='" . base_url("settings/edirs_typ_doc?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>";
			//$row[] = "<a href='" . base_url("settings/edirs_typ_doc?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->irs_typ_doc_count_all($cid),
            "recordsFiltered" => $this->settings->irs_typ_doc_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_irs_typ_doc()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
		
        $id = $this->input->post('deleteid');

        if ($this->settings->deleteirs_typ_doc($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
		
	}
	
	
	public function edirs_typ_doc()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
			$type = $this->input->post('type',true);
            $description = $this->input->post('description',true);
			$used = $this->input->post('used',true);

            if ($this->settings->edithirs_typ_doc($id, $type, $description, $used)) {
				$this->db->delete('geopos_invoice_items', array('irs_type' => $id));
				
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='irs_typ_doc' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typ_docs' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['irs_typ_doc'] = $this->settings->irs_typ_doc_view($data['id']);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Type Doc Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editirs_typ_doc', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	
	/*
		Type TAX
	*/

	public function irs_typs()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
		
        $head['title'] = 'Types Tax';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/irs_typ_list');
        $this->load->view('fixed/footer');
    }
	
	public function irs_typ()
    {
        if ($this->input->post()) {
			$typ_doc = $this->input->post('typ_doc',true);
			$i = 0;
			
			$stringss = "";
            if ($this->settings->addirs_typ($typ_doc)) {
				$serieslist = array();
				$prodindex = 0;
				$idirstax = $this->db->insert_id();
				$s_id = $this->input->post('pid');
				$serie_id = $this->input->post('pid');
				$serie_predf = $this->input->post('serie_pred');
				$serie_copy = $this->input->post('serie_copy', true);
				$serie_tax_inc = $this->input->post('serie_tax_inc');
				$serie_class = $this->input->post('pactid');
				$serie_wareh = $this->input->post('pwareid');
				$serie_type_com = $this->input->post('serie_type_com', true);
				
				foreach ($s_id as $key => $value) {
					$data = array(
						'irs_type' => $idirstax,
						'serie' => $serie_id[$key],
						'predf' => $serie_predf[$key],
						'copy' => $serie_copy[$key],
						'taxs' => $serie_tax_inc[$key],
						'cla' => $serie_class[$key],
						'warehouse' => $serie_wareh[$key],
						'type_com' => $serie_type_com[$key]
					);
					$serieslist[$prodindex] = $data;
					$i++;
					$prodindex++;
				}
				
				if ($prodindex > 0) {
					$this->db->insert_batch('geopos_irs_typ_series', $serieslist);
					echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='irs_typ' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
				} else {
					echo json_encode(array('status' => 'Error', 'message' => "Por favor inserir uma Serie"));
				}
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
			$this->load->library("Common");
            $head['usernm'] = $this->aauth->get_user()->username;
			$data['typ_docs'] = $this->settings->list_irs_typ_doc();
			$data['warehouse'] = $this->invocies->warehouses();
			$data['p_cla'] = $this->products->proclasses();
			$data['p_series'] = $this->settings->list_series();
            $head['title'] = 'New Type Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/irs_typ', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	 public function sirs_typ_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->irs_typ_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->type;
			$row[] = $obj->description;
			$row[] = $obj->nameused;
			$row[] = "<a href='" . base_url("settings/edirs_typ?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->irs_typ_count_all($cid),
            "recordsFiltered" => $this->settings->irs_typ_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_irs_typ()
    {
		if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');
        if ($this->settings->deleteirs_typ($id)) {
			$this->db->delete('geopos_irs_typ_series', array('irs_type' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
	}
	
	public function edirs_typ()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
			$typ_doc = $this->input->post('typ_doc',true);
			
            if ($this->settings->edithirs_typ($id, $typ_doc)) {
				$this->db->delete('geopos_irs_typ_series', array('irs_type' => $id));
				$serieslist = array();
				$prodindex = 0;
				$idirstax = $id;
				$s_id = $this->input->post('pid');
				$serie_id = $this->input->post('pid');
				$serie_predf = $this->input->post('serie_pred');
				$serie_copy = $this->input->post('serie_copy', true);
				$serie_tax_inc = $this->input->post('serie_tax_inc');
				$serie_class = $this->input->post('pactid');
				$serie_wareh = $this->input->post('pwareid');
				$serie_type_com = $this->input->post('serie_type_com', true);
				
				foreach ($s_id as $key => $value) {
					$data = array(
						'irs_type' => $idirstax,
						'serie' => $serie_id[$key],
						'predf' => $serie_predf[$key],
						'copy' => $serie_copy[$key],
						'taxs' => $serie_tax_inc[$key],
						'cla' => $serie_class[$key],
						'warehouse' => $serie_wareh[$key],
						'type_com' => $serie_type_com[$key]
					);
					$serieslist[$prodindex] = $data;
					$i++;
					$prodindex++;
				}
				
				if ($prodindex > 0) {
					$this->db->insert_batch('geopos_irs_typ_series', $serieslist);
					echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='irs_typ' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
				} else {
					echo json_encode(array('status' => 'Error', 'message' => "Por favor inserir uma Serie"));
				}
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
			$this->load->library("Common");
            $data['id'] = $this->input->get('id');
            $data['irs_typ'] = $this->settings->irs_typ_view($data['id']);
			$data['series'] = $this->settings->irs_typ_series($data['id']);
			$data['typ_docs'] = $this->settings->list_irs_typ_doc($data['irs_typ']['typ_doc']);
			$data['warehouse'] = $this->invocies->warehouses();
			$data['p_cla'] = $this->products->proclasses();
			$data['p_series'] = $this->settings->list_series();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Type Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editirs_typ', $data);
            $this->load->view('fixed/footer');
        }
    }
	
	
	
	public function search_wareh()
    {
		$out = array();
		$result = $this->invocies->warehouses();
		foreach ($result as $row) {
			$name = array($row['title'],$row['id']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
	public function search_activi()
    {
		$out = array();
		$result = $this->products->proclasses();
		foreach ($result as $row) {
			$name = array($row['title'],$row['id']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
	public function search_series()
    {
		$out = array();
		$result = $this->settings->list_series();
		foreach ($result as $row) {
			$name = array($row['cae_name'],$row['id']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
	
	public function search_tax()
    {
		$out = array();
		$result = $this->settings->slabs();
		foreach ($result as $row) {
			$name = array($row['val1'],$row['taxcode'],$row['val2'],$row['id']);
			array_push($out, $name);
		}
		echo json_encode($out);
    }
	
	
	public function sub_series()
    {
        $wid = $this->input->get('id');
		$this->db->select("geopos_irs_typ_series.*,geopos_series.id as serie_id, CONCAT(geopos_series.serie,' - ',geopos_config.val1) as seriename, CASE WHEN geopos_irs_typ_series.predf = 0 THEN 'Não' ELSE 'Sim' END as predfname, CASE WHEN geopos_irs_typ_series.taxs = 0 THEN 'Não' ELSE 'Sim' END as taxsname, CASE WHEN geopos_irs_typ_series.type_com = 0 THEN 'Web Service' WHEN geopos_irs_typ_series.type_com = 1 THEN 'SAFT' WHEN geopos_irs_typ_series.type_com = 2 THEN 'Sem Comunicação' ELSE 'Manual' END as type_comname, geopos_warehouse.title as warehousename, geopos_products_class.title as claname");
        $this->db->from('geopos_irs_typ_series');
        $this->db->where('geopos_irs_typ_series.irs_type', $wid);
		$this->db->where('geopos_irs_typ_series.predf', 1);
		$this->db->join('geopos_series', 'geopos_series.id = geopos_irs_typ_series.serie', 'left');
		$this->db->join('geopos_config', 'geopos_config.id = geopos_series.cae', 'left');
		$this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_irs_typ_series.warehouse', 'left');
		$this->db->join('geopos_products_class', 'geopos_products_class.id = geopos_irs_typ_series.cla', 'left');
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
    }
	
}